<?php

use Psr\Container\ContainerInterface;

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 21.04.18
 * Time: 12:43
 */

class UserController {

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function home($request, $response, $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }

    public function register($request, $response, $args) {
        /**
         * @var $conn PDO
         */
        $conn = $this->container['db'];
        $conn->prepare("INSERT INTO Users(username, password, email) VALUES ('test', 'test', 't@t.t')");
    }
}