<?php
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
		$query = "SELECT value FROM catalog_product_entity_media_gallery WHERE entity_id = ".$entity." AND attribute_id = '88'";
		$resp= mysql_query($query);
		while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
	 		$img= $dato['value'];	
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
print_r(cargarProductos(7));
?>
