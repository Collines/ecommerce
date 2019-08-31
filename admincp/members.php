<?php
ob_start(); // to prevent header errors
$pageTitle = "Members"; //TODO: lang("ADMIN_DASHBOARD");
include "init.php";
session_start();
if(isset($_SESSION['Username'])) { // if user is logged in
    addNavBar();    // add navbar to the page
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    if ($do == "manage") {
            $query = "";
            if(isset($_GET['pending'])) {
                $query = "WHERE groupid = 0";
            }
        ?>
        <h2 class='text-center mt-5'>Manage Members</h2>
        <div class="container-fluid members-table text-center">
            <div class="table-responsive mt-5 mb-3">
                <table class="users-table table table-striped table-hover">
                    <tr>
                        <td>UserID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Registered Date</td>
                        <td>Rank</td>
                        <td>Controls</td>
                    </tr>
                    <?php
                    $stmt = $con->prepare("SELECT userid, username, email, firstname, lastname, regDate, groupid  FROM users $query");
                    $stmt->execute();
                    $output = $stmt->fetchAll(); //Fetch all rows
                    if( count($output) > 0) {
                        for($i=0; $i<$stmt->rowCount(); $i++) { // for grapping data and assign them to variables to be shown in the page
                            global $userID;
                            echo "<tr>";
                            for($x=0; $x<(count($output[$i])/2)+1; $x++) {
                                if ($x == (count($output[$i])/2)-1) {
                                    if($output[$i][$x] == 3) {
                                        echo "<td><span class='administrator-rank'>Administrator</span></td>";
                                    } else if ($output[$i][$x] == 2) {
                                        echo "<td><span class='moderator-rank'>Moderator</span></td>";
                                    } else if ($output[$i][$x] == 1) {
                                        echo "<td><span class='user-rank'>User</span></td>";
                                    } else if ($output[$i][$x] == 0) {
                                        echo "<td><span class='pending-rank'>Pending</span></td>";
                                    } else if ($output[$i][$x] == -1) {
                                        echo "<td><span class='banned-rank'>Banned</span></td>";
                                    }
                                }else if($x < (count($output[$i])/2)) {
                                    $data = $output[$i][$x];
                                    echo "<td>" . $data . "</td>";
                                } else {
                                    if($output[$i][(count($output[$i])/2)-1] == 0) {
                                        $str = "<a href='members.php?do=activate&UserID=" . $output[$i][0] . "'>
                                                <button class='btn btn-success mt-1 mb-1'><i class='fas fa-check mr-2'></i>Activate</button>
                                            </a>";
                                    } else {
                                        $str = " ";
                                    }
                                    echo "<td>
                                            <a href='members.php?do=edit&UserID=" . $output[$i][0] . "'>
                                                <button class='btn btn-primary mt-1 mb-1'><i class='far fa-edit mr-2'></i>Edit</button>
                                            </a>
                                            <a href='members.php?do=delete&UserID=" . $output[$i][0] . "'>
                                                <button class='btn btn-danger mt-1 mb-1'><i class='fas fa-minus-circle mr-2'></i>Delete</button>
                                            </a>
                                            $str
                                      </td>";
                                }
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No Pending Users</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <a class='d-block mb-5' href='?do=add'><button class="btn btn-success"><i class="fas fa-plus mr-2"></i>Add Member</button></a>
                </div>
            </div>
        </div>
    <?php }
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
                        <option value="0">Pending User</option>
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
        if($_SERVER['REQUEST_METHOD'] == 'POST') { // if request method is post it will add the member to database from the same page otherwise it will only show the add form
            $Username = $_POST['username'];
            $Email = $_POST['email'];
            $Firstname = $_POST['firstname'];
            $Lastname = $_POST['lastname'];
            $Password = sha1($_POST['password']);
            $formErrors = array();
            if(checkItem('username','users',$Username) > 0) {
                $formErrors[] = "This <strong>Username</strong> already exists";
            }
            if(checkItem('email','users',$Email) > 0) {
                $formErrors[] = "This <strong>Email</strong> already exists";
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
            if($_POST['accountRank'] = '') {
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
                $stmt = $con->prepare("INSERT INTO users (`username`, `password`, `email`, `firstName`, `lastName`, `groupID`, `regDate`) VALUES (?, ?, ?, ?, ?, ?, now());");
                $stmt->execute(array($Username, $Password, $Email, $Firstname, $Lastname, $accountRank));
                redirectPage("Account [" . $Username . "] added successfully!", 'success', 'members.php', 1);
            }
        }
     } else if ($do == "edit") { ?>
        <h2 class="text-center mt-5">Edit Member</h2>
        <?php
        if(isset($_GET['UserID']) && is_numeric($_GET['UserID'])) {
            $isExist = checkItem("userid",'users',$_GET['UserID']);
            if($isExist) {
                $stmt = $con->prepare("SELECT username, firstName, lastName, email, password FROM users WHERE userID = ?;");
                $stmt->execute(array($_GET['UserID']));
                if ($stmt->rowCount() > 0) { // to make sure we get a result from Database
                    $output = $stmt->fetch();
                    $userID = $_GET['UserID'];
                    $userName = $output[0];
                    $Email = $output[3];
                    $currentPassword = $output[4];
                    $firstName = $output[1] ? $output[1] : "First Name";
                    $lastName = $output[2] ? $output[2] : "Last Name";
                    ?>
                    <form class="container mt-5" action="?do=update" method="post">
                        <div class="form-group row">
                            <label for="username"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" value="<?php echo $userName ?>"
                                       autocomplete="off" disabled>
                            </div>
                        </div>
                        <input type="text" hidden value="<?php echo $userName ?>" name="username"/>
                        <input type="text" hidden value="<?php echo $userID ?>" name="userid"/>
                        <input type="hidden" value="<?php echo $currentPassword ?>" name="currentpassword"/>
                        <div class="form-group row">
                            <label for="inputEmail3"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control form-control-lg" id="inputEmail3"
                                       value="<?php echo $Email ?>" name="email" autocomplete="off"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputfirstname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">First
                                Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" id="inputfirstname"
                                       name="firstname" value="<?php echo $firstName ?>" autocomplete="off"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Last
                                Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" id="lastname" name="lastname"
                                       value="<?php echo $lastName ?>" autocomplete="off" required="required"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-lg" id="inputPassword3"
                                       name="password" placeholder="New Password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputconfirmpw" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Confirm
                                Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-lg" id="inputconfirmpw"
                                       name="inputconfirmpw" placeholder="Confirm Password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4 mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">Edit</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            } else {
                redirectPage("User Doesn't Exist", "error", 'members.php',1, false);
            }
        } else {
            header('location:members.php');
        }
    }
    else if ($do == "update") {
        if($_SERVER['REQUEST_METHOD'] == 'POST') { // to prevent user from accessing the page directly from link
            echo "<h2 class='text-center mt-5 mb-5'>Update Member</h2>";
            $id = $_POST['userid'];
            $Username = $_POST['username'];
            $newEmail = $_POST['email'];
            $newFirstname = $_POST['firstname'];
            $newLastname = $_POST['lastname'];
            $stmt2 = $con->prepare('SELECT userID FROM users WHERE email = ?');
            $stmt2->execute(array($newEmail));
            $formErrors = array();
            if($stmt2->rowCount()) {
                $output = $stmt2->fetch();
                if($output[0] != $id) {
                    $formErrors[] = "<strong>Email</strong> Already Exists";
                }
            }
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
                redirectPage("Updated Successfully, [" . $stmt->rowCount() . "] rows affected","success", "", 0.5, false);
            } else {
                header("refresh:1;url=" . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            outputMessage("error", "You can't browse this page directly.");
        }
    } else if ($do == 'delete') {
        if(isset($_GET['UserID']) && is_numeric($_GET['UserID'])) {
            if(isset($_POST['UserID'])) {
                $stmt = $con->prepare('DELETE FROM users WHERE userID = ?;');
                $stmt->execute(array($_POST['UserID']));
                redirectPage("User Deleted Successfully", "success", "members.php", 1);
            } else {
                $isExist = checkItem('userid', 'users', $_GET['UserID']);
                if($isExist) {
                    $stmt2 = $con->prepare('SELECT username, groupID FROM users WHERE userID = ?;');
                    $stmt2->execute(array($_GET['UserID']));
                    $output = $stmt2->fetch();
                    if($output[1] != 3) {
                        ?>
                        <div class="delete-confirmation modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Confirmation</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete [<?php echo $output[0]; ?>]? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="members.php">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </a>
                                        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                                            <input type="hidden" name="UserID" value="<?php echo $_GET['UserID'] ?>"/>
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        redirectPage("You Can't Delete Administrator, only can be done from Database", "error");
                    }
                } else {
                    redirectPage("User doesn't exist", "error", 'members.php');
                }
            }
        } else {
            redirectPage("You can't access this page directly", 'error', 'members.php');
        }
    } else if ($do == 'activate') {
        if(isset($_GET['UserID']) && is_numeric($_GET['UserID'])) {
            if(isset($_POST['UserID'])) {
                $stmt = $con->prepare('UPDATE users SET groupid = 1 WHERE userid = ?');
                $stmt->execute(array($_POST['UserID']));
                redirectPage("User has been activated", "success", "members.php");
            } else {
                $userExist = checkItem('userid', 'users', $_GET['UserID']);
                if($userExist) {
                    $stmt2 = $con->prepare('SELECT username FROM users WHERE userID = ?;');
                    $stmt2->execute(array($_GET['UserID']));
                    $output = $stmt2->fetch();
                    ?>
                    <div class="activate-confirmation modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Activate Confirmation</h5>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to Activate [<?php echo $output[0]; ?>]? </p>
                                </div>
                                <div class="modal-footer">
                                    <a href="members.php">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </a>
                                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                                        <input type="hidden" name="UserID" value="<?php echo $_GET['UserID'] ?>"/>
                                        <input type="submit" class="btn btn-success" value="Activate"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    redirectPage("User doesn't exist","error", 'members.php');
                }

            }
        } else {
            header("location:members.php");
        }
    }
} else {
    redirectPage("You're not Autorized to enter this page!","error", "index.php", 2.5);
}
include $tpl . "footer.inc";
ob_end_flush();