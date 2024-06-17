<?php
session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

// Import database connection
include("connection.php");

$error = ''; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nic = $_SESSION['personal']['nic'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];
    
    // Validate password confirmation
    if ($newpassword == $cpassword) {
        // Check if email already exists
        $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
        if ($result->num_rows > 0) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Email address already registered.</label>';
        } else {
            // Insert user into patient table
            $insert_patient = $database->query("INSERT INTO patient (pemail, pname, ppassword, paddress, pnic, pdob, ptel) 
                                                VALUES ('$email', '$name', '$newpassword', '$address', '$nic', '$dob', '$tele')");
            
            // Insert user into webuser table
            $insert_webuser = $database->query("INSERT INTO webuser (email, usertype) VALUES ('$email', 'p')");

            if ($insert_patient && $insert_webuser) {
                // Set session variables
                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "p";
                $_SESSION["username"] = $fname;

                // Redirect to user dashboard
                header('Location: patient/index.php');
                exit; // Ensure script stops here after redirection
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Error: Registration failed. Please try again later.</label>';
            }
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password confirmation error. Please re-enter password.</label>';
    }
} else {
    // Handle non-POST requests (optional)
    // $error = '<label for="promter" class="form-label"></label>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Signup Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-text {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .sub-text {
            font-size: 16px;
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .input-text {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary-soft {
            background-color: #e0f0ff;
            color: #007bff;
        }

        .hover-link1 {
            color: #007bff;
            text-decoration: none;
        }

        .hover-link1:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<center>
    <div class="container">
        <form action="" method="POST">
            <p class="header-text">Let's Get Started</p>
            <p class="sub-text">It's Okay, Now Create User Account.</p>
            
            <label for="newemail" class="form-label">Email:</label>
            <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
            
            <label for="tele" class="form-label">Mobile Number:</label>
            <input type="tel" name="tele" class="input-text" placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}">
            
            <label for="newpassword" class="form-label">Create New Password:</label>
            <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
            
            <label for="cpassword" class="form-label">Confirm Password:</label>
            <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
            
            <?php echo $error ?>
            
         
            <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
            
            <br><br>
            <label for="" class="sub-text">Already have an account?</label>
            <a href="login.php" class="hover-link1">Login</a>
        </form>
    </div>
</center>

</body>
</html>
