<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

// If the back button is pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['back']) ) {
    header("Location: index.php?page=admin");
    exit; 
// If instead of back button, the update button is pressed
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {
    // Check if required fields are set and not empty
    if (isset($_POST["title"], $_POST["author"], $_POST["year"]) &&
        !empty($_POST["title"]) && !empty($_POST["author"]) && !empty($_POST["year"])
        ) {
        // Requiered fields
        $title = $_POST["title"];
        $author = $_POST["author"];
        // Check if year falls into sensible range
        if($_POST["year"] >= 1000 && $_POST["year"] <= 2100 ) {
            $year = $_POST["year"];
        } else {
            echo "Ebasobiv aastavahemik";
            exit;
        }
        // Non-required fields, assign null if value is not set or is ""
        $image = isset($_POST["image"]) && $_POST["image"] !== "" ? $_POST["image"] : null;
        $synopsis = isset($_POST["synopsis"]) && $_POST["synopsis"] !== "" ? $_POST["synopsis"] : null;
        $status = isset($_POST["status"]) && $_POST["status"] !== "" ? $_POST["status"] : null;
        $sqlInsertBookQuery = "INSERT INTO books (title, author, year, img, synopsis, status) VALUES (?, ?, ?, ?, ?, ?)";
        $insertBook = $connect->prepare($sqlInsertBookQuery);
        $insertBook->bind_param("ssisss", $title, $author, $year, $image, $synopsis, $status);
        if($insertBook->execute()) {
            header('Location: index.php?page=admin');
            exit;
            }
            else {
                echo "Error: " . $insertBook->error;
            }
        }
    $insertBook->close();
    $connect->close();
    } 
?>