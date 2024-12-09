<?php

// session_start();

// if (isset($_SESSION['admin'])) {
// } else {
//     header('location: ../index.php ');
// }
require_once __DIR__ . '/../includes/functions.php';
require_once  __DIR__ . '/../classes/account.class.php';

// Initialize variables to hold form input values and error messages.
$last_name = $first_name  = $password = $lrn = $grade_lvl = $section = "";
$last_nameErr = $first_nameErr  = $passwordErr = $lrnErr = $grade_lvlErr = $sectionErr = "";

$AccountObj = new Account();
// Check if the form was submitted using the POST method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $username = clean_input($_POST['lrn']);
    $password = clean_input($_POST['password']);
    $grade_lvl = clean_input($_POST['grade_lvl']);
    $section_id = clean_input($_POST['section_id']);

    if (empty($first_name)) {
        $first_nameErr = 'First Name is required';
    }
    if (empty($last_name)) {
        $last_nameErr = 'Last Name is required';
    }

    if (empty($lrn)) {
        $lrnErr = 'LRN is required';
    }
    if (empty($grade_lvl)) {
        $grade_lvlErr = 'Year Level is required';
    }
    if (empty($section)) {
        $sectionErr = 'Section is required';
    }

    if (empty($password)) {
        $passwordErr = 'password is required';
    }

    if (empty($last_nameErr) && empty($first_nameErr) && empty($lrnErr) && empty($passwordErr) && empty($grade_lvlErr) && empty($section_idErr)) {
        $AccountObj->last_name = $last_name;
        $AccountObj->first_name = $first_name;
        $AccountObj->lrn = $lrn;
        $AccountObj->grade_lvl = $grade_lvl;
        $AccountObj->section_id = $section_id;
        $AccountObj->password = password_hash($password, PASSWORD_DEFAULT); 
        {
            if ($AccountObj->addStudent()) {
                echo '<div class="alert alert-success" role="alert">Account created successfully!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error creating account. Please try again.</div>';
            }
        }
    }
}
$sections = $AccountObj->getSections();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <style>
        .error {
            color: red;
        }

        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            height: auto;
            background: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #adb5bd;
        }

        .sidebar .nav-link.active {
            background: #495057;
            color: #fff;
        }

        .sidebar .nav-link:hover {
            background: #495057;
            color: #fff;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .col-md-6 {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Profile Dropdown -->
            <div class="dropdown ms-3">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-sm-inline">Admin</span>
                    <img src=".././resources/img/ic_account_circle_48px-512.webp" alt="Profile Picture" class="rounded-circle me-2" width="40" height="40">
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column">
            <div class="p-3">
                <h4 class="text-center">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Add Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h5 style="padding: 10px; font-weight: lighter; font-size:medium">This Section is for adding new enrolled students.</h5>
            <div class="container">
                <div class="col-md-6 bg-light p-5 rounded shadow">
                    <h3 class="mb-4 text-center">Add Student Account</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name <span class="error">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>" required autocomplete="off">
                            <?php if (!empty($first_nameErr)): ?>
                                <div class="error"> <?= $first_nameErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name <span class="error">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>" required autocomplete="off">
                            <?php if (!empty($last_nameErr)): ?>
                                <div class="error"> <?= $last_nameErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="lrn" class="form-label">Learner Reference Number <span class="error">*</span></label>
                            <input type="text" class="form-control" id="lrn" name="lrn" value="<?= $lrn ?>" required autocomplete="off">
                            <?php if (!empty($lrnErr)): ?>
                                <div class="error"> <?= $lrnErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="grade_lvl" class="form-label">Grade Level <span class="error">*</span></label>
                            <select class="form-select" id="grade_lvl" name="grade_lvl" required>
                                <option value="">Select Grade Level</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </select>
                            <?php if (!empty($grade_lvlErr)): ?>
                                <div class="error"> <?= $grade_lvlErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <div class="fixed-dropdown mb-3">
                            <label for="section_id" class="form-label">Section <span class="error">*</span></label>
                            <select class="form-select" id="section_id" name="section_id" required>
                                <option value="">Select Section</option>
                                <?php foreach ($sections as $section): ?>
                                    <option value="<?= $section['id'] ?>">
                                        <?= $section['section_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (!empty($sectionErr)): ?>
                            <div class="error"> <?= $sectionErr ?> </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="error">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" required autocomplete="off">
                            <?php if (!empty($passwordErr)): ?>
                                <div class="error"> <?= $passwordErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password <span class="error">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?= $confirm_password ?>" required autocomplete="off">
                            <?php if (!empty($confirm_passwordErr)): ?>
                                <div class="error"> <?= $confirm_passwordErr ?> </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>