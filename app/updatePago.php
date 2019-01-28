<?php
include '../library/configServer.php';
include '../library/consulSQL.php';


sleep(5);

$numPediUp=$_POST['num-pedido'];
if(!$_FILES['img']['name']=="" && !$numPediUp==""){

    $imagenUp="../assets/img-pagos/".$_FILES['img']['name'];
    if(move_uploaded_file($_FILES['img']['tmp_name'],$imagenUp)){
        if(consultasSQL::UpdateSQL("venta", "pago='$imagenUp'", "NumPedido='$numPediUp'")){
            echo '
            <br>
            <script src="../js/jquery.min.js"></script>
            <img class="center-all-contens" src="../assets/img/Check.png">
            <p><strong>Hecho</strong></p>
            <p class="text-center">
                Recargando<br>
                en 7 segundos
            </p>
            <script>
                setTimeout(function(){
                url ="../pedido.php";
                $(location).attr("href",url);
                },1000);
            </script>
         ';
        }else{
            echo '
            <br>
            <script src="../js/jquery.min.js"></script>
            <img class="center-all-contens" src="../assets/img/cancel.png">
            <p><strong>Error</strong></p>
            <p class="text-center">
                Recargando<br>
                en 7 segundos
            </p>
            <script>
                setTimeout(function(){
                url ="../pedido.php";
                $(location).attr("href",url);
                },1000);
            </script>
         ';
        }  
    }else{
        echo ' 
            
            <img src="../assets/img/incorrectofull.png" class="center-all-contens">
             <br>
             <h3>Ha ocurrido un error al cargar la imagen</h3>
             <p class="lead text-cente">
                 La pagina se redireccionara automaticamente. Si no es asi haga click en el siguiente boton.<br>
                 <a href="../pedido.php" class="btn btn-primary btn-lg">Volver a administración</a>
             </p>';
    }
    
    
}
