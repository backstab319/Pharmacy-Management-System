<?php
    function setusercookie($username){
        setcookie("user",$username,time()+1800,"/");
    }
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Pharmacy</title>
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
                                <a class="nav-link" href="#login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#lan">Langauges</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dev">Dev</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </navbar>
    </div>

    <?php
        include "connect.php";
    ?>

    <div class="background">
        <div class="overlay d-flex flex-column justify-content-center align-items-center">
            
                <div class="heading" id="login">
                    <h1 class="display-4">Pharmacy Login</h1>
                </div>
                <div class="form-group col-lg-4 col-xl-4">
                    <form action="index.php" method="POST">
                        <input type="text" name="username" placeholder="Username" class="form-control mb-2">
                        <input type="password" name="password" placeholder="Password" class="form-control mb-2">
                        <input type="submit" value="Login" name="login" class="form-control btn btn-outline-primary mb-2">
                    </form>
                </div>
                <?php
                    if(isset($_POST["login"])){
                        checkuser();
                    }
                    function checkuser(){
                        global $conn;
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $sql = "SELECT * FROM pharmacy_login WHERE user_id = '$username'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        if($password = $row["password"]){
                            setusercookie($username);
                            rediretcuser($row["user_type"]);
                        }
                    }
                    function rediretcuser($usertype){
                        if($usertype == "admin"){
                            header("Location: admin.php");
                        }elseif($usertype == "manager"){
                            header("Location: manager.php");
                        }elseif($usertype == "pharmacist"){
                            header("Location: pharmacist.php");
                        }else{
                            header("Location: cashier.php");
                        }
                    }
                ?>
            
        </div>
    </div>

    <div class="container col-lg-7 col-xl-7 text-justify text-center my-4" id="about">
        <h1 class="display-4 text-justify">About Pharmacy Management System</h1>
        <p class="lead text-justify">Our project Pharmacy Management System can make the work easier by giving the details of the medicine when its name is entered. A computer gives the details of the medicine like rate of medicine, and the availability of the medicines. It becomes  very difficult in big medical Stores to handle the details of all the medicines manually, so by using this pharmacy  manage  we can maintain the records of all medicines and prescriptions.  We can also handle the details of all the medicines manually, so by using this pharmacy management system we can maintain the records of all the medicines. 
	        This system keeps the e of the data of the medicines.  It is fed with the   information whenever new medicines are brought. When we enter the name of the prescription it gives the details of the medicine.  It gives the price of the medicine and also warns when the medicine has reached its non-availability.
        </p>
    </div>

    <div class="container col-lg-7 col-xl-7 text-justify text-center my-4" id="lan">
        <h1 class="display-4">Language's used</h1>
        <ul class="list-group">
            <li class="list-group-item">Html</li>
            <li class="list-group-item">Css</li>
            <li class="list-group-item">Javascript</li>
            <li class="list-group-item">Php</li>
            <li class="list-group-item">Bootstrap 4</li>
            <li class="list-group-item">Sql</li>
        </ul>
    </div>

    <div class="container col-lg-7 col-xl-7 text-justify text-center my-4" id="dev">
        <h1 class="display-4">About Developer</h1>
        <p class="lead">This project is actively developed by Santhosh S of BCA VI Semester 'B' Section.</p>
    </div>


    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>