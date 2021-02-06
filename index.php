<?php
require 'vendor/autoload.php';

$app = new Slim\App;


#Container untuk membuat semacam fungsi / function
$container = $app->getContainer();
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write($exception);
    };
};

#middleware untuk CORS
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

#buat container untuk database PDO
$container['db'] = function(){
    return new PDO('mysql:local=localhost;dbname=coba-slim', 'root', '');
};

/////////////////////////////////////////////////////////////////////////////////////////////
//TAMPILKAN DATA contoh
$app->get('/koperasi', function($request, $response, $datae){
  $hasil = $this->db->query("select * from koperasi order by cif")->fetchAll(PDO::FETCH_ASSOC);
  $json=json_encode($hasil);
	 print_r($json);
});


$app->run();

?>
