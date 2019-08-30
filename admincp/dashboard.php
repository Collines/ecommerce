<?php
ob_start();
$pageTitle = "Admin Dashboard"; //TODO: lang("ADMIN_DASHBOARD");
include "init.php";
session_start();
if(isset($_SESSION['Username'])) {
    addNavBar();
    // outputMessage('success', lang("ADMIN_WELCOME") . $_SESSION['Username']);
    $latestUsersCount = 5;
    $latestUsers = getLatest('username , userid','users','userid', 'DESC',$latestUsersCount);
    ?>
    <div class="container text-center dashboard-statistics">

        <h1 class="mt-4">Dashboard</h1>
        <div class="row mt-5">
            <a class="d-block col-md-3" href="members.php">
                <div class="stat total-members">
                    Total Members
                    <span><?php echo countItems('userID', 'users'); ?></span>
                </div>
            </a>
            <a class="col-md-3 d-block" href="members.php?pending">
                <div class="stat pending-members">
                    Pending Members
                    <span><?php echo countItems('groupid', 'users',true,"groupid = 0"); ?></span>
                </div>
            </a>
            <div class="col-md-3">
                <div class="stat total-items">
                    Total Items
                    <span>1834</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat total-categories">
                    Categories
                    <span>14</span>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card dashboard">
                    <h5 class="card-header"><i class="fas fa-users mr-2"></i> Latest <?php echo $latestUsersCount ?> Registered Users</h5>
                    <div class="card-body">
                        <?php
                                foreach ($latestUsers as $user) {
                                    echo "<p class='latest-user'><a href='members.php?do=edit&UserID=" . $user['userid'] . "'>" . $user['username'] . "</a></p>";
                                }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-tags mr-2"></i>Latest Items</h5>
                    <div class="card-body">
                        <h5 class="card-title">example tilte</h5>
                        <p class="card-text">normal texts... that's just the layout</p>
                        <a href="#" class="btn btn-primary">A button</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include $tpl . "footer.inc";
} else {
    redirectPage("You're not Autorized to enter this page!", 'error', "index.php", 2);
}
ob_end_flush();