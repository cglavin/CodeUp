<?php
//  ini_set("display_errors", 0);
  ini_set("display_errors", 1);
  include('../code/setup.php');
  include('../code/functions.php');

  $pdo= pdo_connect($setup['db_host'], $setup['db_user'], $setup['db_pswd'],$setup['db_name']);

  $title = $_POST['title'];
  $title = strip_tags(trim($title));

  $link = $_POST['link'];
  $link = strip_tags(trim($link));

  if($title && $link){
    $insert = $pdo->prepare('insert into posts (title,link,date,user_id) values(:title,:link,now(),:user)');
    $insert->bindParam('title',$title,PDO::PARAM_STR);
    $insert->bindParam('link',$link,PDO::PARAM_STR);
    $insert->bindParam('user',$_COOKIE['user_id'],PDO::PARAM_INT);
    $insert->execute();
    print 'success';
  }else{
    print 'update failed';
  }
  $pdo = null;
  ?>
