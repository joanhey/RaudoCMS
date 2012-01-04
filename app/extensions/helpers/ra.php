<?php

class Ra {

	public static function tree( $ficheros, $padre='' )
	{
		if ( empty( $ficheros ) ) return;
	
		$s = '';
		foreach ( $ficheros as $k => $v )
		{
			if ( is_array( $v ) or ! $v )
			{
				echo "<li>" , basename( $k ) , "/</li>";
				$futuro_padre = str_replace( APP_PATH . "views/pages/", '', $k ) . '/';
				$s .= _tree( $v, $futuro_padre );	
			}
			else
			{			
				echo '<li>' , Html::link("admin/cms/editar/$padre$v", $v) , '</li>';
			}
		}
		return "<ul id=\"$k\">$s</ul>";
	}
}
