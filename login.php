<?php
session_start();

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $url = "http://203.94.72.18/trainee/api/auth/signin";

    $data = [
        "username" => $username,
        "password" => $password
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($response, true);

    if(isset($result['token'])){

        $_SESSION['token'] = $result['token'];

        header("Location: dashboard.php");
        exit();

    }else{

        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Hall Booking System</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #1d2671, #c33764);
            font-family: Arial, sans-serif;
        }

        .login-card{
            width: 400px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.3);
        }

        .login-title{
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #1d2671;
        }

        .form-control{
            height: 50px;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-login{
            width: 100%;
            height: 50px;
            border-radius: 10px;
            border: none;
            background: #1d2671;
            font-weight: bold;
            font-size: 18px;
            transition: 0.3s;
        }

        .btn-login:hover{
            background: #c33764;
        }

        .system-text{
            text-align: center;
            margin-bottom: 10px;
            color: gray;
            font-size: 14px;
        }

    </style>

</head>

<body>

<div class="login-card">

    <h2 class="login-title">
        Hall Booking System
    </h2>

    <p class="system-text">
        Secure Hall Reservation Management
    </p>

    <?php if($error != ""){ ?>

        <div class="alert alert-danger">
            <?= $error ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="mb-3">

            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Enter Username"
                   required>

        </div>

        <div class="mb-4">

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Enter Password"
                   required>

        </div>

        <button type="submit"
                name="login"
                class="btn btn-primary btn-login">

            Login

        </button>

    </form>

</div>

</body>

</html>