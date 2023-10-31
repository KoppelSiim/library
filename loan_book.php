<?php
    require($_SERVER["DOCUMENT_ROOT"] . "/../library_config.php");
    global $connect;

    $response = array();

    if (isset($_POST["bookId"])) {

        $bookId = $_POST["bookId"];

        $status = "loaned";
        $deadline = date('Y-m-d', strtotime("+14 days"));

        $sql = "UPDATE books SET status = ?, deadline = ? WHERE id = ?";
        $command = $connect->prepare($sql);
        $command->bind_param("ssi", $status, $deadline, $bookId);

        if ($command->execute()) {
            $response["success"] = true;
            $response["message"] = "Laenutasid raamatu! Oma laenutuste infot näed ribamenüüs 'Kasutaja' valiku alt.";
        } else {
            $response["success"] = false;
            $response["message"] = "Raamatu laenutamine ebaõnnestus!";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "Book ID not provided.";
    }

    header('Content-Type: application/json'); 
    echo json_encode($response); 
?>