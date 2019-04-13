<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Pharmacist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="navbar-section home">
        <navbar class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand">Pharmacy</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#toggle"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="toggle">
                    <div class="navbar-menu ml-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </navbar>
    </div>

    <div class="container jumbotron col-lg-7 col-xl-7 text-center text-justify">
        <h1 class="display-4">Pharmacist Page</h1>
        <p class="lead">Please use the following tools provided to manage the various patient's prescription's and medicine</p>
    </div>

    <div class="container col-lg-7 col-xl-7 text-center text-justify my-4">
        <h1 class="display-4">Manage Medicine Stock</h1>
        <p class="lead">Please use the following link to access the tools to manage medicine stock data</p>
        <a href="medicinestock.php" class="btn btn-outline-primary">Medicine Stock</a>
    </div>

    <div class="container col-lg-7 col-xl-7 text-center text-justify my-4">
        <h1 class="display-4">Make Prescription</h1>
        <p class="lead">Please use the following link to access the tools to make prescription</p>
        <a href="prescription.php" class="btn btn-outline-primary">Make Prescription</a>
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>