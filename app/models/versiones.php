<?php

class Versiones
{
	public function guardarVersion( $pagina )
    {		
		$ver = $this->obtenerVersion( $pagina );
		++$ver;

		$codigo_viejo = Load::model( 'ficheros' )->leerFichero( $pagina );
		_fs::createFile( APP_PATH . "temp/versiones/$pagina/$ver", $codigo_viejo );
	}
	
	public function obtenerVersion( $pagina )
    {
		$pagina = Load::model( 'ficheros' )->filtrarEntrada( $pagina );
		
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
}
