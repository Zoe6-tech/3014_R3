
<?php
function login($username, $password, $ip) {

    ## TODO remove the following debug when done
    //return 'You are trying to login with Username:'.$username.'Password:'.$password;

    //database connecters
    $pdo = Database :: getInstance() -> getConnection();
    #TODO: Finish the following query to check if the username and passowrd are matching in DB
    $get_user_query = ' SELECT * FROM tbl_users  WHERE user_name = :username AND user_password = :password ';
    $user_set = $pdo -> prepare($get_user_query);
    $user_set -> execute(
        array(
            ':username' => $username,
            ':password' => $password
        )
    );

    if($found_user = $user_set -> fetch(PDO::FETCH_ASSOC)){//PDO::FETCH_ASSOC tells PDO to return the result as an associative array.
       //if found user exist in user database, get him in!

       if ($found_user['user_status'] ==='locked') {
        return "You account has locked, please contact admin";
        redirect_to('admin_login.php');
        exit;
    }

        $found_user_id = $found_user['user_id'];//get user id

       
        //Newly created user, not logged in two minutes, user locked
        if ( $found_user['login_times'] == 0) {

            //simply compare two integer timestamp values...
             $diff = strtotime($found_user['user_date']) - time();
            //$diff = strtotime($found_user['user_date']) - strtotime('now');

             $limit_time = 2*60;

            if ( $diff  >=  $limit_time ) {
                  // it been more than 2 minutes
                if ($found_user['user_status'] != 'locked') {
                    $update_user_query = 'UPDATE tbl_users SET user_status = :user_status WHERE user_id = :user_id';
                    $update_user_set = $pdo -> prepare($update_user_query);
                    $update_user_set -> execute(
                        array(
                            ':user_status'=>'locked',
                            ':user_id' => $found_user_id
                        )
                    );
                }
                redirect_to('login_fail.php');
                exit;
            }
        }



        //write the username and userID into session
        $_SESSION['user_id'] = $found_user_id;
        $_SESSION['user_name'] = $found_user['user_name'];
        $_SESSION['user_level'] = $found_user['user_level'];//show user level

        //update the user IP by the curren logged in one
        $update_user_query = 'UPDATE tbl_users SET user_ip = :user_ip WHERE user_id = :user_id';
        $update_user_set = $pdo -> prepare($update_user_query);
        $update_user_set -> execute(
            array(
                ':user_ip' => $ip,
                ':user_id' => $found_user_id
            )
        );
        $_SESSION['user_ip'] = $found_user['user_ip'];//write user_ip in session


        //update the user last login time by the current loggod in one 
        $update_user_query = 'UPDATE tbl_users SET last_login =now() WHERE user_id = :user_id';
        $update_user_set = $pdo -> prepare($update_user_query);
        $update_user_set -> execute(
            array(
                ':user_id' => $found_user_id
                
            )
        );
        $_SESSION['last_login'] = $found_user['last_login'];//write user_lastlogintime in session

        $_SESSION['login_times'] = $found_user['login_times']+1;

        //update the number of successfully login
        $update_user_query = 'UPDATE tbl_users SET login_times=:login_times WHERE user_id=:user_id';
        $update_user_set = $pdo->prepare($update_user_query);
        $update_user_set->execute(
            array(
                ':user_id'=>$found_user_id,
                ':login_times'=>$_SESSION['login_times']
                )
        );

        //first time login redirect to edit user page
        if($_SESSION['login_times'] == 1){
            redirect_to('admin_edituser.php');
        }
       
       ##TODO : debug only, will change here
       //return 'Hello, ' . $username . '!  <br />  Your IP address (using $_SERVER[\'REMOTE_ADDR\']) is ' . $ip . '<br /><br />';
               
       //after login in succes, redirect user back to welcome.php, redirect_to function
       redirect_to('index.php');

    }else{

       //this is invaild attemp, reject it!
       echo "<br />\n";
       return "Sorry, your username or password isn't correct. ";
    }
}


//only login in user can see the index.php, otherwise, rediect to login page
function confirm_logged_in(){
    if(!isset($_SESSION['user_id'])){
          redirect_to('admin_login.php');
    }
}



//if user log out, redirect user to admin_login.php
function logout(){
    session_destroy();
    redirect_to('admin_login.php');
}