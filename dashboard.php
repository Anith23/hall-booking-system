<?php
session_start();

if(!isset($_SESSION['token'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .navbar-custom{
            background: linear-gradient(to right, #1d2671, #c33764);
            padding: 15px 30px;
        }

        .navbar-custom h2{
            color: white;
            margin: 0;
            font-weight: bold;
        }

        .dashboard-container{
            padding: 50px 20px;
        }

        .welcome-text{
            text-align: center;
            margin-bottom: 50px;
        }

        .welcome-text h1{
            font-weight: bold;
            color: #1d2671;
        }

        .welcome-text p{
            color: gray;
            font-size: 18px;
        }

        .dashboard-card{
            border: none;
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
            background: white;
        }

        .dashboard-card:hover{
            transform: translateY(-10px);
        }

        .dashboard-card i{
            font-size: 60px;
            margin-bottom: 20px;
        }

        .hall-icon{
            color: #0d6efd;
        }

        .booking-icon{
            color: #198754;
        }

        .logout-icon{
            color: #dc3545;
        }

        .dashboard-card h3{
            margin-bottom: 15px;
            font-weight: bold;
        }

        .dashboard-card p{
            color: gray;
            margin-bottom: 25px;
        }

        .btn-custom{
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="navbar-custom">

    <h2>
        Hall Booking System
    </h2>

</div>

<div class="container dashboard-container">

    <div class="welcome-text">

        <h1>Welcome to Dashboard</h1>

        <p>
            Manage halls and bookings easily using the system.
        </p>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="dashboard-card">

                <i class="fa-solid fa-building hall-icon"></i>

                <h3>Hall Management</h3>

                <p>
                    Add, update and manage hall information.
                </p>

                <a href="hall.php"
                   class="btn btn-primary btn-custom">

                    Open

                </a>

            </div>

        </div>

        <div class="col-md-4">

            <div class="dashboard-card">

                <i class="fa-solid fa-calendar-check booking-icon"></i>

                <h3>Booking Management</h3>

                <p>
                    Create and manage hall bookings.
                </p>

                <a href="booking.php"
                   class="btn btn-success btn-custom">

                    Open

                </a>

            </div>

        </div>

        <div class="col-md-4">

            <div class="dashboard-card">

                <i class="fa-solid fa-right-from-bracket logout-icon"></i>

                <h3>Logout</h3>

                <p>
                    Securely logout from the system.
                </p>

                <a href="logout.php"
                   class="btn btn-danger btn-custom">

                    Logout

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>