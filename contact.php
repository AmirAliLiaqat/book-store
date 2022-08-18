<?php
    require 'config.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)) {
        header('location: login.php');
    }

    if(isset($_POST['send'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = $_POST['number'];
        $msg = mysqli_real_escape_string($conn, $_POST['message']);

        $check_message = mysqli_query($conn, "SELECT * FROM `message`
        WHERE `name` = '$name' AND `email` = '$email' AND `number` = '$number' 
        AND `message` = '$msg'") or die("Query Failed");

        if(mysqli_num_rows($check_message) > 0) {
            $message[] = "message already been send";
        } else {
            mysqli_query($conn, "INSERT INTO `message` (`user_id`, `name`, `email`, `number`, `message`) 
            VALUES ('$user_id', '$name', '$email', '$number', '$msg')") or die("Query Failed");
            $message[] = "message send successfully";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>contact us</h3>
        <p> <a href="home.php">home</a> / contact </p>
    </div><!--heading-->

    <!-- section start -->
    <section class="contact">
        <form action="" method="post">
            <h3>say something</h3>
            <input type="text" name="name" class="box" placeholder="enter your name" required>
            <input type="email" name="email" class="box" placeholder="enter your email" required>
            <input type="number" name="number" class="box" placeholder="enter your number" required>
            <textarea name="message" class="box" cols="30" rows="10" placeholder="enter your message"></textarea>
            <input type="submit"  class="btn" value="send message" name="send">
        </form>
    </section>
    <!-- section end -->

    <?php include 'footer.php'; ?>

    <!-- custom js file link -->
    <script src="js/script.js"></script>
    
</body>
</html>