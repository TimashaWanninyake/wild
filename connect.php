<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['submitBtn'])) {
        
        extract($_POST);
        $errors = [];

        if (empty($name)) {
            $errors[] = "Please Enter name";
        }
        if (empty($email)) {
            $errors[] = "Please Enter email";
        }
        if (empty($address)) {
            $errors[] = "Please Enter address";
        }
        if (empty($phone)) {
            $errors[] = "Please Enter phone number";
        }
        if (empty($donation)) {
            $errors[] = "Please Enter amount of donation";
        }

        if (!empty($errors)) {
            $errorMessages = implode("\\n", $errors);
            echo "<script>alert('$errorMessages');</script>";
            echo "<script>window.location.replace('index.html');</script>";
        }else{
            $host = "localhost";
            $username = "root";
            $password = ""; //if have a password, enter inside the double quotation
            $database = "wildlifedatabase";

            $alerts = [];
            $con = mysqli_connect($host, $username, $password, $database);

            if (!$con) {
                die('Not connected !');
            }
            echo "<script>alert('connect is successful');</script>";

            $quary = "insert into donations(name,email,address,phone,amount) values('$name','$email','$address','$phone','$donation')";

            if(mysqli_query($con,$quary)){
                $alerts[] = "Data insertion is successful";
            }else{
                $alerts[] ='Data insertion is unsuccessful';
            }
            if (!empty($alerts)) {
                $alertMessages = implode("\\n", $alerts);
                echo "<script>alert('$alertMessages');</script>";
                echo "<script>window.location.replace('index.html');</script>";    
            }
        }
    }
}
?>
