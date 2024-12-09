<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard Item -->
    <li class="nav-item">
      <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <!-- Management Section -->
    <li class="nav-item">
      <a class="nav-link collapsed <?php echo ($current_page == 'manage-books.php' || $current_page == 'manage-request.php' || $current_page == 'manage-borrowing.php' || $current_page == 'manage-students.php') ? 'active' : ''; ?>"
        data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
          <a href="manage-books.php" class="<?php echo ($current_page == 'manage-books.php') ? 'active' : ''; ?>">
            <i class="bi bi-circle"></i><span>Books</span>
          </a>
        </li>
        <li>
          <a href="manage-request.php" class="<?php echo ($current_page == 'manage-request.php') ? 'active' : ''; ?>">
            <i class="bi bi-circle"></i><span>Pending Request</span>
          </a>
        </li>
        <li>
          <a href="manage-borrowing.php" class="<?php echo ($current_page == 'manage-borrowing.php') ? 'active' : ''; ?>">
            <i class="bi bi-circle"></i><span>Issued Books</span>
          </a>
        </li>
        <li>
          <a href="manage-students.php" class="<?php echo ($current_page == 'manage-students.php') ? 'active' : ''; ?>">
            <i class="bi bi-circle"></i><span>Students</span>
          </a>
        </li>
      </ul>
    </li><!-- End Management Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-envelope"></i>
        <span>Contact</span>
      </a>
    </li><!-- End Contact Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-dash-circle"></i>
        <span>Error 404</span>
      </a>
    </li><!-- End Error 404 Page Nav -->

  </ul>

</aside><!-- End Sidebar-->