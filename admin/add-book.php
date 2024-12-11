<?php
require_once __DIR__ . '/../includes/functions.php';
require_once  __DIR__ . '/../classes/book.class.php';

// Initialize variables to hold form input values and error messages.
$title = $year  = $isbn = $no_of_copies = $subject_id = "";
$titleErr = $yearErr = $isbnErr = $no_of_copiesErr = $subject_idErr = "";

$bookObj = new Books();
// Check if the form was submitted using the POST method.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = clean_input($_POST['title']);
    $year = clean_input($_POST['year']);
    $isbn = clean_input($_POST['isbn']);
    $no_of_copies = clean_input($_POST['no_of_copies']);
    $subject_id = clean_input($_POST['subject_id']);

    if (empty($title)) {
        $titleErr = 'Book Title is required';
    }
    if (empty($year)) {
        $yearErr = 'Year Published is required';
    } elseif ($year < 1900 || $year > 2023) {
        $yearErr = 'Year Published must be between 1900 and 2023';
    } elseif (!is_numeric($year)) {
        $yearErr = 'Year Published must be a numeric value';
    }

    if (empty($isbn)) {
        $isbnErr = 'International Standard Book Number is required';
    } elseif (!is_numeric($isbn)) {
        $isbnErr = 'International Standard Book Number must be a numeric value';
    }

    if (empty($no_of_copies)) {
        $no_of_copiesErr = 'Number of Copies is required';
    } elseif (!is_numeric($no_of_copies)) {
        $no_of_copiesErr = 'Number of Copies must be a numeric value';
    }

    if (empty($subject_id)) {
        $subject_idErr = 'Subject is required';
    }

    if (empty($titleErr) && empty($yearErr) && empty($isbnErr) && empty($no_of_copiesErr) && empty($subject_idErr)) {
        $bookObj->title = $title;
        $bookObj->year = $year;
        $bookObj->isbn = $isbn;
        $bookObj->no_of_copies = $no_of_copies;
        $bookObj->subject_id = $subject_id; {
            if ($bookObj->addBook()) {
                echo "<script>
                    alert('Book added successfully!');
                    window.location.href = 'add-book.php'; // Redirect to prevent form resubmission
                </script>";
            } else {
                echo "<script>
                    alert('Error adding book. Please try again.');
                </script>";
            }
        }
    }
}
$subjects = $bookObj->getSubjects();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once './includes/admin_link.php'; ?>
</head>
<style>
    .error {
        color: red;
    }
</style>

<body>
    <?php
    require_once '../classes/book.class.php';
    require_once __DIR__ . '/../includes/functions.php';

    ?>
    <!-- ======= Header ======= -->
    <?php include_once './includes/admin_header.php';  ?>
    <!-- ======= Sidebar ======= -->
    <?php include_once './includes/admin_sidebar.php';  ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="d-flex justify-content-between">
                <h1><i class="bi bi-book-half" style="margin-right: 10px"></i>Add Book</h1>
            </div>
        </div>
        <div class="bg-light p-5 rounded shadow">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="title" class="form-label">Book Title <span class="error">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" required>
                    <?php if (!empty($titleErr)): ?>
                        <div class="error"> <?= $titleErr ?> </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Year Published <span class="error">*</span></label>
                    <input type="number" class="form-control" id="year" name="year" required>
                    <?php if (!empty($yearErr)): ?>
                        <div class="error"> <?= $yearErr ?> </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">International Standard Book Number <span class="error">*</span></label>
                    <input type="number" class="form-control" id="isbn" name="isbn" required>
                    <?php if (!empty($isbnErr)): ?>
                        <div class="error"> <?= $isbnErr ?> </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="no_of_copies" class="form-label">Number of Copies <span class="error">*</span></label>
                    <input type="number" class="form-control" id="no_of_copies" name="no_of_copies" required>
                    <?php if (!empty($no_of_copiesErr)): ?>
                        <div class="error"> <?= $no_of_copiesErr ?> </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject <span class="error">*</span></label>
                    <select class="form-select" id="subject_id" name="subject_id" required>
                        <option value="">Select Subject</option>
                        <?php foreach ($subjects as $subject) : ?>
                            <option value="<?= $subject['id'] ?>"><?= $subject['subject_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($subject_idErr)): ?>
                        <div class="error"> <?= $subject_idErr ?> </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Book</button>
            </form>
        </div>

    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <?php include_once './includes/admin_script.php';  ?>
</body>

</html>