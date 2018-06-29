<?php
/**<form action=\"/admin/pages/index/?action=width_set&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id\">
			<input class=\"inline w-auto\" type=\"text\" name=\"box_width\" value=\"$o->box_width\">
			<button type=\"submit\" class=\"btn-small transparent pa0\">SET</button>
		</form>
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

			$o->box_width = empty($o->box_width) ? '¿Width?': $o->box_width;

			$content .= "
<div class=\"col $o->box_width\">
	<fieldset data-parent=\"$o->id\" id=\"box$o->id\" ondrop=\"drop(event)\" ondragover=\"dropin(event)\" ondragleave=\"dropout(event)\">
		<legend data-href=\"/admin/pages/index/?action=update&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id&box_weight=$o->box_weight&box_width=$o->box_width\" draggable=\"true\" ondragstart=\"drag(event)\">
			<i class=\"grey-text material-icons tiny\">menu</i>
			<a href=\"/admin/pages/read/$o->id\">$o->name</a>	

			<a href=\"/admin/pages/index/?action=weight_down&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id&box_weight=$o->box_weight\"><i class=\"material-icons tiny\">arrow_drop_down</i></a>
			<small>$o->box_weight</small>	
			<a href=\"/admin/pages/index/?action=weight_up&dir=$o->dir&file=$o->file&id=$o->id&boxes_id=$o->boxes_id&box_weight=$o->box_weight\"><i class=\"material-icons tiny\">arrow_drop_up</i></a>

			<small class=\"box_width$o->id\" data-toggle2=\".box_width$o->id\">
				$o->box_width
			</small>
			<form action=\"/admin/pages/width/$o->id\" class=\"box_width$o->id inline w-auto\" data-ajax=\"small.box_width$o->id\" method=\"post\" style=\"display:none\">
				<input type=\"text\" name=\"box_width\" value=\"$o->box_width\">
				<button type=\"submit\" data-toggle=\".box_width$o->id\"><i class=\"material-icons tiny\">check</i></button>
			</form>
			
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
	</fieldset>
</div>";
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
