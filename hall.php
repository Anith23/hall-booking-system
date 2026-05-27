<?php
session_start();

if(!isset($_SESSION['token'])){
    header("Location: login.php");
    exit();
}

$message = "";

/* SAVE HALL */
if(isset($_POST['saveHall'])){

    $url = "http://203.94.72.18/trainee/api/production/hall/save";

    $data = [
        "name" => $_POST['name'],
        "description" => $_POST['description'],
        "location" => $_POST['location'],
        "capacity" => (int)$_POST['capacity'],
        "hasProjector" => true,
        "hasAc" => true,
        "hasWhiteboard" => true
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
        $message = "Hall Saved Successfully";
    }
}

/* GET ALL ACTIVE HALLS */

$url = "http://203.94.72.18/trainee/api/production/hall/get/all/active";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $_SESSION['token']
]);

$response = curl_exec($ch);

curl_close($ch);

$halls = json_decode($response, true);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Hall Management</title>

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

        .hall-icon{
            color: #0d6efd;
            font-size: 25px;
            margin-right: 10px;
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

            <i class="fa-solid fa-building hall-icon"></i>

            Hall Management

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
            Add New Hall
        </h4>

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <input type="text"
                           name="name"
                           placeholder="Hall Name"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="text"
                           name="description"
                           placeholder="Description"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="text"
                           name="location"
                           placeholder="Location"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <input type="number"
                           name="capacity"
                           placeholder="Capacity"
                           class="form-control"
                           required>

                </div>

            </div>

            <button type="submit"
                    name="saveHall"
                    class="btn btn-primary btn-custom">

                Save Hall

            </button>

        </form>

    </div>

    <div class="card custom-card mt-5 p-4">

        <h4 class="mb-4">
            Active Halls
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Capacity</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                if(is_array($halls)){

                    foreach($halls as $hall){
                ?>

                    <tr>

                        <td><?= $hall['name'] ?? '' ?></td>

                        <td><?= $hall['description'] ?? '' ?></td>

                        <td><?= $hall['location'] ?? '' ?></td>

                        <td><?= $hall['capacity'] ?? '' ?></td>

                    </tr>

                <?php
                    }

                }else{
                ?>

                    <tr>

                        <td colspan="4" class="text-center">
                            No Halls Found
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