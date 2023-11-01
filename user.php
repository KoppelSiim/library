<?php
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
// Otsime laenatud raamatud ainult
$sqlGetLoanedBooks = $connect->prepare("SELECT id, title, author, deadline FROM books WHERE status ='loaned'");
$sqlGetLoanedBooks->bind_result($id, $title, $author, $deadLine);
$sqlGetLoanedBooks->execute();
?>

<!--Kasutaja vaade --->
<div class="container">
    <h1>Kasutaja vaade</h1>
    <h4 style="margin-bottom:20px;">Laenatud raamatud</h4>
    <!--Lehe pais -->
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
<!-- Kuvame laenutatud raamatud: pealkiri, autor, tahtaeg ja tagasta nupu -->
<!-- Tagasta nupp muudab konkreetse raamatu staatuse: loaned->shelf  ja deadline-> NULL -->
<?php
// Hetke kuupaev stringina antud formaadis"
$currentDate = date("Y-m-d");
// Muudame DateTime objektiks
$currentDate = new DateTime($currentDate);
// Alustame valjastamist
while($sqlGetLoanedBooks ->fetch()) {
    // Ei ole null ega tyhi string
    if(!empty($deadLine)){
        $deadLineDate = new DateTime($deadLine);
    } else {
        // Tahtaeg puudub
        $bgCol = "gray";
    }
    //DateInterval objekt kahe kuupaeva vahega
    $interval = $currentDate->diff($deadLineDate);
    // Muudame taustavarvi vastavalt paevadele
    $intervalInDays = $interval->format('%a');
    // Echo the difference in days
    echo $intervalInDays;
    if ($interval->days >= 7) {
        $bgCol = "green";
    }
    else if ($interval->days < 7 && $interval->days > 2) {
        $bgCol = "yellow";
    }
    else if ($interval->days <= 2) {
        $bgCol = "red";
    }
    // Valjastame raamatud, kui tahtaeg on null siis valjastame tyhja stringi
    // <div class="col-2" style="background-color: ' .$bgCol . ';" >' . ($deadLine == null ? '' : htmlspecialchars($deadLine)) . '</div>
    echo '
    <div class="row"> 
        <div class="col-3">' . htmlspecialchars($title) . '</div>
        <div class="col-2">' . htmlspecialchars($author) . '</div>';
        echo '<div class="col-2">';
        echo '<p style="font-weight:bold; padding:8px; display: inline; background-color: ' . $bgCol . ';">' . ($deadLine == null ? '' : htmlspecialchars($deadLine)) . '</p>';
        echo '</div>';
        echo '<div class="col-2">
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

<!--Kasutaja vaade lopeb, containeri loputag --->
</div>