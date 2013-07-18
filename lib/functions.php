<?php 
function executeQuery( $connect, $query, $where ) {
    if( isset($where) && !empty($where) ) {
        $query .= $where;
    }
    $r = mysql_query( $query, $connect );
    return $r;
}
function getCategorias( $connect, $query='select * from categorias' ) {
    return executeQuery($query, $connect);
}
function getsubCategorias( $connect, $query='select * from categorias' ) {
    return executeQuery($query, $connect);
}

function listarProductos( $connect, $desde, $hasta ) {
    $limit = 'limit '.$desde. ', '.$hasta;
}
function getProductos( $query='select * from productos' ){
    return executeQuery( $connect, $query);
}
function buscar( $nombre ){
    $where = 'WHERE nombre ='.$nombre;
    return executeQuery( $connect, $query, $where);
}
function guardameContacto( $query = 'INSERT INTO contacto VALUES (', $datos ){
    foreach($datos as $key => $valor ) {
       $query .= $key . '=' . $valor . ',';
    }
    $query .= ')';
    
    $r = executeQuery( $connect, $query );
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
}

function enviarFormulario($to,$connect) {
    foreach($_POST as $nombre => $valor ) {
       $datosArray[$nombre] = $valor; 
    }

    if( mail($to, $datosArray['subject'], $datosArray['message']) ) {
        $bool = guardameContacto($datosArray);
        if($bool){
            header('location');   
        } else {
            echo 'error en guardar contacto';
        }
    } else {
        echo 'error en enviar el email';
    }
}
?>