<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Publishers</title>
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
    .main-content {
        display: flex;
        gap: 20px;
    }

    .form-section {
        width: 25%;
    }

    .table-section {
        width: 75%;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once '../classes/book.class.php';
    require_once __DIR__ . '/../includes/functions.php';

    $bookObj = new Borrow();
    $booksObj = new Books();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_publisher'])) {
        $book_id = intval($_POST['book_id']);
        $publisher_id = intval($_POST['publisher_id']);
    
        // Add your logic to update the book with the publisher
        if ($bookObj->assignPublisherToBook($book_id, $publisher_id)) {
            echo "<script>alert('Publisher assigned successfully.'); window.location.href = 'manage-publishers.php';</script>";
        } else {
            echo "<script>alert('Failed to assign publisher. Please try again.');</script>";
        }
    }

    // Handle form submission for adding a new author
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_publisher'])) {
        $publisher_name = clean_input($_POST['publisher_name']);
        // If the email is empty, set it to an empty string
        $email = empty($_POST['email']) ? '' : clean_input($_POST['email']);

        if (!empty($publisher_name)) {
            if ($bookObj->addPublisher($publisher_name, $email)) {
                echo "<script>alert('Publisher added successfully.'); window.location.href = 'manage-publishers.php';</script>";
            } else {
                echo "<script>alert('Failed to add publisher. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Publisher name is required.');</script>";
        }
    }


    // Handle deletion of an author
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $publisher_id = intval($_POST['publisher_id']);

        if ($bookObj->deletePublisher($publisher_id)) {
            echo "<script>alert('Publisher deleted successfully.'); window.location.href = 'manage-publishers.php';</script>";
        } else {
            echo "<script>alert('Failed to delete the publisher. Please try again.');</script>";
        }
    }

    $publishers = $bookObj->getPublishers();
    ?>

    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php'; ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php'; ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <div>
                    <h1>Management</h1>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignPublisherModal">Assign Book Publisher</button>
                </div>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Publishers</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="main-content">
                <!-- Table Section -->
                <div class="table-section">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Publishers List</h5>
                            <div class="table-responsive">
                                <table id="publisherTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Publisher Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($publishers as $arr) : ?>
                                            <tr>
                                                <td><?= $arr['publisher_name']; ?></td>
                                                <td><?= $arr['email']; ?></td>
                                                <td>
                                                    <form method="POST" action="" onsubmit="return confirmDelete();">
                                                        <input type="hidden" name="publisher_id" value="<?= $arr['id']; ?>">
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
                </div>

                <!-- Form Section -->
                <div class="form-section">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Publisher</h5>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="publisher_name" class="form-label">Publisher Name</label>
                                    <input type="text" class="form-control" id="publisher_name" name="publisher_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email (Optional)</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <button type="submit" name="add_publisher" class="btn btn-primary w-100">Add Publisher</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <!-- Modal for Assigning Publisher -->
    <div class="modal fade" id="assignPublisherModal" tabindex="-1" aria-labelledby="assignPublisherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignPublisherModalLabel">Assign Publisher to Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to assign publisher to book -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="book_id" class="form-label">Select Book</label>
                            <select class="form-select" id="book_id" name="book_id" required>
                                <!-- Populate books dynamically from the database -->
                                <?php
                                // Fetch books from the database (make sure to modify with actual query to get books)
                                $books = $booksObj->showAllBooks(); // Assuming you have a method to get all books
                                foreach ($books as $book) {
                                    echo "<option value='{$book['id']}'>{$book['title']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="publisher_id" class="form-label">Select Publisher</label>
                            <select class="form-select" id="publisher_id" name="publisher_id" required>
                                <!-- Populate publishers dynamically from the database -->
                                <?php
                                $publishers = $bookObj->getPublishers(); // Fetch all publishers
                                foreach ($publishers as $publisher) {
                                    echo "<option value='{$publisher['id']}'>{$publisher['publisher_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="assign_publisher" class="btn btn-primary w-100">Assign Publisher</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include_once './includes/admin_script.php'; ?>
    <script>
        $(document).ready(function() {
            $('#publisherTable').DataTable({
                ordering: false,
                responsive: true
            });
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this publisher?');
        }
    </script>
</body>

</html>