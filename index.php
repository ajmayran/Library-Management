<?php
require_once './includes/functions.php';
require_once './classes/account.class.php';

session_start();

$lrn = $username = $password = '';
$adminLoginErr = $studentLoginErr = '';

$accountObj = new Account();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Admin Login
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $username = clean_input($_POST['username']);
        $password = clean_input($_POST['password']);

        if (empty($username)) {
            $adminLoginErr = 'Username is required';
        } elseif (empty($password)) {
            $adminLoginErr = 'Password is required';
        } else {
            // Attempt to login admin
            if ($accountObj->loginAdmin($username, $password)) {
                $data = $accountObj->fetchUser($username);
                $_SESSION['user'] = $data;
                header('Location: admin/dashboard.php'); // Redirect to admin dashboard
                exit;
            } else {
                $adminLoginErr = 'Invalid Username or Password.';
            }
        }
    }
    // Student Login
    elseif (isset($_POST['lrn']) && !empty($_POST['lrn'])) {
        $lrn = clean_input($_POST['lrn']);
        $password = clean_input($_POST['password']);

        if (empty($lrn)) {
            $studentLoginErr = 'LRN is required';
        } elseif (empty($password)) {
            $_SESSION['user'] = $data;
            $studentLoginErr = 'Password is required';
        } else {
            // Attempt to login student
            if ($accountObj->loginStudent($lrn, $password)) {
                $data = $accountObj->fetch($lrn);
                header('Location: student_home.php'); // Redirect to student homepage
                exit;
            } else {
                $studentLoginErr = 'Invalid LRN or Password.';
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="./img/librarylogo.jpg" rel="icon">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>

</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="POST">
                <h1>LIBRARY SYSTEM</h1>
                <p>Admin</p>
                <input type="text" name="username" id="" placeholder="Username">
                <input type="password" name="password" id="" placeholder="Password">
                <?php if (!empty($adminLoginErr)) : ?>
                    <p style="color: red;"><?= $adminLoginErr ?></p>
                <?php endif; ?>
                <button style="width:100%;"  type="submit">Login</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="POST">
                <h1>LIBRARY SYSTEM</h1>
                <p>Student</p>
                <input type="text" name="lrn" id="" placeholder="Student LRN">
                <input type="password" name="password" id="" placeholder="Password">
                <?php if (!empty($studentLoginErr)) : ?>
                    <p style="color: red;"><?= $studentLoginErr ?></p>
                <?php endif; ?>
                <a href="">Forgot Your Password?</a>
                <button style="width:100%;" type="submit">Login</button>

            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <div class="toggle-background">
                        <div class="toggle-content">
                            <h3 class="admin">ADMIN LOGIN</h3>
                            <button class="hidden" id="login_stud">Student</button>
                            <p>Student login click the button</p>
                        </div>
                    </div>
                </div>
                <div class="toggle-panel toggle-right">
                    <div class="toggle-background">
                        <div class="toggle-content">
                            <h3 class="student">STUDENT LOGIN</h3>
                            <button class="hidden" id="login_adm">Admin</button>
                            <p>Admin login click the button</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/index.js"></script>
</body>
</html>