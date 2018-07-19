<?php
/**
 */
class Variables extends LiteRecord
{
    /**
     */
    public function read($pages_id)
    {
        $sql = 'SELECT * FROM variables WHERE pages_id=?';
        return $variables = $this->all($sql, [$pages_id]);
    }

    /**
     */
    public function readByCode($code)
    {
        $a = explode('{$', $code);
        array_shift($a);
        $b = [];
        foreach ($a as $s)
        {
            $k = explode('}', $s, 2)[0];
            if ($k == 'boxes') continue;
            $b[$k] = '';
        }
        return $b;
    }

    /**
     */
    public function saveVariables($a)
    {
        #_::d($a);
        $pages_id = $a['pages_id'];
        unset($a['pages_id']);
        $sql = 'DELETE FROM variables WHERE pages_id=?';
        $this->query($sql, [$pages_id]);
        $sql = "INSERT INTO variables (pages_id, k, v) VALUES\n";
        foreach ($a as $k=>$v)
        {
            $v = h($v);
            $sql .= $s = " ($pages_id, '$k', '$v'),\n";
        }
        $sql = rtrim($sql, ",\n");
        #_::d($sql);
        $r = $this->query($sql)
            ? Session::setArray('toast', 'Variables salvadas en base de datos.')
            : Session::setArray('toast', 'Error salvando variables en base de datos.');
    }
}
