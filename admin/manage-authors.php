<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Authors</title>
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_author'])) {
        $book_id = intval($_POST['book_id_author']);
        $author_id = intval($_POST['author_id']);

        if (!empty($book_id) && !empty($author_id)) {
            if ($bookObj->assignAuthorToBook($book_id, $author_id)) {
                echo "<script>alert('Author assigned successfully.'); window.location.href = 'manage-publishers.php';</script>";
            } else {
                echo "<script>alert('Failed to assign author. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Both Book and Author must be selected.');</script>";
        }
    }


    // Handle form submission for adding a new author
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_author'])) {
        $first_name = clean_input($_POST['first_name']);
        $last_name = clean_input($_POST['last_name']);

        if (!empty($first_name) && !empty($last_name)) {
            if ($bookObj->addAuthor($first_name, $last_name)) {
                echo "<script>alert('Author added successfully.'); window.location.href = 'manage-authors.php';</script>";
            } else {
                echo "<script>alert('Failed to add author. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Both first name and last name are required.');</script>";
        }
    }

    // Handle deletion of an author
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $author_id = intval($_POST['author_id']);

        if ($bookObj->deleteAuthor($author_id)) {
            echo "<script>alert('Author deleted successfully.'); window.location.href = 'manage-authors.php';</script>";
        } else {
            echo "<script>alert('Failed to delete the author. Please try again.');</script>";
        }
    }

    $authors = $bookObj->getAuthors();
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
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignAuthorModal">Assign Book Authors</button>
                </div>
            </div>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Authors</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section">
                <div class="main-content">
                    <!-- Table Section -->
                    <div class="table-section">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Author List</h5>
                                <div class="table-responsive">
                                    <table id="authorTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($authors as $author) : ?>
                                                <tr>
                                                    <td><?= $author['first_name']; ?></td>
                                                    <td><?= $author['last_name']; ?></td>
                                                    <td>
                                                        <form method="POST" action="" onsubmit="return confirmDelete();">
                                                            <input type="hidden" name="author_id" value="<?= $author['id']; ?>">
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
                                <h5 class="card-title">Add Author</h5>
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <button type="submit" name="add_author" class="btn btn-primary w-100">Add Author</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div class="modal fade" id="assignAuthorModal" tabindex="-1" aria-labelledby="assignAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignAuthorModalLabel">Assign Author to Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="book_id_author" class="form-label">Select Book</label>
                            <select class="form-select" id="book_id_author" name="book_id_author" required>
                                <option value="">Choose a book</option>
                                <?php
                                // Fetch and display books
                                $books = $booksObj->showAllBooks(); // You should have a function to get all books
                                foreach ($books as $book) {
                                    echo "<option value='{$book['id']}'>{$book['title']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="author_id" class="form-label">Select Author</label>
                            <select class="form-select" id="author_id" name="author_id" required>
                                <option value="">Choose an author</option>
                                <?php
                                // Fetch and display authors
                                $authors = $bookObj->getAuthors(); // You should have a function to get all authors
                                foreach ($authors as $author) {
                                    echo "<option value='{$author['id']}'>{$author['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="assign_author" class="btn btn-primary">Assign Author</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include_once './includes/admin_script.php'; ?>
    <script>
        $(document).ready(function() {
            $('#authorTable').DataTable({
                ordering: false,
                responsive: true
            });
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this author?');
        }
    </script>
</body>

</html>