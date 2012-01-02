<?php

class Versiones
{
	public function leyendo( $pagina )
    {
		if ( file_exists( APP_PATH . "temp/versiones/$pagina" ) )
		{
			$versiones = glob( APP_PATH . "temp/versiones/$pagina/*" );
			return count( $versiones );
		}
		else
		{
			$log = mkdir( APP_PATH . "temp/versiones/$pagina", 0777, 1 );
			return '0';
		}
	}
	
	public function editando( $pagina, $codigo )
    {
		# SEGURIDAD: .. fuera y mas de una barra a una
		$pagina = str_replace( '..', '', $pagina );
		$pagina = preg_replace( '/\/{2,}/', '/', $pagina );	
		
		$ver = $this->leyendo( $pagina );
		++$ver;

		$codigo_viejo = Load::model( 'ficheros' )->leerFichero( $pagina );
		_fs::createFile( APP_PATH . "temp/versiones/$pagina/$ver", $codigo_viejo );
		
		if ( _fs::saveFile( APP_PATH . "views/pages/$pagina", $codigo ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página salvada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error salvando' );
		}
	}
}
