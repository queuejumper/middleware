<?php

/**
* 
*/
class ProductController extends API
{
	
	public function actionTest($id)
	{	
		$code = 404;
		$msg = "Args not set!";
		if(isset($id))
		{
			$code = 200;
			$msg = "Args set!";
			$data = $id;
		}
		$this->response['status'] = $msg;
		$this->response['data'] = $data;
		echo $this->setHeader($code);
	}
}
