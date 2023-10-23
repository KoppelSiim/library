<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
$sqlGetAllBooks = $connect->prepare("SELECT id, title, author, status, year, synopsis, img FROM books");
$sqlGetAllBooks->bind_result($id, $title, $author, $status, $year, $synopsis, $img);
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
            <input type="text" class="form-control" id="bookTitle" name="title" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookAuthor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="bookAuthor" name="author" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookYear" class="form-label">Aasta</label>
            <input type="number" class="form-control" id="bookYear" name="year" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookImgUrl" class="form-label">Pildilink</label>
            <input type="text" class="form-control" id="bookImgUrl" name="image">
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookSynopsis" class="form-label">Sünopsis</label>
            <textarea class="form-control" id="bookSynopsis" name="synopsis"></textarea>
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

    <!-- Kuva kõik raamatud, kustuta -->
    <!-- Todo col suurus responsive, gap vaiksemaks -->
    <h4 class="mb-3">Raamatud</h4>
    <div class="row mb-2">
        <div class="col-3 form-label" style="font-weight:bold">Pealkiri</div>
        <div class="col-3 form-label" style="font-weight:bold">Autor</div>
    </div>
    <?php
    while($sqlGetAllBooks->fetch()) {
    echo
    '<div class="row mb-2">
        <div class="col-3">' . htmlspecialchars($title) . '</div>
        <div class="col-3">' . htmlspecialchars($author). '</div>
    </div>';
    }
    ?>
 </div>