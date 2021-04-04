<?php

session_start();
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = $_POST["client"];
    $tour = $_POST["tour"];
    $bike = $_POST["bike"];
    $tva = $_POST["tva"];
    $sql = "INSERT INTO tblfacturation (id_user, idtour, idbike, TVA, TTC) VALUES (:client, :tour, :bike, :tva, (SELECT ((t.duration * m.PricePerHour) * :tva) FROM tblmotors m, tbltours t, tblfacturation f WHERE f.idbike = m.id AND f.idtour = t.id))";
    $query = $dbh->prepare($sql);
    $query->execute([
        "client" => $client,
        "tour" => $tour,
        "bike" => $bike,
        "tva" => $tva
    ]);
    header("location:facturation.php");

    $msg = "Data saved successfully";

}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bike Rental Portal | Facturation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
</head>
<body>
<?php include('includes/header.php');?>
<div class="container mt-5">
    <form method="post">
        <div class="card bg-light border-dark">
            <div class="card-header bg-dark text-light font-weight-bold text-uppercase">
                Basic Info
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text bg-dark text-light" for="client">Select Client*</label>
                            </div>
                            <select class="custom-select" name="client" id="client">
                                <option selected>Choose...</option>
                                <?php
                                $sql = "SELECT * FROM tblusers";
                                foreach ($dbh->query($sql) as $row) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['FullName'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text bg-dark text-light" for="tour">Select Tour</label>
                            </div>
                            <select class="custom-select" name="tour" id="tour">
                                <option selected>Choose...</option>
                                <?php
                                $sql = "SELECT * FROM tbltours";
                                if ($dbh->query($sql)) echo "<alert>Pas d'accès</alert>";
                                foreach ($dbh->query($sql) as $row) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['tname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group mt-4">
            <div class="input-group-prepend">
                <label class="input-group-text bg-dark text-light" for="bike">Select Bike</label>
            </div>
            <select class="custom-select" name="bike" id="bike">
                <option selected>Choose...</option>
                <?php
                $sql = "SELECT * FROM tblmotors";
                if ($dbh->query($sql)) echo "<alert>Pas d'accès</alert>";
                foreach ($dbh->query($sql) as $row) {
                    echo "<option value='" . $row['id'] . "'>" . $row['MotorsTitle'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="input-group mt-4">
            <div class="input-group-append">
                <label class="input-group-text bg-dark text-light" for="tva">TVA</label>
            </div>
            <input type="number" step="5" class="form-control" name="tva" id="tva" placeholder="0" min="0"
                   max="100"/>
            <div class="input-group-append">
                <label class="input-group-text">%</label>
            </div>
        </div>
        <div class="row mt-4 text-center">
            <div class="col">
                <input type="submit" value="Save change" name="submit" class="btn btn-primary"/>
            </div>
            <div class="col">
                <input type="button" class="btn btn-dark text-light"
                       onclick="document.location.href='index.php'" value="Cancel"/>
            </div>
        </div>
    </form>
</div>
</body>
</html>
