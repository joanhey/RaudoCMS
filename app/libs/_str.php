<?php

class _str
{    
	/**
	 * TESTING AT 26-08-11
	 */
	static function cleanSpaces( $s )
	{
		return preg_replace( '/\s+/', '', $s );
	}

	/**
	 * TESTING AT 26-08-11
	 */
	static function cleanJumps( $s )
	{
		return preg_replace( '/(\r\n|\r|\n)+/', '', $s );
	}

	/**
	 * TESTING AT 26-08-11
	 */
	static function reduceSpaces( $s )
	{
		$s = preg_replace( '/ +/', ' ', $s );
		return trim( $s );
	}

	/**
	 * TESTING AT 26-08-11
	 */
	static function cleanTabs( $s )
	{
		return preg_replace( '/\t+/', '', $s );
	}

    static public function slug( $s )
    {
        /*$search = explode( ',', 'ç,Ç,ñ,Ñ,æ,Æ,œ,á,Á,é,É,í,Í,ó,Ó,ú,Ú,à,À,è,È,ì,Ì,ò,Ò,ù,Ù,ä,ë,ï,Ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Š,Œ,Ž,š,¥' );
        $replace = explode( ',', 'c,C,n,N,ae,AE,oe,a,A,e,E,i,I,o,O,u,U,a,A,e,E,i,I,o,O,u,U,ae,e,i,I,oe,ue,y,a,e,i,o,u,a,e,i,o,u,s,o,z,s,Y' );
        $s = str_replace( $search, $replace, $s );*/
        $s = preg_replace( '/[^a-z0-9_]/i', '-', $s );
		return $s;
	}

    static public function _cut($s, $a)
    {
		foreach ($a as $k => $v)
		{
			$fn = "_$k";
			$s = self::$fn($s, $v);
		}
		return $s;
    }
		static public function _beg($s, $beg)
		{
			$a = explode($beg, $s);
			return $a[1];
		}
		
		static public function _end($s, $end)
		{
			$a = explode($end, $s);
			return $a[0];
		}

	static public function eol_($s, $test=0)
	{
		if ($test)
		{
			if ( strstr($s, "\r\n") ) die( 'eol windows!' );
			else if ( strstr($s, "\n") ) die( 'eol linux!' );	
			else if ( strstr($s, "\r") ) die( 'eol mac!' );
			else die ( 'no eol in file!' );
		}
		
		if ( strstr($s, "\r\n") ) return "\r\n";
		else if ( strstr($s, "\n") ) return "\n";		
		else if ( strstr($s, "\r") ) return "\r";
	}
	
	static public function _pre($mix)
	{
		return '<pre>' . htmlentities(print_r($mix, 1), ENT_QUOTES) . '</pre>';
	}
	
		static public function _die($mix)
		{
			die( self::_pre($mix) );
		}
	
	static public function _html($s, $charset='UTF-8')
	{
		if ( defined('APP_CHARSET') ) $charset = APP_CHARSET;
		
		return htmlentities($s, ENT_QUOTES, $charset);
	}
}
