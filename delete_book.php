<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["deleteBook"])) {
    require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
    global $connect;
    $id = $_POST["id"];
    $deleteQuery = $connect->prepare("DELETE FROM books WHERE id = ?");
    $deleteQuery->bind_param("i", $id);
        if ($deleteQuery->execute()) {
            header("Location: index.php?page=admin");
        }
        else {
            echo "Error: ". $deleteQuery->error;
        }
    $deleteQuery->close();
    $connect->close();
}
?>