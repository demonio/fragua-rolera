<?php
/**
 */
class Pages extends LiteRecord
{
    /**
     */
    public function createOne($a)
    {
        unset($a['id']);
        $a['box_weight'] = 1;
    	$this->create($a);
        return $this;
    }
    
    /**
     */
    public function readAll()
    {
    	return $this->all();
    }

    /**
     */
    function mount($boxes, $box_parent='')
    {
        foreach($boxes as $id=>$o)
        {
            if ($o->pages_id <> $box_parent) continue;
            unset($boxes[$id]);
            $a[$id] = $o;
            $a[$id]->childrens = $this->mount($boxes, $o->id);
        }
        if ( ! empty($a) ) return $a;
    }
    
    /**
     */
    public function readBoxes($get)
    {
        $dir = $get['dir'];
        $file = $get['file'];
        $sql = 'SELECT *, b.id as boxes_id FROM boxes b, pages p WHERE p.boxes_id=b.id AND p.dir=? AND p.file=? ORDER BY p.box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);
        if ( ! $page_boxes ) return [];
        $boxes = (new Boxes)->readAll();
        foreach ($page_boxes as $o)
        {
            if ( ! empty($boxes[$o->boxes_id]) ) $o->code = $boxes[$o->boxes_id]->code;
            $a[$o->id] = $o;
        }
        #_::d($a);
        return $this->mount($a);
    }
    
    /**
     */
    public function readOne($pages_id)
    {
        $sql = 'SELECT *, p.id as pages_id FROM pages p, boxes b WHERE p.id=? AND p.boxes_id=b.id';
        $o = $this->first($sql, [$pages_id]);
        $sql = 'SELECT * FROM variables WHERE pages_id=?';
        $variables = $this->all($sql, [$pages_id]);
        $a = [];
        foreach ($variables as $variable)
        {
            $a[$variable->k] = $variable->v;
        }
        $o->variables = $a;
        #_::d($o);
        return $o;
    }
    
    /**
     */
    public function updateOne($a)
    {
    	$this->update($a);
    	return $this->readOne($a['id']);
    }
    
    /**
     */
    public function deleteOne($id)
    {
    	$this->delete($id);
    }
    
    /**
     */
    public function createFile($post)
    {
        $app_path = dirname(APP_PATH);
        $dir = $post['dir'];
        $file_new = ltrim('/', $post['file_new']);
        #_::d(dirname("$app_path$dir$file_new"));
        mkdir(dirname("$app_path$dir$file_new"), 0777, 1);
        $boxes = $this->readBoxes($post);
        $content = Mount::page($boxes);
        file_put_contents("$app_path$dir$file_new", $content);

        /*$sql = 'SELECT * FROM pages WHERE dir=? AND file=? ORDER BY box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file_new]);

        $sql = "INSERT INTO pages (pages_id, boxes_id, dir, file, box_weight, box_width) VALUES\n";
        foreach ($page_boxes as $o)
        {
            $sql .= $s = " ('$o->pages_id', '$o->boxes_id', '$dir', '$file_new', '$o->box_weight', '$o->box_width'),\n";
        }        
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Cajas creadas en base de datos.')
            : Session::setArray('toast', 'Error creando cajas en base de datos.');*/
    
        return (object)['dir'=>$dir, 'file'=>$file_new];
    }
    
    /**
     */
    public function updateFile($a)
    {
        $dir = $a['dir'];
        $file = $a['file'];
        $file_new = $a['file_new'];

        $boxes = $this->readBoxes($a);
        $content = Mount::page($boxes);
        file_put_contents(dirname(APP_PATH) . "$dir$file_new", $content);
        if ($file <> $file_new) $this->deleteFile($a);

        /*$sql = 'SELECT * FROM pages WHERE dir=? AND file=? ORDER BY box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file]);

        $sql = "INSERT INTO pages (pages_id, boxes_id, dir, file, box_weight, box_width) VALUES\n";
        foreach ($page_boxes as $o)
        {
            $sql .= $s = " ('$o->pages_id', '$o->boxes_id', '$dir', '$file', '$o->box_weight', '$o->box_width'),\n";
        }        
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Cajas actualizadas en base de datos.')
            : Session::setArray('toast', 'Error actualizando cajas en base de datos.');*/

        return (object)['dir'=>$dir, 'file'=>$file_new];
    }
    
    /**
     */
    public function deleteFile($a)
    {
        $app_path = dirname(APP_PATH);
        $dir = $a['dir'];
        $file = $a['file'];
        if ($file)
            unlink("$app_path$dir$file");
        else
            rmdir("$app_path$dir");

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file]);

        return ($file) ? $dir : dirname($dir);
    }
    
    /**
     */
    public function weightDown($a)
    {
        $weight = ( (int)$a['box_weight'] < 2 ) ? 1 : $a['box_weight']-1;
        $id = (int)$a['id'];
        $sql = 'UPDATE pages SET box_weight=? WHERE id=?';
        $this->query($sql, [$weight, $id]);
    }
    
    /**
     */
    public function weightUP($a)
    {
        $weight = ( (int)$a['box_weight'] < 1 ) ? 1 : $a['box_weight']+1;
        $id = (int)$a['id'];
        $sql = 'UPDATE pages SET box_weight=? WHERE id=?';
        $this->query($sql, [$weight, $id]);
    }
    
    /**
     */
    public function width($id, $a)
    {
        $width = h($a['box_width']);
        $sql = 'UPDATE pages SET box_width=? WHERE id=?';
        $this->query($sql, [$width, (int)$id]);
        return $width;
    }
}
