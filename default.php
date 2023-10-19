<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
global $order;
$result = null;

// otsing
$baseSelect = "SELECT title, author FROM books ";
$formSubmitted = false;

if (isset($_POST["submitSearch"])) {

    $id_submit = $_POST["submitSearch"];
    $formSubmitted = true;

    $sql = $baseSelect;
    $conditions[] = array();
    $bindParams[] = array();

    if (!empty($_POST["title"])) {
        $titleFromForm = $_POST["title"];
        $conditions[] = "title = ?";
        $bindParams[] = $titleFromForm;
    }

    if (!empty($_POST["author"])) {
        $authorFromForm = $_POST["author"];
        $conditions[] = "author = ?";
        $bindParams[] = $authorFromForm;
    }

    if (!empty($_POST["status"])) {
        $statusFromForm = $_POST["status"];
        $conditions[] = 'status = "shelf" OR status = "hall"';
        $bindParams[] = $statusFromForm;
    }

    if(!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);

        $order = $connect->prepare($sql);

        //Bind params
        if ($order) {
            $types = str_repeat('s', count($bindParams));
            $order->bind_param($types, ...$bindParams);

            $order->execute();

            $result = $order->get_result();
        }
    }
}
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
        <label for="status">Kuva ainult saadaval raamatuid </label>
        <input type="checkbox" name="status" id="status">
        <input type="submit" value="available">
    </div> 

    <div class="form-group">
        <button type="submit" name="submitSearch">Otsi</button>
    </div>

</form>


<div class="searchResultForm">
   <?php 
    if ($formSubmitted && $result) {
        while ($row = $result->fetch_assoc()) { ?>
            <div>
                <form method="POST" action="">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 larger-text">
                                <?php echo htmlspecialchars($row['title']);?>
                                <?php echo htmlspecialchars($row['author']);?>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="toDetail" value="<?php echo $row['id'] ?>">Vaata</button>
                                <button type="submit" name="borrow" value="<?php echo $row['id'] ?>">Laenuta</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>
         <?php
        }
     } ?>
</div>


