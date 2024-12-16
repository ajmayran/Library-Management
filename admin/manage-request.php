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
    }

    .table td {
        font-size: smaller;
    }
</style>

<body>
    <?php
    require_once '../classes/book.borrowing.class.php';
    require_once __DIR__ . '/../includes/functions.php';

    $bookObj = new Borrow();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve_with_remarks'])) {
            $request_id = intval($_POST['request_id']);
            $remarks = $_POST['remarks'];

            $success = $bookObj->approveRequest($request_id, $remarks);

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
            <div class="d-flex justify-content-between">
                <h1>Management</h1>
                <a href="request-records.php" class="text-primary">Request Records</a>
            </div>
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
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal"
                                                onclick="setRequestId(<?= $request['id']; ?>)">
                                                Approve
                                            </button>
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

        <!-- Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="approveModalLabel">Approve Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Hidden Input for Request ID -->
                            <input type="hidden" name="request_id" id="modal_request_id">

                            <!-- Textarea for Remarks -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="approve_with_remarks" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

        function setRequestId(requestId) {
            document.getElementById('modal_request_id').value = requestId;
        }
    </script>
</body>

</html>