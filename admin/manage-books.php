<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Books</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
    /* Ensuring table takes full width and prevents compression */
    .table-responsive {
        overflow-x: auto;
    }

    .table th {
        white-space: nowrap;
        /* Ensures text stays on one line */
    }

    .table td {
        font-size: smaller;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';


    $bookObj = new Books();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $book_id = intval($_POST['book_id']);  // Use book_id, not student_id

        if ($bookObj->deleteBook($book_id)) {
            echo "<script>alert('Book deleted successfully.'); window.location.href = 'manage-books.php';</script>";
        } else {
            echo "<script>alert('Failed to delete the book.'); window.location.href = 'manage-books.php';</script>";
        }
    }

    $books = $bookObj->showAllBooks();
    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <div>
                <h1>Management</h1>
                </div>
                <div class="d-flex gap-2">
                <a href="add-book.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg" style="margin-right: 5px;"></i>Add Book</a>
                </div>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Books</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Book List</h5>
                    <!-- Table with responsive wrapper -->
                    <div class="table-responsive">
                        <table id="studentTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Authors</th>
                                    <th>Publisher</th>
                                    <th>Year</th>
                                    <th>Subject</th>
                                    <th>No. of Copies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $book) : ?>
                                    <tr>
                                        <td><?= $book['title']; ?></td>
                                        <td><?= $book['authors']; ?></td>
                                        <td><?= $book['publishers']; ?></td>
                                        <td><?= $book['year']; ?></td>
                                        <td><?= $book['subject_name']; ?></td>
                                        <td><?= $book['no_of_copies']; ?></td>
                                        <td>
                                            <form method="POST" action="" onsubmit="return confirmDelete();">
                                                <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <?php include_once './includes/admin_script.php';  ?>
    <script>
        $(document).ready(function() {
            // Initialize DataTables with responsive option and disable ordering
            $('#studentTable').DataTable({
                ordering: false, // Disable ordering/sorting
                responsive: true // Enable responsiveness
            });
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this book?');
        }
    </script>
</body>

</html>