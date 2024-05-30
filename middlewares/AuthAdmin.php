<?php
namespace Projet3wa\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthAdmin implements IMiddleware {

    public function handle(Request $request): void 
    {
        if(isset($_SESSION["user"])){
            $user = $_SESSION["user"];
            if($user->getRole() != 'ADMIN'){
                header('Location: ' . url('loginAdmin'));
                exit();
            }
        }else{
            header('Location: ' . url('loginAdmin'));
            exit();
        }
    }
}