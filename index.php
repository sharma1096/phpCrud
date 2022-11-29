<?php
// INSERT INTO `notesentry` (`S.NO.`, `Title`, `Description`, `TimeStamp`) VALUES (NULL, 'buy books', 'books are not available', current_timestamp());
$insert = false;
$update = false;
$delete = false;

// Connecting to the Database
$serverName = 'localhost';
$userName = 'root';
$password = '';
$dataBase = 'notes';

// ---> Creating a connection(B/W database(of server) and program)
$connection = mysqli_connect($serverName, $userName, $password, $dataBase);

// Check for the conection established success
if (!$connection) {
    die('Sorry we failed to connect:' . mysqli_connect_error());
}

// ----------------Inserting entries----------------------
// echo $_SERVER['REQUEST_METHOD']; // this is just for debugging
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        //update record
        $snoEdit = $_POST['snoEdit'];
        $editTitle = $_POST['editTitle'];
        $editTextArea = $_POST['editTextArea'];

        $sqlQuery = "UPDATE `notesentry` SET `Title` = '$editTitle', `Description` = '$editTextArea' WHERE `S.NO.` = '$snoEdit'";

        $result = mysqli_query($connection, $sqlQuery);

        if ($result) {
            $update = true;
        } else {
            echo '<br>The database was not created successfully because of the error --->' .
                mysqli_error($connection);
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['textArea'];

        $sqlQuery = "INSERT INTO `notesentry` (`Title`, `Description`) VALUES ('$title', '$description')";
        // sqlQuery to create table in database

        $result = mysqli_query($connection, $sqlQuery);

        //Check for the database creation success
        if ($result) {
            $insert = true;
        } else {
            echo '<br>The database was not created successfully because of the error --->' .
                mysqli_error($connection);
        }
    }
}

// ----------------Deleting entries----------------------
// echo $_SERVER['REQUEST_METHOD']; // this is just for debugging
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['delete'])) {
        //update record
        $serialNo = $_GET['delete'];

        $sqlQuery = "DELETE FROM `notesentry` WHERE `notesentry`.`S.NO.` = '$serialNo'";

        $result = mysqli_query($connection, $sqlQuery);

        if ($result) {
            $delete = true;
        } else {
            echo '<br>The database was not created successfully because of the error --->' .
                mysqli_error($connection);
        }
    }
}
?>
<!-- -------------------------------------------------------------  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <!-- below css and javaScript is for dataTable from jQuery table plugin -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <title>PhpCrud</title>
</head>

<body>
    <!-- ---------------------------Edit modal---------------------------- -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
        Launch demo modal
    </button> -->

    <!-- Edit modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/PHPtutorial/phpCrud/index.php" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="editTitle">Note Title</label>
                            <input type="text" class="form-control" id="editTitle" name="editTitle" />
                        </div>
                        <div class="form-group">
                            <label for="editTextArea">Note Description</label>
                            <textarea class="form-control" id="editTextArea" name="editTextArea" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update notes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- ------------------Navbar------------------ -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">iNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contect Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    Search
                </button>
            </form>
        </div>
    </nav>
    <!-- showing alert -->
    <?php if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your entry is successfully inserted.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    } ?>
    <?php if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your entry is updated successfully...
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } ?>
    <?php if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your entry is deleted successfully...
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    } ?>
    <!-- ------------------Adding notes------------------ -->
    <div class="container mt-3">
        <h2>Add a note</h2>
        <form action="/PHPtutorial/phpCrud/index.php" method="post">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" />
            </div>
            <div class="form-group">
                <label for="textArea">Note Description</label>
                <textarea class="form-control" id="textArea" name="textArea" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <!-- -------------------------------------------------------------------  -->
    <div class="container my-3">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.NO.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlQuery = 'SELECT * FROM `notesentry`';

                $result = mysqli_query($connection, $sqlQuery);

                //Check for the database creation success
                if ($result) {
                    //finding the number of record in the database
                    $numOfRec = mysqli_num_rows($result);

                    // Displaying the row returned by the sql query
                    if ($numOfRec != 0) {
                        $count = 1;
                        // We can fetch in a better way using the while loop
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <th scope='row'>" .
                                $count .
                                "</th>
                            <td>" .
                                $row['Title'] .
                                "</td>
                            <td>" .
                                $row['Description'] .
                                "</td>
                            <td><button class='edit btn btn-sm btn-primary' id=" .
                                $row['S.NO.'] .
                                ">Edit</button> <button class='delete btn btn-sm btn-primary' id=" .
                                $row['S.NO.'] .
                                ">Delete</button>
                            </tr>";
                            $count += 1;
                        }
                    }
                }
                ?>
            </tbody>

        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- below javaScript is for dataTable from jQuery table plugin -->
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    <script>
    /*-------------Script for edit button-------------*/
    EditBtn = document.getElementsByClassName("edit");
    Array.from(EditBtn).forEach((element) => {
        // console.log(element);
        element.addEventListener("click", (e) => {
            parentsOfe = e.target.parentNode.parentNode;
            // console.log(parentsOfe);
            title = parentsOfe.getElementsByTagName("td")[0].innerText;
            // console.log(title);
            description = parentsOfe.getElementsByTagName("td")[1].innerText;
            // console.log(description);


            editTitle.value = title;
            editTextArea.value = description;
            snoEdit.value = e.target.id;
            // console.log(e.target.id);

            $('#editModal').modal('toggle');
        })
    })
    /*-------------Script for delete button-------------*/
    deleteBtn = document.getElementsByClassName("delete");
    Array.from(deleteBtn).forEach((element) => {
        // console.log(element);
        element.addEventListener("click", (e) => {
            serialNo = e.target.id;
            // console.log(serialNo);

            if (confirm("Are you sure..You want to delete this notes!!")) {
                // console.log("Yes");
                window.location.href = `/PHPtutorial/phpCrud/index.php?delete=${serialNo}`;
            } else {
                console.log("No");
            }
        })
    })
    </script>
</body>

</html>