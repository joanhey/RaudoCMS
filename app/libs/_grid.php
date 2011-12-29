<?php

/**
 * <form>		Defines an HTML form for user input
 * <input />	Defines an input control
 *   button
 *   checkbox
 *   file
 *   hidden
 *   image
 *   password
 *   radio
 *   reset
 *   submit
 *   text
 * <textarea> 	Defines a multi-line text input control
 * <label> 		Defines a label for an input element
 * <fieldset> 	Defines a border around elements in a form
 * <legend> 	Defines a caption for a fieldset element
 * <select> 	Defines a select list (drop-down list)
 * <optgroup> 	Defines a group of related options in a select list
 * <option> 	Defines an option in a select list
 * <button> 	Defines a push button
**/

class _grid
{    	
	static public function div_($size, $attr=array() )
	{
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::beg('div', $attr['div']);		
	}
	
	static public function _div()
	{
		return '</div>';
	}
	
	static public function div($size, $attr=array() )
	{
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::wrap('', 'div', $attr['div']);		
	}
	
	static public function form_($action='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('form') );
		
		$attr['form']['action'] = $action;		
		if ( empty($attr['form']['class']) ) $attr['form']['class'] = 'kugrid';
		else $attr['form']['class'] .= ' kugrid';		
		if ( empty($attr['form']['method']) ) $attr['form']['method'] = 'post';

		return Tag::beg('form', $attr['form']);
	}
		
	static public function _form()
	{
		return '</form>';
	}
		
	static public function _input_($size, $label='', $require='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('label', 'em', 'input', 'div') );

		if ($require) $require = ' ' . Tag::wrap($require, 'em', $attr['em']);
		$label = Tag::wrap($label . $require, 'label', $attr['label']);
		
		/*if ( empty($attr['input']['name']) ) $name = $attr['input']['name'] = Ku::to_var($label);
		else $name = $attr['input']['name'];
		if ( empty($attr['input']['value']) )
		{
			if ( ! empty($$name) ) $attr['input']['value'] = $$name; 
			else if ( ! empty($_POST[$name]) ) $attr['input']['value'] = $_POST[$name]; 
		}*/
		$input = Tag::beg('input', $attr['input']);
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::wrap($label . $input, 'div', $attr['div']);		
	}
	
	static public function list_($size, $label='', $require='', $attr=array())
	{
		$attr = Ku::is_empty($attr, array('div', 'label', 'em', 'ul') );
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		$div = Tag::beg('div', $attr['div']);
		
		if ($require) $require = ' ' . Tag::wrap($require, 'em', $attr['em']);	
		$label = Tag::wrap($label . $require, 'label', $attr['label']);
		
		return  $div . $label . Tag::beg('ul', $attr['ul']);
	}
	
	static public function _list()
	{
		return '</ul></div>';
	}
	
	static public function checkbox($label='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('input', 'label', 'li') );
		
		$attr['input']['type'] = 'checkbox';
		if (empty($attr['input']['name']) ) $attr['input']['name'] = Ku::to_var($label);
		$input = Tag::beg('input', $attr['input']);

		$label = Tag::wrap($label, 'label', $attr['label']);
		
		return Tag::wrap($input . $label, 'li', $attr['li']);
	}
		
	static public function file()
	{
		
	}
			
	static public function hidden($name, $value='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('input') );
		
		$attr['input']['type'] = 'hidden';
		$attr['input']['id'] = $name;
		$attr['input']['name'] = $name;
		$attr['input']['value'] = $value;
		return Tag::beg('input', $attr);
	}
		
	static public function image()
	{
		
	}
		
	static public function password()
	{
		
	}
		
	static public function radio($label='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('input', 'label', 'li') );
		
		$attr['input']['type'] = 'radio';
		if (empty($attr['input']['name']) ) $attr['input']['name'] = Ku::to_var($label);
		$input = Tag::beg('input', $attr['input']);

		$label = Tag::wrap($label, 'label', $attr['label']);

		return Tag::wrap($input . $label, 'li', $attr['li']);
	}
		
	static public function reset()
	{
		
	}
		
	static public function submit()
	{
		
	}
		
	static public function textarea($size, $label='', $require='', $attr=array(), $text='')
	{
		$attr = Ku::is_empty($attr, array('label', 'em', 'textarea', 'div') );

		if ($require) $require = ' ' . Tag::wrap($require, 'em', $attr['em']);
		$label = Tag::wrap($label . $require, 'label', $attr['label']);
		
		/*if ( empty($attr['textarea']['name']) ) $name = $attr['textarea']['name'] = Ku::to_var($label);
		if ( ! $text)
		{
			if ( ! empty($name) and ! empty($_POST[$name]) ) $text = $_POST[$name];
			else $text = '';
		}*/
		$textarea = Tag::wrap($text, 'textarea', $attr['textarea']);
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::wrap($label . $textarea, 'div', $attr['div']);		
	}
		
	static public function label($size, $text='', $require='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('label', 'em', 'div') );
		
		if ($require) $require = Tag::wrap($require, 'em', $attr['em']) . ' ';	
		$label = Tag::wrap($require . $text, 'label', $attr['label']);
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::wrap($label, 'div', $attr['div']);		
	}
		
	static public function fieldset_($size, $legend='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('fieldset', 'legend', 'div') );
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		$div = Tag::beg('div', $attr['div']);

		if ( empty($attr['fieldset']['class']) ) $attr['fieldset']['class'] = "fieldset";
		else $attr['fieldset']['class'] .= " fieldset";		
		$fieldset = Tag::beg('div', $attr['fieldset']);

		if ($legend) $legend = "<div class=\"legend\">$legend</div>";
		
		return $div . $fieldset . $legend;
	}
		
	static public function _fieldset()
	{
		return '</div></div>';
	}
		
	static public function select($size, $label='', $require='', $attr=array(), $options=array(), $selected='')
	{
		$s = self::select_($size, $label, $require, $attr);
		
		foreach ($options as $k => $v)
		{
			if ($selected == $k) $option['selected'] = 'selected';
			else if ( isset($option['selected']) ) unset($option['selected']);
			
			$option['name'] = $k;
			$option['value'] = $v;
			
			$s .= Tag::wrap(ucfirst($k), 'option', $option);
		}
		
		return $s .= self::_select();
	}
	
	static public function select_($size, $label='', $require='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('div', 'label', 'em', 'select') );
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		$div = Tag::beg('div', $attr['div']);
		
		if ($require) $require = ' ' . Tag::wrap($require, 'em', $attr['em']);	
		$label = Tag::wrap($label . $require, 'label', $attr['label']);
				
		return $div . $label . Tag::beg('select', $attr['select']);
	}
	
	static public function _select()
	{
		return '</select></div>';
	}
		
	static public function optgroup()
	{
		
	}
		
	static public function option($text='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('option') );
		
		return Tag::wrap($text, 'option', $attr['option']);		
	}
		
	static public function button($size, $text='', $attr=array() )
	{
		$attr = Ku::is_empty($attr, array('button', 'div') );
						
		if (empty($attr['button']['type']) ) $attr['button']['type'] = 'submit';
		$button = Tag::wrap($text, 'button', $attr['button']);
		
		if ( empty($attr['div']['class']) ) $attr['div']['class'] = "size-$size";
		else $attr['div']['class'] .= " size-$size";		
		return Tag::wrap($button, 'div', $attr['div']);		
	}
	
	static public function _sizes()
	{
		$_SESSION['js'] .=
		"
			function _sizes()
			{
				$('.kugrid .fieldset, .kugrid input[type=\"text\"], .kugrid label, .kugrid option, .kugrid select, .kugrid textarea').each(function()
				{
					var parent = $(this).parent('div');
					var parent_widht = $(parent).width();
					var padding_right = $(this).css('padding-right');
					var padding_left = $(this).css('padding-left');
					var width = parent_widht-(parseInt(padding_right)+parseInt(padding_left));
					$(this).width(width+'px');
				});
			}
			
			$(function()
			{
				_sizes();
			});
	
			$(window).resize(function()
			{ 
				_sizes();
			});
		";
	}
}