<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
// Otsime laenatud raamatud ainult
$sqlGetLoanedBooks = $connect->prepare("SELECT id, title, author, deadline FROM books WHERE status ='loaned'");
$sqlGetLoanedBooks->bind_result($id, $title, $author,$deadLine);
$sqlGetLoanedBooks->execute();
?>

<!--Kasutaja vaade --->
<div class="container">
    <h1>Kasutaja vaade</h1>
    <h4 style="margin-bottom:20px;">Laenatud raamatud</h4>
   
    <div class="row">
        <div class="col-3">
            <label class="mb-2" style="font-weight:bold;">Pealkiri</label>
        </div>
        <div class="col-2">
            <label class="mb-2" style="font-weight:bold;">Autor</label>
        </div>
        <div class="col-2">
            <label class="mb-2" style="font-weight:bold;">Tähtaeg</label>
        </div>
    </div>
    <hr>
    <!-- Kuvame laenutatud raamatud: pealkiri, autor, tahtaeg ja tagasta nupp -->
    <!-- Tagasta nupp muudab konkreetse raamatu staatuse: loaned->shelf  ja deadline-> NULL -->
    <?php
    while($sqlGetLoanedBooks ->fetch()) {
        echo '
        <div class="row"> 
            <div class="col-3">' . htmlspecialchars($title) . '</div>
            <div class="col-2">' . htmlspecialchars($author) . '</div>
            <div class="col-2">' . htmlspecialchars($deadLine) . '</div>
            <div class="col-2">
                <form method="POST" action="return_book.php">
                    <input type="hidden" name="bookId" value=' . htmlspecialchars($id) .'>
                    <button type="submit" name="returnBook" class="btn-sm btn-primary mb-4">Tagasta</button>
                </form>
            </div>
        </div>';  
    }
    $sqlGetLoanedBooks->close();
    $connect->close();
    ?>

</div>