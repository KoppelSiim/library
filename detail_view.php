<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT title, author, available, deadline FROM books WHERE id = ?";
    $command = $connect->prepare($sql);

    $command->bind_param("ssss", $title, $author, $year, $status, $deadline);
    $command->execute();

    $command->bind_result($title, $author, $year, $status, $deadline);

} else {
    echo "Ühtegi raamatut pole valitud kuvamiseks.";
}

//laenutuse nupp ka siia
//back/sulgemine tagasi otsingu lehele? 

?>

<h2>Detailvaade<h2>

<div class="detailView">

    <h4><?php echo htmlspecialchars($title); ?></h1>
    <p>Autor: <?php echo htmlspecialchars($author); ?></p>
    <p>Staatus: <?php echo htmlspecialchars($statusTranslated)?></p>

    <?php
        if ($deadline !== null) {
            echo "<p>Laenutuse tähtaeg: " . htmlspecialchars($deadline) . "</p>";
        }
    ?>
</div>