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

class AppController extends Controller {

	final protected function initialize()
	{
		if($this->module_name == 'admin'){
			Load::lib('session');
            Load::lib('simple_auth');
			
			if(SimpleAuth::isAuth()){
				View::template('admin/cms');
			} else {
				//session_start();
				View::select(NULL, 'admin/login');
				return FALSE;
			}
		}
	}

	final protected function finalize()
	{
	}
}