<?php
    require 'config.php';

    if(isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
        $user_type = $_POST['user_type'];

        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' 
        AND password = '$pass'") or die("Query Failed");

        if(mysqli_num_rows($select_users) > 0) {
            $message[] = "user already exist!";
        } else {
            if($pass != $cpass) {
                $message[] = "confirm password not matched!";
            } else {
                mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`, `user_type`) 
                VALUES ('$name','$email','$pass','$user_type')") or die("Query Failed");
                $message[] = "register successfully";
                header('location: login.php');
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php
        if(isset($message)) {
            foreach ($message as $message) {
                echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div><!--message-->
                ';
            }
        }
    ?>

    <div class="form-container">
        <form action="" method="post">
            <h3>register now</h3>
            <input type="text" class="box" name="name" placeholder="enter your name" required >
            <input type="email" class="box" name="email" placeholder="enter your email" required >
            <input type="password" class="box" name="password" placeholder="enter your password" required >
            <input type="password" class="box" name="cpassword" placeholder="confirm your password" required >
            <select class="box" name="user_type">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" class="btn" name="submit" value="register now">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </div><!--form-container-->

</body>
</html>