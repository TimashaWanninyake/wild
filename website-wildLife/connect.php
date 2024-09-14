<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['submitBtn'])) {
        
        extract($_POST);
        $errors = [];


        //bankslip saving
        $savingFolder = "C:\xampp\htdocs\receipts";
        if (isset($_FILES['bankSlip'])) {
            $bankSlip = $_FILES['bankSlip'];
            $bankSlipName = $bankSlip['name'];
            $bankSlipTmpName = $bankSlip['tmp_name'];
            $bankSlipError = $bankSlip['error'];

            if ($bankSlipError === 0) {
                $destination = $savingFolder . $bankSlipName;
                if (move_uploaded_file($bankSlipTmpName, $destination)) {
                    $alerts[] = "Bank slip uploaded successfully";
                } else {
                    $alerts[] = "Failed to upload bank slip";
                }
            } else {
                $alerts[] = "Error uploading bank slip: " . $bankSlipError;
            }
        } else {
            $alerts[] = "No bank slip file found";
        }


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
            $password = "bbw@8138"; //if have a password, enter inside the double quotation
            $database = "wildlifedatabase";

            $alerts = [];
            $con = mysqli_connect($host, $username, $password, $database);

            if (!$con) {
                die('Not connected !');
            }
            echo "<script>alert('connect is successful');</script>";

            $quary = "insert into web_donations(name,email,address,phone,amount) values('$name','$email','$address','$phone','$donation')";

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
