<?php
/**
 * PHP version 5
 * LICENSE
 *
 * This source file is subject to the GNU/GPL that is bundled
 * with this package in the file docs/LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to distrotuz@gmail.com so we can send you a copy immediately.
 *
 * @author demomnio69 #kumbiaphp
 */

class _page
{
	/**
	 * Devuelve las primeras etiquetas de comienzo de un documento html doctype+html+head+title
	 * 
	 * @param string $title titulo del documento html
	 * @return string
	 */                                                
	static public function beg_( $title, $charset='utf-8', $attr=array() )
	{
		$flash = _flash::_return_();
		_css::_file_( 'fw' );
		_css::_file_( 'style' );
		
		$s =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		$s .= "\n<html>";
			$s .= "\n\t<head>";
				$s .= "\n\t\t<meta http-equiv=\"Content-type\" content=\"text/html; charset=$charset\" />";
				$s .= "\n\t\t<title>$title</title>";
				$s .= _css::_echo_();
			$s .= "\n\t</head>";
			$s .= "\n\t<body>";
				$s .= "\n\t\t<div class=\"flash\">$flash</div>";
		$_SESSION['css'] = array();
		return $s;
	}

	/**
	 * Devuelve la etiqueta de cierre body y html
	 *
	 * @return string
	 */                                                
	static public function _end()
	{
		_js::_file_( 'jquery' );

			$s = "\n\t<br />&nbsp;</body>";
		$s .= "\n</html>\n\n";
		$s .= _js::_echo_();
		$_SESSION['js'] = array();
		return $s;
	}

	/**
	 * Devuelve la capa de contenido
	 *
	 * @return string
	 */                                                
	static public function _content_()
	{	
		$s = "\n\t\t<div style=\"float:left; position:relative\">";
			$s .= "\n\t\t\t" . View::content( 1 );
		$s .= "\n\t\t</div>";
		return $s;
	}

	/**
	 * Imprime la variable de sesion con nombre "css"
	 * 
	 * @return string
	 */                                                
	static public function _css_()
	{
		$s = '';
		
		if ( ! empty( $_SESSION['css']['file'] ) )
		{
			foreach ($_SESSION['css']['file'] as $file)
			{
				$s .= "\n\t\t$file";
			}
		}
		return $s;
	}
	
	/**
	 * Devuelve los scripts incluidos con _js::_inc_
	 */                                                
	static public function _js_()
	{
		$s = '';
		
		if ( ! empty( $_SESSION['js']['file'] ) )
		{
			if ( array_key_exists( 'jquery', $_SESSION['js']['file'] ) )
			{
				$s .= $_SESSION['js']['file']['jquery'] . "\n";
				unset( $_SESSION['js']['file']['jquery'] );
			}
			
			foreach ($_SESSION['js']['file'] as $file)
			{
				$s .= "$file\n";
			}
		}
		
		$s .= "\n" . _page::tag_('script') . "\n";
		
		if ( ! empty( $_SESSION['js']['add'] ) )
		{
			foreach ($_SESSION['js']['add'] as $script)
			{
				$s .= "\n$script\n";
			}
		}
		
		if ( ! empty( $_SESSION['js']['fn'] ) )
		{
			foreach ($_SESSION['js']['fn'] as $script)
			{
				$s .= "\n$script\n";
			}
		}
		
		if ( ! empty( $_SESSION['js']['ready'] ) )
		{
			$s .= "\n$(function()\n";
			$s .= "{";
				foreach ($_SESSION['js']['ready'] as $script)
				{
					$s .= "\t$script\n";
				}
			$s .= "});\n\n";
		}
		
		if ( ! empty( $_SESSION['js']['resize'] ) )
		{
			$s .= "$(window).resize(function()\n";
			$s .= "{";
				foreach ($_SESSION['js']['resize'] as $script)
				{
					$s .= "\n\t$script\n";
				}
			$s .= "});\n\n";
		}
		$s .= "</script>\n";
		return $s;
	}

	/**
	 * Comienzo de columna
	 * 
	 * @return string
	 */                                                
	static public function col_( $attr=array() )
	{
		if ( is_string( $attr ) ) $attr['id'] = $attr;
		
		$attr['class'] = empty( $attr['class'] ) ? 'column' : 'column ' . $attr['class'];		
		if ( ! empty( $attr['type'] ) )
		{
			$attr['class'] .= ' ' . $attr['type'];
			$attr['type'] = '';
		}
		
		if ( ! empty( $attr['width'] ) )
		{
			$width = 'width:' . $attr['width'] . 'px';
			$attr['style'] = empty( $attr['style'] ) ? $width : $width . ' ' . $attr['style'];
			$attr['width'] = '';
		}

		return self::tag_('div', $attr);
	}
	
	/**
	 * Comienzo de columna
	 * 
	 * @return string
	 */                                                
	static public function _col()
	{
		return "</div>";
	}
	
	/**
	 * Comienzo de columnas
	 * 
	 * @param int $cols numero de columnas
	 * @return string
	 */                                                
	static public function cols_($cols)
	{
		return "<div class=\"unit on-$cols columns\">";
	}
	
	/**
	 * Comienzo de columnas
	 * 
	 * @return string
	 */                                                
	static public function _cols()
	{
		return "</div>";
	}
	
	/**
	 * Comienzo de fila o bloque
	 * 
	 * @return string
	 */                                                
	static public function row_( $x=array() )
	{
		if ( is_string( $x ) ) $attr['id'] = $x;
		return self::tag_('div', $attr);
	}
	
	/**
	 * Final de fila o bloque
	 * 
	 * @return string
	 */                                                
	static public function _row()
	{
		return '</div>';
	}
	
	/**
	 * Devuelve una cadena de atributos y valores para una etiqueta html desde un array
	 *
	 * @param mix $attr titulo del documento html
	 * @return string
	 */                                        
	static public function to_attr( $attr=null )
	{
		// Si $attr es una cadena de texto no hay nada que convertir
		if ( ! is_array( $attr)  ) return $attr;
		
		$s = '';
		foreach ( $attr as $k => $v )
		{
			if ( empty( $v ) )
			{
				continue;
			}
			// Si el array es tridimensional $attr['div']['class']='red'
			else if ( is_array( $v ) )
			{
				$s .= self::to_attr( $v );
			}
			else
			{
				if ( defined( 'PUBLIC_PATH' ) )
				{
					if ( $k == 'href' or $k == 'src' )
					{
						$v = PUBLIC_PATH . ltrim( $v, '/' );
					}
				}
				$s .= " $k=\"$v\"";
			}
		}
		return $s;
	}
	
	/**
	 * Devuelve una etiqueta html "corta" (que no tiene etiqueta de cierre)
	 *
	 * @param string $tag etiqueta html "corta" /^area|base|basefont|br|col|hr|img|input|link|meta|param$/
	 * @param mix $attr lista de atributos ej: $attr['class']='red'
	 * @return string
	 */                                                
	static public function _tag_( $tag, $attr=null )
	{
		if ( $tag=='link' )
		{
			if ( empty( $attr['rel'] ) ) $attr['rel'] = 'stylesheet';
			if ( empty( $attr['type'] ) ) $attr['type'] = 'text/css';
		}
		$s = $attr ? self::to_attr( $attr ) : '';			
		return "<$tag$s />";
	}

	/**
	 * Devuelve una etiqueta de apertura html con sus atributos
	 *
	 * @param string $tag etiqueta html
	 * @param mix $attr lista de atributos ej: $attr['class']='red'
	 * 
	 * @return string
	 */                                                
	static public function tag_( $tag, $attr=null )
	{
		if ( $tag=='comment' )
		{
			return '<!--';
		}
		else if ( $tag=='input' )
		{
			if ( empty( $attr['type']) ) $attr['type']='text';
		}
		else if  ($tag=='script')
		{
			if ( empty( $attr['type']) ) $attr['type']='text/javascript';
		}
		
		$s = $attr ? self::to_attr($attr) : '';
				
		return "<$tag$s>";
	}

	/**
	 * Devuelve una etiqueta de cierre html
	 * 
	 * @return string
	 */                                                
	static public function _tag( $tag )
	{
		if ( $tag=='comment' )
		{
			return '-->';
		}
		return "</$tag>";
	}
	
	/**
	 * Devuelve una cadena entre una etiqueta html de apertura y cierre
	 *
	 * @param string $s cadena de texto o html
	 * @param string $tag etiqueta html
	 * @param mix $attr lista de atributos ej: $attr['class']='red'
	 * 
	 * @return string
	 */                                                
	static public function _wrap_( $s, $tag, $attr=null )
	{
		return self::tag_( $tag, $attr ) . $s . self::_tag( $tag );
	}
	
	/**
	 * Devuelve el valor de una variable
	 * 
	 * @param mix $mix variable
	 * @param string $wrap por defecto se devulve el resultado entre etiquetas pre
	 */			
	static public function _text_( $mix, $wrap='pre' )
	{
		$s = htmlentities( print_r($mix, 1), ENT_QUOTES );
		if ( ! $wrap ) return $s;
		else return _page::_wrap_($s, $wrap);
	}
	
	/**
	 * Devuelve una etiqueta span con style color red
	 *
	 * @param string $s cadena de texto o html
	 * @return string
	 */			
	static public function _red_($s)
	{
		 return self::_wrap_( $s, 'span', ' style="color:red"' );
	}
}
