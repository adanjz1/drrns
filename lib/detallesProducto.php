<?php
	$id_con=mysql_connect("localhost","root","darriens");//Nombre del server, usuario, contraseña
	mysql_select_db("magento",$id_con);//Nomber de la base de datos, como me conecto
	
	$descProd = array();
	$idProd = $_GET['id'];
	$nomProd = $_GET['name'];
	$category = $_GET['cat'];
	$nomCat = $_GET['nameC'];		
	
	//****NOMBRE DE SUBCATEGORIA****//
	$query = "SELECT category_id FROM catalog_category_product WHERE product_id = ".$idProd;	
	$resp = mysql_query($query);
	$idsCats=array();
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
		$idsCats[]= $dato['category_id'];	
		
	}
	//parseo y lo paso a un string
	$sep=" ";
	foreach($idsCats as $id){
		$ids.=$sep.$id;
		$sep = ",";
	}
	$query = "SELECT id_entity FROM catalog_category_entity WHERE entity_id IN(".$ids.") AND level = 2 LIMIT 1 ";
	$resp = mysql_query($query);
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
		$idSub=$dato['entity_id'];	
	}
	//traigo el nombre de la subcategoria
	$query = "SELECT value FROM catalog_category_entity_varchar 
			          WHERE entity_id = ".$subCat['entity_id']." AND attribute_id = '41'";
	$resp  = mysql_query($query);			
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
		$nomSub= $dato['value'];	
	}	
	mysql_free_result($resp);
	
	//****PRECIO****//
	$query = "SELECT value FROM catalog_product_entity_decimal WHERE entity_id = ".$idProd." AND attribute_id = '75'";
	$resp  = mysql_query($query);
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
 		$price= $dato['value'];	
	}	
	
	//****IMAGENES****//
	$imgs = array();	
	$query = "SELECT value FROM catalog_product_entity_media_gallery WHERE entity_id = ".$entity." AND attribute_id = '88'";
	$resp= mysql_query($query);
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
 		$imgs[]= $dato['value'];	
	}	
	//****DESCRIPTION****//
	$query = "SELECT value FROM catalog_product_entity_text WHERE entity_id = ".$idProd." AND attribute_id = '72'";
	$resp  = mysql_query($query);
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
 		$desc= $dato['value'];	
	}	
	//****VIDEOS****//
	$query = "SELECT value FROM catalog_product_entity_text WHERE entity_id = ".$idProd." AND attribute_id = '73'";
	$resp  = mysql_query($query);
	while ($dato = mysql_fetch_array($resp,MYSQL_ASSOC)) {
 		$desc= $dato['value'];	
	}
	$videos=array();
	$links = explode("\n",$desc);
	//agarra todos los links y ponerlos en un array		
        // obtener el valor luego del igual de la url y colocarlo en videos 
	
	mysql_free_result();

	//array Final
	$descProd['name_prod']=$nomProd;
	$descProd['name_category']=$nomCat;
	$descProd['name_subcategory']=$nomSub;
	$descProd['price']=$price;
	$descProd['images']=$imgs;
	$descProd['description']=$desc;			
	$descProd['videos']=$videos;	
	
	return $descProd;
?>
