<?php
/**
 */
class Boxes extends LiteRecord
{
    #
    public function createOne($a)
    {
        # LOS ARCHIVOS NO SE GUARDAN EN LA BASE DE DATOS
        if ($a['target'] == 'file')
        {
            file_put_contents($a['name'], $a['code']);
            return;
        }

    	$a['slug'] = _::shorten($a['name']);
        if ( $this->readOne($a['slug']) ) return Session::setArray('toast', '¡Clave repetida!');
    	unset($a['id']);
    	$this->create($a);

    	return $this->readOne($a['slug']);
    }

    #
    public function readOne($x)
    {
        if ( is_numeric($x) ) $sql = 'SELECT * FROM boxes WHERE id=?';
        else $sql = 'SELECT * FROM boxes WHERE slug=?';
    	return $this->first($sql, [$x]);
    }

    #
    public function updateOne($a)
    {
        # LOS ARCHIVOS NO SE GUARDAN EN LA BASE DE DATOS
        if ($a['target'] == 'file')
        {
            file_put_contents($a['name'], $a['code']);
            return;
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
        foreach ($boxes as $o) $a[$o->id] = $o;
        return $a;
    }
}
