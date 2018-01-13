<?php
// namespace core;
 /**
* 
*/
class API
{
	
	protected 	$method,
				$response = [
					"status" => "failed",
					"message" => null,
					"data" => null
				];

	function __construct()
	{
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        $this->method = $_SERVER['REQUEST_METHOD'];		
	}

	public function setHeader($status,$msg=null)
	{
		header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
		$this->response['message'] = $msg;
		return json_encode($this->response);
	}
	private function requestStatus($code)
	{
		$satus = [
			200 => 'OK',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        ];
        return ($satus[$code]) ? $satus[$code] : $satus[500];
	}

}