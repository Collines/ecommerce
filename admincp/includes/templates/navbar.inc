<nav class="admin-navbar navbar navbar-expand-lg bg-dark navbar-dark">
    <a class="navbar-brand ml-lg-5" href="dashboard.php"><?php echo lang("ADMIN_LOGO")?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admincp-navbar" aria-controls="admincp-navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="admincp-navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo printActiveLink('categories.php') ?>" href="categories.php"><?php echo lang("ADMIN_CATEGORIES")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo printActiveLink('items.php') ?>" href="items.php"><?php echo lang("ADMIN_ITEMS")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo printActiveLink('members.php') ?>" href="members.php"><?php echo lang("ADMIN_MEMBERS")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo printActiveLink('') ?>" href="#"><?php echo lang("ADMIN_STATISTICS")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo printActiveLink() ?>" href="#"><?php echo lang("ADMIN_LOGS")?></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mr-lg-5">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['Username'] ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="members.php?do=edit&UserID=<?php echo $_SESSION['UserID'];?>">Edit Profile</a>
                    <a class="dropdown-item" href="#"><?php echo lang("SETTINGS")?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><?php echo lang("LOGOUT")?></a>
                </div>
            </li>
        </ul>
    </div>
</nav>