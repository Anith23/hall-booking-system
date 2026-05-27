<?php
session_start();

if(!isset($_SESSION['token'])){
    header("Location: login.php");
    exit();
}

$message = "";

/* GET HALLS */

$hallUrl = "http://203.94.72.18/trainee/api/production/hall/get/all/active";

$ch = curl_init($hallUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $_SESSION['token']
]);

$hallResponse = curl_exec($ch);

curl_close($ch);

$halls = json_decode($hallResponse, true);

/* SAVE BOOKING */

if(isset($_POST['saveBooking'])){

    $url = "http://203.94.72.18/trainee/api/production/booking/save";

    $data = [

        "reservedDate" => $_POST['reservedDate'],

        "startTime" => $_POST['startTime'],

        "endTime" => $_POST['endTime'],

        "bookingFor" => $_POST['bookingFor'],

        "expectedParticipants" => (int)$_POST['expectedParticipants'],

        "specialRequirements" => $_POST['specialRequirements'],

        "hall" => [
            "id" => $_POST['hallId']
        ],

        "requestedBy" => [
            "userId" => "f2a8d1b7-6c39-45e5-93a4-8d2c1e7f0b03"
        ],

        "createdAt" => date('Y-m-d\TH:i:s')
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $_SESSION['token']
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($response, true);

    if(isset($result['message'])){
        $message = $result['message'];
    }else{
        $message = "Booking Created Successfully";
    }
}

/* GET BOOKINGS */

$bookingUrl = "http://203.94.72.18/trainee/api/production/booking/get/all/bookings";

$ch = curl_init($bookingUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $_SESSION['token']
]);

$bookingResponse = curl_exec($ch);

curl_close($ch);

$bookings = json_decode($bookingResponse, true);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Booking Management</title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            background: #f4f6f9;
            font-family: Arial, sans-serif;
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

        .page-title{
            color: #1d2671;
            font-weight: bold;
        }

        .custom-card{
            border: none;
            border-radius: 20px;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
        }

        .form-control{
            height: 50px;
            border-radius: 10px;
        }

        .btn-custom{
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: bold;
        }

        .table thead{
            background: #1d2671;
            color: white;
        }

        .booking-icon{
            color: #198754;
            font-size: 25px;
            margin-right: 10px;
        }

        .badge-status{
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

    </style>

</head>

<body>

<div class="navbar-custom">

    <h2>
        Hall Booking System
    </h2>

</div>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="page-title">

            <i class="fa-solid fa-calendar-check booking-icon"></i>

            Booking Management

        </h2>

        <a href="dashboard.php"
           class="btn btn-dark btn-custom">

            Back

        </a>

    </div>

    <?php if($message != ""){ ?>

        <div class="alert alert-success">
            <?= $message ?>
        </div>

    <?php } ?>

    <div class="card custom-card p-4">

        <h4 class="mb-4">
            Create Booking
        </h4>

        <form method="POST">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Date</label>

                    <input type="date"
                           name="reservedDate"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Start Time</label>

                    <input type="time"
                           name="startTime"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label>End Time</label>

                    <input type="time"
                           name="endTime"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="text"
                           name="bookingFor"
                           placeholder="Booking For"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="number"
                           name="expectedParticipants"
                           placeholder="Expected Participants"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="text"
                           name="specialRequirements"
                           placeholder="Special Requirements"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <select name="hallId"
                            class="form-control"
                            required>

                        <option value="">
                            Select Hall
                        </option>

                        <?php foreach($halls as $hall){ ?>

                            <option value="<?= $hall['id'] ?>">
                                <?= $hall['name'] ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

            </div>

            <button type="submit"
                    name="saveBooking"
                    class="btn btn-success btn-custom">

                Create Booking

            </button>

        </form>

    </div>

    <div class="card custom-card mt-5 p-4">

        <h4 class="mb-4">
            All Bookings
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                    <tr>
                        <th>Booking For</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Participants</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                if(is_array($bookings)){

                    foreach($bookings as $booking){
                ?>

                    <tr>

                        <td><?= $booking['bookingFor'] ?? '' ?></td>

                        <td><?= $booking['reservedDate'] ?? '' ?></td>

                        <td><?= $booking['startTime'] ?? '' ?></td>

                        <td><?= $booking['endTime'] ?? '' ?></td>

                        <td>

                            <span class="badge bg-success badge-status">

                                <?= $booking['expectedParticipants'] ?? '' ?>

                            </span>

                        </td>

                    </tr>

                <?php
                    }

                }else{
                ?>

                    <tr>

                        <td colspan="5" class="text-center">
                            No Bookings Found
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>