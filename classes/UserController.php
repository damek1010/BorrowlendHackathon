<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 21.04.18
 * Time: 12:43
 */

class UserController {
    public function home($request, $response, $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }
}