<?php
namespace Projet3wa\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthUser implements IMiddleware {

    public function handle(Request $request): void 
    {
        if(isset($_SESSION["user"])){
            $user = $_SESSION["user"];
            if(!in_array($user->getRole(),['ADMIN','USER'])){
                header('Location: ' . url('login'));
                exit();
            }
        }else{
            header('Location: ' . url('login'));
            exit();
        }
    }
}