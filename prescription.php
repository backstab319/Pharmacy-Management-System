<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Prescription</title>
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

    <?php
        include "connect.php";
    ?>

<div class="container text-center my-4 col-lg-7 col-xl-7">
        <h1 class="display-4">Prescription</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <?php
                prescription();
                function prescription(){
                    global $conn;
                    $sql = "SELECT * FROM prescription";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        showpre($result);
                    }else{
                        echo "<p class='lead'>There are no prescription's</p>";
                    }
                }
                function showpre($result){
                    echo '<table class="table table-bordered table-striped table-hover">
                    <form method="POST" action="prescription.php">
                    <thead class="thead-primary">
                    <tr>
                    <th>Medicine Name</th>
                    <th>Medicine Price</th>
                    <th>Medicine Description</th>
                    <th>Quantity</th>
                    </tr>
                    </thead>';
                    while($row = $result->fetch_assoc()){
                        if($row["quantity"] != 0){
                            echo "<tr><td>".$row['med_name']."</td><td>".$row['med_price']."</td><td>".$row['med_description']."</td><td><input type='number' name='".$row['med_name']."quan'></td></tr>";
                        }
                    }
                    echo "</table>
                        <input type='submit' value='Order' name='order' class='btn btn-outline-primary'>
                        </form>
                    ";
                }
                if(isset($_POST["order"])){
                    order();
                }
                function order(){
                    global $conn;
                    $sql = "SELECT * FROM prescription";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $name = $row["med_name"];
                    $desc = $row["med_description"];
                    $price = $row["med_price"];
                    $quantity = $_POST[$name."quan"];
                    checkstock($name,$quantity);
                    $sql = "SELECT * FROM order_med WHERE med_name='$name'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $newquan = $row["quantity"] + $quantity;
                        $sql = "UPDATE order_med SET quantity = $newquan WHERE med_name='$name'";
                        $conn->query($sql);
                    }else{
                        $sql = "INSERT INTO order_med VALUES('$name','$desc',$price,$quantity)";
                        $conn->query($sql);
                    }
                    header("Location: prescription.php");
                }
                function checkstock($name,$quantity){
                    global $conn;
                    $sql = "SELECT * FROM med_stock WHERE med_name='$name'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    if($quantity >= $row["quantity"]){
                        echo "The inventory is low please choose a smaller quantity!";
                    }else{
                        $newquan = $row["quantity"] - $quantity;
                        $sql = "UPDATE med_stock SET quantity = '$newquan' WHERE med_name='$name'";
                        $conn->query($sql);
                    }
                }
            ?>
        </div>
    </div>

    <div class="container text-center my-4 col-lg-7 col-xl-7">
        <h1 class="display-4">Clear Prescription</h1>
        <form action="prescription.php" method="POST">
            <input type="submit" value="Clear" name="clear" class="btn btn-outline-primary">
        </form>
        <?php
            if(isset($_POST["clear"])){
                clearpres();
            }
            function clearpres(){
                global $conn;
                $sql = "TRUNCATE TABLE prescription";
                $conn->query($sql);
                header("Location: prescription.php");
            }
        ?>
    </div>

    <div class="container text-center my-4 col-lg-7 col-xl-7">
        <h1 class="display-4">Medicine Stock</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <?php
                showmedicine();
                function showmedicine(){
                    global $conn;
                    $sql = "SELECT * FROM med_stock";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        show($result);
                    }else{
                        echo "<p class='lead'>The medicine stock is empty</p>";
                    }
                }
                function show($result){
                    echo '<table class="table table-bordered table-striped table-hover">
                    <thead class="thead-primary">
                    <tr>
                    <th>Medicine name</th>
                    <th>Medicine Price</th>
                    <th>Description</th>
                    <th>Available Stock</th>
                    <th>Add</th>
                    </tr>
                    </thead>';
                    while($row = $result->fetch_assoc()){
                        echo "<tr><td>".$row['med_name']."</td><td>".$row['med_price']."</td><td>".$row['med_description']."</td><td>".$row['quantity']."</td><td><a class='btn btn-outline-primary' href='prescription.php?medicine=".$row['med_name']."'>Add</a></td></tr>";
                    }
                    echo "</table>";
                }
                if(isset($_GET["medicine"])){
                    addmed($_GET["medicine"]);
                    header("Location: prescription.php");
                }
                function addmed($medname){
                    global $conn;
                    $sql = "SELECT * FROM med_stock WHERE med_name='$medname'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $name = $row["med_name"];
                    $price = $row["med_price"];
                    $desc = $row["med_description"];
                    $quan = $row["quantity"];
                    if($quan > 0){
                        $sql = "SELECT * FROM prescription WHERE med_name='$name'";
                        $result = $conn->query($sql);
                        if($result->num_rows == 0){
                            $sql = "INSERT INTO prescription VALUES('$name',$price,'$desc',1)";
                            $conn->query($sql);
                        }
                    }else{
                        echo "Inventory low!";
                    }
                }
            ?>
        </div>
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>