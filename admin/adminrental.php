<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="./img/librarylogo.jpg" rel="icon">
    <link rel="stylesheet" href="../Library/css/headerstyles.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        /* Styling for the search results */
        /* p.search {
            text-align: center;
            margin: 20px 0;
        } */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="userhome.php">Library System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'view-books.php' ? 'active' : ''; ?>" href="view-books.php"><i class="fas fa-list"></i> View Books</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'borrowed.php' ? 'active' : ''; ?>" href="borrowed.php"><i class="fas fa-book"></i> Borrowed Books</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'fines.php' ? 'active' : ''; ?>" href="fines.php"><i class="fas fa-coins"></i> Fines and Penalties</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./img/ic_account_circle_48px-512.webp" alt="user-account" width="30" height="30" class="rounded-circle">
                            <span class="ms-2">User</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="user-settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><a class="dropdown-item" href="support.php"><i class="fas fa-question-circle"></i> Help</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">        
        <?php
            require_once 'books-rental.class.php';
            require_once 'functions.php';

            $rentalObj = new Rental();

            $keyword = '';
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $keyword = clean_input($_POST['keyword']);
            }

            $array = $rentalObj->showAll($keyword);
        ?>

        <!-- <form action="" method="post">
            <label for="keyword">Search</label>
            <input type="text" name="keyword" id="keyword" value="<?= $keyword ?>">
            <input type="submit" value="Search" name="search" id="search">
        </form> -->

        <table id="booksTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No.</th> 
                        <th>Borrower Name</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (empty($array)) {
                    ?>
                        <tr>
                            <td colspan="8"><p class="text-center">No rental found.</p></td>
                        </tr>
                    <?php
                    } else {
                        foreach ($array as $arr) {
                            $status = $arr['status'];
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $arr['borrower_name'] ?></td>
                            <td><?= $arr['title'] ?></td>
                            <td><?= date('M-d-Y', strtotime($arr['borrow_date'])) ?></td>
                            <td><?= !empty($arr['return_date'])? date('M-d-Y', strtotime($arr['return_date'])):'' ?></td>
                            <td><?= $arr['remarks'] ?></td>
                            <td><?= $arr['status'] ?></td>
                            <td>
                                <?php if ($status == 'Borrowed') { ?>
                                    <a href="return-book.php?id=<?= $arr['rental_id'] ?>" class="btn btn-sm btn-primary">Return Book</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
</body>
</html>
