<?php


if(isset($_POST['buscar_send'])){
    $texto = $_POST['texto'];


?>

      <script>window.setTimeout(function() { window.location = 'http://iswug.net/webapps/LetsTeach/buscar.php?buscar=<?php echo $texto?>'}, 1);</script>

<?php } ?>



<div class="sticky-top">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand">
            <img src="imagenes/logo.jpeg" width="60" height="60" alt="">
        </a>
        <a class="navbar-brand" href="index.php">Let's Teach</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">                    
                </li>
            </ul>



            <form method='POST' class="form-inline">
                <input name="texto" class="form-control mr-sm-2" type="search" placeholder="¿Que buscas?"
                    aria-label="Search">
                    <button name="buscar_send" type="registrar" class="btn btn-secondary">Buscar</button>
            </form>






        </div>
    </nav>

</div>