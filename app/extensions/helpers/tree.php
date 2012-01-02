<?php

function _tree( $ficheros )
{
	if ( empty( $ficheros ) ) return;
	
	$s = '';
	$directorio = '';
	foreach ( $ficheros as $k => $v )
	{
		if ( is_array( $v ) or ! $v )
		{
			$s .= "<li>" . basename( $k ) . "/</li>";
			$s .= _tree( $v );	
			$directorio .= str_replace( APP_PATH . 'views/pages/', '', $k ) . '/';
		}
		else
		{
			
			$s .= "<li><a href=\"admin/cms/editar/$directorio$v\">$v</a></li>";
		}
	}
	return "<ul id=\"$k\">$s</ul>";
}
