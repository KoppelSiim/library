<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT title, author, status, deadline FROM books WHERE id = ?";
    $command = $connect->prepare($sql);

    $command->bind_param("i", $id);
    $command->execute();

    $command->bind_result($title, $author, $status, $deadline);
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
    <!-- Add your CSS links or styles here -->
</head>
<body>

<h2>Detailvaade</h2>

<div class="modal-overlay" id="bookModal">
    <div class="modal-content">
        <div class="detailView">
            <h4><?php echo htmlspecialchars($title); ?></h4>
            <p>Autor: <?php echo htmlspecialchars($author); ?></p>
            <p>Staatus: <?php echo htmlspecialchars($statusTranslated)?></p>

            <?php
                if ($deadline !== null) {
                    echo "<p>Laenutuse tähtaeg: " . htmlspecialchars($deadline) . "</p>";
                }
            ?>

            <button id="closePopup" onclick="closePopup();">Sulge aken</button>
        </div>
    </div>
</div>

<script>
    function closePopup() {
        window.close()
    }
</script>
