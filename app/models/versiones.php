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
	
	public function editando( $get, $post )
    {
		$carpetas = dirname( $get['f'] );
		if ( $carpetas ) $carpetas .= '/';

		$pagina = basename( $get['f'] );
		
		$ver = $this->leyendo( $get );
		++$ver;

		$codigo_viejo = Load::model( 'ficheros' )->leerFichero( $get );
		_fs::createFile( APP_PATH . "temp/versiones/$carpetas$pagina/$ver", $codigo_viejo );
		
		if ( _fs::updateFile( APP_PATH . "views/pages/$pagina", $post['codigo'] ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página actualizada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error editando' );
		}
	}
}
