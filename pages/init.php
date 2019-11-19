<?php
 
// constantes com as credenciais de acesso ao banco MySQL
define('DB_HOST', 'us-cdbr-iron-east-05.cleardb.net');
define('DB_USER', 'b4f566418cd96d');
define('DB_PASS', 'f903135e');
define('DB_NAME', 'heroku_719e8912e39726a');

/*define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_trashall');*/
 
 
// habilita todas as exibições de erros
ini_set('display_errors', true);
error_reporting(E_ALL);
 
// inclui o arquivo de funçõees
require_once 'functions.php';
