<?php
/**
AUTHOR: AHMED SALLAM
DESCRIPTION: THIS CALSS ACTS AS HELPER CLASS TO GET GLOBAL PARAMETERS
*/
class Helper
{
	public static function params()
	{
		require (BASE_DIR.'/config/web.php');
		if(isset($config['params']))
			return $config['params'];
		return null;
	}


	public static function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
}