<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// ukljuci database i product klase
include_once '../config/database.php';
include_once '../objects/product.php';
  
// prezmi konekciju na bazu
$database = new Database();
$db = $database->getConnection();
  
// pripremi product objekat
$product = new Product($db);
  
// preuzmi id proizvoda iz jsona
$data = json_decode(file_get_contents("php://input"));
  
// podesi id proizvoda
$product->id = $data->id;
  
// obrisi proizvod
if($product->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Product was deleted."));
}
  
// ako proizvod ne moze da se obrise
else{
  
    // podesi response code - 503 service unavailable
    http_response_code(503);
  
    // posalji poruku korisniku
    echo json_encode(array("message" => "Unable to delete product."));
}
?>