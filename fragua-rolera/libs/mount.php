<?php
/**
 */
class Mount
{
	/**
	 * ESTA PARTE SE USA EN EL MODELO PAGES PARA CREAR ARCHIVOS CON LAS CAJAS
	 */
	static public function page($boxes)
	{
		if ( ! $boxes ) return;
		if ( empty($content) ) $content = '';
		#_::d($boxes);
        foreach ($boxes as $o)
        {
			$content .= PHP_EOL;

			# INCLUIMOS LOS VALORES DE LAS VARIABLES EN CADA CAJA PARA GUARDAR EL RESULTADO FINAL EN EL ARCHIVO ELEGIDO
			$variables = (new Variables)->read($o->id);
			foreach ($variables as $variable)
			{
				$o->code = str_ireplace('{$' . $variable->k . '}', $variable->v, $o->code);
			}

        	if ( strstr($o->code, '{$boxes}') )
			{
				if ($o->childrens)
				{
					$content .= str_replace('{$boxes}', Mount::page($o->childrens), $o->code);
				}
				else 
				{
					$content .= str_replace('{$boxes}', '', $o->code);
				}
			}
			else
			{
				$content .= $o->code;
			}
        }
        return trim($content);
	}
}
