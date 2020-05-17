<?php

/**
 * Destroy a user session and its data
**/
function destroy_session_and_data()
{
    session_start();
    $_SESSION= array();
    setcookie(session_name(), "", time()-259200, "/");
    session_destroy();
}


function sessionFixation(){
  if(!isset($_SESSION['initiated'])){
    session_regenerate_id();
    $_SESSION['initiated'] = 1;
  }
  if(!isset($_SESSION['count'])){
    $_SESSION['count'] = 0;
  }
  else{
    $_SESSION['count']++;
  }
  if($SESSION['count'] > 5){
    session_regenerate_id();
  }
}
