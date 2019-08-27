<?php
    $noNavBar = '';
    include "init.php";
    include $funct . "functions.php";
    session_start();
    if(isset($_SESSION['Username'])) {
        header( "Location:dashboard.php" );
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
//        $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
        $hashedPassword = sha1($password);
//        echo password_verify($password, $hashedPassword);
        // check if the user exist in database
        $stmt = $con->prepare("SELECT username, password, groupID FROM users WHERE username = ? AND password = ?;");
        $stmt->execute(array($username, $hashedPassword));
        $count = $stmt->rowCount();
        if($count) {
            $_SESSION['Username'] = $username;
            echo "<div class='alert-success text-center'></div>";
            outputMessage('success', "You've logged in! directing...");
            header( "refresh:3;url=dashboard.php" );
            exit();
        } else {
            outputMessage("error", "Your account doesn't exist in our Database");
        }
    }

?>
<form class="admin-cp-login" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <fieldset class="text-center">
        <legend>Administration Login</legend>
        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off"/>
        <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password"/>
        <input class="btn btn-block btn-primary" type="submit" value="Login"/>
    </fieldset>
</form>
<?php
    include $tpl . "footer.inc";
?>
