<?php
require_once '../load.php';

//make sure this page only access to 
confirm_logged_in();
//only admin have acesss to this page
admin_access_only();


$id = $_SESSION['user_id'];//define in login.php

$users = getAllUsers($id);

if(!$users){
    $messager = 'Fail to get user list';
}

// when user click submit
if(isset($_POST['submit'])){
    $data = array(
        'fname'      => trim($_POST['fname']),
        'lname'      => trim($_POST['lname']),
        'username'   => trim($_POST['username']),
        'password'   => trim($_POST['password']),
        'email'      => trim($_POST['email']),
        'user_level' => isCurrentUserAdminAbove()?trim($_POST['user_level']):'0', 
        'id'         => trim($_POST['userid']),//update a exist user so need id
    );
    // var_dump($data);die;
  $message = editUser($data);//update user info to database
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../public/css/main.css">
    <link rel="stylesheet" type="text/css"  href="../public/css/reset.css">
    <title>Edit User</title>
</head>
<body>
    <section class="edit_user_area">
        <h2>Edit Other Users</h2>
       
        <div class="edit_user_form">
            <?php echo !empty($message)?$message:'';?>

                <?php if(!empty($users)):?>
                        <?php while($user_info = $users -> fetch(PDO::FETCH_ASSOC)):?><!--user_info: table columns name-->
                            <br>
                        <form action="admin_editotheruser.php" method="post">
                            <input type="hidden" name="userid" value="<?php echo $user_info['user_id']; ?>">
                            <div class="edituser_label_input">
                            <label for="user_name">User Name:</label>
                            <input type="text" name="username"  id="user_name"  value="<?php echo $user_info['user_name']; ?>">
                            </div>
                            <br>
                            <div class="edituser_label_input">
                            <label for="first_name">First Name:</label>
                            <input type="text" name="fname"  id="first_name"  value="<?php echo $user_info['user_fname']; ?>"> 
                            </div>
                            <br>
                            <div class="edituser_label_input">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="lname"  id="last_name"  value="<?php echo $user_info['user_lname']; ?>">
                            </div>
                            <br>
                            <div class="edituser_label_input">
                            <label for="password">Password:</label>
                            <input type="text" name="password"  id="password"  value="<?php echo $user_info['user_password']; ?>">
                            </div>
                            <br>
                            <div class="edituser_label_input">
                            <label for="email">User Email:</label>
                            <input type="email" name="email"  id="email"  value="<?php echo $user_info['user_email']; ?>">
                            </div>
                            <br>
                            <div class="edituser_label_input">
                            <?php if(isCurrentUserAdminAbove()):?>
                                <label for="user_level">User Level:</label>
                                <select  name="user_level"  id="user_level" >
                                    <?php  $user_level_map = getUserLevelMap();
                                    foreach($user_level_map as $val => $label): ?>
                                    <option value="<?php echo $val;?>"<?php echo $val ===(int)$user_info['user_level']?'selected':'';?>><?php echo $label;?></option>   
                                    <?php endforeach;?>
                                </select>
                            <?php endif;?>
                            </div>
                            <br><br>

                            
                            <div class="edit_user_buttons">
                                <button  class="subimt-createuser" type="submit" name="submit">SUBMIT</button>
                                <a href="index.php">BACK</a>
                            </div>
                            
                        </form>
                        
                        <?php endwhile;?>

                <?php endif;?>
        </div>
    </section>
</body>
</html>