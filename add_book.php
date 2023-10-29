<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
// Check if required fields are set and not empty
if (isset($_POST["title"], $_POST["author"], $_POST["year"]) &&
    !empty($_POST["title"]) && !empty($_POST["author"]) && !empty($_POST["year"])
    ) {
    // Requiered fields
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];
    // Non-required fields, assign null if value is not set or is ""
    $image = isset($_POST["image"]) && $_POST["image"] !== "" ? $_POST["image"] : null;
    $synopsis = isset($_POST["synopsis"]) && $_POST["synopsis"] !== "" ? $_POST["synopsis"] : null;
    $status = isset($_POST["status"]) && $_POST["status"] !== "" ? $_POST["status"] : null;
    
    $sqlInsertBook = $connect->prepare("INSERT INTO books (title, author, year, img, synopsis, status) VALUES (?, ?, ?, ?, ?, ?)");
    $sqlInsertBook->bind_param("ssisss", $title, $author, $year, $image, $synopsis, $status);
    if($sqlInsertBook->execute()) {
        header('Location: index.php?page=admin');
        exit;
        }
        else {
            echo "Error: " . $sqlInsertBook->error;
        }
    }
    $sqlInsertBook->close();
    $connect->close();
?>