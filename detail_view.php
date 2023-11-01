<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT title, author, status, deadline, img, synopsis, year FROM books WHERE id = ?";
    $command = $connect->prepare($sql);

    $command->bind_param("i", $id);
    $command->execute();

    $command->bind_result($title, $author, $status, $deadline, $img, $synopsis, $year);
    $command->fetch();

    $statusTranslated = translateStatus($status);

} else {
    echo "Ühtegi raamatut pole valitud kuvamiseks.";
}

function translateStatus($status) {
    switch ($status) {
        case 'shelf':
            return 'Riiulis';
        case 'hall':
            return 'Saalis';
        case 'loaned':
            return 'Laenutatud';
        case 'storage':
            return 'Hoius';
        default:
            return 'Tundmatu';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Raamatu Detailvaade</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="modal-overlay" id="bookModal">
    <div class="modal-content">
        <div class="detailView">
            <h1 class="title"><?php echo htmlspecialchars($title); ?></h1>

            <img src="<?php echo htmlspecialchars($img); ?>" alt="Book Image" height="200">

            <p>Autor: <?php echo htmlspecialchars($author); ?></p>
            <p>Aasta: <?php echo htmlspecialchars($year); ?></p>
            <p>Staatus: <?php echo htmlspecialchars($statusTranslated)?></p>

            <?php
                if ($deadline !== null) {
                    echo "<p>Laenutuse tähtaeg: " . htmlspecialchars($deadline) . "</p>";
                }
            ?>
            <hr>

            <p>Sünopsis:</p>
            <p><?php echo htmlspecialchars($synopsis); ?></p>

            <button id="closePopup" class="button-green" onclick="closePopup();">Sulge aken</button>
        </div>
    </div>
</div>

<script>
    function closePopup() {
        window.close()
    }
</script>
