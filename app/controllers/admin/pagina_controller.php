<?php
/**
 * Administración
 *
 * Controlador para crear, editar y borrar paginas
 */


class PaginaController extends AppController 
{
	public function index()
	{
		if ( ! empty( $_POST['accion'] ) )
		{
			$accion = ( $_POST['accion'] == 'borrar' ) ? 'borrar' : 'editar';
			$this->$accion( $_POST );
			return Router::redirect( '/admin/cms/index?dir=' . $_POST['pagina'] );
		}
	}
        
    public function editar( $post )
	{
		if ( strstr( $post['pagina'], APP_PATH . 'views/pages' ) )
		{
			if ( _fs::updateFile( $post['pagina'], $post['codigo'] ) )
			{
				$_SESSION['flash'] = Flash::valid( 'Página actualizada' );
			}
			else
			{
				$_SESSION['flash'] = Flash::error( 'Error editando' );
			}
			return Router::redirect( '/admin/cms/index?dir=' . $post['pagina'] );
		}
		return Router::redirect( '/admin/cms' );
	}
        
    public function borrar( $post )
	{
			if ( _fs::deleteFile( $post['pagina'] ) )
			{
				$_SESSION['flash'] = Flash::valid( 'Página borrada' );
			}
			else
			{
				$_SESSION['flash'] = Flash::error( 'Error borrando' );
			}
			return Router::redirect( '/admin/cms/index?dir=' . basename( $post['pagina'] ) );
	}
}