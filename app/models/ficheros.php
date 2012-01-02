<?php

class Ficheros
{
	public function leerDirectorio()
    {
		// CONTENIDO DEL DIRECTORIO
		return _fs::readDirs( APP_PATH . "views/pages/" );
	}
	
	public function leerFichero( $parameters )
    {
		$pagina = join( '/', $parameters );		
		
		// CONTENIDO DEL FICHERO
		return _fs::readFile( APP_PATH . "views/pages/$pagina" );
	}
	
	
	/*public function ver( $get )
    {
		// DIRECTORIO POR DEFECTO
		$a['directorio'] = empty( $get['d'] ) ? '' : $get['d'];
		// NO SE PERMITE INTRODUCIR ..
		$a['directorio'] = str_replace( '..', '', $a['directorio'] );
		
		// DIRECTORIO PADRE	REAL
		$a['padre'] = realpath( APP_PATH . "views/pages/{$a['directorio']}/.." ) . '/';
		// DIRECTORIO PADRE RELATIVO
		$a['padre'] = str_replace( APP_PATH . 'views/pages/', '', $a['padre'] );
		
		// CONTENIDO DEL DIRECTORIO
		$a['ficheros'] = _fs::readDir( APP_PATH . "views/pages/{$a['directorio']}" );

		// ARCHIVO POR DEFECTO
		$a['fichero'] = empty( $get['f'] ) ? '' : $get['f'];
		
		return $a;
	}*/
}
