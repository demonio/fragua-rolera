<?php
/**
 */
class Boxes extends LiteRecord
{
    #
    public function createOne($a)
    {
    	$a['slug'] = _::slug($a['name']);
        if ( $this->readOne($a['slug']) ) return Session::setArray('toast', '¡Clave repetida!');
    	unset($a['id']);
    	$this->create($a);

        if ($a['target'] == 'file')
        {
            file_put_contents($a['name'], $a['code']);
        }

    	return $this->readOne($a['slug']);
    }

    #
    public function readOne($slug)
    {
    	$sql = 'SELECT * FROM boxes WHERE slug=?';
    	return $this->first($sql, [$slug]);
    }

    #
    public function updateOne($a)
    {
    	$a['slug'] = _::slug($a['name']);

        if ($a['target'] == 'file')
        {
            if ( ! is_writable($a['name']) )  Session::setArray('toast', 'No se puede escribir.');
            file_put_contents($a['name'], $a['code']);
        }

    	$this->update($a);
    	return $this->readOne($a['slug']);
    }

    #
    public function deleteOne($id)
    {
    	$this->delete($id);
    }

    #
    public function readAll()
    {
    	$boxes = $this->all();
        foreach ($boxes as $o) $a[$o->slug] = $o;
        #_::d($a);
        return $a;
    }
}
