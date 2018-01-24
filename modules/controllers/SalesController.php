<?php

/**
* 
*/
class SalesController extends API
{
	
	public function actionGetUser()
	{
		$obj = new Sales();

		print_r($obj->getUser());
	}

	public function actionGetSales($token)
	{
		$this->requiredMethod('GET')->authorize($token);
		$obj = new Sales($this->token);
		$result = $obj->getSales();
		if(isset($result['faultCode']))
			$this->ripcordError($result);
		if($result)
			$this->ripcordOK($result,'successful request!');;
	}

	public function actionCreateSales()
	{
		$this->requiredMethod('POST')
			->setPayload()
			->authorize();
		$obj = new Sales($this->token);
		$saleOrderData = $this->mappingSaleOrder();
		$order = $obj->setSales(
				$saleOrderData
			);
		if($order['faultCode'] || !is_integer($order) || !isset($saleOrderData['partner_id']))
			$this->ripcordError($order);
		$saleOrderLineData = $this->mappingSaleOrderLine($order,$saleOrderData['partner_id']);
		foreach ($saleOrderLineData as $data)
		{
			$orderLine = $obj->setOrderLine($data);
		}
		if(isset($orderLine['faultCode']))
			$this->ripcordError($orderLine);
		if(is_integer($order) && is_integer($orderLine))
			$this->ripcordOK(null,'Sales has been created succeffuly!');
	}

	private function mappingSaleOrder()
	{
		$_data = [];
		$saleOrder = [
			"partner_id" => [
						"required" => true,
						"dataType" => "integer"
			],
			"validity_date" => [
				"required" => false,
				"dataType" => "date",
			],
		];
			foreach ((array)$saleOrder as $key => $value)
			{
				if(isset($value['required']) && $value['required'] 
					&& (!array_key_exists($key, $this->data) ||!isset($this->data[$key]) || empty($this->data[$key])))
					$this->requestError(405,"{$key} is required!");
				if(array_key_exists($key, $this->data) && isset($value['dataType']))
				{
					if($value['dataType'] == "date")
					{
						if(!Helper::validateDate($this->data[$key],"Y-m-d"))
							$this->requestError(405,"{$key} must be in Y-m-d format!");
					}elseif($value['dataType'] == "float")
					{
						if(!is_integer($this->data[$key]) && !is_float($this->data[$key]))
							$this->requestError(405,"{$key} must be numeric!");
					}
					else
					{
					if(gettype($this->data[$key]) != $value['dataType'])
						$this->requestError(405,"{$key} must be {$value['dataType']}!");
					}
				}
				if(isset($value['required']) && !$value['required'] && !array_key_exists($key, $this->data))
					unset($key);
				else
					$_data[$key] = $this->data[$key];
			}
		return $_data;
	}
	private function mappingSaleOrderLine($order_id,$partner_id)
	{
		$_data = [];
		$saleOrderLine = [
			"product_id" => [
				"required" => true,
				"dataType" => "integer",

			"validity_date" => [
				"required" => false,
				"dataType" => "date",
			],
			],
			"name" => [
				"required" => false,
				"dataType" => "string"
			],
			"product_uom_qty" => [
				"required" => true,
				"dataType" => "float"
			],
			"price_unit" => [
				"required" => false,
				"dataType" => "float"
			]			
		];
		foreach ((array)$this->data['items'] as $key => $value)
		{
			foreach ((array)$value as $key1 => $value1)
			{
				
				foreach ((array)$saleOrderLine as $key2 => $value2)
				{
					if(isset($value2['required']) && $value2['required'])
					{
						if(!isset($key2) || !isset($value[$key2]) || empty($value[$key2]))
							$this->requestError(405,"{$key2} is required!");
					}
					if($value2['dataType'] == "float")
					{
						if(!is_integer($value[$key2]) && !is_float($value[$key2]))
							$this->requestError(405,"{$key2} must be numeric!");
					}
					elseif(isset($value2['dataType']) && isset($value[$key2]) 
						&& gettype($value[$key2]) != $value2['dataType'])
						$this->requestError(405,"{$key2} must be {$value2['dataType']}!");
					if(isset($value2['required']) && !$value2['required'])
					{
						if($value2['dataType'] == "integer" || $value2['dataType'] == "float")
						{
							if(!isset($key2) || !isset($value[$key2]))
								$value[$key2] = 0;
						}
						else
						{
							if(!isset($key2) || empty($value[$key2]))
								$value[$key2] = "null";
						}
					}
				}
				$value['order_id'] = $order_id;
				$value['order_partner_id'] = $partner_id;
			}
			array_push($_data,$value);	
		}
		return $_data;
	}
	private function salesRequiredPayload()
	{
		$this->requiredPayload =[
			"token" =>[
				"required" => true,
				"dataType" => "string"
			],
			"data" => [
				"partner_id" => [
						"required" => true,
						"dataType" => "integer"
				],
				"validity_date" => [
					"required" => false,
					"dataType" => "date",
					],
				"items" => [
					"product_id" => [
						"required" => true,
						"dataType" => "integer"
					],
					"name" => [
						"required" => false,
						"dataType" => "string"
					],
					"product_uom_qty" => [
						"required" => true,
						"dataType" => "float"
					],
					"price_unit" => [
						"required" => true,
						"dataType" => "float"
					]
				]
			]
		];
		return $this;
	}

}
