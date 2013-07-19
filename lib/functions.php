<?php 
global $connect;
$connect = mysql_connect("localhost","root","");//Nombre del server, usuario, contraseña
mysql_select_db("magento",$id_con);//Nomber de la base de datos, como me conecto

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
function getCategorias(){
	$query = "SELECT entity_id FROM catalog_category_entity WHERE level = 1";
	$response = mysql_query($query);
	$categories = array();
	while ($dato = mysql_fetch_array($response,MYSQL_ASSOC)) {
                        $entity_id = $dato['entity_id'];
                        //obtengo el nombre de la categoria
                        $query = "SELECT value FROM catalog_category_entity_varchar 
                                  WHERE entity_id = ".$entity_id." AND	attribute_id = '41'";			
                        $response = mysql_query($query);
                        while ($dato = mysql_fetch_array($response,MYSQL_ASSOC)) {
                                $nom = $dato['value'];
                        }
                $categories[$entity_id]["name"] = $nom;
                $categories[$entity_id]["subCategories"]=array();

                $query = "SELECT entity_id FROM catalog_category_entity WHERE parent_id = ".$entity_id;
                $resp  = mysql_query($query);
                $i=0;
                $subCategories=array();
                while($subCat = mysql_fetch_array($resp,MYSQL_ASSOC)) {
                        //traigo nombre de la subcategoria			
                        $query = "SELECT value FROM catalog_category_entity_varchar 
                                  WHERE entity_id = ".$subCat['entity_id']." AND attribute_id = '41'";
                        $resp  = mysql_query($query);			
                        while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
                                $nomSub= $dato['value'];	
                        }	
                        //traigo imagen de la subcategoria	  
                        $query = "SELECT value FROM catalog_category_entity_varchar 
                                  WHERE entity_id = ".$subCat['entity_id']." AND attribute_id = '45'";
                        $resp  = mysql_query($query);			
                        while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
                                $imgSub= $dato['value'];	
                        }
                        $subCategories['name'] = $nomSub;
                        $subCategories['id'] = $subCat['entity_id'];
                        $subCategories['image'] = $imgSub;	
                        $categories[$entity_id]["subCategories"] = $subCategories;
                        mysql_free_result($resp);
                }
	
        }
	return $categories;
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
function cargarProductos($category = NULL,$subCategory= NULL){		
	$getAllCat = FALSE;
        $getAllSubCat = FALSE;
	if(is_null($category)){
                $getAllCat = TRUE;//tiene que traer todos los productos de todas las categorias!		
        }
        if(is_null($subCategory)){
                $getAllSubCat = TRUE;//tiene que traer todos los productos de todas las subcategorias!		
        }
		
		
	$id_con=mysql_connect("localhost","root","");//Nombre del server, usuario, contraseña
	mysql_select_db("magento",$id_con);//Nomber de la base de datos, como me conecto
	
	if(!$getAllCat){
		//traigo los productos asociados a la categoria
		$query = "SELECT product_id FROM catalog_category_product WHERE category_id = ".$category;
	}else{
		//traigo todas las categorias padre
		$query = "SELECT entity_id FROM catalog_product_entity";
	}	
	$response = mysql_query($query);
	
	//Vector donde guardo toda la info de cada producto y despues voy a mostrar
	$productos = array();

	$products_entities = array();
	$i = 0;	
	while ($dato = mysql_fetch_array($response,MYSQL_ASSOC)) {
		if(!$getAllCat){ 
                    $products_entities[$i] = $dato['product_id']; 		
                } else {
                    $products_entities[$i] = $dato['entity_id'];
                }
		$i++;	
	}	
	
	foreach($products_entities as $entity){

		//****IMAGEN****
		$imgs=array();
                $query = "SELECT value FROM catalog_product_entity_media_gallery WHERE entity_id = ".$entity." AND attribute_id = '88'";
		$resp= mysql_query($query);
		while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 		$imgs[]= $dato['value'];	
		}	
		//****IMAGEN****	
			
		//****NOMBRE PRODUCTO****
		$query = "SELECT value FROM catalog_product_entity_varchar WHERE entity_id = ".$entity." AND attribute_id = '71'";
		$resp  = mysql_query($query);
 		while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 		$nom= $dato['value'];	
		}	
		//****NOMBRE PRODUCTO****	
		
		//****PRECIO****
		$query = "SELECT value FROM catalog_product_entity_decimal WHERE entity_id = ".$entity." AND attribute_id = '75'";
		$resp  = mysql_query($query);
 		while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 		$price= $dato['value'];	
		}	
		//****PRECIO****	
		
		
		$productos[$entity]["name"] = $nom;
		$productos[$entity]["image"] = $img;
		$productos[$entity]["price"] = $price;
                mysql_free_result($resp);	
	}

		//traigo las subcategorias
                if(!$getAllSubCat){
                    $query = "SELECT entity_id FROM catalog_category_entity WHERE parent_id = ".$category;
                }else {
                    $query = "SELECT entity_id FROM catalog_category_entity";
                }
		$resp  = mysql_query($query);
 		$i=0;
		$subCategories=array();
		while($subCat = mysql_fetch_array($resp,MYSQL_ASSOC)) {
			//traigo nombre de la subcategoria			
							
			$query = "SELECT value FROM catalog_category_entity_varchar 
			          WHERE entity_id = ".$subCat['entity_id']." AND attribute_id = '41'";
			$resp  = mysql_query($query);			
			while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 			$nomSub= $dato['value'];	
			}	
                        //traigo imagen de la subcategoria	  
			$query = "SELECT value FROM catalog_category_entity_varchar 
			          WHERE entity_id = ".$subCat['entity_id']." AND attribute_id = '45'";
			$resp  = mysql_query($query);			
			while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 			$imgSub= $dato['value'];	
                        }	
		
		}//fin foreach de categorias	
		$subCatEntity=$subCat['entity_id'];		
		$subCategories[$subCatEntity]['name'] = $nomSub;
                if(isset($imgSub)) {
                    $subCategories[$subCatEntity]['image'] = $imgSub;
                }
	mysql_free_result($resp);
        
        array_push($productos, $subCategories);
        return $productos;
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