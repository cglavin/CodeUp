<?php
//  ini_set("display_errors", 0);
  ini_set("display_errors", 1);
  include('../code/setup.php');
  include('../code/functions.php');

  $pdo= pdo_connect($setup['db_host'], $setup['db_user'], $setup['db_pswd'],$setup['db_name']);

  $post = $_POST['post_id'];
  $status = $_POST['vote_status'];

  if($post && $status){
    $query = $pdo->prepare('insert into votes(post_id,user_id,date,status) values(:post_id,:user,now(),:status)');
    $query->bindParam('post_id',$post,PDO::PARAM_INT);
    $query->bindParam('user',$_COOKIE['user_id'],PDO::PARAM_INT);
    $query->bindParam('status',$status,PDO::PARAM_STR);
    $query->execute();
    $lastId = $pdo->lastInsertId();
    $score = get_score($post);
    print $score;
  }else{
    print 'fail';
  }
  $pdo = null;
?>
