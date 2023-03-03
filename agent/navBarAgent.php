<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus'></i>
            <span class="logo_name">L'YDEC</span>
        </div>

        <ul class="nav-links">
            <li>
                <a href="clientDashboard.php" class="active">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../commun/index.php">
                    <i class='bx bx-box'></i>
                    <span class="links_name">Home</span>
                </a>
            </li>



            <li>
                <a href="File.php">
                    <i class='bx bx-book-alt'></i>
                    <span class="links_name">Saisir fichier annuelle</span>
                </a>
            </li>
            <li class="../commun/log_out">
                <a href="log_out.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard</span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class='bx bx-search'></i>
            </div>
            <div class="profile-details">
                <a href="profile.php"> <span class="admin_name">Mohamed Fatehi</span> </a>

            </div>
        </nav>



        <script>
            let sidebar = document.querySelector(".sidebar");
            let sidebarBtn = document.querySelector(".sidebarBtn");
            sidebarBtn.onclick = function() {
                sidebar.classList.toggle("active");
                if (sidebar.classList.contains("active")) {
                    sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
                } else
                    sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        </script>