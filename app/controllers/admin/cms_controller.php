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
	    $this->limit_params = false;
		
		if ( Input::isAjax() ) View::template( NULL );
    }

	public function index()
	{
		$this->ficheros = Load::model( 'ficheros' )->leerDirectorio();
	}

	public function ver()
	{
		$pagina = join( '/', $this->parameters );		
		$pagina = basename( $pagina, '.phtml' );
		
		View::setPath( 'pages/' );
		View::select( $pagina, NULL );
	}

    public function editar()
	{			
		if ( ! empty( $_POST['codigo'] ) )
		{
			Load::model( 'versiones' )->editando( $this->parameters, $_POST );			
		}

		$this->pagina = join( '/', $this->parameters );		
		$this->fichero = Load::model( 'ficheros' )->leerFichero( $this->parameters );
		$this->version = Load::model( 'versiones' )->leyendo( $this->parameters );
		
		View::select( 'codemirror' );
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