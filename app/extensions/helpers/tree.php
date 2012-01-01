<?php

function _tree( $ficheros, $raiz )
{
	#_::stop($ficheros);
	if ( empty( $ficheros ) ) return;
	
	$s = '';
	$directorio = '';
	foreach ( $ficheros as $k => $v )
	{
		if ( is_array( $v ) or ! $v )
		{
			$s .= "<li>" . basename( $k ) . "/</li>";
			$s .= _tree( $v, $raiz );	
			$directorio .= str_replace( $raiz, '', $k );
		}
		else
		{
			
			$s .= "<li><a href=\"admin/cms/ver?f=$directorio/$v\">$v</a></li>";
		}
	}
	return "<ul id=\"$k\">$s</ul>";
}
