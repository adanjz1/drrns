<?php 
global $connect;

/* -=========== BASE DE DATOS ===========- */

function executeQuery( $query='', $where=null ) {
    if( !empty($where) ) {
        $query .= $where;
    }
    $r = @mysql_query( $query, $connect );
    mysql_free_result($r); 
    return $r;
}
function executeQueryBool($query) {
    $r = @mysql_query( $query, $connect );
    
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
    mysql_free_result($r); 
}
function getCategorias( $query='SELECT * FROM categorias' ) {
    return executeQuery( $query );
}
function getsubCategorias( $query='SELECT * FROM categorias' ) {
    return executeQuery( $query );
}
function getProductos( $query='SELECT * FROM productos', $where = null ){
    if( !empty($where) ) {
        $query .= ' '.$where;
    }
    return executeQuery( $query );
}
function getNumTotalDeRegistros( $registros ) {
    $query = 'SELECT count(*) FROM '.$tabla;
    if( $activos ){
        $query .= ' WHERE activos=1';
    }
    return executeQuery( $query );
}
/* CONVERSIONES */
function fetchArray($mysqlResult) {
    return mysql_fetch_array($mysqlResult,MYSQL_ASSOC);
}
function toArray($mysqlResultFetchArray){
    $res=array();
        
    while ($mysqlResultFetchArray)
    {
        $res[]=$mysqlResultFetchArray;
    }

    return $res;
}

/* -=========== PRODUCTOS ===========- */
function listarProductos( $desde, $hasta, $tamanio_pagina = 30, $paginado = false) {
    $where = 'WHERE activos =1  limit '.$desde. ', '.$hasta;
    $productos = getProductos('SELECT * FROM productos',$where);
    $productosFetchArray = fetchArray($productos);
    $productosArray = toArray($productosFetchArray);
    
    if( !$paginado ) {
        return $productosArray;
    } else {
        if( count($productosArray) ) { 
            /* PAGINAR */
            $num_total_registros = getNumTotalDeRegistros( $productosArray );
            $total_paginas = ceil( $num_total_registros / $tamanio_pagina ); 
            $anterior = $pagina-$tamanio_pagina;
            $posterior = $pagina+$tamanio_pagina;

            $r = array( 'paginado' => 
                            array(
                                'total-de-registros' => $num_total_registros,
                                'total-de-paginas' => $total_paginas,
                                'anterior' => $anterior,
                                'posterior' => $posterior,
                                ),
                        'productos' => $productosArray
                        );
            return $r;
        } else {
            // no hay productos
            return false; 
        }
    }
}

/* -============CONTACTO=============- */

function enviarFormulario( $to ) {
    foreach($_POST as $nombre => $valor ) {
       $datosArray[$nombre] = $valor; 
    }

    if( mail($to, $datosArray['subject'], $datosArray['message']) ) {
        $bool = guardameContacto($datosArray);
        if($bool){
            return true;
        } else {
            echo 'error en guardar contacto';
        }
    } else {
        echo 'error en enviar el email';
    }
}
function guardameContacto( $datos, $query = 'INSERT INTO contacto VALUES (' ){
    foreach($datos as $key => $valor ) {
       $query .= $key . '=' . $valor . ',';
    }
    $query .= ')';
    
    return executeQueryBool( $query );
}

/* -============OTRAS================- */
function buscar( $nombre ){
    $query = 'SELECT * FROM productos';
    $where = ' '.'WHERE nombre ='.$nombre;
    return executeQuery( $query, $where );
}
?>