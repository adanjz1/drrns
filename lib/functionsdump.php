<?php 

// HARDCODEAR returns
//  array("nombre","")
    
/* -=========== BASE DE DATOS ===========- */
function executeQuery( $query, $where=null ) {
    if( isset($where) && !empty($where) ) {
        $query .= $where;
    }
    //$r = mysql_query( $query, $where );
    $r = array( 1 => array(
                        'nombre' => 'Lalo',
                        'apellido' => 'Lelel',
                        'descripcion' => 'mucha descripcion',
                        'especificaciones' => array()
                        ),
                2 => array(
                        'nombre' => 'Honey 27 Flashback completo',
                        'precio' => '530,00',
                        'descripcion' => 'Criada por Mike Mahoney, a empresa de longboard presa muito a qualidade dos seus produtos, com acabamentos e detalhes extremamente desenvolvido, a Honey vem a nos mostrar uma filosofia em uma construção laminada com madeiras exóticas.' ,
                        'especificaciones' => array(
                                                'Honey Skateboard / Grand Junction, CO - USA', 
                                                'Style Street, Pool e Cruising',
                                                'Trucks Tracker Dart 129',
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                )
                        ),
                 3 => array(
                        'nombre' => 'Roda Abec 11 BigZigs Reflex - Pink - 75mm - 77a',
                        'apellido' => 'Lelel',
                        'descripcion' => 'mucha descripcion',
                        'especificaciones' => array()
                        ),
                 4 => array(
                        'nombre' => 'Roda Gravity Drifter - Preta - 70mm - 80a',
                        'precio' => '530,00',
                        'descripcion' => 'Criada por Mike Mahoney, a empresa de longboard presa muito a qualidade dos seus produtos, com acabamentos e detalhes extremamente desenvolvido, a Honey vem a nos mostrar uma filosofia em uma construção laminada com madeiras exóticas.' ,
                        'especificaciones' => array(
                                                'Honey Skateboard / Grand Junction, CO - USA', 
                                                'Style Street, Pool e Cruising',
                                                'Trucks Tracker Dart 129',
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                )
                        ),
                 5 => array(
                        'nombre' => 'Roda Abec 14 BigZigs Reflex - Green - 75mm - 721',
                        'apellido' => 'sarasa',
                        'descripcion' => 'Alguna descripcion',
                        'especificaciones' => array()
                        ),
                 6 => array(
                        'nombre' => 'Rode Gravity - Preta - 90mm - 10a',
                        'precio' => '1650,00',
                        'descripcion' => 'Criada por Mike Mahoney.' ,
                        'especificaciones' => array(
                                                'Rolamento Turbo Abec 7', 
                                                'Roda Roxa Orangatang Fat Free 65mm 83a'
                                                )
                        )
                );
    return $r;
}
function executeQueryBool( $query, $connect ) {
    //$r = mysql_query( $query, $connect );
    $r = 3;
    if( odbc_num_rows($r) > 0 ) {
        return true;
    } else {
        return false;
    }
}
function getCategorias( $query='select * from categorias' ) {
    return executeQuery( $query );
}
function getsubCategorias( $query='select * from categorias' ) {
    return executeQuery( $query );
}
function getProductos( $query='select * from productos' ){
    return executeQuery( $query );
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
    
    return executeQueryBool( $query );
}

/* -============OTRAS================- */
function buscar( $nombre ){
    $where = 'WHERE nombre ='.$nombre;
    return executeQuery( $query, $where );
}
?>