<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>View order</title>
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
        <h1 class="display-4">View Prescription Bills</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <?php
                showbills();
                function showbills(){
                    global $conn;
                    $sql = "SELECT * FROM order_med";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        show($result);
                    }else{
                        echo "<p class='lead'>There are no prescription bills</p>";
                    }
                }
                function show($result){
                    $total = 0;
                    echo '<table class="table table-bordered table-striped table-hover">
                    <thead class="thead-primary">
                    <tr>
                    <th>Medicine name</th>
                    <th>Medicine Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    </tr>
                    </thead>';
                    while($row = $result->fetch_assoc()){
                        echo "<tr><td>".$row['med_name']."</td><td>".$row['med_description']."</td><td>".$row['med_price']."</td><td>".$row["quantity"]."</td></tr>";
                        $total = $total + $row["med_price"] * $row["quantity"];
                    }
                    echo "<tr><td></td><td></td><td>Total</td><td>".$total."</td></tr></table>";
                }
            ?>
        </div>
    </div>

    <div class="container text-center my-4 col-lg-7 col-xl-7">
        <h1 class="display-4">Clear prescription order's</h1>
        <div class="form-group">
            <form action="vieworder.php" method="POST">
                <input type="submit" value="Clear" name="clear" class="btn btn-outline-primary">
            </form>
        </div>
        <?php
            if(isset($_POST["clear"])){
                clear();
            }
            function clear(){
                global $conn;
                $sql = "TRUNCATE TABLE order_med";
                $conn->query($sql);
                header("Location: vieworder.php");
            }
        ?>
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>