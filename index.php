<?php

ini_set('display_errors', 1);

require('Controllers/bugController.php');

$uri = $_SERVER['REQUEST_URI'];

switch(true) {

    case ($uri == '/bug/list'):

        return (new bugController())->list();

        break;

    case preg_match('#^/bug/show/(\d+)$#', $uri, $matches):

        $id = $matches[1];

        return (new bugController())->show($id);

        break;

    case ($uri == '/bug/add'):

        return (new bugController())->add();

        break;

    default:

        http_response_code(404);

        echo 'Page non trouvée !';
        
}

// switch($uri) {
//     case '/bug/list':
//         return (new bugController())->list();
//         break;
//     case '/bug/add':
//         return (new bugController())->add();
//         break;
//     default:
//         http_response_code(404);
//         echo 'Page non trouvée !';
// }