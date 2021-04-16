<?php


class json_transform
{
    private $string;
    public  $properties;
    public  $cities;
    public  $types;


    //decodifica la cadena convirtiéndola a tipo string
    public function decodeString()
    {
        $this->string = file_get_contents("data-1.json");
        $this->properties = json_decode($this->string);
    }


    public function getCities()
    {
        //variable ciudades para almacenar la salida.
        $ciudades = "";

        //Ejecutamos y obtenemos la variable de propiedades
        $this->decodeString();

        //Introducimos en ciclo para organizar 
        $arrayCities = [];
        $arrayAux = [];

        foreach ($this->properties as $key => $property) {
            $arrayAux[] = $property->Ciudad;
        }

        //Filtramos utilizando la función array_unique de php
        $arrayCities = array_unique($arrayAux);

        //Introducimos en ciclo para mostrar
        foreach ($arrayCities as $city) {
            $ciudades .= '<option>' . $city . '</option>';
        }

        echo $ciudades;
    }

    public function getTypes()
    {
        //variable tipos para almacenar la salida.
        $tipos = "";

        //ejecutamos y obtenemos la variable de propiedades
        $this->decodeString();

        //introducimos en ciclo para mostrar 
        $arrayTypes = [];
        $arrayAux = [];
        foreach ($this->properties as $key => $property) {
            $arrayAux[] = $property->Tipo;
        }

        // Filtramos utilizando la función array_unique de php
        $arrayTypes = array_unique($arrayAux);

        //Introducimos en ciclo para mostrar
        foreach ($arrayTypes as $type) {
            $tipos .= '<option>' . $type . '</option>';
        }

        echo $tipos;
    }


    //para obtener las propiedades
    public function getProperties()
    {
        //variable para almacenar la salida.
        $propiedades = "";
        $arrayAux = [];
        $type = "";
        $city = "";

        //ejecutamos y obtenemos la variable de propiedades
        $this->decodeString();

        //variables que almacenan los tipos / ciudades que vienen por GET

        //si está seteado y es diferente de blanco
        if(isset($_POST['type'])){
            $type = $_POST['type'];
        }
        
        //si está seteada y es diferente de blanco
        if(isset($_POST['city']) ){
            $city = $_POST['city'];
        }
        

        //si pasamos la ciudad y el tipo juntos
        if($type !== "" && $city !== "" ){
            foreach ($this->properties as $key => $property) {
                if($property->Tipo == $type && $property->Ciudad == $city)
                $arrayAux[] = $property;
            }
        }else
         //si pasamos sólo la ciudad
         if($type == "" && $city !== "" ){
            foreach ($this->properties as $key => $property) {
                if($property->Ciudad == $city)
                $arrayAux[] = $property;
            }
        }else

         //si pasamos sólo el tipo
         if($type !== "" && $city  == "" ){
            foreach ($this->properties as $key => $property) {
                if($property->Tipo == $type)
                $arrayAux[] = $property;
            }
        }else{
            $arrayAux = $this->properties;
        }


        //introducimos en ciclo para mostrar 
        foreach ($arrayAux as $property) {
            $propiedades .= '   
            <div class="col s12 ">
              <div class="card">
                <div class="card-image">
                  <img style="height: 200px" src="img/home.jpg">
                </div>
                <div class="card-content">
                  <p>
                    <b>Dirección: </b>'.$property->Direccion.'.<br>
                    <b>Ciudad:</b>'.$property->Ciudad.'.<br>
                    <b>Teléfono:</b>'.$property->Telefono.'.<br>
                    <b>Código postal:</b>'.$property->Codigo_Postal.'.<br>
                    <b>Tipo: </b>'.$property->Tipo.'.<br>
                    <b>Precio: </b>'.$property->Precio.'.<br>
                  </p>
                </div>
                <div class="card-action">
                <form action="back/store.php" method="post">
                  <input type="text" class="hide" name="direccion" value="'.$property->Direccion.'">
                  <input type="text" class="hide" name="ciudad" value="'.$property->Ciudad.'">
                  <input type="text" class="hide" name="telefono" value="'.$property->Telefono.'">
                  <input type="text" class="hide" name="codigo_postal" value="'.$property->Codigo_Postal.'">
                  <input type="text" class="hide" name="tipo" value="'.$property->Tipo.'">
                  <input type="text" class="hide" name="precio" value="'.$property->Precio.'">
                  <input type="text" class="hide" name="id_bien" value="'.$property->Id.'">
                  <button type="submit" class="waves-effect waves-light btn">Guardar</button>
                </form>
                </div>
              </div>
            </div>';
        }


        echo $propiedades;
    }
    
}
