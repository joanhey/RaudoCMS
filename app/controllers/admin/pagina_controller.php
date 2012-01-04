<?php
/**
 * Administración
 *
 * Controlador para crear, editar y borrar paginas
 */


class PaginaController extends AdminController 
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
			Load::model( 'versiones' )->editando( $post['dir'], $post['pagina'], $post['codigo'] );			
			return Router::redirect( "/admin/cms/index?dir={$post['dir']}/{$post['pagina']}" );
		}
		return Router::redirect( '/admin/cms' );
	}
}
