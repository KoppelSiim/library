<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["returnBook"])) {
    require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
    global $connect;
    $id = $_POST["bookId"];
    $sqlReturnBook = $connect->prepare("UPDATE books SET status = 'shelf', deadline = NULL WHERE id = ?");
    $sqlReturnBook->bind_param("i", $id);
        if ($sqlReturnBook->execute()) {
            header("Location: index.php?page=user");
        }
        else {
            echo "Error: ". $sqlReturnBook->error;
        }
    $sqlReturnBook->close();
    $connect->close();
}
?>