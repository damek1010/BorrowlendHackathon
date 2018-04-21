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
        return json_encode($result);
    }

    public function basic(Request $request, $response) {
        $args = $request->getParams();
        $bills = new BillsController($this->container);

        $result = [
            'debt' => $bills->getDebtByUser($args['user_id']),
            'deficit' => $bills->getDeficitByUser($args['user_id'])
        ];

        return json_encode($result);
    }

    public function signin(Request $request, $response){
        $args = $request->getParams();
        $conn = $this->container['db'];

        /**
         * @var $stmt PDOStatement
         */
        $stmt = $conn->prepare("SELECT id, login, password FROM Users WHERE login=:login AND password=:pass");
        $stmt->execute ([
           ':login' => $args['login'],
           ':pass' => md5($args['password'])
        ]);

        if($stmt->rowCount() <= 0) return json_encode(['err' => 1]);

        $result = $stmt->fetch();

        return json_encode([
            'id' => $result['id'],
            'login' => $result['login']
        ]);
    }

    public function bills(Request $request, $response) {
        $conn = $this->container['db'];
        /**
         * @var $stmt PDOStatement
         */
        $args = $request->getParams();
        $stmt = $conn->prepare("SELECT id, title FROM Bills WHERE Bills.owned=:user_id");
        $stmt->execute([
            ':user_id' => $args['user_id']
        ]);
        return json_encode($stmt->fetchAll());
    }
}