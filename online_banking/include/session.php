<?php
session_start();
function ErrorMessage(){
    if (isset($_SESSION["error_message"]))
    {
        $output = "<div class=\"alert alert-danger alert-dismissible\">";
        $output .= htmlentities($_SESSION["error_message"]);
        $output .= "<button type=\"button\" class=\"btn-close\" data-dismiss=\"alert\">&times;</button>";
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
        $output .= htmlentities($_SESSION["success_message"]);
        $output .= "<button type='button' class='btn-close' data-dismiss=\"alert\">&times;</button>";
        $output .= "</div>";
        $_SESSION["success_message"] = null;
        return $output;
    }
}
?>