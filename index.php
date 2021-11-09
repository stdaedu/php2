<?php
    include('dbconnect.php');
    $error = array();

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);

    // hooson baigaa talbariig shalgah
    if(!empty($name) && !empty($email) && !empty($password) && !empty($cpassword)){
        // email helbertei bichigdsen esehiig shalgah
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['email_type_wrong'] = "Email buruu bn";
        }
        // repeat password taarj bga esehiig shalgah
        if($password !== $cpassword){
            $error['password_not_match'] = "Password taarahgui bn";
        }

        $query = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($connection, $query);

        // ogodliin sand mail davhtsaj baigaa esehiig shalgah
        if(mysqli_num_rows($res) > 0){
            $error['email_exist'] = 'Ene mail deer ali hediin burtgel uussen bn';
        }

        // aldaa baihgui tohioldold ogodliin san ruu ogogdloo oruulah
        if(count($error) === 0){
            $insert_data = "insert into users(username, email, password) values('$name', '$email', '$password');";
            $id_insert = mysqli_query($connection, $insert_data);
            if($id_insert){
                // ogogdol orson tohioldold welcome.php ruu shiljih
                header('location: welcome.php');
            } else {
                $error['insert_data_error'] = "Database error";
            }
        }

    } else {
        $error['empty'] = "Hooson talbar uldeej bolohgui!";
    }
}
    // aldaanuudiig hevlej haruulah
    if(count($error) >= 1){
        foreach($error as $showerror){
            echo $showerror . '<br>';
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST" autocomplete="">
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name= "password" placeholder="Password">
        <input type="password" name= "cpassword" placeholder="Repeat password">
        <input type="submit" name="submit" value="Signup">
    </form>
    <?php 
        
    ?>

</body>
</html>