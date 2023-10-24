<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;
global $order;
$result = null;

// otsing
$baseSelect = "SELECT id, title, author FROM books ";
$formSubmitted = false;

// Check if the search button has been clicked
if (isset($_GET["submitSearch"])) {
    $formSubmitted = true;

    $sql = $baseSelect;
    $conditions = array();
    $bindParams = array(); // Define $bindParams as a flat array

    // Use $_GET to retrieve parameters from the URL
    if (!empty($_GET["id"])) {
        $idFromForm = $_GET["id"];
        $conditions[] = "id = ?";
        $bindParams[] = $idFromForm;
    }

    if (!empty($_GET["title"])) {
        $titleFromForm = $_GET["title"];
        $conditions[] = "title LIKE ?";
        $bindParams[] = '%' . $titleFromForm . '%';
    }
    
    if (!empty($_GET["author"])) {
        $authorFromForm = $_GET["author"];
        $conditions[] = "author LIKE ?";
        $bindParams[] = '%' . $authorFromForm . '%';
    }

    if (!empty($_GET["status"])) {
        if ($_GET["status"] === "hall_shelf") {
            $conditions[] = 'status IN (?, ?)';
            $bindParams[] = "hall";
            $bindParams[] = "shelf";
        }
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);

        $order = $connect->prepare($sql);

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
<div class="container">
    <h2>Raamatukogu</h2>
    <h4>Otsing</h4>

    <form class="searchForm" method="GET" action="">
        <!-- Modify input field names to match the parameters -->
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
            <input type="checkbox" name="status" value="hall_shelf" id="status">
        </div> 

        <div class="form-group">
            <button type="submit" class="btn btn-dark" value="search" name="submitSearch">Search</button>
        </div>
    </form>
</div>

<br>

<div class="searchResultForm container">
    <?php 
    if ($formSubmitted && $result) {
        while ($row = $result->fetch_assoc()) { ?>
            <div>
                <form method="GET" action="">
                    <div class="container">
                        <div class="row">

                            <div class="col-2 mb-2">
                                <b><?php echo htmlspecialchars($row['title']);?></b>
                            </div>

                            <div class="col-2 mb-2">
                                <?php echo htmlspecialchars($row['author']);?>
                            </div>

                            <div class="col-2 mb-2">
                                <button type="submit" class="btn btn-dark" name="toDetail" value="<?php echo $row['id']; ?>">Vaata</button>
                                <button type="submit" class="btn btn-dark" name="borrow" value="<?php echo $row['id']; ?>">Laenuta</button>
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