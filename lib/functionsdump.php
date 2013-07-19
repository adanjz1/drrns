<?php     
/* -=========== BASE DE DATOS ===========- */
function executeQuery( $query, $where=null ) {
    if( !empty($where) ) {
        $query .= $where;
    }
    $r = array( 1 => array(
                        'nombre' => 'Lalo',
                        'apellido' => 'Lelel',
                        'img'    => '',
                        'descripcion' => 'mucha descripcion',
                        'especificaciones' => array(),
                        'activo' => 1
                        ),
                2 => array(
                        'nombre' => 'Honey 27 Flashback completo',
                        'precio' => '530,00',
                        'img'    => '',
                        'descripcion' => 'Criada por Mike Mahoney, a empresa de longboard presa muito a qualidade dos seus produtos, com acabamentos e detalhes extremamente desenvolvido, a Honey vem a nos mostrar uma filosofia em uma construção laminada com madeiras exóticas.' ,
                        'especificaciones' => array(
                                                'Honey Skateboard / Grand Junction, CO - USA', 
                                                'Style Street, Pool e Cruising',
                                                'Trucks Tracker Dart 129',
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                ),
                        'activo' => 1
                        ),
                 3 => array(
                        'nombre' => 'Roda Abec 11 BigZigs Reflex - Pink - 75mm - 77a',
                        'apellido' => 'Lelel',
                        'img'    => '',
                        'descripcion' => 'mucha descripcion',
                        'especificaciones' => array(),
                        'activo' => 1
                        ),
                 4 => array(
                        'nombre' => 'Roda Gravity Drifter - Preta - 70mm - 80a',
                        'precio' => '530,00',
                        'img'    => '',
                        'descripcion' => 'Criada por Mike Mahoney, a empresa de longboard presa muito a qualidade dos seus produtos, com acabamentos e detalhes extremamente desenvolvido, a Honey vem a nos mostrar uma filosofia em uma construção laminada com madeiras exóticas.' ,
                        'especificaciones' => array(
                                                'Honey Skateboard / Grand Junction, CO - USA', 
                                                'Style Street, Pool e Cruising',
                                                'Trucks Tracker Dart 129',
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                ),
                        'activo' => 1
                        ),
                 5 => array(
                        'nombre' => 'Roda Abec 14 BigZigs Reflex - Green - 75mm - 721',
                        'apellido' => 'sarasa',
                        'img'    => '',
                        'descripcion' => 'Alguna descripcion',
                        'especificaciones' => array(),
                        'activo' => 1
                        ),
                 6 => array(
                        'nombre' => 'Rode Gravity - Preta - 90mm - 10a',
                        'precio' => '1650,00',
                        'img'    => '',
                        'descripcion' => 'Criada por Mike Mahoney.' ,
                        'especificaciones' => array(
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                ),
                        'activo' => 1
                        ),
                7 => array(
                        'nombre' => 'Soy invisible',
                        'precio' => '1000000000000,99',
                        'img'    => 'transparent.png',
                        'descripcion' => 'Las alarmas de calor corporal me ven :(' ,
                        'especificaciones' => array(),
                        'activo' => 0
                        )
                );
    return $r;
}
function executeQueryBool( $query ) {
    $r = 3;
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
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
    if(is_array( $registros )) {
        return count( $registros );
   } else {
       return mysql_num_rows( $registros );
   }
}
/* CONVERSIONES */
function fetchArray($mysqlResult) {
    return mysql_fetch_array($mysqlResult,MYSQL_ASSOC);
}
function toArray($mysqlResult){
    $res=array();
        
    while ($mysqlResult)
    {
        $res[]=$mysqlResult;
    }

    return $res;
}

/* -=========== PRODUCTOS ===========- */
function listarProductos( $desde, $hasta, $tamanio_pagina = 30, $paginado = false) {
    $limit = ' limit '.$desde. ', '.$hasta;
    $productos = getProductos('SELECT * FROM productos','WHERE activos=1');
    $productosFetchArray = fetchArray($productos);
    $productosArray = toArray($productosFetchArray);
    
    if( !$paginado ) {
        return $productosArray;
    } else {
        if( count($productosArray) ) { 
            /* PAGINAR */
            $num_total_registros = getNumTotalDeRegistros( $productosArray, true );
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

function enviarFormulario($to,$connect) {
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
    $where = 'WHERE nombre ='.$nombre;
    return executeQuery( $query, $where );
}
?>