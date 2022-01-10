<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// ukljuci database i ostale klase
include_once '../config/database.php';
include_once '../objects/category.php';
  
// preuzmi konekciju na bazu
$database = new Database();
$db = $database->getConnection();
  
// pripremi product objekat
$category = new Category($db);
  
// preuzmi id proizvoda koji ce biti izmenjen
$data = json_decode(file_get_contents("php://input"));
  
// setuj ID property proizvoda koji se menja
$category->id = $data->id;
  
// setuj propertije proizvoda
$category->name = $data->name;
$category->description = $data->description;
$category->id = $data->id;
  
// izmeni proizvod u bazi
if($category->update()){
  
    // podesi response code - 200 ok
    http_response_code(200);
  
    // posalji poruku korisniku da su podaci izmenjeni
    echo json_encode(array("message" => "Product was updated."));
}
  
// ako izmena proizvoda nije uspela posalji poruku korisniku
else{
  
    // podesi response code - 503 service unavailable
    http_response_code(503);
  
    // posalji poruku korisniku da izmena nije obavljena
    echo json_encode(array("message" => "Unable to update product."));
}
?>