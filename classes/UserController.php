<?php

use Psr\Container\ContainerInterface;
use Slim\Http\Request;

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

    public function register(Request $request, $response)
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

    public function basic(Request $request, $response) {
        $args = $request->getParams();
        $bills = new BillsController($this->container);

        $result = [
            'debt' => $bills->getDebtByUser($args['user_id']),
            'deficit' => $bills->getDeficitByUser($args['user_id'])
        ];

        echo json_encode($result);
        return $response;
    }

    public function signin(Request $request, $response){
        $args = $request->getParams();
        $conn = $this->container['db'];

        $stmt = $conn->prepare("SELECT login, password FROM Users WHERE login=:login AND password=:pass");
        $result = $stmt->execute ([
           'login' => $args['login'],
           'pass' => $args['password']
        ]);
        $result->fetch();

        if(isset($result['login']) == false) {
            $result = [
                'err' => 'User non exist'
            ];
        }
        else {
            $result = [ 'login' => $result['login']];
        }


        echo json_encode($result);
        return $response;
    }
}