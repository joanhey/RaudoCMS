<?php

class _curl
{
	static function file( $url, $dest )
	{
		$i = curl_init();
		curl_setopt( $i, CURLOPT_URL, $url );
		$referer = _str::_cut( $url, array( 'beg' => 'http://', 'end' => '/' ), 1 );
		curl_setopt( $i, CURLOPT_REFERER, $referer );
		curl_setopt( $i, CURLOPT_HEADER, 0 );
		$browser = 'Mozilla/4.0 ( compatible; MSIE 5.01; Windows NT 5.0 )';
		curl_setopt( $i, CURLOPT_USERAGENT, $browser );
		if ( ! $f = fopen( $dest, 'w' )  ) die(  "ERROR: la ruta de destino '$dest' no existe."  );
		curl_setopt( $i, CURLOPT_FILE, $f );
		curl_exec( $i );
		// Comprobar si occurió algún error
		if ( curl_errno( $i )  )
		{
			echo ' <span style="background:yellow">ERROR</span><br />';
			echo 'Curl error: ' . curl_error( $i ) . '<hr />';
		}
		else
		{
			echo ' <span style="color:green">A LA SACA</span><hr />';
		}
		_::flush();
		if ( $f ) fclose( $f );
		curl_close( $i );
	}

	static function str( $url )
	{
		$i = curl_init(); # initialize curl handle
		curl_setopt($i, CURLOPT_HEADER, 1);
		curl_setopt($i, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($i, CURLOPT_HTTPGET, 1);
		curl_setopt($i, CURLOPT_URL, $url );
		curl_setopt($i, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt($i, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		
		/*echo '<pre>';
		var_dump(curl_exec($i));
		var_dump(curl_getinfo($i));
		var_dump(curl_error($i));
		die;*/
		
		/*$i = curl_init(); # initialize curl handle
		curl_setopt( $i, CURLOPT_URL, $url ); # set url to post to
		curl_setopt( $i, CURLOPT_FAILONERROR, 1 ); # Fail on errors
		#curl_setopt( $i, CURLOPT_FOLLOWLOCATION, 1 ); # allow redirects
		curl_setopt( $i, CURLOPT_RETURNTRANSFER, 1 ); # return into a variable
		#curl_setopt( $i, CURLOPT_PORT, 80 ); # Set the port number
		#curl_setopt( $i, CURLOPT_TIMEOUT, 15 ); # times out after 15s
		$browser = 'Mozilla/4.0 ( compatible; MSIE 5.01; Windows NT 5.0 )';
		curl_setopt( $i, CURLOPT_USERAGENT, $browser );
		$code = curl_exec( $i );
		// Comprobar si occurió algún error
		if ( curl_errno( $i )  )
		{
			echo ' <span style="background:yellow">ERROR</span><br />';
			echo 'Curl error: ' . curl_error( $i ) . '<hr />';
		}
		curl_close( $i );*/
		return $code;
	}
	
	static function get( $url, $dest, $pat='' )
	{
		if ( ! $pat ) $pat = array( 'beg'=>'<body', 'end'=>'</body>' );

		$code = self::str( $url );
		$part = _str::_cut( $code, $pat );
		$a = explode( '<img ', $part );
		array_shift( $a );
		
		#_::stop( $a );
		
		foreach ( $a as $v )
		{
			$src = _str::_cut( $v, array( 'beg' => 'src="', 'end' => '"' )  );			
			if ( ! strstr( $src, '.jpg' ) ) continue;
			$alt = _str::_cut( $v, array( 'beg' => 'alt="', 'end' => '"' )  );
			$alt = str_replace( 'Æ', 'Ae', $alt );
			$alt = preg_replace( '/[^a-zA-Z0-9\.]/', '_', $alt );

			if ( preg_match( '/^(Forest|Island|Mountain|Plains|Swamp)$/', $alt ) )
			{
				if ( empty( $n ) ) $n = 100;
				++$n;
				$basic_land = "__$n_";
			}
			else
			{
				$basic_land = '';
			}

			echo $img = "$dest$alt$basic_land.full.jpg";
			if ( file_exists( $img ) )
			{
				echo ' <span style="color:blue">YA LA TENIAS</span><hr />';
				_::flush();
				continue;
			}
			
			_curl::file( $src, $img );			
		}
	}
}
