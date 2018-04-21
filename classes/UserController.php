<?php

use Psr\Container\ContainerInterface;

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 21.04.18
 * Time: 12:43
 */
class UserController
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function home($request, $response, $args)
    {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }

    public function register(\Slim\Http\Request $request, $response)
    {
        /**
         * @var $conn PDO
         */
        $args = $request->getParams();
        $conn = $this->container['db'];
        $stmt = $conn->prepare("INSERT INTO Users(login, password, email) VALUES (:username, :password, :email)");
        $result = $stmt->execute([
            ':username' => $args['login'],
            ':password' => md5($args['password']),
            ':email' => $args['email']
        ]);

        $result = [
            'err' => !$result
        ];
        echo json_encode($result);
        return $response;
    }
}