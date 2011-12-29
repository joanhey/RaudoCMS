<?php

class _array
{    
    static public function applyFn( $fn, $a )
	{
		$b = array();
		foreach( $a as $k => $v )
		{
			$b[ $k ] = ( is_array( $v ) ? _array::applyFn( $fn, $v ) : $fn( $v ) );
		}
		return $b;
	}
}
