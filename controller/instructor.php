<?php
    
    //Llamando a la cadena de Conexion
    require_once("../config/conexion.php");

    //llamando a la clase
    require_once("../models/Instructor.php");

    //inicializando clase
    $instructor = new Instructor();

    //opcion de solicitud de controller
    switch ($_GET["op"]) {

        // Guardar y editar cuando se tenga el ID
        case "guardaryeditar":
            if(empty($_POST["cur_id"])){
                $curso->insert_curso($_POST["cat_id"], $_POST["cur_nom"], $_POST["cur_descrip"], $_POST["cur_fechini"], $_POST["cur_fechfin"], $_POST["inst_id"]);
            }else{
                $curso->update_curso($_POST["cur_id"],$_POST["cat_id"], $_POST["cur_nom"], $_POST["cur_descrip"], $_POST["cur_fechini"], $_POST["cur_fechfin"], $_POST["inst_id"]);
            }
            break;
        
        //Creando Json segun el ID
        case "mostrar":
            $datos = $curso->get_curso_id($_POST["cur_id"]);
            if(is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row){
                    $output["cur_id"] = $row["cur_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["cur_nom"] = $row["cur_nom"];
                    $output["cur_descrip"] = $row["cur_descrip"];
                    $output["cur_fechini"] = $row["cur_fechini"];
                    $output["cur_fechfin"] = $row["cur_fechfin"];
                    $output["inst_id"] = $row["inst_id"];
                }
                echo json_encode($output);
            }
            break;
        
        //Eliminar segun ID
        case "eliminar":
            $curso->delete_curso($_POST["cur_id"]);
            break;

        //listar toda la informacion segun formato de datatable
        case "listar":
            $datos = $curso->get_curso();
            $data = array();
    
            foreach ($datos as $row) {
                $sub_array = array();
                // Agregar cada columna al array en lugar de sobrescribirlo
                $sub_array[] = $row["cat_id"];
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = $row["inst_id"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["cur_id"].');" id="'.$row["cur_id"].'" class="btn btn-outline-warning btn-icon"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cur_id"].');" id="'.$row["cur_id"].'" class="btn btn-outline-danger btn-icon"><i class="fa fa-times"></i></button>';

                $data[] = $sub_array;
            }
            
            // Devolver los resultados en formato JSON
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            
            echo json_encode($results);
            break;
        
        case "combo":
            $datos = $instructor->get_instructor();
            if (is_array($datos) == true and count($datos) > 0) {
                $html = "<option value='' disabled selected>Seleccione</option>";
                foreach ($datos as $row) {
                    $html .= "<option value='".$row['inst_id']."'>".$row['inst_nom']." ".$row['inst_apep']." ".$row['inst_apem']."</option>";
                }
            }
            echo $html;
            break;
    }
?>