<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// ukljuci database i product klase
include_once '../config/database.php';
include_once '../objects/product.php';
  
// preuzmi database konekciju
$database = new Database();
$db = $database->getConnection();
  
// pripremi product objekat
$product = new Product($db);
  
// podesi id property proizvoda za citanje
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// procitaj detalje proizvoda
$product->readOne();
  
if($product->name!=null){
    // kreiraj niz
    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category_id" => $product->category_id,
        "category_name" => $product->category_name
  
    );
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // ispisi u json formatu
    echo json_encode($product_arr);
}
  
else{
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // reci korisniku da proizvod ne postoji
    echo json_encode(array("message" => "Product does not exist."));
}
?>