<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manage Requests</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
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


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve'])) {
            $request_id = intval($_POST['request_id']);
            $success = $bookObj->approveRequest($request_id);

            if ($success) {
                echo "<script>alert('Request approved successfully!');</script>";
            } else {
                echo "<script>alert('Failed to approve the request.');</script>";
            }
        }

        if (isset($_POST['delete'])) {
            $request_id = intval($_POST['request_id']);
            $success = $bookObj->declineRequest($request_id);

            if ($success) {
                echo "<script>alert('Request declined successfully!');</script>";
            } else {
                echo "<script>alert('Failed to delete the request.');</script>";
            }
        }
    }
    $requests = $bookObj->ShowRequest();
    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../admin/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Requests</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Request</h5>
                    <!-- Table with responsive wrapper -->
                    <div class="table-responsive">
                        <table id="pendingTable" class="display table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Book Title</th>
                                    <th>Student Name</th>
                                    <th>Grade Level</th>
                                    <th>Section</th>
                                    <th>Date Requested</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $request) : ?>
                                    <tr>
                                        <td><?= $request['id']; ?></td>
                                        <td><?= $request['title']; ?></td>
                                        <td><?= $request['student_name']; ?></td>
                                        <td><?= $request['grade_lvl']; ?></td>
                                        <td><?= $request['section_name']; ?></td>
                                        <td><?= $request['date_requested']; ?></td>
                                        <td>
                                            <form method="POST" action="" style="display:inline;">
                                                <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                <button type="submit" name="approve" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this request?')">Approve</button>
                                            </form>
                                            <form method="POST" action="" style="display:inline;">
                                                <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to decline this request?')">Decline</button>
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
            $('#pendingTable').DataTable({
                ordering: false, // Disable ordering/sorting
                responsive: true // Enable responsiveness
            });
        });
    </script>
</body>

</html>