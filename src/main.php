<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Qusai\Mbira; // import our Class

// auto load packages
require '../vendor/autoload.php';

ini_set('display_error', 1);

$settings = [
    'displayErrorDetails' => true,
];

$app = new \Slim\App($settings);

$app->get('/', function (Request $request, Response $response, array $args) {

    $data     = [
    	'msg' => 'Welcome to Qusai\'s Api'
    ];
    $response = $response->withJson($data); // Immutable obj
    return $response;
});

$app->get('/product/{upc}', function (Request $request, Response $response, array $args) {
    
    $upc = $args['upc'];

    $mbira = new Mbira();

    $product = $mbira->retriveProduct($upc);

    // if we found a product with the given UPC, save it in DB and send it back with success msg
    if ($product) {
        
        $result = $mbira->saveReceivedProduct($product);

        $data = [
            'msg'     => 'success, the product has been saved!',
            'result' => $result,
        ];
        $response = $response->withJson($data);
    } else {

        $data = [
            'error' => $upc . ' does not exist!',
        ];
        $response = $response->withJson($data);
    }

    return $response;
});

$app->run();
