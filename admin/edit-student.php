<?php
require_once __DIR__ . '/../includes/functions.php';
require_once  __DIR__ . '/../classes/account.class.php';

// Initialize variables
$first_name = $last_name = $lrn = $grade_lvl = $section_id = "";
$first_nameErr = $last_nameErr = $lrnErr = $grade_lvlErr = $section_idErr = "";

// Create an Account object
$AccountObj = new Account();

// Get the student ID from the URL
$student_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($student_id) {
    // Fetch the student data based on ID
    $student = $AccountObj->getStudentById($student_id);

    if ($student) {
        // Pre-populate the form fields with the student data
        $first_name = $student['first_name'];
        $last_name = $student['last_name'];
        $lrn = $student['LRN'];
        $grade_lvl = $student['grade_lvl'];
        $section_id = $student['section_id'];
    } else {
        echo "<script>alert('Student not found!');</script>";
        exit;
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and clean the form input
    $first_name = clean_input($_POST['first_name']);
    $last_name = clean_input($_POST['last_name']);
    $lrn = clean_input($_POST['lrn']);
    $grade_lvl = clean_input($_POST['grade_lvl']);
    $section_id = clean_input($_POST['section_id']);

    // Validation
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
        $grade_lvlErr = 'Grade Level is required';
    }
    if (empty($section_id)) {
        $section_idErr = 'Section is required';
    }

    if (empty($first_nameErr) && empty($last_nameErr) && empty($lrnErr) && empty($grade_lvlErr) && empty($section_idErr)) {
        // Update student data
        $AccountObj->first_name = $first_name;
        $AccountObj->last_name = $last_name;
        $AccountObj->lrn = $lrn;
        $AccountObj->grade_lvl = $grade_lvl;
        $AccountObj->section_id = $section_id;

        if ($AccountObj->updateStudent($student_id)) {
            echo "<script>
                    alert('Student information updated successfully!');
                    window.location.href = 'manage-students.php'; // Redirect to the student list page
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating student. Please try again.');
                  </script>";
        }
    }
}

// Fetch sections for the select dropdown
$sections = $AccountObj->getSections();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <?php include_once './includes/admin_link.php'; ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php'; ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php'; ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1><i class="bi bi-person-vcard-fill" style="margin-right: 10px;"></i>Update Student Information</h1>
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
                        <option value="Grade 7" <?= ($grade_lvl == 'Grade 7' ? 'selected' : '') ?>>Grade 7</option>
                        <option value="Grade 8" <?= ($grade_lvl == 'Grade 8' ? 'selected' : '') ?>>Grade 8</option>
                        <option value="Grade 9" <?= ($grade_lvl == 'Grade 9' ? 'selected' : '') ?>>Grade 9</option>
                        <option value="Grade 10" <?= ($grade_lvl == 'Grade 10' ? 'selected' : '') ?>>Grade 10</option>
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
                            <option value="<?= $section['id'] ?>" <?= ($section_id == $section['id'] ? 'selected' : '') ?>>
                                <?= $section['section_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if (!empty($section_idErr)): ?>
                    <div class="error"> <?= $section_idErr ?> </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary w-100">Update Account</button>
            </form>
        </div>
    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <?php include_once './includes/admin_script.php'; ?>
</body>

</html>
