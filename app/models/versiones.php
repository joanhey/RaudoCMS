<?php

class Versiones
{
	public function leyendo( $pagina, $codigo )
    {
		$pagina = basename( $pagina );
		if ( file_exists( APP_PATH . "temp/versiones/$pagina" ) )
		{
			$versiones = glob( APP_PATH . "temp/versiones/$pagina/*" );
			return count( $versiones );
		}
		else
		{
			$log = mkdir( APP_PATH . "temp/versiones/$pagina", 0777 );
			return '0';
		}
	}
	
	public function editando( $dir, $pagina, $codigo )
    {
		$ver = $this->leyendo( "$dir/$pagina", $codigo );
		++$ver;
		$codigo_viejo = _fs::readFile( "$dir/$pagina" );
		_fs::createFile( APP_PATH . "temp/versiones/$pagina/$ver", $codigo_viejo );
		
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
