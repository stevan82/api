<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// ukljuci database i ostale klase
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/product.php';
  
// utilities
$utilities = new Utilities();
  
// instanciraj bazu i proizvod
$database = new Database();
$db = $database->getConnection();
  
// inicijalizuj objekat
$product = new Product($db);
  
// aktiviraj upit
$stmt = $product->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// proveri da li je pronadjeno vise od jednog proizvoda
if($num>0){
  
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
    $products_arr["paging"]=array();
  
    // preuzmi podatke
   
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
  
  
    // ukljuci paginaciju
    $total_rows=$product->count();
    $page_url="{$home_url}product/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $products_arr["paging"]=$paging;
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // pretvori ga u json format
    echo json_encode($products_arr);
}
  
else{
  
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // reci korisniku da proizvodi  ne postoje
    echo json_encode(
        array("message" => "No products found.")
    );
}
?>