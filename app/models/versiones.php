<?php

class Versiones
{
	public function leyendo( $parameters )
    {
		$ruta = join( '/', $parameters );		
		
		$carpetas = dirname( $ruta );
		if ( $carpetas ) $carpetas .= '/';

		$pagina = basename( $ruta );

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
	
	public function editando( $parameters, $post )
    {
		$ruta = join( '/', $parameters );		
		
		$carpetas = dirname( $ruta );
		if ( $carpetas ) $carpetas .= '/';

		$pagina = basename( $ruta );
		
		$ver = $this->leyendo( $parameters );
		++$ver;

		$codigo_viejo = Load::model( 'ficheros' )->leerFichero( $parameters );
		_fs::createFile( APP_PATH . "temp/versiones/$carpetas$pagina/$ver", $codigo_viejo );
		
		if ( _fs::updateFile( APP_PATH . "views/pages/$ruta", $post['codigo'] ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página actualizada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error editando' );
		}
	}
}
