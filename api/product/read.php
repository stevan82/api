<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// ukljuci database i product fajlove
include_once '../config/database.php';
include_once '../objects/product.php';
  
// instanciranje database i product objekta
$database = new Database();
$db = $database->getConnection();
  
// inicijalizacija objekta
$product = new Product($db);
  
// upit za citanje proizvoda
$stmt = $product->read();
$num = $stmt->rowCount();
  
// proveri da li ima vise od 0 redova
if($num>0){
  
    // products niz
    $products_arr=array();
    $products_arr["records"]=array();
  
    // retrieve our table contents   
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // ekstraktuj red
        // ovo ce pretvoriti $row['name'] u
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
  
    // prikazi podatke o proizvodima u json formatu
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