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
            if ($o->box_parent <> $box_parent) continue;
            unset($boxes[$id]);
            $a[$id] = $o;
            $a[$id]->childrens = $this->mount($boxes, $o->box);
        }
        if ( ! empty($a) ) return $a;
    }
    
    /**
     */
    public function readBoxes($get)
    {
        $dir = $get['dir'];
        $file = $get['file'];
        $sql = 'SELECT * FROM pages WHERE dir=? AND file=? ORDER BY box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);
        if ( ! $page_boxes ) return [];
        $boxes = (new Boxes)->readAll();
        foreach ($page_boxes as $o)
        {
            if ( ! empty($boxes[$o->box]) ) $o->code = $boxes[$o->box]->code;
            $a[$o->box] = $o;
        }
        #_::d($a);
        return $this->mount($a);
    }
    
    /**
     */
    public function readOne($id)
    {
        $sql = 'SELECT *, p.id as pages_id FROM pages p, boxes b WHERE p.id=? AND p.box=b.slug';
        $o = $this->first($sql, [$id]);

        $sql = 'SELECT * FROM variables WHERE boxes_id=?';
        $variables = $this->all($sql, [$o->id]);
        foreach ($variables as $variable)
        {
            $a[$variable->k] = $variable->v;
        }
        $o->variables = $a;
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
        $dir = $post['dir'];
        $file = $post['file'];
        $file_new = $post['file_new'];
        $boxes = $this->readBoxes($post);
        $content = Mount::page($boxes);
        file_put_contents(dirname(APP_PATH) . "$dir$file_new", $content);

        $sql = 'SELECT * FROM pages WHERE dir=? AND file=? ORDER BY box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file_new]);

        $sql = "INSERT INTO pages (dir, file, box_parent, box, box_weight, box_width) VALUES\n";
        foreach ($page_boxes as $o)
        {
            $sql .= $s = " ('$dir', '$file_new', '$o->box_parent', '$o->box', '$o->box_weight', '$o->box_width'),\n";
        }        
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Cajas creadas en base de datos.')
            : Session::setArray('toast', 'Error creando cajas en base de datos.');
    
        return (object)['dir'=>$dir, 'file'=>$file_new];
    }
    
    /**
     */
    public function updateFile($post)
    {
        $dir = $post['dir'];
        $file = $post['file'];
        $boxes = $this->readBoxes($post);
        $content = Mount::page($boxes);
        file_put_contents(dirname(APP_PATH) . "$dir$file", $content);

        $sql = 'SELECT * FROM pages WHERE dir=? AND file=? ORDER BY box_weight';
        $page_boxes = $this->all($sql, [$dir, $file]);

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file]);

        $sql = "INSERT INTO pages (dir, file, box_parent, box, box_weight, box_width) VALUES\n";
        foreach ($page_boxes as $o)
        {
            $sql .= $s = " ('$dir', '$file', '$o->box_parent', '$o->box', '$o->box_weight', '$o->box_width'),\n";
        }        
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Cajas actualizadas en base de datos.')
            : Session::setArray('toast', 'Error actualizando cajas en base de datos.');

        return (object)['dir'=>$dir, 'file'=>$file];
    }
    
    /**
     */
    public function deleteFile($post)
    {
        $dir = $post['dir'];
        $file = $post['file'];
        unlink(dirname(APP_PATH) . "$dir$file");

        $sql = "DELETE FROM pages WHERE dir=? AND file=?";
        $this->query($sql, [$dir, $file]);

        return $dir;
    }
}
