<!--Kasutaja vaade --->
<div class="container">
    <h1>Kasutaja vaade</h1>
    <h4>Laenatud raamatud</h4>
   
    <div class="row">
        <div class="col-2 mb-2">
            <label for="bookTitle" class="">Pealkiri</label>
        </div>
        <div class="col-2 mb-2">
            <label for="bookAuthor" class="">Autor</label>
        </div>
        <div class="col-2 mb-2">
            <label for="deadLine" class="">Tähtaeg</label>
        </div>
    </div>
    
     <!-- Siia tuleb hakata fetchima raamatuid -->
    <div class="row"> 
        <div class="col-2">
            <p id="bookTitle">Titleofbook</p>
        </div>
        <div class="col-2">
            <p id="bookAuthor">Authorofbook</p>
        </div>
        <div class="col-2">
            <p id="deadLine">Insert date here</p>
        </div>
        <div class="col-2">
            <form method="POST" action="">
                <!-- id tagastamiseks saadame hiljem siit -->
                <button type="submit" name="deleteBook" value = "$id" class="btn-sm btn-primary mb-4">Tagasta</button>
            </form>
        </div>  
    </div>

</div>