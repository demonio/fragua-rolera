<?php
/**
 */
class Mount
{
	/**
	 * ESTA PARTE SE USA EN LA VISTA DEL USUARIO EN EL BACKEND
	 */
	static public function boxes($boxes, $a=[])
	{
		if ( ! $boxes ) return;
		if ( empty($content) ) $content = '';
        foreach ($boxes as $o)
        {
			#_::d($o);
			$o->code = str_replace('<', '&lt;', $o->code);
			$o->code = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $o->code);
			$o->code = trim($o->code);
			$o->code = nl2br($o->code);

			$content .= "
<fieldset id=\"box$o->id\" data-parent=\"$o->box\" ondrop=\"drop(event)\" ondragover=\"dropin(event)\" ondragleave=\"dropout(event)\">
	<legend draggable=\"true\" ondragstart=\"drag(event)\" data-href=\"/admin/pages/index/?action=update&dir=$o->dir&file=$o->file&box=$o->box&id=$o->id\">
		<i class=\"grey-text material-icons tiny\">menu</i>
		<a class=\"load-modal\" href=\"/admin/pages/read/$o->id\">$o->box</a>
		<sup>$o->box_weight</sup>		
	</legend>";
		if ( strstr($o->code, '{$boxes}') )
		{
			if ($o->childrens)
			{
				$content .= Mount::boxes($o->childrens, $a);
			}
		}

		/*$a = explode('{$', $o->code);
		array_shift($a);
		foreach ($a as $s)
		{
			$var = explode('}', $s, 2)[0];
			$content .= "<label>$var:</label>";
		}*/

		$content .= "
		<a class=\"delete\" href=\"/admin/pages/delete/$o->id/?dir=$o->dir&file=$o->file\"><i class=\"material-icons red-text right tiny\">close</i></a>
</fieldset>";
        }
        return $content;
	}

	/**
	 */
	static public function page($boxes)
	{
		if ( ! $boxes ) return;
		if ( empty($content) ) $content = '';
        foreach ($boxes as $id=>$o)
        {
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
        return $content;
	}
}
