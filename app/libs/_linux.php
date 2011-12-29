<?php

class _linux
{
	static public function tail_($log, $n=25, $reverse=0)
    {
		$reverse = $reverse ? '-r' : ''; 
 		exec("tail $reverse -n $n $log", $a);
		$s = '';
		foreach ($a as $line)
		{
			$s .= strip_tags($line) . '<br />';
		}
		return $s;     
    }
}