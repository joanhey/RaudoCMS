<?php

class Ficheros
{
	public function filtrarEntrada( $pagina )
    {
		# SEGURIDAD: .. fuera y mas de una barra a una
		$pagina = str_replace( '..', '', $pagina );
		return preg_replace( '/\/{2,}/', '/', $pagina );	
	}
	
	public function leerDirectorio()
    {
		# CONTENIDO DEL DIRECTORIO
		$pagina = $this->filtrarEntrada( $pagina );
		return _fs::readDirs( APP_PATH . "views/pages/" );
	}
	
	public function leerFichero( $pagina )
    {
		# CONTENIDO DEL FICHERO
		$pagina = $this->filtrarEntrada( $pagina );
		return _fs::readFile( APP_PATH . "views/pages/$pagina" );
	}
	
	public function salvarFichero( $pagina, $codigo )
    {
		$pagina = $this->filtrarEntrada( $pagina );
		Load::model( 'versiones' )->guardarVersion( $pagina );
				
		if ( _fs::saveFile( APP_PATH . "views/pages/$pagina", $codigo ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página salvada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error salvando' );
		}
	}
	
	public function borrarFichero( $pagina )
    {
		$pagina = $this->filtrarEntrada( $pagina );
		Load::model( 'versiones' )->guardarVersion( $pagina );
		
		if ( _fs::deleteFile( APP_PATH . "views/pages/$pagina" ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página borrada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error borrando' );
		}
	}
}
