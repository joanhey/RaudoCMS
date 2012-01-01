<?php

class Versiones
{
	public function leyendo( $get )
    {
		$carpetas = dirname( $get['f'] );
		if ( $carpetas ) $carpetas .= '/';

		$pagina = basename( $get['f'] );
		if ( file_exists( APP_PATH . "temp/versiones/$carpetas$pagina" ) )
		{
			$versiones = glob( APP_PATH . "temp/versiones/$carpetas$pagina/*" );
			return count( $versiones );
		}
		else
		{
			$log = mkdir( APP_PATH . "temp/versiones/$carpetas$pagina", 0777, 1 );
			return '0';
		}
	}
	
	public function editando( $dir, $pagina, $codigo )
    {
		$raiz = APP_PATH  . 'views/pages';
		$carpetas = str_replace( $raiz, '', $dir );
		$carpetas = trim( $carpetas, '/' );
		if ( $carpetas ) $carpetas .= '/';
		
		$ver = $this->leyendo( $dir, $pagina, $codigo );
		++$ver;
		$codigo_viejo = _fs::readFile( "$dir/$pagina" );
		_fs::createFile( APP_PATH . "temp/versiones/$carpetas$pagina/$ver", $codigo_viejo );
		
		if ( _fs::updateFile( "$dir/$pagina", $codigo ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página actualizada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error editando' );
		}
	}
}
