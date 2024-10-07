<?php
    
    //Llamando a la cadena de Conexion
    require_once("../config/conexion.php");

    //llamando a la clase
    require_once("../models/Usuario.php");

    //inicializando clase
    $usuario = new Usuario();

    //opcion de solicitud de controller
    switch ($_GET["op"]) {
        // Microservicio para mostrar el listado de cursos de un usuario
        case "listar_cursos":
            $datos = $usuario->get_cursos_x_usuario($_POST["usu_id"]);
            $data = array();
    
            foreach ($datos as $row) {
                $sub_array = array();
                // Agregar cada columna al array en lugar de sobrescribirlo
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = $row["inst_nom"] . " " . $row["inst_apep"];
                $sub_array[] = '<button type="button" onClick="certificado('.$row["curd_id"].');" id="'.$row["curd_id"].'" class="btn btn-outline-primary btn-icon"><i class="fa fa-id-card"></i></button>';
    
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

        // Microservicio para mostrar el listado de cursos de un usuario
        case "listar_cursos_top10":
            $datos = $usuario->get_cursos_x_usuario_top10($_POST["usu_id"]);
            $data = array();
    
            foreach ($datos as $row) {
                $sub_array = array();
                // Agregar cada columna al array en lugar de sobrescribirlo
                $sub_array[] = $row["cur_nom"];
                $sub_array[] = $row["cur_fechini"];
                $sub_array[] = $row["cur_fechfin"];
                $sub_array[] = $row["inst_nom"] . " " . $row["inst_apep"];
                $sub_array[] = '<button type="button" onClick="certificado('.$row["curd_id"].');" id="'.$row["curd_id"].'" class="btn btn-outline-primary btn-icon"><i class="fa fa-id-card"></i></button>';
    
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
        
        
        /* Microservicio para mostrar información del certificado con el curd_id */
        case "mostrar_curso_detalle":
            $datos = $usuario->get_curso_x_id_detalle($_POST["curd_id"]);
            if(is_array($datos) == true and count($datos) > 0){
                foreach($datos as $row){
                    $output["curd_id"] = $row["curd_id"];
                    $output["cur_id"] = $row["cur_id"];
                    $output["cur_nom"] = $row["cur_nom"];
                    $output["cur_descrip"] = $row["cur_descrip"];
                    $output["cur_fechini"] = $row["cur_fechini"];
                    $output["cur_fechfin"] = $row["cur_fechfin"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_apep"] = $row["usu_apep"];
                    $output["usu_apem"] = $row["usu_apem"];
                    $output["inst_id"] = $row["inst_id"];
                    $output["inst_nom"] = $row["inst_nom"];
                    $output["inst_apep"] = $row["inst_apep"];
                    $output["inst_apem"] = $row["inst_apem"];
                }
                echo json_encode($output);
            }
            break;
        
        case "total":
            $datos=$usuario->get_total_cursos_x_usuario($_POST["usu_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["total"] = $row["total"];
                }
                echo json_encode($output);
            }
            break;
    }
?>