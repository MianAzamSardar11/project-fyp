<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header text-center">
            <h3 class="fw-bold"><span style="color:orange">Sociavo</span> Agency</h3>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a href="index.php" class="sidebar-link text-dark">
                        <i data-feather="home" width="20" class="text-orange"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">
                    <a href="services.php" class="sidebar-link text-dark">
                        <i data-feather="grid" width="20" class="text-orange"></i>
                        <span>Services</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'service-category.php') ? 'active' : ''; ?>">
                    <a href="service-category.php" class="sidebar-link text-dark">
                        <i data-feather="layers" width="20" class="text-orange"></i>
                        <span>Service Category</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'portfolio.php') ? 'active' : ''; ?>">
                    <a href="portfolio.php" class="sidebar-link text-dark">
                        <i data-feather="briefcase" width="20" class="text-orange"></i>
                        <span>Portfolio</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'team.php') ? 'active' : ''; ?>">
                    <a href="team.php" class="sidebar-link text-dark">
                        <i data-feather="users" width="20" class="text-orange"></i>
                        <span>Team</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'projects.php') ? 'active' : ''; ?>">
                    <a href="projects.php" class="sidebar-link text-dark">
                        <i data-feather="hard-drive" width="20" class="text-orange"></i>
                        <span>Projects</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'clients.php') ? 'active' : ''; ?>">
                    <a href="clients.php" class="sidebar-link text-dark">
                        <i data-feather="users" width="20" class="text-orange"></i>
                        <span>Clients</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'testimonials.php') ? 'active' : ''; ?>">
                    <a href="testimonials.php" class="sidebar-link">
                        <i data-feather="award" width="20" class="text-orange"></i>
                        <span>Testimonials</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'pricing.php') ? 'active' : ''; ?>">
                    <a href="pricing.php" class="sidebar-link text-dark">
                        <i data-feather="dollar-sign" width="20" class="text-orange"></i>
                        <span>Pricing</span>
                    </a>
                </li>


                <li class="sidebar-item <?php echo ($current_page == 'users-messages.php') ? 'active' : ''; ?>">
                    <a href="users-messages.php" class="sidebar-link">
                        <i data-feather="message-square" width="20" class="text-orange"></i>
                        <span>User Messages</span>
                    </a>
                </li>

                <li class="sidebar-item <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
                    <a href="admin.php" class="sidebar-link">
                        <i data-feather="users" width="20" class="text-orange"></i>
                        <span>Admin</span>
                    </a>
                </li>


                <li class="sidebar-item <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
                    <a href="settings.php" class="sidebar-link">
                        <i data-feather="settings" width="20" class="text-orange"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item has-sub <?php echo ($current_page == 'about.php' || $current_page == 'form-element-input-group.html' || $current_page == 'counter.php') ? 'active' : ''; ?>">
                    <a href="#" class="sidebar-link">
                        <i data-feather="settings" width="20"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="about.php">About</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="form-element-input-group.html">Logo & Name</a></li>
                        <li><a href="counter.php">Counter</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>