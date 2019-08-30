<?php
    ob_start();
    session_start();
    if(isset($_SESSION['Username'])) {
        header( "Location:dashboard.php" );
    }
    $pageTitle = "Admin Control Panel Login"; //lang("ADMIN_CP_LOGIN");
    include "init.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
//        $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
        $hashedPassword = sha1($password);
//        echo password_verify($password, $hashedPassword);
        // check if the user exist in database
        $stmt = $con->prepare("SELECT userID, username, password, groupID FROM users WHERE username = ? AND password = ?;");
        $stmt->execute(array($username, $hashedPassword));
        $output = $stmt->fetch();
        $userID = $output[0];
        $groupID = $output[3];
        $count = $stmt->rowCount();
        if($count) {
            if($groupID == 3 ) { // if user account is administrator
                $_SESSION['Username'] = $username;
                $_SESSION['UserID'] = $userID;
                redirectPage(lang('ADMIN_LOGIN_SUCCESS'),"success", "dashboard.php",1.5);
            } else {
                outputMessage('warning', lang('ADMIN_NOT_AUTH_LOGIN'));
            }
        }
        else {
            outputMessage("error", lang("ADMIN_USER_NOT_EXIST"));
        }
    }

?>
<form class="admin-cp-login" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <fieldset class="text-center">
        <legend><?php echo lang("ADMIN_LOGIN"); ?></legend>
        <input class="form-control" type="text" name="username" placeholder="<?php echo lang('USERNAME')?>" dir="auto" autocomplete="off"/>
        <input class="form-control" type="password" name="password" placeholder="<?php echo lang('PASSWORD')?>" dir="auto" autocomplete="new-password"/>
        <input class="btn btn-block btn-primary" type="submit" value="<?php echo lang('LOGIN')?>""/>
    </fieldset>
</form>
<?php
    include $tpl . "footer.inc";
    ob_end_flush();
?>
