<?php
/**
 * NAVAJA SUIZA
 */
class _
{
    # IMPRIME UNA VARIABLE Y PARA
    static public function d($x, $code=0)
    {
        if ( is_bool($x) ) die( var_dump($x) );
        else if ($code) $x = str_replace('<', '&lt;', $x);
        die('<pre>' . print_r($x, 1) . '</pre>');
    }

    # IMPRIME UNA VARIABLE
    static public function e($x)
    {
        var_dump($x);
    }

    # REDIRECCIONA
    static public function go($url)
    {
        if ( Input::isAjax() )
            echo "<script>location.href='$url'</script>";
        else
            Redirect::to($url);
        exit;
    }

    # RETORNA EL VALOR DE UNA VARIABLE DE SESION
    static public function s($k)
    {
        if ( isset($_SESSION[$k]) ) return $_SESSION[$k];
    }

	# CONVIERTE UN TITULO EN UN PARAMETRO
    static public function slug($s, $by='-')
    {
        $a = ['á','é','í','ó','ú'];
        $b = ['a','e','i','o','u'];
        $s = str_ireplace($a, $b, $s);
        $s = preg_replace('/[^a-z0-9]/i', $by, $s);
		$s = mb_strtolower($s);
		return $s;
	}

	# CONVIERTE NOMBRES EN CLAVES ÚNICAS DE 8 CARACTERES
    static public function shorten($s)
    {
        return substr(md5(time().$s), 0, 8);
	}

    # RETORNA EL VALOR DE LA PROPIEDAD DEL OBJETO O SU CLAVE POST
    static public function v($o, $k)
    {
        if ( isset($o->$k) ) return $o->$k;
        if ( isset($_POST[$k]) ) return $_POST[$k];
    }
}
