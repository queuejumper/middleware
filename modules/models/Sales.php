<?php

/**
* 
*/
class Sales extends RipcordHelper
{

	function __construct($token)
	{
		parent::__construct($token);
	}


	public function getUser()
	{
		return $this->getUid();
	}

	public function getSales()
	{
		return $this->setUid()
					->setModel('product.product')
					->setWhere([])
					->setFields(['name'])
					->search_read();
	}

	public function setSales($data=[])
	{
		// return $this->setOrderLine($data);
		return $this->setUid()
					->setModel('sale.order')
					->setData($data)
					->save();
	}

	public function setOrderLine($data=[])
	{
		//print_r($data);exit;
		return 	$this->setUid()
					->setModel('sale.order.line')
					->setData($data)
					->save();
	}
	public function updateOrderLine($data=[],$id=[])
	{
		return 	$this->setUid()
			->setModel('sale.order.line')
			->setData($data)
			->update($id);
	}
}