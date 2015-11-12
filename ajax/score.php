<?php
//  ini_set("display_errors", 0);
  ini_set("display_errors", 1);
  include('../code/setup.php');
  include('../code/functions.php');

  $pdo= pdo_connect($setup['db_host'], $setup['db_user'], $setup['db_pswd'],$setup['db_name']);

  $post = $_POST['post_id'];

  if($post){
    mysql_insert_id();
    $score = get_score($pos);
    print $score;
  }else{
    print 'fail';
  }
  $pdo = null;
?>
