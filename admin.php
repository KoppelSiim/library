<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
$bookId = null;
$status = null;
//Raamatu vaata ja uuenda vaade, laeme, kui vajutatakse vaata nupule
if(isset($_POST["viewDetailsid"])){
    $bookId = $_POST["viewDetailsid"];
    // Turvalisuse mõttes konverteerime täisarvuks
    $bookId = intval($bookId); 
    // On int ja positiivne, sobib
    if($bookId > 0) {
        $sql = "SELECT id, title, author, deadline, status, year, synopsis, img FROM books WHERE id = ?";
        $sqlGetBookDetails = $connect->prepare($sql);
        $sqlGetBookDetails->bind_param("i", $bookId);
        //Detailvaate jaoks on osad muutujanimed teised, et mitte minna konflikti - id, pealkiri ja autor
        $sqlGetBookDetails->bind_result($did, $dtitle, $dauthor, $deadLine, $status, $year, $synopsis, $img);
        $sqlGetBookDetails->execute();
        $sqlGetBookDetails->fetch();
        //VÄGA OlULINE RIDA, muidu on out of sync error
        $sqlGetBookDetails->close();
    } else {
        echo "Ebasobiv id";
        exit;
    }
}
// Admin vaates põhilise info kuvamiseks
$sqlGetAllBooks = $connect->prepare("SELECT id, title, author FROM books");
$sqlGetAllBooks->bind_result($id, $title, $author);
$sqlGetAllBooks->execute();
?>
<!-- Haldus leht -->
<div class="container">
    <h1>Haldus</h1>
    <!-- Kuvame formi pealkirja vastavalt lisamise või vaata/uuenda vaatele -->
    <h4><?= $bookId ? "Uuenda" : "Lisa raamat"?></h4>
    <!--Raamatu lisamise, vaatamise, uuendamise form -->
    <!--Kui kasutatakse detailvaadet valmistame ette uuendamise scripti, vastasel juhul raamatu lisamise scripti  -->
    <form method="POST" action=<?= $bookId ? "update_book.php" : "add_book.php" ?> class="mb-3">
    <!-- Saadame raamatu id uuendamiseks siit -->
    <input type="hidden" name="book_id" value="<?= $bookId ?>">
        <!--Eeltäidame vormi vaata/uuenda vaates, kui kasutaja vajutab vaata nupule -->
        <div class="form-group row col-2 mb-2">
            <label for="bookTitle" class="form-label">Pealkiri</label>
            <input type="text" class="form-control" id="bookTitle" name="title" value="<?= $dtitle ?? "" ?>" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookAuthor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="bookAuthor" name="author" value="<?= $dauthor ?? "" ?>" required>
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookYear" class="form-label">Aasta</label>
            <input type="number" class="form-control" id="bookYear" name="year" value="<?= $year?? "" ?>"required min="1000" max="2100">
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookImgUrl" class="form-label">Pildilink</label>
            <input type="text" class="form-control" id="bookImgUrl" name="image" value="<?= $img?? "" ?>">
        </div>
        <div class="form-group row col-2 mb-2">
            <label for="bookSynopsis" class="form-label">Sünopsis</label>
            <textarea class="form-control" id="bookSynopsis" name="synopsis"><?= $synopsis ?? "" ?></textarea>
        </div>
        <div class="form-group row col-2 mb-2">
        <select class="form-control form-select" name="status">
            <option value="">Staatus</option> 
            <option value="shelf" <?= $status === "shelf" ? "selected" : "" ?>>Riiul</option>
            <option value="hall" <?= $status === "hall" ? "selected" : "" ?>>Saal</option>
            <option value="loaned" <?= $status === "loaned" ? "selected" : "" ?>>Laenutatud</option>
            <option value="storage" <?= $status === "storage" ? "selected" : "" ?>>Ladu</option>
        </select>
        </div>
        <div class="form-group row mb-2">
        <!-- 2 nuppu, vastavalt sellele, kas on lisamise või vaata/uuenda vaade -->
        <?php
        $addState = '
        <div class="col-1">
            <button type="submit" name="addBook" class="btn btn-primary">Lisa</button>
        </div>
        <div class="col-1">
            <button type="submit" name="back" class="btn btn-danger">Tagasi</button>
        </div>
        ';
        $updateState = '
        <div class="col-1">
            <button type="submit" name="updateBook" class="btn btn-success">Uuenda</button>
        </div>
        <div class="col-1">
            <button type="submit" name="back" class="btn btn-danger">Tagasi</button>
        </div>
        ';
        $state = $bookId ? $updateState : $addState;
        echo $state;
        ?>
        </div>
    </form>

    <!-- Kuvan admin põhivaates ainult raamatu pealkirja ja autori -->
    <h4 class="mb-3">Raamatud</h4>
    <div class="row mb-2">
        <div class="col-3 form-label" style="font-weight:bold">Pealkiri</div>
        <div class="col-3 form-label" style="font-weight:bold">Autor</div>
    </div>
    <!-- Kuvan 2 formi ja nuppu, detailvaate ja kustutamise jaoks -->
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