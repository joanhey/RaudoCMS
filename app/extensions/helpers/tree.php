<?php

function _tree( $a )
{
	#_::stop($a);
	if ( empty( $a ) ) return;
	
	$s = '';
	foreach ( $a as $k => $v )
	{
		if ( is_array( $v ) or ! $v )
		{
			$s .= "<li>" . basename( $k ) . "/</li>";
			$s .= _tree( $v );
			
		}
		else
		{
			$s .= "<li>$v</li>";
		}
	}
	return "<ul id=\"$k\">$s</ul>";
}
