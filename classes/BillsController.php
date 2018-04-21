<?php

use Psr\Container\ContainerInterface;
use Slim\Http\Request;

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 21.04.18
 * Time: 14:11
 */

class BillsController {

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getDebtByUser($userId) {
        $conn = $this->container['db'];
        /**
         * @var $stmt PDOStatement
         */
        $stmt = $conn->prepare("SELECT SUM(Bills.amount) FROM User_Bills INNER JOIN Bills ON Bills.id = User_Bills.bill WHERE User_Bills.user = :user_id");
        $stmt->execute([
            ':user_id' => $userId
        ]);
        return $stmt->fetchColumn(0);
    }

    public function getDeficitByUser($userId) {
        $conn = $this->container['db'];
        /**
         * @var $stmt PDOStatement
         */
        $stmt = $conn->prepare("SELECT SUM(Bills.amount) FROM Bills WHERE Bills.owned = :user_id");
        $stmt->execute([
            ':user_id' => $userId
        ]);
        return $stmt->fetchColumn(0);
    }

    public function show(Request $request, $response) {
        $conn = $this->container['db'];
        /**
         * @var $stmt PDOStatement
         */
        $args = $request->getParams();
        $stmt = $conn->prepare("SELECT id, title, owned FROM Bills WHERE Bills.id=:bill_id");
        $stmt->execute([
            ':bill_id' => $args['bill_id']
        ]);
        $bill = $stmt->fetch();
        $stmt = $conn->prepare("SELECT login FROM User_Bills INNER JOIN Users ON Users.id = User_Bills.user WHERE User_Bills.bill=:bill_id");
        $stmt->execute([
            ':bill_id' => $args['bill_id']
        ]);
        $users = $stmt->fetchAll();
        $result = [
            'bill' => $bill,
            'users' => $users
        ];
        return json_encode($result);
    }
}