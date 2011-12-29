<?php

class _js
{	
	protected static $_content = array();
	
	/**
	 * 21 NOV 2010
	 */                                                
	static public function inc( $file )
	{
		echo '
<script type="text/javascript">

$(function()
{
';
		self::_inc_( $file );
		echo '
});

</script>';	
	}
	
	/**
	 * 21 NOV 2010
	 */                                                
	static public function inc_( $file )
	{
		echo '
<script type="text/javascript">

$(function()
{
';
		self::_inc_( $file );
	}
	
	/**
	 * 21 NOV 2010
	 */                                                
	static public function _inc_( $file )
	{
		include PUB_PATH . "javascript/$file.js";
	}
	
	/**
	 * 21 NOV 2010
	 */                                                
	static public function _inc( $file )
	{
		self::_inc_( $file );
		echo '
});

</script>';	
	}
	
	/**
	 * Devuelve los scripts incluidos con _js::_inc_
	 */                                                
	static public function _echo_()
	{
		echo self::_return_();
	}
	
	/**
	 * Devuelve los scripts incluidos con _js::_inc_
	 */                                                
	static public function _return_()
	{
		$s = '';
		
		if ( ! empty( self::$_content['js']['file'] ) )
		{
			if ( array_key_exists( 'jquery', self::$_content['js']['file'] ) )
			{
				$s .= self::$_content['js']['file']['jquery'] . "\n";
				unset( self::$_content['js']['file']['jquery'] );
			}
			
			foreach ( self::$_content['js']['file'] as $file)
			{
				$s .= "$file\n";
			}
		}
		
		$s .= "\n" . _page::tag_('script') . "\n";
		
		if ( ! empty( self::$_content['js']['add'] ) )
		{
			foreach ( self::$_content['js']['add'] as $script)
			{
				$s .= "\n$script\n";
			}
		}
		
		if ( ! empty( self::$_content['js']['fn'] ) )
		{
			foreach ( self::$_content['js']['fn'] as $script)
			{
				$s .= "\n$script\n";
			}
		}
		
		if ( ! empty( self::$_content['js']['ready'] ) )
		{
			$s .= "\n$(function()\n";
			$s .= "{";
				foreach ( self::$_content['js']['ready'] as $script)
				{
					$s .= "\t$script\n";
				}
			$s .= "});\n\n";
		}
		
		if ( ! empty( self::$_content['js']['resize'] ) )
		{
			$s .= "$(window).resize(function()\n";
			$s .= "{";
				foreach ( self::$_content['js']['resize'] as $script)
				{
					$s .= "\n\t$script\n";
				}
			$s .= "});\n\n";
		}
		$s .= "</script>\n";
		return $s;
	}

	/**
	 * Almacena un archivo js
	 * 
	 * @param string $file ruta al archivo js
	 */                                                
	static public function _file_( $file )
	{
		$attr['src'] = "javascript/$file.js";
		self::$_content['js']['file'][$file] = _page::_wrap_( '', 'script', $attr );
	}
	
	/**
	 * Almacena un script que extiende un archivo js 
	 * 
	 * @param string $file ruta al archivo js
	 */                                                
	static public function _add_( $file )
	{
		$content = file_get_contents(PUB_PATH . "javascript/$file.js");
		self::$_content['js']['add'][$file] = str_replace("\n", "\n\t", $content);	
	}
	
	/**
	 * Almacena un script que ejecuta un js al finalizar la carga de html
	 * 
	 * @param string $file ruta al archivo js
	 */                                                
	static public function _ready_( $file )
	{
		$content = file_get_contents(PUB_PATH . "javascript/$file.js");
		self::$_content['js']['ready'][$file] = str_replace("\n", "\n\t", $content);	
	}

    static public function _center_($tag, $dad)
    {
		self::$_content['js']['add'][__METHOD__] =
"jQuery.fn.center = function (dad)
{
	var dad = dad || 'window';
	$(dad).css( { position:'relative' } );
	
	this.css('position', 'absolute');
	
	var top = ( $(dad).height() - this.height() ) / 2;
	if (top < 5) top = 5;
	
	var left = ( $(dad).width() - this.width() ) / 2; 
	if (left < 5) left = 5;
				
	this.css('top', top+'px')  
		.css('left', left+'px')
		.appendTo(dad);
	return this;
}";
		
		self::$_content['js']['ready'][__METHOD__] = "$('$tag').center('$dad');";
		
		self::$_content['js']['resize'][__METHOD__] = "$('$tag').center('$dad');";
	}
	
    static public function _filter_()
    {
		self::$_content['js']['add'][__METHOD__] = 
"// EXPRESION PARA BUSCAR IGNORANDO MAYUSCULAS Y MINUSCULAS
$.expr[':'].containsNoCase = function(el, i, m)
{  
	var search = m[3];
	if ( ! search) return false;
	return eval('/' + search + '/ig').test( $(el).text() );
}";
			
		self::$_content['js']['ready'][__METHOD__] =
	"// APLICANDO LA FUNCION DE AL SOLTAR UNA TECLA BUSCA EN LA LISTA EL CONTENIDO DEL CAMPO DE TEXTO
	$('.filter').each(function()
		{
			this.onkeyup=filter;
		}
	);";
			
		self::$_content['js']['fn'][__METHOD__] =
"function filter()
{
	// CRITERIO DE BUSQUEDA
	var s = $('input.filter').val();

	// SE OCULTA LA LISTA O SE MUESTRA SI NO HAY CRITERIO
	if (s)
	{
		$('.list li').hide();
		
		// SE BUSCA EL VALOR DEL CAMPO DE TEXTO EN LA LISTA
		$('.list').find('li:containsNoCase('+s+')').show();
	}
	else
	{
		$('.list li').show();
	}
}";
	}
	
    static public function _load_($tag, $load, $callback='', $delay=0)
    {
		$s = "$('$tag').load('$load'";
		if ($callback) $s .= ", function(){ $callback }";
		$s .= ');';
		if ($delay) $s = self::_delay_($s, $delay);
		self::$_content['js']['ready'][__METHOD__] = $s;
	}
		
	static public function _remove_($tag, $delay=0)
	{
		$s = "$('$tag').fadeOut('slow', function(){ $(this).remove(); })";
		if ($delay) $s = self::_delay_($s, $delay);
		self::$_content['js']['ready'][__METHOD__] = $s;
	}
	
	/**
	 * Para programar una funcion javascript
	 * 
	 * @param string $fn funcion javascript
	 * @param number $delay tiempo en segundos
	 * @return string
	 */                        	
    static public function _delay_($fn, $delay=0)
    {
        $delay = $delay*1000;
		return "setTimeout(\"$fn\", $delay);";
	}
}
