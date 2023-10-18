<!-- Haldus leht -->
<div class="container">
    <h1>Haldus</h1>
    <!--Raamatu lisamine form -->
    <h4>Lisa raamat</h4>
    <form method="POST" action="" class="mb-2">
        <div class="form-group row col-2 mb-3">
            <label for="bookTitle" class="form-label">Pealkiri</label>
            <input type="text" class="form-control" id="bookTitle" name="title">
        </div>
        <div class="form-group row col-2 mb-3">
            <label for="bookAuthor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="bookAuthor" name="author">
        </div>
        <div class="form-group row col-1 mb-3">
            <button type="submit" name="addBook" class="btn btn-primary">Salvesta</button>
        </div>
    </form>

    <!-- Kuva kõik raamatud, kustuta -->
    <!-- Todo col suurus responsive, gap vaiksemaks -->
    <h4>Raamatud</h4>
    
    <div class="row">
        <div class="col-2">
            <label for="bookTitle" class="">Pealkiri:</label>
        </div>
        <div class="col-2">
            <p id="bookTitle">titleofbook</p>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <label for="bookAuthor" class="">Autor:</label>
        </div>
        <div class="col-2">
            <p id="bookAuthor">authorofbook</p>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <form method="POST" action="">
                <!-- id kustutamiseks saadame hiljem siit -->
                <button type="submit" name="deleteBook" value = "$id" class="btn btn-danger mb-2">Kustuta</button>
            </form>
        </div>  
    </div>

</div>