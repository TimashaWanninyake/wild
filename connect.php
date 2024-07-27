<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (isset($_POST['donatorName']) && isset($_POST['phoneNumber']) && isset($_POST['address']) && isset($_POST['email']) && isset($_POST['donation']) && isset($_FILES['photo'])) {
            
            $donatorName = $_POST['donatorName'];
            $phoneNumber = $_POST['phoneNumber'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $donation = $_POST['donation'];

            
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = $_FILES['photo']['name'];
            $fileSize = $_FILES['photo']['size'];
            $fileType = $_FILES['photo']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            
            if (!empty($donatorName) && !empty($phoneNumber) && !empty($address) && !empty($email) && !empty($donation) && !empty($fileName)) {
                
                $conn = new mysqli('localhost', 'root', '', 'donations');
                if ($conn->connect_error) {
                    die('Connection Failed: ' . $conn->connect_error);
                } else {
                    
                    $stmt = $conn->prepare("INSERT INTO donate(donatorName, phoneNumber, address, email, donation, photo) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $donatorName, $phoneNumber, $address, $email, $donation, $fileName);
                    if ($stmt->execute()) {
                        
                        $uploadDirectory = 'uploads/';
                        $destPath = $uploadDirectory . $fileName;
                        if (move_uploaded_file($fileTmpPath, $destPath)) {
                            echo "Donated Successfully";
                        } else {
                            echo "Error: Failed to move uploaded file.";
                        }
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                    $conn->close();
                }
            } else {
                echo "Error: All fields are required.";
            }
        } else {
            echo "Error: All form fields must be submitted.";
        }
    } else {
        echo "Error: Form submission method must be POST.";
    }
?>
