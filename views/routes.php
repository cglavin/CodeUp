<?php
if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
    $loc = explode ( '/',$_SERVER['REDIRECT_QUERY_STRING'] );
    $loc_count = count($loc);
    $loc[0] ? $loc[0] : $loc[0] = 'home';
  }else{
    $loc[0] = 'home';
    $loc_count = count($loc);
  }

  //find what page we're on based on the url
  $nav_id = get_navID(0, 1, $loc_count, $loc);
  //if a page id isn't found, set to 1 (home)
  $nav_id ? $nav_id : $nav_id = 1;

  //now that we have a page id, let's get some page
  $pageInfo = get_pageInfo($nav_id);
  print '<h1>'.$pageInfo[0]['title'].'</h1>';
  print $pageInfo[0]['content'];

  require_once('pages/'.$pageInfo[0]['file']);
  if($pageInfo[0]['js'] != ''){
     $additionalJS = '/js/'.$pageInfo[0]['js'];
     $includeJS = '<script src="'.$additionalJS.'"></script>';
  }
  ?>
