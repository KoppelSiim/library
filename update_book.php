<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
$allowedStatus = array("shelf","loaned","hall","storage");
$status = null;
// If back button is pressed
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["back"]) ) {
    header("Location:index.php?page=admin");
    exit; 
// If update button is pressed
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["updateBook"])) {
    // Check if required fields are set and not empty
    if(isset($_POST["title"], $_POST["author"], $_POST["year"], $_POST["book_id"]) &&
    !empty($_POST["title"]) && !empty($_POST["author"]) && !empty($_POST["year"]) && !empty($_POST["book_id"])
    ) {
        $bookId = $_POST["book_id"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        // Check if year falls into sensible range
        if($_POST["year"] >= 1000 && $_POST["year"] <= 2100 ) {
            $year = $_POST["year"];
        }
        else {
            echo "Ebasobiv aastavahemik";
            exit;
        }
        // Check if status has a valid value, assign null if not
        $status = (in_array($_POST["status"], $allowedStatus)) ? $_POST["status"] : null;
        // Assign value if set, assign null for empty string
        $image = isset($_POST["image"]) && $_POST["image"] !== "" ? $_POST["image"] : null;
        $synopsis = isset($_POST["synopsis"]) && $_POST["synopsis"] !== "" ? $_POST["synopsis"] : null;
        $updateBookQuery = "UPDATE books SET title=?, author=?, year=?, img=?, synopsis=?, status=? WHERE id=?";
        $sqlUpdateBook = $connect->prepare($updateBookQuery);
        $sqlUpdateBook->bind_param("ssisssi", $title, $author, $year, $image, $synopsis, $status, $bookId);
        if ($sqlUpdateBook->execute()) {
            header('Location: index.php?page=admin');
            exit;
        } else {
            echo "Error: " . $sqlUpdateBook->error;
        }
        
    }
    $sqlUpdateBook->close();
    $connect -> close();
}
?>