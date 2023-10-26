<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

//ViewDetalid pohjal raamatu andmed
if(isset($_POST["viewDetailsid"])){

    $bookId = $_POST["viewDetailsid"];
    $sql = "SELECT id, title, author, deadline, status, year, synopsis, img FROM books WHERE id = ?";
    $sqlGetBookDetails = $connect->prepare($sql);
    $sqlGetBookDetails->bind_param("i", $bookId);
    $sqlGetBookDetails->bind_result($did, $dtitle, $dauthor, $deadLine, $status, $year, $synopsis, $img);
    $sqlGetBookDetails->execute();
    $sqlGetBookDetails->fetch();
    //VÄGA OlULINE RIDA, muidu on out of sync error
    $sqlGetBookDetails->close();
}
// Admin vaates põhilise info kuvamiseks
$sqlGetAllBooks = $connect->prepare("SELECT id, title, author FROM books");
$sqlGetAllBooks->bind_result($id, $title, $author);
$sqlGetAllBooks->execute();
?>
<!-- Haldus leht -->
<div class="container">
    <h1>Haldus</h1>
    <!--Raamatu lisamine form -->

    <h4>Lisa raamat</h4>
    <form method="POST" action="add_book.php" class="mb-3" name="addBook">
        <div class="form-group row col-2 mb-2">
            <label for="bookTitle" class="form-label">Pealkiri</label>
            <input type="text" class="form-control" id="bookTitle" name="title" value="<?= $dtitle ?? "" ?>" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookAuthor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="bookAuthor" name="author" value="<?= $dauthor?? "" ?>" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookYear" class="form-label">Aasta</label>
            <input type="number" class="form-control" id="bookYear" name="year" value="<?= $year?? "" ?>"required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookImgUrl" class="form-label">Pildilink</label>
            <input type="text" class="form-control" id="bookImgUrl" name="image" value="<?= $img?? "" ?>">
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookSynopsis" class="form-label">Sünopsis</label>
            <textarea class="form-control" id="bookSynopsis" name="synopsis" value="<?= $synopsis?? "" ?>" ></textarea>
        </div>
        <div class="form-group row col-2 mb-2">
        <select class="form-control form-select" name="status">
            <option value="shelf">Riiul</option>
            <option value="hall">Saal</option>
            <option value="loaned">Laenutatud</option>
            <option value="storage">Ladu</option>
        </select>
        </div>
        <div class="form-group row col-1 mb-2">
            <button type="submit" name="addBook" class="btn btn-primary">Salvesta</button>
        </div>
    </form>
    <!-- Kuvan admin põhivaates hetkel ainult raamatu pealkirja ja autori -->
    <h4 class="mb-3">Raamatud</h4>
    <div class="row mb-2">
        <div class="col-3 form-label" style="font-weight:bold">Pealkiri</div>
        <div class="col-3 form-label" style="font-weight:bold">Autor</div>
    </div>
    <!-- Kuvan 2 formi ja nuppu, delete on lisatud, detailvaade hetkel veel mitte -->
    <?php
    while($sqlGetAllBooks->fetch()) 
    echo
    '<div class="row mb-2">
        <div class="col-3">' . htmlspecialchars($title) . '</div>
        <div class="col-3">' . htmlspecialchars($author). '</div>
        <div class="col-2">
            <form method="POST" action="'.$_SERVER["PHP_SELF"].'?page=admin&viewDetailsid=' . htmlspecialchars($id) . '">
                <input type="hidden" name="viewDetailsid" value="' . htmlspecialchars($id) . '">
                <button type="submit" name="" class="btn btn-info">Vaata</button>
            </form>
        </div>
        <div class= "col-1">
            <form method="POST" action="delete_book.php">
            <input type="hidden" name="id" value=' . htmlspecialchars($id) . '>
            <button type="submit" name="deleteBook" class="btn-danger">Kustuta</button>
            </form>
        </div>
    </div>';
    
    ?>
 </div>