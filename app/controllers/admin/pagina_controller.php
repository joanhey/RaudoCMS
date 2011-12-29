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
		if ( ! empty( $_POST['dir'] ) and ! empty( $_POST['pagina'] ) )
		{
			$this->editar( $_POST );
			return Router::redirect( "/admin/cms/index?dir={$_POST['dir']}/{$_POST['pagina']}" );
		}
		return Router::redirect( '/admin/cms' );
	}
        
    public function editar( $post )
	{
		if ( strstr( $post['dir'], APP_PATH . 'views/pages' ) )
		{
			if ( _fs::updateFile( "{$post['dir']}/{$post['pagina']}", $post['codigo'] ) )
			{
				$_SESSION['flash'] = Flash::valid( 'Página actualizada' );
			}
			else
			{
				$_SESSION['flash'] = Flash::error( 'Error editando' );
			}
			return Router::redirect( "/admin/cms/index?dir={$post['dir']}/{$post['pagina']}" );
		}
		return Router::redirect( '/admin/cms' );
	}
        
    public function borrar( $post )
	{
		/*if ( _fs::deleteFile( $post['pagina'] ) )
		{
			$_SESSION['flash'] = Flash::valid( 'Página borrada' );
		}
		else
		{
			$_SESSION['flash'] = Flash::error( 'Error borrando' );
		}
		return Router::redirect( '/admin/cms/index?dir=' . basename( $post['pagina'] ) );*/
	}
}