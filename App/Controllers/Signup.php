<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Signup extends \Core\Controller   
{

   public function newAction()
   {
    View::renderTemplate('Signup/new.html');
   }


   /** sign up a new user */

   public function createAction()
   {
     $user = new User($_POST);

     if($user->save()){
         
        $user->sendActivationEmail();

        $this->redirect('/signup/success');

     }else{

        View::renderTemplate('Signup/new.html', [
            'user'=>$user
        ]);
    }

   }

   public function successAction()
   {
        View::renderTemplate('Signup/success.html');
   }

   public function activateAction()
   {
     $this->route_params['token'];
     User::activate($this->route_params['token']);
     $this->redirect('/signup/activated');
   }


/**
 * show the activation success page 
 * @return void
  */ 

   public function activatedAction()
   {
      /**
       * after activation the default data can be assigned to user    /////////////////////////////////////////
       */
         View::renderTemplate('Signup/activated.html');
   }
   

}
