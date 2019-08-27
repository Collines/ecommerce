<?php
    function outputMessage($type, $message) {
        $output = array(
            "error" => "<div class='alert-danger text-center p-1'>$message</div>",
            "success" => "<div class='alert-success text-center p-1'>$message</div>",
            "warning" => "<div class='alert-warning text-center p-1'>$message</div>"
        );
        echo $output[$type];
    }