<?php
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require 'common.php';
// $db = "";
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
    return $this->view->render($respond,'form.html',[]);
});

$app->post('/save',function($request,$respond,$args)use($db){
    echo "<pre>";
    $textdata = ($request->getParsedBody());
    $uploadFile = ($request->getUploadedFiles());
    $filename = array();
    foreach ($uploadFile as $key => $value) {
       $ext = pathinfo($value->getClientFilename(), PATHINFO_EXTENSION);
       $fname = md5($key.$value->getClientFilename().$value->getSize()).".$ext";
       move_uploaded_file($value->file, "upload\\$fname");
       array_push($filename,$fname);
    }
    // getUploadedFiles
    $db->query("INSERT INTO geekathon(teamName,repreName,projName, role, azureService, proposal, tableID, img1, img2, img3) VALUES(?,?,?,?,?,?,?,?,?,?)", array($textdata['teamName'],$textdata['repreName'],$textdata['projName'],$textdata['role'],$textdata['azureService'],($textdata['proposal']),$textdata['tableID'],$filename[0],$filename[1],$filename[2]));//Parameters must be ordered

    return $respond->withStatus(302)->withHeader('Location', '/thankyou');
});


$app->get('/thankyou',function($request,$respond,$args){
    return $this->view->render($respond,'thank.html',[]);
});

$app->get('/tuymoveisadmin',function($request,$respond,$args){
    $_SESSION['admin']= md5('ok');
    return $respond->withStatus(302)->withHeader('Location', '/report');
});

$app->get('/report',function($request,$respond,$args)use($db){
    $data = $db->query("SELECT * FROM geekathon ORDER by tableID,recordID");
    if(isset($_SESSION['admin'])&& $_SESSION['admin'] == md5('ok')){
        return $this->view->render($respond,'report.html',[
            'datas' => $data
        ]);
    }else{
        return $respond->withStatus(302)->withHeader('Location', '/');
    }
    
});

$app->get('/report/{id}',function($request,$respond,$args)use($db){
    $data = $db->query("SELECT * FROM geekathon WHERE recordID = ?",array($args['id']));
    if(isset($_SESSION['admin'])&& $_SESSION['admin'] == md5('ok')){
        return $this->view->render($respond,'report-item.html',[
            'data' => $data[0]
        ]);
    }else{
        return $respond->withStatus(302)->withHeader('Location', '/');
    }
    
});

$app->get('/upload/{imgname}',function($request,$respond,$args){
    header("content-type: image/jpg");
    echo file_get_contents('./upload/'.$args['imgname']);
    
});

$app->run();

?>