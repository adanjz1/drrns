<?php 

// HARDCODEAR returns
//  array("nombre","")

/* -=========== BASE DE DATOS ===========- */
function executeQuery( $connect, $query=null, $where=null ) {
    if( !empty($where) ) {
        $query .= $where;
    }
    $r = @mysql_query( $connect, $query, $where );
    mysql_free_result($r); 
    return $r;
}
function executeQueryBool($r) {
    $r = @mysql_query( $query, $connect );
    
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
    mysql_free_result($r); 
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
function getNumTotalDeRegistros( $registros ) {
    if(is_array( $registros )) {
        return count( $registros );
   } else {
       return mysql_num_rows( $registros );
   }
}

/* -=========== PRODUCTOS ===========- */
function listarProductos( $desde, $hasta, $tamaño_pagina = 30) {
    $limit = ' limit '.$desde. ', '.$hasta;
    $productos = getProductos();

    if( count($productos) ) { 
        /* PAGINAR */
        $num_total_registros = getNumTotalDeRegistros( $productos );
        $total_paginas = ceil( $num_total_registros / $tamaño_pagina ); 
        $anterior = $pagina-$tamaño_pagina;
        $posterior = $pagina+$tamaño_pagina;
        
        $paginado = array( 
                        'total-de-registros' => $num_total_registros,
                        'total-paginas' => $total_paginas,
                        'anterior' => $anterior,
                        'posterior' => $posterior
                        );
        return $paginado;
    } else {
        //header('Location: lalalal.php');
        echo 'No hay productos';
    }
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