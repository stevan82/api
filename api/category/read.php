<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// ukljuci database i category klase
include_once '../config/database.php';
include_once '../objects/category.php';
  
// instanciraj database i category objekte
$database = new Database();
$db = $database->getConnection();
  
// inicijalizuj objekat
$category = new Category($db);
  
// pokreni upit
$stmt = $category->read();
$num = $stmt->rowCount();
  
// proveri da li je vise od 0 redova pronadjeno
if($num>0){
  
    // niz kategorija
    $categories_arr=array();
    $categories_arr["records"]=array();
  
    // preuzmi listu podataka

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // ekstraktuj red
        // ovo ce napraviti da $row['name'] bude
        // samo $name
        extract($row);
  
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
        );
  
        array_push($categories_arr["records"], $category_item);
    }
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // prikazi podatke o kategorijama u json formatu
    echo json_encode($categories_arr);
}
  
else{
  
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // posalji poruku korisniku da kategorije nisu pronadjene
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>