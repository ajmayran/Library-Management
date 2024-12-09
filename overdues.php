<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Books</title>
    <link rel="stylesheet" href="./css/headerstyles.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/table-style.css">
    <?php include_once './includes/header-link.php'; ?>
</head>

<body>
    <?php include_once './includes/student_navbar.php'; ?>
    <br>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-secondary">Overdues</h4>
        </div>
    </div>
    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';
    $bookObj = new Books();
    $array = $bookObj->fetchOverdues();
    ?>
    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Borrowed Date</th>
                    <th scope="col">Supposely Returned Date</th>
                    <th scope="col">Days Overdue</th>
                    <th scope="col">Fines</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="7">
                            <p class="text-center text-muted" style="padding: 10rem;">No Books found.</p>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($array as $arr) {
                    ?>
                        <tr>
                            <td><?= $arr['id'] ?></td>
                            <td><?= $arr['title'] ?></td>
                            <td><?= $arr['author'] ?></td>
                            <td><?= $arr['subject_name'] ?></td>
                            <td><?= $arr['borrow_date'] ?></td>
                            <td><?= $arr['return_date'] ?></td>
                            <td>
                                <a href="return-book.php?id=<?= $arr['id'] ?>" class="btn btn-primary">Return Book</a>
                            </td>

                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap and DataTables JS -->
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/bootstrap-datatables/datatables.js"></script>
    <script src="./assets/bootstrap-datatables/datatables.min.css"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                "pageLength": 20,
                "lengthMenu": [
                    [20, 40, 60, 80 - 1],
                    [20, 40, 60, 80, "All"]
                ],
                "searching": true,
                "ordering": true,
                "paging": true,
                "language": {
                    "emptyTable": "No data available in table",
                    "lengthMenu": "Show _MENU_ Books per page",
                    "search": "Search Books: ",
                    "paginate": {
                        "next": "🡆",
                        "previous": "🡄"
                    }
                }
            });
        });
    </script>
</body>
<?php include_once './includes/footer.php'; ?>

</html>