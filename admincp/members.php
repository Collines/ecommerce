<?php
$pageTitle = "Members"; //lang("ADMIN_DASHBOARD");
include "init.php";
session_start();
if(isset($_SESSION['Username'])) {
    addNavBar();
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    include $tpl . "footer.inc";

    if ($do == "manage") {
        echo "<a class='ml-3 mt-4 d-block' href='?do=add'>Add New Member</a>";
    }
    else if ($do == "add") {
        ?>
        <h2 class='text-center mt-5'>Add Member</h2>
        <form class="container mt-5" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group row">
                <label for="username" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" autocomplete="off" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control form-control-lg" id="inputEmail3" placeholder="Email" name="email" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputfirstname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">First Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="inputfirstname" name="firstname" placeholder="First Name" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="lastname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Last Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="lastname" name="lastname" placeholder="Last Name" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control form-control-lg" id="inputPassword3" name="password" placeholder="New Password" autocomplete="new-password" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputconfirmpw" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Confirm Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control form-control-lg" id="inputconfirmpw" name="inputconfirmpw" placeholder="Confirm Password" autocomplete="new-password" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="accountrank" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Account Rank</label>
                <div class="col-sm-8" id="accountrank">
                    <select name="accountRank" class="custom-select custom-select-lg" required="required">
                        <option value="" selected>Open this select menu</option>
                        <option value="1">Normal User</option>
                        <option value="2">Moderator</option>
                        <option value="3">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Add</button>
                </div>
            </div>
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $Username = $_POST['username'];
            $Email = $_POST['email'];
            $Firstname = $_POST['firstname'];
            $Lastname = $_POST['lastname'];
            $Password = sha1($_POST['password']);
            $stmt = $con->prepare('SELECT username FROM users WHERE username = ?');
            $stmt->execute(array($Username));
            $alreadyFound = $stmt->rowCount();
            $formErrors = array();
            if($alreadyFound > 0) {
                $formErrors[] = "This <strong>Username</strong> already exists";
            }
            if(empty($Username)) {
                $formErrors[] = "<strong>Username</strong> field can't be empty";
            }
            if(empty($Email)) {
                $formErrors[] = "<strong>Email</strong> field can't be empty";
            }
            if(empty($Firstname) || empty($Lastname)) {
                $formErrors[] = "<strong>First Name</strong> & <strong>Last Name</strong> fields can't be empty";
            }
            if(empty($_POST['accountRank'])) {
                $formErrors[] = "You must set user account rank";
            }
            if($_POST['password'] != $_POST['inputconfirmpw']){
                $formErrors[] = "<strong>Passwords</strong> didn't match!";
            }
            foreach ($formErrors as $error) {
                outputMessage("error", $error);
            }
            if(empty($formErrors)) {
                $accountRank = $_POST['accountRank'];
                $stmt = $con->prepare("INSERT INTO users (`username`, `password`, `email`, `firstName`, `lastName`, `groupID`) VALUES (?, ?, ?, ?, ?, ?);");
                $stmt->execute(array($Username, $Password, $Email, $Firstname, $Lastname, $accountRank));
                outputMessage("success", "Account [" . $Username . "] added successfully!");
            }
        }
     } else if ($do == "edit") { ?>
        <h2 class="text-center mt-5">Edit Member</h2>
        <?php
        $stmt = $con->prepare("SELECT username, firstName, lastName, email, password FROM users WHERE userID = ?;");
        $stmt->execute(array($_SESSION['UserID']));
        $output = $stmt->fetch();
        $userID = $_SESSION['UserID'];
        $userName = $output[0];
        $Email = $output[3];
        $currentPassword = $output[4];
        $firstName = $output[1] ? $output[1] : "First Name";
        $lastName = $output[2] ? $output[2] : "Last Name";
        ?>
        <form class="container mt-5" action="?do=update" method="post">
            <div class="form-group row">
                <label for="username" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Username</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg"  value="<?php echo $userName?>" autocomplete="off" disabled>
                </div>
            </div>
            <input type="text" hidden value="<?php echo $userName?>" name="username"/>
            <input type="text" hidden value="<?php echo $userID?>" name="userid"/>
            <input type="hidden" value="<?php echo $currentPassword?>" name="currentpassword"/>
            <div class="form-group row">
                <label for="inputEmail3" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control form-control-lg" id="inputEmail3" value="<?php echo $Email ?>" name="email" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputfirstname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">First Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="inputfirstname" name="firstname" value="<?php echo $firstName?>" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="lastname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Last Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="lastname" name="lastname" value="<?php echo $lastName?>" autocomplete="off" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control form-control-lg" id="inputPassword3" name="password" placeholder="New Password" autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputconfirmpw" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Confirm Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control form-control-lg" id="inputconfirmpw" name="inputconfirmpw" placeholder="Confirm Password" autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Edit</button>
                </div>
            </div>
        </form>
    <?php }
    else if ($do == "update") {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h2 class='text-center mt-5 mb-5'>Update Member</h2>";
            $id = $_POST['userid'];
            $Username = $_POST['username'];
            $newEmail = $_POST['email'];
            $newFirstname = $_POST['firstname'];
            $newLastname = $_POST['lastname'];
            $formErrors = array();
            if(empty($newEmail)) {
                $formErrors[] = "<strong>Email</strong> field can't be empty";
            }
            if(empty($newFirstname) || empty($newLastname)) {
                $formErrors[] = "<strong>First Name</strong> & <strong>Last Name</strong> fields can't be empty";
            }
            if($_POST['password'] != $_POST['inputconfirmpw']){
                $formErrors[] = "<strong>Passwords</strong> didn't match!";
            }
            foreach ($formErrors as $error) {
                outputMessage("error", $error);
            }
            if(empty($formErrors)) {
                $newHashedPassword = empty($_POST['password']) ?  $_POST['currentpassword'] : sha1($_POST['password']);
                $stmt = $con->prepare("UPDATE users SET email = ? , firstName = ? , lastName = ? , password = ? WHERE userID = ?;");
                $stmt->execute(array($newEmail, $newFirstname, $newLastname, $newHashedPassword, $id));
                outputMessage("success", "Updated Successfully, [" . $stmt->rowCount() . "] rows affected");
                header("refresh:0.5;url=?do=edit&UserID=" . $_SESSION['UserID']);
            }
        } else {
            outputMessage("error", "You can't browse this page directly.");
        }
    }

} else {
    outputMessage('error', "You're not Autorized to enter this page! Redirecting..");
    header( "refresh:1;url=index.php" );
}