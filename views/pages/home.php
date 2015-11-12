<?php
//  ini_set("display_errors", 0);
  ini_set("display_errors", 1);
   $query = $pdo->prepare('select post_id, title, link, date, user_id from posts order by date desc');
   $query->execute();
   $results = $query->fetchALL();
  // print_r($results);
  $posts = get_posts();
?>
<ul class="list-group link-list">
   <?php
      print $posts;
   /*
      foreach($results as $val){
        $vote_count = get_vote_count($val['post_id']);
        if($_COOKIE['user_id'] > 0){
        print '<li class="list-group-item"><a href="'.$val['link'].'" target="_blank">'.$val['title'].'</a> <span id="'.$val['post_id'].'_up" class="glyphicon glyphicon-thumbs-up vote vote_up" aria-hidden="true"></span><span id="'.$val['post_id'].'_down" aria-hidden="true" class="glyphicon glyphicon-thumbs-down vote vote_down"></span>'.$vote_count.'</li>';
        }else{
        print '<li class="list-group-item"><a href="'.$val['link'].'" target="_blank">'.$val['title'].'</a>'.$vote_count.' </li>';
        }
      }
      */
    ?>
</ul>
