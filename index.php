<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//agregamos archivos de php
require("back/decode_json.php");
require("back/crud.php");

//instancia que decodifica json
$json = new json_transform();
$crud = new crud()
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/customColors.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/index.css" media="screen,projection" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulario</title>
</head>

<body>

  <div class="contenedor">
    <div class="card rowTitulo">
      <h1>Bienes Intelcost</h1>
    </div>
    <div class="colFiltros">
      <form action="#" method="post" id="formulario">
        <div class="filtrosContenido">
          <div class="tituloFiltros">
            <h5>Filtros</h5>
          </div>

          <div class="filtroCiudad input-field">
            <p><label for="selectCiudad">Ciudad:</label><br></p>
            <select name="city" id="city">
              <option value="" selected>Elige una ciudad</option>
              <!--inyectamos las ciudades-->
              <?php $json->getCities(); ?>
              <!--fin inyectamos las ciudades-->
            </select>
          </div>
          <div class="filtroTipo input-field">
            <p><label for="selecTipo">Tipo:</label></p>
            <br>
            <select name="type" id="type">
              <option value="">Elige un tipo</option>
              <!--inyectamos los tipos-->
              <?php $json->getTypes() ?>
              <!--fin inyectamos los tipos-->
            </select>
          </div>
          <div class="filtroPrecio">
            <label for="rangoPrecio">Precio:</label>
            <input type="text" id="rangoPrecio" name="precio" value="" />
          </div>
          <div class="botonField">
            <input type="submit" class="btn white" value="Buscar" id="submitButton">
          </div>
        </div>
      </form>
    </div>
    <div id="tabs" style="width: 75%;">
      <ul>
        <li><a href="#tabs-1">Bienes disponibles</a></li>
        <li><a href="#tabs-2">Mis bienes</a></li>
        <li><a href="#tabs-3">Reportes</a></li>
      </ul>
      <div id="tabs-1">
        <div class="colContenido">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Resultados de la búsqueda:</h5>
            <div class="divider"></div>
            <!--Here-->
            <div class="row">
              <!--muestra las propiedades-->
              <?php $json->getProperties(); ?>
              <!--fin muestra las propiedades-->
            </div>
          </div>
        </div>
      </div>

      <div id="tabs-2">
        <div class="colContenido">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Bienes guardados:</h5>
            <div class="divider"></div>
            <!--here-->
            <?php $crud->list(); ?>
          </div>
        </div>
      </div>
      
      <div id="tabs-3">
        <div class="colContenido">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Reportes:</h5>
            <form action="back/report.php" method="post">
              <select name="cityR" id="cityR">
                <option value="" selected>Elige una ciudad</option>
                <!--inyectamos las ciudades-->
                <?php $json->getCities(); ?>
                <!--fin inyectamos las ciudades-->
              </select>

              <select name="typeR" id="typeR">
                <option value="" selected>Elige un tipo</option>
                <!--inyectamos los tipos-->
                <?php $json->getTypes(); ?>
                <!--fin inyectamos los tipos-->
              </select>
              <button type="submit" class="waves-effect waves-light btn">Generar reporte</button>
            </form>
            <div class="divider"></div>
            <!--here-->
          </div>
        </div>
      </div>


    </div>


    <script src="js/jquery.js"></script>

    <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/buscador.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#tabs").tabs();
      });
    </script>
</body>

</html>