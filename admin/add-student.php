<?php
require_once __DIR__ . '/../includes/functions.php';
require_once  __DIR__ . '/../classes/account.class.php';

// Initialize variables to hold form input values and error messages.
$last_name = $first_name  = $password = $lrn = $grade_lvl = $section_id = "";
$last_nameErr = $first_nameErr  = $passwordErr = $lrnErr = $grade_lvlErr = $section_idErr = "";

$AccountObj = new Account();
// Check if the form was submitted using the POST method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $lrn = clean_input($_POST['lrn']);
    $password = clean_input($_POST['password']);
    $grade_lvl = clean_input($_POST['grade_lvl']);
    $section_id = clean_input($_POST['section_id']);

    if (empty($first_name)) {
        $first_nameErr = 'First Name is required';
    }
    if (empty($last_name)) {
        $last_nameErr = 'Last Name is required';
    }

    $excludeID = '';

    if (empty($lrn)) {
        $lrnErr = 'LRN is required';
    } elseif ($AccountObj->lrnExist($lrn, $excludeID)) {
        $lrnErr = 'LRN already exists';
    } elseif (strlen($lrn) < 14 || strlen($lrn) > 15) {
        $lrnErr = 'LRN must be between 14 and 15 digits';
    }

    if (empty($grade_lvl)) {
        $grade_lvlErr = 'Year Level is required';
    }
    if (empty($section_id)) {
        $section_idErr = 'Section is required';
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
        $AccountObj->password = password_hash($password, PASSWORD_DEFAULT); {
            if ($AccountObj->addStudent()) {
                echo "<script>
                    alert('Account created successfully!');
                    window.location.href = 'add-student.php'; // Redirect to prevent form resubmission
                </script>";
            } else {
                echo "<script>
                    alert('Error creating account. Please try again.');
                </script>";
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
    <?php include_once './includes/admin_link.php'; ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <h1><i class="bi bi-person-fill-add" style="margin-right: 10px"></i>Add Student Account</h1>
            </div>
        </div><!-- End Page Title -->
        <div class="bg-light p-5 rounded shadow">
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
                    <input type="text" class="form-control" id="lrn" name="lrn" value="<?= $lrn ?>" required autocomplete="off" maxlength="15" minlength="14">
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
                <?php if (!empty($section_idErr)): ?>
                    <div class="error"> <?= $section_idErr ?> </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="error">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                    <?php if (!empty($passwordErr)): ?>
                        <div class="error"> <?= $passwordErr ?> </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Account</button>
            </form>
        </div>
        </div>
    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <?php include_once './includes/admin_script.php';  ?>
</body>

</html>