<?php
/**
 * Administración
 *
 * Controlador para crear, editar y borrar paginas
 */


class CmsController extends AppController 
{
	/*protected function before_filter()
	{
		if ( Input::isAjax() ) View::template( NULL );
    }*/

	public function index()
	{
		$this->ficheros = Load::model( 'ficheros' )->leerDirectorio();
		$this->raiz = APP_PATH . 'views/pages/';
	}

	public function ver( $vista='' )
	{
		$this->fichero = Load::model( 'ficheros' )->leerFichero( $_GET );
		$this->version = Load::model( 'versiones' )->leyendo( $_GET );
		if ( preg_match( '/(ace|codemirror)/', $vista ) ) View::select( $vista, NULL );
	}

    public function editar()
	{
		$this->fichero = Load::model( 'ficheros' )->leerFichero( $_GET );
		$this->version = Load::model( 'versiones' )->leyendo( $_GET );

		if ( ! empty( $_GET['f'] ) )
		{
			Load::model( 'versiones' )->editando( $_GET, $_POST );			
			return Router::redirect( "/admin/cms/ver?f={$_GET['f']}" );
		}
		return Router::redirect( '/admin/cms' );
	}
	
	/*public function codigo( $vista )
	{
		$this->pagina = $_GET['f'];
		$this->codigo = file_get_contents( $this->pagina );
		$this->codigo = htmlspecialchars( $this->codigo, ENT_QUOTES, APP_CHARSET );
		View::select( $vista, NULL );
	}
	
	public function pagina()
	{
		// $_GET['f'] deberia llamarse item o similar
		$this->dir = dirname( $_GET['f'] );
		$this->pagina = basename( $_GET['f'] );
		$this->codigo = file_get_contents( $_GET['f'] );
		$this->codigo = htmlspecialchars( $this->codigo, ENT_QUOTES, APP_CHARSET );
		$this->version = Load::model( 'versiones' )->leyendo( $this->dir, $this->pagina );
	}
	
	public function paginas()
	{
		if ( empty( $_GET['f'] ) ) $_GET['f'] = APP_PATH . 'views/pages';
		$dir = is_dir( $_GET['f'] ) ? $_GET['f'] : dirname( $_GET['f'] );
		$dir = '/' . ltrim( $dir, '/' );
		$this->items = _fs::readDir( $dir );
		$this->dad = $dir == '/' ? '' : $dir;
		$this->up = ( empty( $_REQUEST['up'] ) or $_GET['f'] == APP_PATH . 'views/pages' )? 0 : 1;
	}*/
}