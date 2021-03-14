<?php
require_once '../load.php';

$ip = $_SERVER['REMOTE_ADDR'];//"REMOTE_ADDR" => The IP address from which the user is viewing the current page.
//we want get the value $ip, and add it in login() as the third parameter

//gain username and password, empty check
if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); //The trim() function removes whitespace and other predefined characters from both sides of a string.
    
    
    if(!empty($username) && !empty($password)){//if username and password both not empty
        $result = login($username, $password, $ip);//allow login, login function in login.php
        $message = $result;
    }else{
        redirect_to('admin_login.php');
        // echo "<br />\n";
        // $message = 'Plesase fill out the request field';
    }
}


//if user already log in, redirect user to welcome.php, dont allow login in user access admin_login.php again
if(isset($_SESSION['user_id'])){
    redirect_to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../public/css/main.css">
    <link rel="stylesheet" type="text/css"  href="../public/css/reset.css">
    <title>Welcome to the admin panel</title>
</head>
<body>
    <section class="login_area">
           

            <div class="login_form_area">
                <?php echo !empty($message)?$message:'';?>
                <h3>LOGIN TO YOUR ACCOUNT</h3>
                <div class="login_form">
                    <form action="admin_login.php" method="post">
                    <label for="username">Username:</label> <br>
                    <input id="username" type="text" name="username" value="" placeholder="" ><br>
                    
                    <label for="password">Password:</label> <br>
                    <input id="password" type="text" name="password" value="" placeholder="" ><br>
                    
                    <button type="submit" name="submit">LOGIN</button>
                    <!-- <h4>* Login Attempt: <?php echo $_SESSION['login_attempts']; ?> </h4> -->
                       
                    </form>
                </div>
            </div>

            <h3>Username : Pan</h3>
            <h3>Password : pan123</h3>
    </section>
</body>
</html>
