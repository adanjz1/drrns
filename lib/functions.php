<?php 

/* -=========== BASE DE DATOS ===========- */
function executeQuery( $connect, $query, $where ) {
    if( isset($where) && !empty($where) ) {
        $query .= $where;
    }
    $r = mysql_query( $connect, $query, $where );
    return $r;
}
function executeQueryBool($r) {
    $r = mysql_query( $query, $connect );
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
}
function getCategorias( $connect, $query='select * from categorias' ) {
    return executeQuery( $connect, $query );
}
function getsubCategorias( $connect, $query='select * from categorias' ) {
    return executeQuery( $connect, $query );
}
function getProductos( $query='select * from productos' ){
    return executeQuery( $connect, $query );
}

/* -=========== PRODUCTOS ===========- */
function listarProductos( $connect, $desde, $hasta ) {
    $limit = ' limit '.$desde. ', '.$hasta;
    $rs = executeQueryBool( $connect, $query, $limit );    
    if( $rs ) { 
        listar($rs);
        paginar($rs);          
    } else {
        header('Location: lalalal.php');
    }
}
function listar($rs) {
    $keys = array_keys($lista[0]);
   
    foreach ($keys as $k) {
        $k = ucwords($k);
        $fieldsNames[$i] = ($k != "#") ? strtolower($k) : 'id';
        $table = $table . "<th bgcolor = '#a3d869'><font color='#FFFFFF'>" . $k . "</font></th>";
    }
    
    foreach ($lista as $u) {
        $table = $table . "<tr>";
        $id = $u['id_'.$table_name];
        foreach ($u as $data) {
            $class= 'input-medium';
            $table = $table . "<td><input type='text' style='color:#004b2b' class='$class' id='$fieldsNames[$ii]-$id' value='$data' disabled /></td>";
        }
    }
    
    $table = $table . "</tr>";    
}
function paginar($rs){
    $num_total_registros = mysql_num_rows($rs); 
    //calculo el total de páginas 
    $total_paginas = ceil( $num_total_registros / $tamaño_pagina); 
        //muestro los distintos índices de las páginas, si es que hay varias páginas 
        if ($total_paginas > 1){ 
            $table.= "<tr><td colspan='11' align='center' >";
            $anterior = $pagina-$tamaño_pagina;
            $posterior = $pagina+$tamaño_pagina;
            for ($i=$pagina;$i<=$total_paginas;$i++){ 
                if( $anterior > 0 && $i==$pagina ) {
                    $table .= "<a href=listado.php?pagina=" . $anterior . "> << </a> "; 
                } elseif ( $pagina < $tamaño_pagina && $pagina != 0 && $i==$pagina ) {
                    $anterior = 0;
                    $table .= "<a href=listado.php?pagina=" . $anterior . "> << </a> "; 
                }
                if( $hasta == $i ) {
                    ( $posterior > $total_paginas ) ? $posterior = $total_paginas : $posterior; 
                    $table .= "<a href=listado.php?pagina=" . $posterior . "> >> </a> "; 
                    break;
                }
                if ($pagina == $i) {
                     //si muestro el índice de la página actual, no coloco enlace 
                     $table .= $pagina . " "; 
                } else {
                     //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
                     $table .= "<a href=listado.php?pagina=" . $i . "> " . $i . " </a> "; 
                }
            }
            $table.= "</td></tr>";
        }
        
        //cerramos el conjunto de resultado y la conexión con la base de datos 
        mysql_free_result($rs); 
        
        print_r($table);
}

/* -============CONTACTO=============- */

function enviarFormulario($to,$connect) {
    foreach($_POST as $nombre => $valor ) {
       $datosArray[$nombre] = $valor; 
    }

    if( mail($to, $datosArray['subject'], $datosArray['message']) ) {
        $bool = guardameContacto($datosArray);
        if($bool){
            header('Location: lalalal.php');
        } else {
            echo 'error en guardar contacto';
        }
    } else {
        echo 'error en enviar el email';
    }
}
function guardameContacto( $query = 'INSERT INTO contacto VALUES (', $datos ){
    foreach($datos as $key => $valor ) {
       $query .= $key . '=' . $valor . ',';
    }
    $query .= ')';
    
    return executeQueryBool( $connect, $query );
}

/* -============OTRAS================- */
function buscar( $nombre ){
    $where = 'WHERE nombre ='.$nombre;
    return executeQuery( $connect, $query, $where );
}
?>