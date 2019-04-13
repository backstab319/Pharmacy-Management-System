<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Stock</title>
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
        <h1 class="display-4">View Medicine Stock</h1>
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
                    <th>Stock Quantity</th>
                    </tr>
                    </thead>';
                    while($row = $result->fetch_assoc()){
                        
                        echo "<tr><td>".$row['med_name']."</td><td>".$row['med_price']."</td><td>".$row['med_description']."</td><td>".$row["quantity"]."</td></tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Add Medicine Information</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <form method="POST" action="medicinestock.php">
                <div class="form-group">
                    <input type="text" class="form-control my-2" name="med_name" placeholder="Medicine Name">
                    <input type="number" class="form-control my-2" name="price" placeholder="Price">
                    <input type="text" class="form-control my-2" name="desc" placeholder="Medicine description">
                    <input type="number" class="form-control my-2" name="quantity" placeholder="Quantity">
                    <input type="submit" class="form-control my-2 btn btn-outline-primary" value="Add Medicine" name="add">
                </div>
            </form>
        </div>
        <?php
            if(isset($_POST["add"])){
                add_medicine();
            }
            function add_medicine(){
                global $conn;
                $med_name = $_POST["med_name"];
                $med_price = $_POST["price"];
                $med_description = $_POST["desc"];
                $quantity= $_POST["quantity"];
                checkmed($med_name,$quantity);
                if(($med_name and $med_price and $med_description and $quantity) != NULL){
                    $sql = "INSERT INTO med_stock VALUES('$med_name',$med_price,'$med_description',$quantity)";
                    $conn->query($sql);
                    header("Location: medicinestock.php");
                }
            }
            function checkmed($med_name,$quantity){
                global $conn;
                $sql = "SELECT * FROM med_stock WHERE med_name='$med_name'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    echo $row["quantity"];
                    $new_quantity = $row["quantity"] + $quantity;
                    $sql = "UPDATE med_stock SET quantity=$new_quantity WHERE med_name='$med_name'";
                    $conn->query($sql);
                    exit();
                }
            }
        ?>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Update Medicine Stock Information</h1>
        <p class="text-justify lead">Please select the information that you want to update with the information that you want it to change it to.</p>
        <div class="container text-center col-lg-7 col-xl-7">
            <form method="POST" action="medicinestock.php">
                <div class="form-group">
                    <input type="text" class="form-control my-2" name="oldval" placeholder="Enter old value">
                    <label for="column">Select Information to change</label>
                    <select class="form-control my-2" name="column" id="column">
                        <option value="med_name">Medicine Name</option>
                        <option value="med_price">Medicine Price</option>
                        <option value="desc">Description</option>
                        <option value="quantity">Quantity</option>
                    </select>
                    <input type="text" class="form-control my-2" name="newval" placeholder="Enter new value">
                    <input type="submit" class="form-control my-2" value="Update" name="update">
                </div>
            </form>
        </div>
        <?php
            if(isset($_POST["update"])){
                update_stock();
            }
            function update_stock(){
                global $conn;
                $oldval = $_POST["oldval"];
                $column = $_POST["column"];
                $newval = $_POST["newval"];
                $sql = "UPDATE med_stock SET $column='$newval' WHERE $column='$oldval'";
                $conn->query($sql);
                header("Location: medicinestock.php");
            }
        ?>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Remove Medicine from stock</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <div class="form-group">
                <form method="POST" action="medicinestock.php">
                    <label for="del_val">Select medicine name to delete</label>
                        <select class="form-control my-2" name="delval" id="del_val">
                            <?php
                                dispoption();
                                function dispoption(){
                                    global $conn;
                                    $sql = "SELECT med_name FROM med_stock";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0){
                                        while($row = $result->fetch_assoc()){
                                            echo $row["name"];
                                            echo "<option value='".$row["med_name"]."'>".$row["med_name"]."</option>";
                                        }
                                    }
                                }
                            ?>
                        </select>
                    <input type="submit" class="form-control my-2" value="Delete" name="delete">
                </form>
            </div>
        </div>
        <?php
            if(isset($_POST["delete"])){
                deletemed();
            }
            function deletemed(){
                global $conn;
                $med_name = $_POST["delval"];
                $sql = "DELETE FROM med_stock WHERE med_name='$med_name'";
                $conn->query($sql);
            }
        ?>
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>