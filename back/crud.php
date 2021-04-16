<?php

class crud
{
  public function list()
  {
    require("connect.php");
    $propiedades = "";

    /* Consultas de selección que devuelven un conjunto de resultados */
    if ($resultado = $db->cnx->query("SELECT * FROM bienes")) {
      while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $propiedades .= '   
                <div class="col s12 ">
                  <div class="card">
                    <div class="card-image">
                      <img style="height: 200px" src="img/home.jpg">
                    </div>
                    <div class="card-content">
                      <p>
                        <b>Dirección: </b>' . $row['direccion'] . '.<br>
                        <b>Ciudad:</b>' . $row['ciudad'] . '.<br>
                        <b>Teléfono:</b>' . $row['telefono'] . '.<br>
                        <b>Código postal:</b>' . $row['codigo_postal'] . '.<br>
                        <b>Tipo: </b>' . $row['tipo'] . '.<br>
                        <b>Precio: </b>' . $row['precio'] . '.<br>
                      </p>
                    </div>
                    <div class="card-action">
                    <form action="back/delete.php" method="post">
                      <input type="text" class="hide" name="id" value="' . $row['id'] . '">
                      <button type="submit" class="waves-effect waves-light btn">Eliminar</button>
                    </form>
                    </div>
                  </div>
                </div>';
      }

      echo $propiedades;
      /* liberar el conjunto de resultados */
      $resultado->close();
    }
  }

  public function report()
  {
    //Headers para imprimir el Excel
    header("Pragma: public");
    header("Expires: 0");
    $filename = "nombreArchivoQueDescarga.xls";
    header("Content-type: application/x-msdownload");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    
    require("connect.php");
    $propiedades = "";
    $type = "";
    $city = "";

    //si está seteado 
    if (isset($_POST['typeR'])) {
      $type = $_POST['typeR'];
    }

    //si está seteada 
    if (isset($_POST['cityR'])) {
      $city = $_POST['cityR'];
    }



    //si pasamos la ciudad y el tipo juntos
    if ($type !== "" && $city !== "") {
      $query = "SELECT * FROM bienes where ciudad = '$city' and tipo = '$type'";
    } else
      //si pasamos sólo la ciudad
      if ($type == "" && $city !== "") {
        $query = "SELECT * FROM bienes where  ciudad = '$city'";
      } else

        //si pasamos sólo el tipo
        if ($type !== "" && $city  == "") {
          $query = "SELECT * FROM bienes where tipo = '$type'";
        } else {
          $query = "SELECT * FROM bienes ";
        }


    /* Consultas de selección que devuelven un conjunto de resultados */
    if ($resultado = $db->cnx->query($query)) {
      while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $propiedades .= '
                      <tr>
                        <td>' . $row['direccion'] . '.</td>
                        <td>' . $row['ciudad'] . '.</td>
                        <td>' . $row['telefono'] . '.</td>
                        <td>' . $row['codigo_postal'] . '.</td>
                        <td>' . $row['tipo'] . '.</td>
                        <td>' . $row['precio'] . '.</td>
                      </tr>
                    ';
      } 

      //termina de crear la tabla
      echo "<table border='1'>
      <tr>
        <th>Direccion</th>
        <th>Ciudad</th>
        <th>Telefono</th>
        <th>Codigo Postal</th>
        <th>Tipo</th>
        <th>Precio</th>
      </tr>
      $propiedades
    </table>";
      /* liberar el conjunto de resultados */
      $resultado->close();
    } else {
      echo mysqli_error($db->cnx);
    }
  }


  //función para almacenar en base de datos
  public function store()
  {

    //obtenemos la conexión
    require("connect.php");

    //recuperamos los datos
    $id_bien = $_POST['id_bien'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $telefono = $_POST['telefono'];
    $codigo_postal = $_POST['codigo_postal'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];

    //guardamos
    if ($resultado = $db->cnx->query("INSERT INTO bienes 
                                              (id_bien, 
                                               direccion , 
                                               ciudad , 
                                               telefono ,
                                               codigo_postal, 
                                               tipo, 
                                               precio  ) 
                                      VALUES  ($id_bien, 
                                               '$direccion' , 
                                               '$ciudad' , 
                                               '$telefono' ,
                                               '$codigo_postal', 
                                               '$tipo', 
                                               '$precio' )")) {
      echo "Guardado";
      //redireccionamos
      header('Location: ../', true);
      exit();
    } else {
      echo mysqli_error($db->cnx);;
    }
  }

  //función para eliminar un elemento físicamente
  public function delete()
  {
    //obtenemos la conexión
    require("connect.php");

    //recuperamos los datos
    $id = $_POST['id'];

    //guardamos
    echo "delete from bienes where id=$id";
    if ($resultado = $db->cnx->query("delete from bienes where id=$id")) {
      echo "Eliminado";
      //redireccionamos
      header('Location: ../', true);
      exit();
    } else {
      echo mysqli_error($db->cnx);
    }
  }
}
