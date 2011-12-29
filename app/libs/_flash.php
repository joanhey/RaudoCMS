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

$_SESSION['flash'] = empty( $_SESSION['flash'] ) ? '' : $_SESSION['flash'];

class _flash
{
	/**
	 * Devuelve la variable de sesion flash
	 * 
	 * @return string
	 */
	static public function _return_( $delay=5 )
	{
		_css::_file_( 'style' );
		_js::_remove_( '[class$=_message]', $delay );
		
		$s = $_SESSION['flash'];
		unset( $_SESSION['flash'] );
		return $s;
	}
	
	/**
	 * Imprime la variable de sesion flash
	 */
	static public function _echo_( $delay=5 )
	{
		echo self::_return_( $delay );
	}
}
