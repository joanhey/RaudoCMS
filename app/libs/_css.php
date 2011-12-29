<?php

class _css
{	
	protected static $_content = array();
	
	/**
	 * Almacena en un variable de sesion con nombre "css" un enlace "<link..." hacia una hoja de estilos
	 * 
	 * @param string $file ruta de la hoja de estilos
	 * @param mix $attr lista de atributos ej: $attr['class']='red'
	 */                                                
	static public function _file_( $file, $attr=null )
	{
		$attr['href'] = "css/$file.css";
		self::$_content['css']['file'][$file] = _page::_tag_( 'link', $attr );
	}

	/**
	 * Imprime la variable de sesion con nombre "css"
	 * 
	 * @return string
	 */                                                
	static public function _echo_()
	{
		$s = '';
		
		if ( ! empty( self::$_content['css']['file'] ) )
		{
			foreach ( self::$_content['css']['file'] as $file )
			{
				$s .= "\n\t\t$file";
			}
		}
		return $s;
	}
}
