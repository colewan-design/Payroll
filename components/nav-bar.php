

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="employees.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Employees
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="employee_data.php" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Employee Data
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="project.php" class="nav-link">
            <i class="nav-icon fas fa-project-diagram"></i>
            <p>
              Project
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="position.php" class="nav-link">
            <i class="nav-icon fas fa-street-view"></i>
            <p>
              Positions
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="salary_matrix.php" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Salary Matrix
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="report.php" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Report
            </p>
          </a>
        </li>
         <li class="nav-item">
          <a href="employee_leave.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Leave
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calculator"></i>
            <p>
              Calculations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="incentives.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Allowance</p>
              </a>
            </li>
          <li class="nav-item">
            <a href="deductions.php" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p style="font-size: 15px;">Mandatory Deductions</p>
            </a>
          </li>
            <li class="nav-item">
              <a href="other_deductions.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Other Deductions</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>
              Payslip
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="payslips.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Payslip</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="payslip_data.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Record of Paylips</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="payroll-history.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>History of Payslips</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-secret"></i>
            <p>
              Admin Actions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="archive.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Archives</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="new_user.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="change_password.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Password</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="user_logs.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User Logs</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="employee-account.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Employee Accounts</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="news-manage.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage News</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="faq.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
    <script>
    // Get the URL of the current page
    var url = window.location.href;

    // Get all the links in the navbar
    var links = document.querySelectorAll('.nav-link');

    // Loop through the links and set the active class for the current page's link
    for(var i = 0; i < links.length; i++) {
        var link = links[i];
        var linkUrl = link.href;

        // Compare the link URL with the current page's URL
        if(url.indexOf(linkUrl) !== -1) {
            link.classList.add('active');
        }
    }
</script>