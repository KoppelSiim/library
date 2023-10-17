<?php
require("header.php");
if(isset($_GET["page"])) {
    $openPage = $_GET["page"].".php";
    if (file_exists($openPage)) {
        require($openPage);
    } else {
        require("error404.php");
    }

} else {
    require("default.php");
}

require("footer.php");
?>