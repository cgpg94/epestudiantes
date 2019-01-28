<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Refresh" content="12;url=pedido.php">

    <title>Pedido</title>
    <?php include './inc/link.php';
    
    include './library/configServer.php';
    include './library/consulSQL.php';?>
    
    <?php include './inc/navbar.php'; 
     header('Content-Type: text/html; charset=UTF-8'); ?>
</head>
<body id="container-page-index">
    <section id="container-pedido">
        <div class="container">
            <div class="page-header">
              <h1>Confirmar pedido</h1>
            </div>

            <div class="col-xs-12 col-sm-12">
              <?php
              session_start();
              $suma = 0;
              
              if(isset($_GET['precio'])){
                  $_SESSION['producto'][$_SESSION['contador']] = $_GET['precio'];
                  $_SESSION['contador']++;
                
              }
              
              echo '<table class="table table-bordered">';
              
              for($i = 0;$i<$_SESSION['contador'];$i++){
              
                  $consulta=ejecutarSQL::consultar("select * from producto where CodigoProd='".$_SESSION['producto'][$i]."'");
              
                  
                  while($fila = mysqli_fetch_array($consulta)) {
              
                          echo "<tr><td>".$fila['NombreProd']."</td><td> ".$fila['Precio']."</td></tr>";
                  $suma += $fila['Precio'];
                  }
              }
              echo "<tr><td>Subtotal</td><td>$".number_format($suma,2)."</td></tr>";
              echo "</table>";
              $_SESSION['sumaTotal']=$suma;
              
              ?>
            </div>
            <br><br><br>
            <div class="row">
                
                <div class="col-xs-12 col-sm-12">
                    <div id="form-compra">
                        <form action="app/confirmcompra.php" method="POST"  role="form" class="FormCatElec" data-form="save">
                            <?php
                                if(!$_SESSION['nombreUser']=="" &&!$_SESSION['claveUser']==""){
                                    echo '
                                   
                                        <h2 class="text-center">¿Confirmar pedido?</h2>
                                        <p class="text-center">Para confirmar tu pedido presiona el botón confirmar</p>
                                        <br>
                                          <input type="hidden" name="clien-name" value="'.$_SESSION['nombreUser'].'">
                                          <input type="hidden" name="clien-pass" value="'.$_SESSION['claveUser'].'">
                                          <input type="hidden"  name="clien-number" value="log">
                                      
                                        <p class="text-center"><button class="btn btn-success" type="submit">Confirmar</button></p>
                                        <br><br><br>
                                    ';
                                }else{
                                    echo '
                                        <h3 class="text-center">¿Confirmar el pedido?</h3>
                                        <p>
                                            Para confirmar tu compra debes haber iniciar sesión o introducir tu nombre de usuario
                                            y contraseña con la cual te registraste en <span class="tittles-pages-logo">VENTA DE EQUIPOS INFORMÁTICOS Y TECNOLOGÍCOS</span>.
                                        </p>
                                        <br>
                                      <div class="form-group">
                                        <div class="input-group">
                                          <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                          <input class="form-control all-elements-tooltip" type="text" placeholder="Ingrese su nombre" required name="clien-name" data-toggle="tooltip" data-placement="top" title="Ingrese su nombre" pattern="[a-zA-Z]{1,9}" maxlength="9">
                                        </div>
                                      </div>
                                      <br>
                                      <div class="form-group">
                                        <div class="input-group">
                                          <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                          <input class="form-control all-elements-tooltip" type="password" placeholder="Introdusca su contraseña" required name="clien-pass" data-toggle="tooltip" data-placement="top" title="Introdusca su contraseña">
                                        </div>
                                      </div>
                                      <input type="hidden"  name="clien-number" value="notlog">
                                      <br>
                                      <p class="text-center"><button class="btn btn-success" type="submit">Confirmar</button></p>
                                      <br><br><br>
                                    '; 
                                }
                            ?>
                            <div class="ResForm" style="width: 100%; text-align: center; margin: 0;"></div>
                        </form>
                    </div>
                    
                </div>

                <div class="col-xs-12 col-sm-14">
                <div class="panel panel-info">

                
                
                               <div class="panel-heading text-center"><h3>Historial de pedidos</h3></div>
                               <div class="panel-heading text-center"><strong> N° de cuenta: </strong>1214254781 Banco de Guayaquil -
                               <strong>Telefono:</strong> 0932487891</p></div>
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead class="">
                                          <tr>
                                              <th class="text-center">#</th>
                                              <th class="text-center">Fecha</th>
                                              <th class="text-center">Cliente</th>
                                              <th class="text-center">Descuento</th>
                                              <th class="text-center">Total</th>
                                              <th class="text-center">Estado</th>
                                              <th class="text-center">Recibo</th>
                                              <th class="text-center">Actualizar recibo</th>
                                              <th class="text-center">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                            $usuario=ejecutarSQL::consultar("select cedula from cliente where Nombre='".$_SESSION['nombreUser']."'");
                                            $usU=mysqli_fetch_array($usuario);
                                            $pedidoU=  ejecutarSQL::consultar("select * from venta where cedula='".$usU['cedula']."'");
                                            $upp=1;
                                            while($peU=mysqli_fetch_array($pedidoU)){
                                                echo '
                                                    <div id="update-pedido">
                                                      <form method="post" action="app/updatePago.php" enctype="multipart/form-data" id="res-update-pago-'.$upp.'">
                                                        <tr>
                                                            <td>'.$peU['NumPedido'].'<input type="hidden" name="num-pedido" value="'.$peU['NumPedido'].'"></td>
                                                            <td>'.$peU['Fecha'].'</td>
                                                            <td>';
                                                                $conUs= ejecutarSQL::consultar("select * from cliente where cedula='".$peU['cedula']."'");
                                                                while($UsP=mysqli_fetch_array($conUs)){
                                                                    echo $UsP['NombreCompleto'];
                                                                }
                                                    echo   '</td>
                                                            <td>'.$peU['Descuento'].'%</td>
                                                            <td>'.$peU['TotalPagar'].'</td>
                                                            <td>'
                                                            .$peU['Estado'].'
                                                            </td>
                                                           
                                                            <td>
                                                            <img src="'.$peU['pago'].'" alt="pago" width="200" height="200" class="img-responsive">
                                                             
                                                            </td>
                                                            <td>
                                                            <label>Imagen de deposito o tranferencia</label>
                                                            <input type="file" name="img">
                                                            <p class="help-block">Formato de imagenes admitido png, jpg,jpeg</p>
                                                        </td>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-primary button-UPPE" value="res-update-pedido-'.$upp.'">Actualizar pago</button>
                                                                <div id="res-update-pedido-'.$upp.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                            </td>
                                                        </tr>
                                                      </form>
                                                    </div>
                                                    ';
                                                $upp=$upp+1;
                                            }
                                          ?>
                                          
                                      </tbody>
                                  </table>
                              </div>
                              </div>

                </div>
            </div>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>

</body>
</html>