<!-- Haldus leht -->
<div class="container">
    <h1>Haldus</h1>
    <!--Raamatu lisamine form -->
    <form method="POST" action="">
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
</div>