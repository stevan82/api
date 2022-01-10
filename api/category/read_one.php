<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// ukljuci database i category klase
include_once '../config/database.php';
include_once '../objects/category.php';
  
// preuzmi database konekciju
$database = new Database();
$db = $database->getConnection();
  
// pripremi category objekat
$category = new Category($db);
  
// podesi id property proizvoda za citanje
$category->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// procitaj detalje proizvoda
$category->readOne();
  
if($category->name!=null){
    // kreiraj niz
    $category_arr = array(
        "id" =>  $category->id,
        "name" => $category->name,
        "description" => $category->description  
    );
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // ispisi u json formatu
    echo json_encode($category_arr);
}
  
else{
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // reci korisniku da proizvod ne postoji
    echo json_encode(array("message" => "Category does not exist."));
}
?>