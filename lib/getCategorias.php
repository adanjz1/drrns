<?php
function getCategorias(){
	$id_con=mysql_connect("localhost","root","");//Nombre del server, usuario, contraseña
	mysql_select_db("magento",$id_con);//Nomber de la base de datos, como me conecto
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
?>