<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Form</title>
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

        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
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
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }

        .btn:hover {
            background: #218838;
        }

        .signup-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        .error {
            color: rgb(255, 62, 62);
            text-align: center;
            margin-bottom: 15px;
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php
        session_start();

        $_SESSION["user"]="";
        $_SESSION["usertype"]="";

        // Set the new timezone
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $_SESSION["date"]=$date;

        //import database
        include("connection.php");

        $error = '<label for="promter" class="form-label">&nbsp;</label>';

        if($_POST){

            $email = $_POST['useremail'];
            $password = $_POST['userpassword'];

            $result = $database->query("select * from webuser where email='$email'");
            if($result->num_rows == 1){
                $utype = $result->fetch_assoc()['usertype'];
                if ($utype == 'p'){
                    $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                    if ($checker->num_rows == 1){
                        // Patient dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'p';

                        header('location: patient/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label error">Wrong credentials: Invalid email or password</label>';
                    }
                } elseif ($utype == 'a'){
                    $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                    if ($checker->num_rows == 1){
                        // Admin dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'a';

                        header('location: admin/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label error">Wrong credentials: Invalid email or password</label>';
                    }
                } elseif ($utype == 'd'){
                    $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                    if ($checker->num_rows == 1){
                        // Doctor dashboard
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'd';

                        header('location: doctor/index.php');
                    } else {
                        $error = '<label for="promter" class="form-label error">Wrong credentials: Invalid email or password</label>';
                    }
                }
            } else {
                $error = '<label for="promter" class="form-label error">We can\'t find any account for this email.</label>';
            }
        }

        echo $error;
    ?>
    <form method="post">
        <div class="form-group">
            <label for="useremail">Email</label>
            <input type="email" id="useremail" name="useremail" required>
        </div>
        <div class="form-group">
            <label for="userpassword">Password</label>
            <input type="password" id="userpassword" name="userpassword" required>
        </div>
        <button type="submit" class="btn">Login</button>
        <a href="signup.php" class="signup-link">Sign Up</a>
    </form>
</div>

</body>
</html>
