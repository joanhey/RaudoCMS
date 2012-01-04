<?php
/**
 * BT es el helper para manejar fácilmente el bootstrap de twitter
 * 
 */
class Bt {

	public static function label($msg , $tipo = NULL)
	{
		echo "<span class=\"label $tipo\">$msg</span>";
	}
}
