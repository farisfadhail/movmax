<div class="navbar">
    <div class="navbar-container">
        <div class="logo-container">
            <a href="index.php" style="text-decoration: none;">
                <h1 class="logo">MovMax</h1>
            </a>
        </div>
        <div class="menu-container">
            <ul class="menu-list">
                <li class="menu-list-item"><a href="index.php">Home</a></li>
                <li class="menu-list-item"><a href="movies.php">Movies</a></li>
                <li class="menu-list-item"><a href="search.php">Search</a></li>
            </ul>
        </div>
        <div class="profile-container">
            <?php if ($_SESSION["user"]["is_admin"] != '0') { ?>
                <a href="dashboard/index.php" style="text-decoration: none; color: white;">Dashboard</a>
            <?php } ?>
            <div class="profile-text-container">
                <div class="dropdown">
                    <a style="text-decoration: none; color: white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="profile-text">Hi, <?php echo $_SESSION["user"]["username"] ?></span>
                        <div class="dropdown fas fa-caret-down"></div>
                    </a> 
                    <div class="dropdown-content">
                        <a href="profile.php" class="dropdown-item">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>