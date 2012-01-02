<?php

class _fs
{    
    static public function replaceFileNames( $str_old, $str_new, $dir_root, $confirm=0 )
    {
		set_time_limit( 0 );
		
		$path = explode( '/', $dir_root );
		$dir_root = array_pop( $path );
		$path = join( '/', $path );
		
		$items = scandir( "$path/$dir_root" );

		foreach ( $items as $item )
		{
			if ( $item == '.' or $item == '..' ) continue;
			if ( is_dir( "$path/$dir_root/$item" ) ) continue;
			
			echo "$path/$dir_root/$item<br />";
						
			if ( strstr( $item, $str_old ) )
			{
				if ( $str_old == $str_new ) $str_new = '';
				$file_new = str_replace( $str_old, $str_new, $item );
				
				echo " |- $path/$dir_root/$item => $path/$dir_root/$file_new<br />";
				
				if ( $confirm )
				{
					$rename = rename( "$path/$dir_root/$item", "$path/$dir_root/$file_new" );
					var_dump( $rename );
					echo '<br />';			
				}
				
			}
			_::flush();		
		}
	}
	
    static public function eol_($file, $test=0)
    {
		return _str::eol_( self::readFile( $file ), $test );
	}
	
	# 2012
    static public function createDir( $path, $mode=0777 )
    {
       mkdir( $path, $mode, 1 );
    }
	
    static public function readDir($dir, $and=array())
    {
		if ( ! file_exists($dir) ) return 'lost';
		if ( ! is_readable($dir) ) return 'deny';
				
		$items = scandir($dir);
		foreach ($items as $item)
		{
			if ( empty($and['all']) and preg_match('/^\.{1,2}$/', $item) ) continue; # NADA DE . O ..
			
			$fullpath = rtrim($dir, '/') . '/' . $item;
			if ( is_dir($fullpath) )
			{
				if ( ! empty($and['dir-deny']) and in_array($item, $and['dir-deny']) ) continue; # NADA DE LO NEGADO
				if ( ! empty($and['dir-allow']) and ! in_array($item, $and['dir-allow']) ) continue; # SOLO LO PERMITIDO
	
				if ( empty( $and['recursive'] ) )
				{
					$a[$fullpath] = array();
				}
				else
				{
					$a[$fullpath] = self::readDir($fullpath, $and);
				}
			}
			else
			{
				if ( ! empty($and['file-deny']) and in_array($item, $and['file-deny']) ) continue; # NADA DE LO NEGADO
				if ( ! empty($and['file-allow']) and ! in_array($item, $and['file-allow']) ) continue; # SOLO LO PERMITIDO
				
				$a[] = $item;
			}
		}
		if ( ! empty($a) ) return $a;
	}
	
    static public function readDirs($dir, $and=array())
    {
		$and['recursive'] = 1;
		return self::readDir($dir, $and);
	}
	
    static public function readFile($file)
    {
        if ( ! file_exists($file) ) return "$file no exists!";

        if ( is_dir($file) ) return self::readFile($file);

        return file_get_contents($file);
    }
	
	# 2012
    static public function createFile( $file, $data='' )
    {
		if ( file_exists( $file ) ) return "$file exists!";

		$dir = dirname( $file );
		if ( ! file_exists( $dir ) ) self::createDir( $dir );
		
        return file_put_contents( $file, $data );
	}
	
	# 2012
    static public function updateFile( $file, $data )
    {
		if ( ! file_exists( $file ) ) return "$file no exists!";
	
		return file_put_contents( $file, $data );
    }
	
	# 2012
    static public function saveFile( $file, $data )
    {
		return file_exists( $file ) ? self::updateFile( $file, $data ) : self::createFile( $file, $data );
    }
	
    static public function deleteFile($file)
    {
        return unlink($file);
    }

	# 2012
    static public function deleteDir( $dir ) 
    {
		if ( ! file_exists( $dir ) ) return "$dir no exists!";
		
		if ( ! self::readDir( $dir ) ) rmdir( $dir );
    }
	
    static public function copyFile($from, $to)
    {
        $path = dirname($to);
		self::createDir($path);
        if ( copy($from, $to) ) return '<em>' . $from . ' => ' . $to . '<em> <strong>copiado!</strong><br />';
		else return 0;
    }
	
    static public function moveFile($from, $to)
    {
        if ( file_exists($to) ) return 0;

        $path = dirname($to);
		self::createDir($path);
        $copy = copy($from, $to);
		$unlink = unlink($from);
		if ($copy and $unlink) return '<em>' . $from . ' => ' . $to . '<em> <strong>movido!</strong><br />';
		else return 0;
    }
	
    static public function copyDir($from, $to)
    {
		$items = self::readDir($from);
		
		if ( ! $items ) return self::createDir($to); # SI NO HAY ARCHIVOS, FINALIZA CREANDO EL DIRECTORIO VACIO
		
		foreach ($items as $k => $v)
		{		
			if ( is_string($v) ) # ARCHIVO
			{
				self::copyFile($from . '/' .  $v, $to . '/' . $v);
			}
			else # DIRECTORIO
			{
				$dir = str_replace($from, '', $k);
				self::copyDir($k, $to . $dir);
			}
		}
    }	
	
    static public function moveDir($from, $to='')
    {
		$items = self::readDir($from);
		
		if ( ! $items ) return self::deleteDir($from);
		
		foreach ($items as $k => $v)
		{		
			if ( is_string($v) ) # ARCHIVO
			{
				$_SESSION['result'][] = self::moveFile($from . '/' .  $v, $to . '/' . $v);
			}
			else # DIRECTORIO
			{
				$dir = str_replace($from, '', $k);
				self::moveDir($k, $to . $dir);
			}
		}
		self::deleteDir($from);
    }	
	
    static public function parentDir($item)
    {
		#$item = trim($item, '/');
		
		$item = explode('/', $item);
		
		array_pop($item);
		
		return '/' . join('/', $item);
	}
}

?>