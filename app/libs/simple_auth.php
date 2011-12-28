<?PHP

define('USER_NAME','admin');     // cambiar por tu nombre de usuario
define('PASSWORD','1234');       // cambiar por tu propia contraseña
define('SESSION_KEY','AxwkEzPsweRY251'); // cambiar por tu propia llave

class SimpleAuth
{

	/**
	 * isAuth
	 * 
	 * @param void
	 * @return bool
	 */
	public static function isAuth(){
		
		if(Session::get(SESSION_KEY) == TRUE){
			return TRUE;
		} else {
		//no ha iniciado session
			// chequear
			if(isset($_POST['mode']) && $_POST['mode'] =='auth_login'){
				//data was posted.
				return self::check($_POST['username'],$_POST['password']);
			} else {
				//No puedes entrar !!
				return FALSE;
			}
		}
	}

	/**
	 * check
	 * 
	 * @param $username
	 * @param $password
	 * @return bool
	 */
	public static function check($username, $password){
		
		if($username == USER_NAME && $password == PASSWORD){
			Session::set(SESSION_KEY,TRUE);
			return TRUE;
		} else {
			Session::set(SESSION_KEY,FALSE);
			Flash::error('Datos incorrectos para poder entrar');
			return FALSE;
		}
		
	}
	/**
	 * logout
	 * 
	 * @param void
	 * @return void
	 */
	public static function logout(){
		Session::set(SESSION_KEY,FALSE);
	}
}