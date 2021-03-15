<?php 
//provide a location, use the header which is how direct people in PHP
function redirect_to($location=null){
     if($location!= null){
         //echo 'about to rediect';
         header('Location: '.$location);//set a location to destination
         exit;
     }
}

//only admin have access to this page
function admin_access_only(){
    if($_SESSION['user_level'] != 2){
          redirect_to('admin_edituser.php');
    }
}

