<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Students</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
    /* Ensuring table takes full width and prevents compression */
    .table-responsive {
        overflow-x: auto;
    }

    .table td {
        font-size: smaller;
    }
</style>

<body>
    <?php
    require_once '../classes/account.class.php';
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';


    $accountObj = new Account();
    $bookObj = new Borrow();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $student_id = intval($_POST['student_id']);

        if ($bookObj->deleteStudent($student_id)) {
            echo "<script>alert('Student deleted successfully.'); window.location.href = 'manage-students.php';</script>";
        } else {
            echo "<script>alert('Failed to remove the student.'); window.location.href = 'manage-students.php';</script>";
        }
    }

    $students = $accountObj->getAllStudents();
    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <h1>Management</h1>
                <a href="add-student.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg" style="margin-right: 5px;"></i>Add Student</a>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student List</h5>
                    <!-- Table with responsive wrapper -->
                    <div class="table-responsive">
                        <table id="studentTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Learner Reference Number</th>
                                    <th>Student Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student) : ?>
                                    <tr>
                                        <td><?= $student['id']; ?></td>
                                        <td><?= $student['lrn']; ?></td>
                                        <td><?= $student['student_name']; ?></td>
                                        <td><?= $student['grade_lvl']; ?></td>
                                        <td><?= $student['section_name']; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-evenly">
                                                <a href="edit-student.php?id=<?= $student['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                <form method="POST" action="" onsubmit="return confirmDelete();">
                                                    <input type="hidden" name="student_id" value="<?= $student['id']; ?>">
                                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
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
            return confirm('Are you sure you want to remove this student?');
        }
    </script>
</body>

</html>