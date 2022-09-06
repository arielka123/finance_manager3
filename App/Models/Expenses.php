<?php

namespace App\Models;

use PDO;
use \App\Auth;
use \App\Models\Validation;

      
/* Expense model
 *
 * PHP version 7.0
 */

class Expenses extends \Core\Model
{   

/**
 * get array of results
 */
    public static function  loadExpenseCategoriesData()
    {

    $user_id=Auth::getUserId();

    $sql_query_category_income = 'SELECT * FROM expenses_category_assigned_to_users
                                   WHERE user_id = :user_id';

    $db = static::getDB();
    $stmt = $db->prepare($sql_query_category_income);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
   // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    }

    /**
     * get array of results 
     */

    public static function  loadPaymentMethodData()
    {

    $user_id=Auth::getUserId();   

    $sql_query_category_income = 'SELECT * FROM payment_methods_assigned_to_users
                                   WHERE user_id = :user_id';

    $db = static::getDB();
    $stmt = $db->prepare($sql_query_category_income);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
   // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

   // print_r($result);

    return $result;

    }

    public static function saveNewData ()
    {
        $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id,
        payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
                VALUES (:user_id, :id_expense_category, :id_payment_method, :amount, :date_of_expense, :expense_comment) ';


        $date = $_POST['date'];        
        $id_expense_category =$_POST['expense'];

      //  $amount = $_POST['amount'];        
      //$comment = $_POST['comment'];


        if(Validation::validate_amount()==true)
        {
            $amount = Validation::validate_amount();
        }
        else return false;


        $comment = Validation::validate_comment();

        $id_payment_method = $_POST['payment'];

        $user_id=Auth::getUserId();

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id_expense_category', $id_expense_category, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':date_of_expense', $date, PDO::PARAM_STR);
        $stmt->bindValue(':expense_comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':id_payment_method', $id_payment_method, PDO::PARAM_INT);

        $stmt->execute();

        return true;

    }

}