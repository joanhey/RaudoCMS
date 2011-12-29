<?php
/**
 * Administración
 *
 * Controlador para crear, editar y borrar paginas
 */


class CmsController extends AppController 
{
	protected function before_filter()
	{
		if ( Input::isAjax() ) View::template( NULL );
    }

	public function index()
	{
		$this->dir = empty( $_REQUEST['dir'] ) ? '' : $_REQUEST['dir'];
	}
	
	public function codigo()
	{
		$this->pagina = $_REQUEST['dir'];
		$this->codigo = file_get_contents( $this->pagina );
		$this->codigo = htmlspecialchars( $this->codigo, ENT_QUOTES, APP_CHARSET );
		View::template( NULL );
	}
	
	public function pagina()
	{
		// $_REQUEST['dir'] deberia llamarse item o similar
		$this->dir = dirname( $_REQUEST['dir'] );
		$this->pagina = basename( $_REQUEST['dir'] );
		$this->codigo = file_get_contents( $_REQUEST['dir'] );
		$this->codigo = htmlspecialchars( $this->codigo, ENT_QUOTES, APP_CHARSET );
		$this->version = Load::model( 'versiones' )->leyendo( $this->dir, $this->pagina, $this->codigo );
	}
	
	public function paginas()
	{
		if ( empty( $_REQUEST['dir'] ) ) $_REQUEST['dir'] = APP_PATH . 'views/pages';
		$dir = is_dir( $_REQUEST['dir'] ) ? $_REQUEST['dir'] : dirname( $_REQUEST['dir'] );
		$dir = '/' . ltrim( $dir, '/' );
		$this->items = _fs::readDir( $dir );
		$this->dad = $dir == '/' ? '' : $dir;
		$this->up = ( empty( $_REQUEST['up'] ) or $_REQUEST['dir'] == APP_PATH . 'views/pages' )? 0 : 1;
	}
}