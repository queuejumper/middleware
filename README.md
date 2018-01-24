ODOO-CRM MIDDLEWARE
-------------------
Author: Ahmed sallam
Description: this application acts as a middleware to estalish connection between ERP & VTIGER/CRM in order to perform CRUD on ERP models.


Technologies
-------------------
Native PHP, XML-RPC


Desing Pattern
-------------------
MVC


Techniques
-------------------
-The app establishes a connection to ERP using Ripcord libarary with ERP (db name, ERP username, ERP password)
-Executes Odoo's built-in methods (create,write,search,etc) to perform actions on models.


Requirements
-------------------
-Ripcord libarary (/lib/)


Configuration
-------------------
/config/params.php:
	global parameters and keys like (ERP Credentials, Access Tokens,etc)

/urlManager.php:
	containing urls and their aliases. every url indicates (controller, action,parameter(optional))
	-HTTP requests must start with 'api' to extend the api class. ex.(/api/create-order)

/index.php:
	current environment. dev will enable displaying errors (Debug Mode)