<?php
/**
 */
class Variables extends LiteRecord
{
    /**
     */
    public function saveVariables($a)
    {
        $boxes_id = $a['boxes_id'];
        unset($a['boxes_id']);
        $sql = 'DELETE FROM variables WHERE boxes_id=?';
        $this->query($sql, [$boxes_id]);
        $sql = "INSERT INTO variables (boxes_id, k, v) VALUES\n";
        foreach ($a as $k=>$v)
        {
            $sql .= $s = " ($boxes_id, '$k', '$v'),\n";
        }
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Variables salvadas en base de datos.')
            : Session::setArray('toast', 'Error salvando variables en base de datos.');
    }
}
