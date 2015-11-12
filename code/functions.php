<?php
function pdo_connect($server, $username, $passwd,$db_name){
try {
    $conn = new PDO('mysql:host='.$server.';dbname='.$db_name.'', $username, $passwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
  }
  return $conn;
}

function get_navID($parent = 0, $level = 1, $count, $loc){
global $pdo;

$query = $pdo->prepare('select url_phrase, page_id from pages where parent_id = :parent and url_phrase = :loc');
$query->bindParam('parent',$parent,PDO::PARAM_INT);
$query->bindParam('loc',$loc[$level - 1],PDO::PARAM_STR);
$query->execute();
$child_list = $query->fetchALL();


	if($child_list){
	   foreach($child_list as $v){
	     if($v['url_phrase'] == end($loc) && $level == $count){
		   $nav_id = $v['page_id'];
		   break;
		 }

		 $level++;

		 $nav_id = get_navID($v['page_id'], $level, $count, $loc);

		 $level--;
	   }

	}
	if(isset($nav_id)){
	  return $nav_id;
	}
}

function get_pageInfo($pageID = 1){
  global $pdo;

  $query = $pdo->prepare('select title, content, url_phrase, file, js from pages where page_id = :id');
  $query->bindParam('id',$pageID,PDO::PARAM_INT);
  $query->execute();
  $pageInfo = $query->fetchALL();
  if(isset($pageInfo)){
    return $pageInfo;
  }
}
function get_this_post($postID){
  global $pdo;
  $query = $pdo->prepare('select post_id, title, link, date, user_id from posts where post_id = :id');
  $query->bindParam('id',$postID,PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetchALL();
  if($result){
    $vote_count = get_vote_count($val['post_id'],$val['date']);
      $post = $vote_count.' <a href="'.$result[0]['link'].'" target="_blank">'.$result[0]['title'].'</a>';
  }
  return $post;
}
function get_posts(){
  global $pdo;
  $query = $pdo->prepare('select post_id, title, link, date, user_id from posts order by date desc');
  $query->execute();
  $results = $query->fetchALL();
  $items = '';
  foreach($results as $val){
    $vote_count = get_vote_count($val['post_id'],$val['date']);
    if($_COOKIE['user_id'] > 0){
      $checkVote = user_voted($val['post_id'], $_COOKIE['user_id']);
      if($checkVote > 0){
        $items .= '<li class="list-group-item">'.$vote_count.' <a href="'.$val['link'].'" target="_blank">'.$val['title'].'</a></li>';
      }else{
        $items .= '<li class="list-group-item">'.$vote_count.' <a href="'.$val['link'].'" target="_blank">'.$val['title'].'</a> <span id="'.$val['post_id'].'_up" class="glyphicon glyphicon-thumbs-up vote vote_up" aria-hidden="true"></span><span id="'.$val['post_id'].'_down" aria-hidden="true" class="glyphicon glyphicon-thumbs-down vote vote_down"></span></li>';
      }
    }else{
      $items .= '<li class="list-group-item">'.$vote_count.' <a href="'.$val['link'].'" target="_blank">'.$val['title'].'</a> </li>';
    }
  }
  return $items;
}
function get_vote_count($postID,$date){
  global $pdo;
  $query = $pdo->prepare('select user_id, date, status from votes where post_id = :id');
  $query->bindParam('id',$postID,PDO::PARAM_INT);
  $query->execute();
  $votes = $query->fetchALL();
  $count = 0;
  if($votes){
    //$count = count($votes);
    foreach($votes as $key=>$val){
      $val['status'] == 'up'? $count++ : $count--;
    }

    $now = strtotime('now');
    $difference = ($now - strtotime($date))/60;//min since post was made
    $decay = floor($difference/5); //how many 5 min periods have passed?
    $score_pad = $count * 1000;//padding the score to better show decay
    //lose 1 point for every five minutes that have passed
    $score = $score_pad - $decay;
    $score > 0 ? $score : $score = 0;


  }else{
    $count = 0;
    $score = 0;
  }

  $disp_score = '<button class="btn btn-primary" type="button">Score <span class="badge" id="badge_'.$postID.'">'.$score.'</span></button>';
  return $disp_score;
}

function get_score($postID){
  global $pdo;
  $query = $pdo->prepare('select v.user_id, p.date, status from votes v, posts p where v.post_id = :id and v.post_id = p.post_id');
  $query->bindParam('id',$postID,PDO::PARAM_INT);
  $query->execute();
  $votes = $query->fetchALL();
  $count = 0;
  if($votes){
    //$count = count($votes);
    $i = 0;
    foreach($votes as $key=>$val){
      $val['status'] == 'up'? $count++ : $count--;
      if($i == 0){
        $date = $val['date'];
      }
      $i++;
    }

    $now = strtotime('now');
    $difference = ($now - strtotime($date))/60;//min since post was made
    $decay = floor($difference/5); //how many 5 min periods have passed?
    $score_pad = $count * 1000;//padding the score to better show decay
    //lose 1 point for every five minutes that have passed
    $score = $score_pad - $decay;
    $score > 0 ? $score : $score = 0;


  }else{
    $count = 0;
    $score = 'aaa';
  }

  return $score;
}

function user_voted($postID, $userID){
 global $pdo;
 $query = $pdo->prepare('select vote_id from votes where post_id = :pID and user_id = :uID');
 $query->bindParam('pID',$postID,PDO::PARAM_INT);
 $query->bindParam('uID',$userID,PDO::PARAM_INT);
 $query->execute();
 $result = $query->fetchALL();
 if($result){
   $count = count($result);
 }else{
   $count = 0;
 }
 return $count;
}
?>
