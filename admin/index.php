<?php
require_once '../load.php';
confirm_logged_in();//only login in user can see the index.php page


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Welcome Page</title>
</head>
<body>
    <section class="index_php">
        <div class="login_user">
            <div class="login_info">
                <h2>Hello, <?php echo $_SESSION['user_name'];?>! </h2>
                <h3>You are : <?php echo getCurrentUserLevel();?></h3>

                

                
                <h4>IP address:  <?php echo $_SESSION['user_ip']?></h4>
                <h4>Last Login Time: <?php echo $_SESSION['last_login']; ?></h4>
                <h4>Number of Successful Login: <?php echo $_SESSION['login_times'];?></h4>
                

                
                
            </div>

            <div class="login_user_buttons">
                <?php if(!empty($_SESSION['user_level'])):?>
                <a href="admin_createuser.php">Create New User</a>
                <?php endif;?>
                 <br>
                <a href="admin_edituser.php">Edit My Account</a>
                <br>
                <?php if($_SESSION['user_level'] ==2):?>
                <a href="admin_editotheruser.php">Edit Others Account</a>
                <?php endif;?>
                <br>
                <a href="admin_logout.php">Sign Out</a>
            </div>

        </div>

    </section>
</body>
</html>