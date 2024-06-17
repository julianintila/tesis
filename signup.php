<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Signup Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .signup-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        .signup-container h2 {
            margin-bottom: 10px;
            color: #333;
            text-align: center;
        }

        .signup-container p {
            margin-bottom: 20px;
            color: #777;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .login-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .signup-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Let's Get Started</h2>
    <p>Add Your Personal Details to Continue</p>
    <?php
        session_start();

        $_SESSION["user"]="";
        $_SESSION["usertype"]="";

        // Set the new timezone
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $_SESSION["date"]=$date;

        if($_POST){
            $_SESSION["personal"] = array(
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'address' => $_POST['address'],
                'nic' => $_POST['nic'],
                'dob' => $_POST['dob']
            );

            print_r($_SESSION["personal"]);
            header("location: create-account.php");
        }
    ?>
    <form method="post">
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="nic">NIC</label>
            <input type="text" id="nic" name="nic" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
        </div>
        <button type="submit" class="btn">Next</button>
        <a href="login.php" class="login-link">Already have an account? Go back to login</a>
    </form>
</div>

</body>
</html>
