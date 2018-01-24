baseUrl = 'http://138.197.3.52/middleware/index.php/';
$(function(){
	$('#company').html(info['company']['name']);
	$('#token').html(info['company']['token']);
	$('#url-options').on('change',function(){
		var $this = $(this),
			index = $this.find(":selected").text();
		$('#url').html(baseUrl+index);
		$('#request-type').html(info['api'][index]['type']);
		$('#success-box').html(JSON.stringify(info['api'][index]['response']['success'],null, 2));
		$('#failure-box').html(JSON.stringify(info['api'][index]['response']['failure'],null, 2));
		$('#payload-box').html(JSON.stringify(info['api'][index]['payload'],null, 2));
	});

});
$(function(){
	$.each(info['api'], function(k,v) {
	    $('#url-options').append($("<option />").text(k));
	});
});

info =
{
	"company":{
		"name":"Scenet",
		"token":"HRwk53reH34eFu5E"
	},
	"api":{
	   "api/create-sales":{
	      "type":"POST",
	      "response":{
	         "success":{
	            "status":"ok",
	            "message":null,
	            "data":null
	         },
	         "failure":{
	            "status":"failed",
	            "message":null,
	         	"data":null
	         }
	      },
	      "payload":{
	         "token":{
	            "required":true,
	            "dataType":"string"
	         },
	         "data":{
	            "partner_id":{
	               "required":true,
	               "dataType":"integer"
	            },
	            "validity_date":{
	               "required":false,
	               "dataType":"date"
	            },
	            "items":[{
	               "product_id":{
	                  "required":true,
	                  "dataType":"integer"
	               },
	               "name":{
	                  "required":false,
	                  "dataType":"string"
	               },
	               "product_uom_qty":{
	                  "required":true,
	                  "dataType":"float"
	               },
	               "price_unit":{
	                  "required":true,
	                  "dataType":"float"
	               }
	            }]
	         }
	      }
	   }
	}
};