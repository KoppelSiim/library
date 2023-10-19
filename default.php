<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

// otsing
$baseSelect = "SELECT title, author FROM books ";

if (isset($_POST["submitSearch"])) {

    $id_submit = $_POST["submitSearch"];

    $sql = $baseSelect;
    $conditions = array();

    if (!empty($_POST["title"])) {
        $titleFromForm = $_POST["title"];
        $conditions[] = "title = ?";
    }

    if (!empty($_POST["author"])) {
        $titleFromForm = $_POST["title"];
        $conditions[] = "title = ?";
    }

    if (!empty($_POST["available"])) {
        $availableFromForm = $_POST["available"];
        $conditions[] = "available = ?";
    }

    if(!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }


}

//  sql käsu täitmine
//  andmete välja kuvamine vastavalt sql käsule
//  laenutamise php blokk
//  detailvaate redirection


?>

<h2>Raamatukogu<h2>
<h4>Otsing<h4>

<form class="searchForm" method="POST" action="">

    <div class="form-group">
        <label for="title" class="form-label">Pealkiri</label>
        <input type="text" class="form-control" id="title" name="title" style="max-width: 200px">
    </div>

    <div class="form-group">
        <label for="author" class="form-label">Autor</label>
        <input type="text" class="form-control" id="author" name="author" style="max-width: 200px">
    </div>
    
    <div class="form-group">
        <label for="available">Kuva ainult saadaval raamatuid </label>
        <input type="checkbox" name="available" id="available">
        <input type="submit" value="available">
    </div> 

    <div class="form-group">
        <button type="submit" name="submitSearch">Otsi</button>
    </div>

</form>


<div class="searchResultForm">

   <?php while ($command->fetch()) { ?>

    <div>
        <form method="POST" action="">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 larger-text">

                        <?php echo htmlspecialchars($title);?>
                        <?php echo htmlspecialchars($author);?>

                    </div>

                    <div class="col-md-2">

                        <button type="submit" name="toDetail" value="<?php echo $id; ?>">Vaata</button>
                        <button type="submit" name="borrow" value="<?php echo $id; ?>">Laenuta</button>

                    </div>
                </div>
            </div>

        </form>
        <br>
    </div>
    
    <?php } ?>

</div>


