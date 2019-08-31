<?php
    // Output Messages Handler
    function outputMessage($type, $message) {
        $output = array(
            "error" => "<div class='alert-danger text-center p-1'>$message</div>",
            "success" => "<div class='alert-success text-center p-1'>$message</div>",
            "warning" => "<div class='alert-warning text-center p-1'>$message</div>"
        );
        echo $output[$type];
    }

    // Get Page Title for Multilingual option
    function getPageTitle() {
        global $pageTitle;
        if(isset($pageTitle)) {
            echo $pageTitle;
        } else {
            echo "Dafault";
        }
    }

    // Page Redirect Handler
    function redirectPage($msg, $type, $page=NULL, $seconds=1.05, $showRedirectMsg = true) {
        if($page === NULL || $page == "") {
            $page = $_SERVER['HTTP_REFERER'];
        }
        outputMessage($type, $msg);
        if($showRedirectMsg){
            outputMessage($type, "You'll be redirected in $seconds Seconds...");
        }
        header("refresh:$seconds;url=$page",true,301);
        exit();
    }

    // Check Item from Database
    function checkItem($select, $from, $value) {
        global $con;
        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = '$value';");
        $statement->execute();
        return $statement->rowCount();
    }

    //Count Items Function
    function countItems($item, $table, $filter=false, $filterStr='') {
        global $con;
        if($filter) {
            $stmt = $con->prepare("SELECT $item FROM $table WHERE $filterStr");
            $stmt->execute();
            return $stmt->rowCount();
        } else {
            $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }

    function getLatest($fields,$table,$order, $orderType="DESC", $limit = 5) {
        global $con;
        $stmt = $con->prepare("SELECT $fields FROM $table ORDER BY $order $orderType LIMIT $limit");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

    function printActiveLink($route) {
        return strpos($_SERVER['REQUEST_URI'], $route) !== false ? 'active' : '';
    }