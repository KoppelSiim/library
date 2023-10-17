<?php 
require($_SERVER["DOCUMENT_ROOT"]."/../library_config.php");
global $connect;

// otsing
$baseSelect = "SELECT * FROM books ";

//isSet otsingu submit
//  ifelse blokid tyhjade parameetrite kontrollimiseks
//  sql käsu täitmine
//  andmete välja kuvamine vastavalt sql käsule


?>

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
        <label for="subscribe">Kuva ainult saadaval raamatuid </label>
        <input type="checkbox" name="available" id="available">
        <input type="submit" value="available">
    </div> 

    <div class="form-group">
        <button type="submit" name="submitSearch">Otsi</button>
    </div>

</form>




<p>Pealeht</p>

Raamatute otsing

AJ TODO:
1.ehitan htmli yles
2.teen raamatute db
3.t2idan db raamatutega



