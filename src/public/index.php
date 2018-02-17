<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
// require 'common.php';
$app = new \Slim\App;





// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        // 'cache' => '../cache'
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};




$app->get('/',function($request,$respond,$args){
    
    return $this->view->render($respond,'form.html',[
        
    ]);
});

$app->post('/save',function($request,$respond,$args){
    echo "<pre>";
    print_r($request->getUploadedFiles());
    // getUploadedFiles
    
});




$app->run();

?>