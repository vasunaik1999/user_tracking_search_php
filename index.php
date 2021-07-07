<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tracker</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            padding: 30px;
        }

        .card-background {
            background-color: #f6f6f6;
            border-radius: 30px;
        }

        .card {
            border-radius: 30px;
        }

        .btn {
            border-radius: 30px;
            padding: 7px 15px;
        }

        .form-control {
            border-radius: 30px;
        }

        .radius-circular {
            border-radius: 30px;
        }
    </style>
</head>

<body>

    <h1 class="mx-auto text-center">User Tracker</h1>
    <p class="mx-auto text-center">Track location of user</p>
    <div class="card mt-2">
        <div class="card-body card-background">
            <form action="" method="post">
                <div class="row mt-2">
                    <div class="col">
                        <h2>Search for user details</h2>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 mt-3 mt-md-0">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name...">
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date">
                    </div>
                    <div class="col-md-4 mt-4" style="margin: auto;">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search pr-2"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $server = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "user_details";

    //If your mysql is connect to port 3306 then ignore port
    $connection = mysqli_connect($server, $username, $password, $dbname, "3307");

    //Checking connection
    if (!$connection) {
        die("Connection to database failed due to " . mysqli_connect_error());
    }

    //If post request then it will execute search query
    if (isset($_POST['submit'])) {

        $search_name = $_POST['name'];
        $search_date = $_POST['date'];

        //Sql query
        $sql = "select * from user_details where name = '$search_name' and (`date_time` LIKE '%$search_date%')";
    ?>

        <div class="card mt-5">
            <div class="card-body card-background">
                <ul class="nav nav-tabs radius-circular" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="card-tab" style="border-radius:20px; border:1px;" data-bs-toggle="tab" data-bs-target="#displayCards" type="button" role="tab" aria-controls="Cards" aria-selected="true">Cards</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="table-tab" style="border-radius:20px; border:1px;" data-bs-toggle="tab" data-bs-target="#displayTable" type="button" role="tab" aria-controls="Table" aria-selected="false">Table</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Display Cards  -->
                    <div class="tab-pane fade show active" id="displayCards" role="tabpanel" aria-labelledby="card-tab">
                        <div class="row mt-3">

                            <!-- Get Result of the query -->
                            <?php if ($result = $connection->query($sql)) { ?>
                                <h3 class="mb-4">Result</h3>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <div class="col-md-3 mt-3 mt-md-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <span><i class="fas fa-user"></i></span>
                                                <?php echo $row['name'] . "<br><br>"; ?>
                                                <span class="my-3"><i class="fas fa-map-marker-alt"></i></span>
                                                <?php
                                                echo $row['latitude'] . " , ";
                                                echo $row['longitude'] . "<br><br>";
                                                ?>
                                                <span class="my-2"><i class="fas fa-clock"></i></span>
                                                <?php echo $row['date_time']; ?>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                        </div>
                    </div>
                    <!-- Display Table -->
                    <div class="tab-pane fade" id="displayTable" role="tabpanel" aria-labelledby="table-tab">
                        <h3 class="mb-4 mt-3">Result</h3>
                        <div class="row mt-3">
                            <div class=" col">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Time</th>
                                                    <th scope="col">Latitude</th>
                                                    <th scope="col">longitude</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                if ($result1 = $connection->query($sql)) {
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo ++$count ?></td>
                                                            <td><?php echo $row1['date_time'] ?></td>
                                                            <td><?php echo $row1['latitude'] ?></td>
                                                            <td><?php echo $row1['longitude'] ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $connection->close();
        ?>
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>