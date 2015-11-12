<?php
//  ini_set("display_errors", 0);
  ini_set("display_errors", 1);
  include('../code/setup.php');
  include('../code/functions.php');

  $pdo= pdo_connect($setup['db_host'], $setup['db_user'], $setup['db_pswd'],$setup['db_name']);
  $message = '';
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  if($email && $pass){
    //strip tags and remove whitespace
    $email = strip_tags(preg_replace('/\s*/m', '', $email));
    $pass = strip_tags(preg_replace('/\s*/m', '', $pass));
    $query = $pdo->prepare('select user_id,f_name,l_name,email,pass from users where email = :email');
    $query->bindParam('email',$email,PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchALL();
    if($result){//email exists in the database
      //print_r($result);
      if($result[0]['pass'] == $pass){//password is good
         $name = $result[0]['f_name'].' '.$result[0]['l_name'];
         //set cookie valid for 1 hour
         setcookie("user_name", "".$name."", time()+3600, "/");
         setcookie("user_id", $result[0]['user_id'], time()+3600, "/");
         $message = 'success';
         echo $message;
      }else{//bad password
        $message = 'error:bad_password';
        echo $message;
      }
    }else{//no result, email not in database
       $message = 'error:bad_email';
       echo $message;
    }
  }
  $pdo = null;
?>
