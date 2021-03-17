<?php


//drop down menu
function getUserLevelMap(){
    return array(
        '0' => 'Member',
        '1' => 'Admin',
        '2' => 'Super Admin',

    );
}

//display user level on dashboard
function getCurrentUserLevel(){
    $user_level_map = getUserLevelMap();
    if(isset($_SESSION['user_level']) && array_key_exists($_SESSION['user_level'], $user_level_map)){
        // array_key_exists will check $_SESSION['user_level'] whether exist in array $user_level_map for not
        return $user_level_map[$_SESSION['user_level']];
    }else{
        return "unrecognized";
    }
}

//insert new user info in database
function createUser($user_data){
    //if user data does not have this username or username already exist
    if(empty($user_data['username'])||isUsernameExists($user_data['username'])){
        return 'Username is invalid!';
    }


    $pdo = Database::getInstance() -> getConnection();

    $create_user_query = 'INSERT INTO tbl_users(user_fname, user_lname, user_name, user_password, user_email, user_level)';
    $create_user_query .= ' VALUE(:fname, :lname, :username, :password, :email, :user_level) '; //use placeholder prevent SQL injection


    //return $create_user_query;


    ## 1. Run the proper SQL query, insert user into tbl_user
    $create_user_set = $pdo -> prepare($create_user_query);
    $create_user_result = $create_user_set -> execute(
        array(
            ':fname' => $user_data['fname'],
            ':lname' => $user_data['lname'],
            ':username' => $user_data['username'],
            ':password' => $user_data['password'],
            ':email' => $user_data['email'],
            ':user_level' =>$user_data['user_level'],
        )
    );



    ## 2. Redirect to index.php if create user successfully, mayber leave some message to user?
    ## Otherwise, showing error message
    if($create_user_result){
        redirect_to('admin_createsuccess.php');
    }else{
        return 'The user did not go through!!!';
    }
}

function getSingleUser($user_id){
    // echo 'you are try to fetch user :'.$user_id;
    $pdo = Database::getInstance() -> getConnection();

    $get_user_query = 'SELECT * FROM tbl_users WHERE user_id = :id';//SQL placeholder to aviod SQL injection
    $get_user_set = $pdo ->prepare($get_user_query);
    $get_user_result = $get_user_set -> execute(
        array(
            ':id' => $user_id
        )
        );

    if($get_user_result && $get_user_set ->rowCount()){
        return $get_user_set;
    }else{
        return false;
    }
}





//get all users(not include own account)
function getAllUsers($user_id){
    $pdo = Database::getInstance() -> getConnection();

    $get_all_user_query = 'SELECT * FROM tbl_users where user_id != :id';//SQL placeholder to aviod SQL injection
    $users = $pdo ->prepare($get_all_user_query);
    $get_all_user_result = $users -> execute(
        array(
            ':id' => $user_id
        )
        );

    if($users){
         return $users;
    }else{
        return false;
    }

}



function editUser($user_data){


     $existing_user = getSingleUser($user_data['id'])->fetch();

	# only check that the username is taken if it actually changed
    if ($existing_user['user_name'] != $user_data['username']) {
    		if(empty($user_data['username']) || isUsernameExists($user_data['username'])){
        	return 'Username is invalid!!';
            }
	}

    $pdo = Database::getInstance() -> getConnection();

    $update_user_query = 'UPDATE tbl_users SET user_fname = :fname, user_lname = :lname, user_name = :username, user_password = :password, user_email = :email, user_level = :user_level WHERE user_id = :id';
    $update_user_set = $pdo ->prepare($update_user_query);
    $update_user_result = $update_user_set -> execute(
        array(
          ':fname'      =>$user_data['fname'],
          ':lname'      =>$user_data['lname'],
          ':username'   =>$user_data['username'],
          ':password'   =>$user_data['password'],
          ':email'      =>$user_data['email'],
          ':user_level' =>$user_data['user_level'],
          ':id'         =>$user_data['id'],

        )
    );

   
    if($update_user_result){
        if ($_SESSION['user_id'] == $user_data['id']) {
            //check update session after edit user
            $_SESSION['user_name'] = $user_data['username'];//up to date
            $_SESSION['user_level'] = $user_data['user_level'];


            if($_SESSION['login_times'] == 1){
                redirect_to('newuser_firstedit.php');
            }

            redirect_to('index.php');
        } else {
            redirect_to('admin_updatesuccess.php');
        }

    }else{
        return 'The user update not go through!!!';
    }

}

//only admin can access or change
function isCurrentUserAdminAbove(){
    return !empty($_SESSION['user_level']);
}


function isUsernameExists($username){//true=exist, stop
    $pdo = Database::getInstance() -> getConnection();

    $user_exists_query = 'SELECT COUNT(*) FROM tbl_users WHERE user_name = :username';
    $user_exists_set = $pdo ->prepare($user_exists_query);
    $user_exists_result = $user_exists_set -> execute(
        array(
          ':username'=>$username
        )
    );

    return !$user_exists_result || $user_exists_set->fetchColumn()>0;
                                  // if this username more than 0, mean this user already exist
} 


