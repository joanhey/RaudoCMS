<?php
/**
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 **/

// @see Controller nuevo controller
require_once CORE_PATH . 'kumbia/controller.php';

class AdminController extends Controller {

	final protected function initialize()
	{
                //session_start();

			Load::lib('session');
                        Load::lib('simple_auth');
			
			if(SimpleAuth::isAuth()){
				View::template('admin/admin');
			} else {
				View::select(NULL, 'admin/login');
				return FALSE;
			}
	}

	final protected function finalize()
	{
	}
}
