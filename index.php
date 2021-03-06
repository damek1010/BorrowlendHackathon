<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$config = require ('config.php');
$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
$app->group('/user', function (){
    $this->get('/home', \UserController::class . ':home');
    $this->post('/basic', \UserController::class . ':basic');
    $this->post('/register', \UserController::class . ':register');
    $this->post('/signin', \UserController::class . ':signin');
    $this->post('/bills', \UserController::class . ':bills');
});

$app->group('/bills', function (){
    $this->post('/', BillsController::class . ':show');
});
$app->run();