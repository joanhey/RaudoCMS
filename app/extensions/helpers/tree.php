<?php

function _tree( $ficheros, $padre='' )
{
	if ( empty( $ficheros ) ) return;
	
	$s = '';
	foreach ( $ficheros as $k => $v )
	{
		if ( is_array( $v ) or ! $v )
		{
			$s .= "<li>" . basename( $k ) . "/</li>";
			$futuro_padre = str_replace( APP_PATH . "views/pages/", '', $k ) . '/';
			$s .= _tree( $v, $futuro_padre );	
		}
		else
		{			
			$s .= "<li><a href=\"admin/cms/editar/$padre$v\">$v</a></li>";
		}
	}
	return "<ul id=\"$k\">$s</ul>";
}
