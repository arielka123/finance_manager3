<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Token;
use \App\Flash;

use Twig\Node\Expression\Binary\LessEqualBinary;

/** Password controller */

class Password extends \Core\Controller
{
    public function forgotAction()
    {
        View::renderTemplate('Password/forgot.html');
    }

    public function requestResetAction()
    {
       User::sendPasswordReset($_POST['email']);       

       View::renderTemplate('Password/reset_requested.html');
    }   

    public function resetAction()
    {
        $token = $this->route_params['token'];

        $user= $this->getUserOrExit($token);

        View::renderTemplate('Password/reset.html', [
            'token' =>$token
        ]);
    }

    /**
     * reset the user's password
     */

     public function resetPasswordAction()
     {
        $token = $_POST['token'];

        $user= $this->getUserOrExit($token);
           
        /**echo "reset user's password here"; */ 
        if($user->resetPassword($_POST['password'])){
           header('Location: /login');
            Flash::addMessage('Możesz teraz się zalogować');

        } else{
            View::renderTemplate('Password/reset.html', [
                'token' => $token,
                'user' => $user
            ]);

        }
     }

     protected function getUserOrExit($token)
     {
         $user = User::findByPasswordReset($token);
         if($user){
             return $user;
         }else{

            #TODO zweryfikowac czy flash potrzebny
           // Flash::addMessage('Link do odzyskiwania hasła stracił ważność');

            View::renderTemplate('Password/token_ expired.html');
            exit;
         }
     }
}