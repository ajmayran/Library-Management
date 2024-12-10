<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
            <h4 class="text-secondary">My Request Records</h4>
        </div>
    </div>
    <?php
    require_once './classes/book.class.php';
    require_once './includes/functions.php';
    $bookObj = new Books();

    if (isset($_GET['id'])) {
        $request_id = $_GET['id'];
        $bookObj = new Books();

        // Call the removeRequest function
        if ($bookObj->removeRequest($id, $student_id)) {
            // If the request is removed successfully, display a success message
            echo "<script>
                    alert('Book request has been removed successfully.');
                    window.location.href = 'borrow-book.php'; // Redirect to the request page after removal
                  </script>";
        } else {
            // If something goes wrong, display an error message
            echo "<script>
                    alert('Failed to remove the book request. Please try again.');
                  </script>";
        }
    }
    $array = $bookObj->showRequestRecord($student_id);
    ?>

    <div class="table-responsive">
        <table id="booksTable" class="table  table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Book Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Request Date</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($array)) {
                ?>
                    <tr>
                        <td colspan="6">
                            <p class="text-center text-muted" style="padding: 10rem;">No Books found.</p>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($array as $arr) {
                        $status = $arr['status'];
                    ?>
                        <tr>
                            <td><?= $arr['title'] ?></td>
                            <td>
                                <?php
                                // Check if authors are available and split if needed
                                if (isset($arr['authors']) && !empty($arr['authors'])):
                                    $authors = explode(', ', $arr['authors']);
                                    foreach ($authors as $author):
                                ?>
                                    <span><?= htmlspecialchars($author); ?></span>
                                    <?php endforeach;
                                else: ?>
                                    <span>No authors listed</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $arr['subject_name'] ?></td>    
                            <td><?= date('F j, Y', strtotime($arr['date_requested'])) ?></td>
                            <td><?= $arr['status'] ?></td>
                            <td>
                                <?php
                                if ($status != 'Approved' and $status != 'Denied') {
                                ?>
                                    <a href="?id=<?= $arr['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this request?');">Remove Request</a>
                                <?php
                                }
                                ?>
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
    <?php include_once './includes/table-script.php'; ?>
</body>
<?php include_once './includes/footer.php'; ?>

</html>