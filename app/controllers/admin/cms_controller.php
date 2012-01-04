<?php
/**
 * Administración
 *
 * Controlador para crear, editar y borrar paginas
 */


class CmsController extends AdminController 
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
		if ( ! empty( $_POST['pagina'] ) and ! empty( $_POST['codigo'] ) )
		{
			Load::model( 'ficheros' )->salvarFichero( $_POST['pagina'], $_POST['codigo'] );			
			$this->fichero = Load::model( 'ficheros' )->leerFichero( $_POST['pagina'] );
			$this->version = Load::model( 'versiones' )->obtenerVersion( $_POST['pagina'] );
			$this->pagina = $_POST['pagina'];		
		}
		else
		{
			$pagina = join( '/', $this->parameters );
			$this->fichero = ( $pagina ) ? Load::model( 'ficheros' )->leerFichero( $pagina ) : '';
			$this->version = ( $pagina ) ? Load::model( 'versiones' )->obtenerVersion( $pagina ) : '';
			$this->pagina = ( $pagina ) ? $pagina : '';		
		}
		View::select( 'codemirror' );
	}

    public function borrar()
	{			
		$pagina = join( '/', $this->parameters );
		if ( $pagina )
		{
			Load::model( 'ficheros' )->borrarFichero( $pagina );			
			$this->fichero = '';
			$this->version = '';
			$this->pagina = '';		
		}
		View::select( 'codemirror' );
	}
}
