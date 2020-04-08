<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE,PATCH");
require('params.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use BugApp\Controllers\bugController;


$length = strlen(base_path);

$uri = substr($_SERVER['REQUEST_URI'], $length + 1);

$method = $_SERVER['REQUEST_METHOD'];
$data =  parse_str(file_get_contents('php://input'), $_PATCH); 

// var_dump($method);die;

switch (true) {

    // LIST

    case preg_match('#^bug$#', $uri) && $method == 'GET':
        
        return (new bugController())->list_Bug();

        break;

    // SHOW 

    case preg_match('#^bug/(\d+)$#', $uri, $matches) && $method == 'GET':

        $id = $matches[1];

        return (new bugController())->show($id);

        break;

    // TODO: UPDATE

    case preg_match('#^bug/(\d+)$#', $uri, $matches) && $method == 'PATCH':
 
        $id = $matches[1];
        return (new bugController())->update($id,$_PATCH);

        break;
        
    // TODO: ADD
    case preg_match('#^add$#', $uri) && $method == 'POST':

        return (new bugController())->add($_POST);

    break;

    // TODO: FILTRE
    case preg_match('#^bug(|\?.)#', $uri) && $method == 'GET':

        $string = $_GET["closed"];
        return (new bugController())->list_Bug_Closed($string);

    break;

    // TODO: DELETE
    case preg_match('#^bug/(\d+)$#', $uri, $matches) && $method == 'DELETE':

        $id = $matches[1];

        return (new bugController())->delete($id);

        break;

    default:  
        var_dump("erreur url");
            
    // TODO: page non-trouvée
}
