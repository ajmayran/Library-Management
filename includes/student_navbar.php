<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: index.php');
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="student_home.php">Library System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-3">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'my_dash.php' ? 'active' : ''; ?>" href="my_dash.php"><i class="fa-solid fa-book"></i> Dashboard</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'view-books.php' ? 'active' : ''; ?>" href="view-books.php"><i class="fas fa-list"></i> View Books</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'overdues.php' ? 'active' : ''; ?>" href="overdues.php"><i class="fas fa-coins"></i> Overdues</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./resources/img/ic_account_circle_48px-512.webp" alt="user-account" width="30" height="30" class="rounded-circle">
                        <span class="ms-2" style="font-size: small; font-weight:lighter"><?php echo $_SESSION['student_lname']; ?>, <?php echo $_SESSION['student_fname']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="user-settings.php"><i class="fas fa-cog" style="color: brown;"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="support.php"><i class="fas fa-question-circle" style="color: brown;"></i> Help</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="./logout.php"><i class="fas fa-sign-out-alt" style="color: brown;"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>