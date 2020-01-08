<?php

require('params.php');

ini_set('display_errors', 1);

require('Controllers/bugController.php');

$length = strlen(base_path);

$uri = substr($_SERVER['REQUEST_URI'], $length+1) ;

switch(true) {
    
    case (strpos($uri,'bug/list') === 0):
        
        return (new bugController())->list();
        
    break;
    
    case preg_match('#^bug/show/(\d+)$#', $uri, $matches):
        
        $id = $matches[1];
        
        return (new bugController())->show($id);
        
    break;
    
    case ($uri == 'bug/add'):
        
        return (new bugController())->add();
        
    break;
    
    case preg_match('#^bug/update/(\d+)$#', $uri, $matches):
        
        $id = $matches[1];
        
        return (new bugController())->update($id);
        
    break;
    
    default:
    
    http_response_code(404);
    
    echo 'Page non trouvée !';
    
}