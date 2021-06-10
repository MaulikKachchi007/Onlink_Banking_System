<?php
session_start();
function ErrorMessage(){
    if (isset($_SESSION["error_message"]))
    {
        $output = "<div class=\"alert alert-danger alert-dismissible\">";
        $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
        $output .= htmlentities($_SESSION["error_message"]);
        $output .= "</div>";
        $_SESSION["error_message"] = null;
        return $output;
    }
}
function SuccessMessage()
{
    if (isset($_SESSION["success_message"]))
    {
        $output = "<div class=\"alert alert-success alert-dismissible\">";
        $output .= "<button type='button' class='close' data-dismiss=\"alert\">&times;</button>";
        $output .= htmlentities($_SESSION["success_message"]);
        $output .= "</div>";
        $_SESSION["success_message"] = null;
        return $output;
    }
}
?>