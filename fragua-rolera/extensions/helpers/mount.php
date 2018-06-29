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
		#_::d($boxes);
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
<fieldset id=\"box$o->id\" data-parent=\"$o->id\" ondrop=\"drop(event)\" ondragover=\"dropin(event)\" ondragleave=\"dropout(event)\">
	<legend draggable=\"true\" ondragstart=\"drag(event)\" data-href=\"/admin/pages/index/?action=update&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id\">
		<i class=\"grey-text material-icons tiny\">menu</i>
		<a href=\"/admin/pages/read/$o->id\">$o->name</a>	
		<a href=\"/admin/pages/index/?action=weight_down&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id\"><i class=\"material-icons tiny\">arrow_drop_down</i></a>
		<small>$o->box_weight</small>	
		<a href=\"/admin/pages/index/?action=weight_up&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id\"><i class=\"material-icons tiny\">arrow_drop_up</i></a>
	</legend>";

		if ($o->childrens)
		{
			if ( strstr($o->code, '{$boxes}') )
				$content .= str_replace('{$boxes}', Mount::boxes($o->childrens, $a), $o->code);
			else
				$content .= Mount::boxes($o->childrens, $a);
		}

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
