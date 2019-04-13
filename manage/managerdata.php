<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Manager's Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
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
                                <a class="nav-link" href="../index.php">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </navbar>
    </div>

    <?php
        include "../connect.php";
    ?>

    <div class="container text-center my-4 col-lg-7 col-xl-7">
        <h1 class="display-4">View Manager's Info</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <?php
                showmanager();
                function showmanager(){
                    global $conn;
                    $sql = "SELECT * FROM manager";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        show($result);
                    }else{
                        echo "<p class='lead'>There are no doctor's</p>";
                    }
                }
                function show($result){
                    echo '<table class="table table-bordered table-striped table-hover">
                    <thead class="thead-primary">
                    <tr>
                    <th>Manager name</th>
                    <th>Phone number</th>
                    <th>Address</th>
                    <th>Salary</th>
                    </tr>
                    </thead>';
                    while($row = $result->fetch_assoc()){
                        
                        echo "<tr><td>".$row['name']."</td><td>".$row['phone']."</td><td>".$row['address']."</td><td>".$row["salary"]."</td></tr>";
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Add Manager's Information</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <form method="POST" action="managerdata.php">
                <div class="form-group">
                    <input type="text" class="form-control my-2" name="name" placeholder="Manager's name">
                    <input type="number" class="form-control my-2" name="phone" placeholder="Phone number">
                    <input type="text" class="form-control my-2" name="address" placeholder="Address">
                    <input type="number" class="form-control my-2" name="salary" placeholder="Salary">
                    <input type="submit" class="form-control my-2 btn btn-outline-primary" value="Add Manager" name="add">
                </div>
            </form>
        </div>
        <?php
            if(isset($_POST["add"])){
                add_manager();
            }
            function add_manager(){
                global $conn;
                $name = $_POST["name"];
                $phone = $_POST["phone"];
                $address = $_POST["address"];
                $salary= $_POST["salary"];
                if(($name and $phone and $address and $salary) != NULL){
                    $sql = "INSERT INTO pharmacy_login VALUES('$name','$name','manager')";
                    $conn->query($sql);
                    $sql = "INSERT INTO manager VALUES ('$name',$phone,'$address',$salary)";
                    $conn->query($sql);
                    header("Location: managerdata.php");
                }
            }
        ?>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Update Manager's Information</h1>
        <p class="text-justify lead">Please select the information that you want to update with the information that you want it to change it to.</p>
        <div class="container text-center col-lg-7 col-xl-7">
            <form method="POST" action="managerdata.php">
                <div class="form-group">
                    <input type="text" class="form-control my-2" name="oldval" placeholder="Enter old value">
                    <label for="column">Select Information to change</label>
                    <select class="form-control my-2" name="column" id="column">
                        <option value="phone">Phone number</option>
                        <option value="address">Address</option>
                        <option value="salary">Salary</option>
                    </select>
                    <input type="text" class="form-control my-2" name="newval" placeholder="Enter new value">
                    <input type="submit" class="form-control my-2" value="Update" name="update">
                </div>
            </form>
        </div>
        <?php
            if(isset($_POST["update"])){
                update_manager();
            }
            function update_manager(){
                global $conn;
                $oldval = $_POST["oldval"];
                $column = $_POST["column"];
                $newval = $_POST["newval"];
                $sql = "UPDATE manager SET $column='$newval' WHERE $column='$oldval'";
                $conn->query($sql);
                header("Location: managerdata.php");
            }
        ?>
    </div>

    <div class="container text-center my-4 col-lg-6 col-xl-6">
        <h1 class="display-4">Delete Manager's Information</h1>
        <div class="container text-center col-lg-7 col-xl-7">
            <div class="form-group">
                <form method="POST" action="managerdata.php">
                    <label for="del_val">Select manager's name to delete</label>
                        <select class="form-control my-2" name="delval" id="del_val">
                            <?php
                                dispoption();
                                function dispoption(){
                                    global $conn;
                                    $sql = "SELECT name FROM manager";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0){
                                        while($row = $result->fetch_assoc()){
                                            echo $row["name"];
                                            echo "<option value='".$row["name"]."'>".$row["name"]."</option>";
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
                deletelogin();
            }
            function deletelogin(){
                global $conn;
                $val = $_POST["delval"];
                $sql = "DELETE FROM manager WHERE name='$val'";
                $conn->query($sql);
                $sql = "DELETE FROM pharmacy_login WHERE user_id='$val'";
                $conn->query($sql);
            }
        ?>
    </div>
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>