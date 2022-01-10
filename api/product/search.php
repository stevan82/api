<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// ukljuci database i ostale klase
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';
  
// instanciraj database i product objekat
$database = new Database();
$db = $database->getConnection();
  
// inicijalizuj objekat
$product = new Product($db);
  
// preuzmi keywordse
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// aktiviraj upit
$stmt = $product->search($keywords);
$num = $stmt->rowCount();
  
// proveri da li je vise od 0 redova pronadjeno
if($num>0){
  
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
  
    // preuzmi listu redova
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // ekstraktuj red
        // ovo ce napraviti da $row['name'] bude
        // samo $name 
        extract($row);
  
        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
  
        array_push($products_arr["records"], $product_item);
    }
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // prikazi podatke u vidu jsona
    echo json_encode($products_arr);
}
  
else{
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // reci korisniku da proizvodi nisu pronadjeni
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>