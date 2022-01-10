<?php
// prikazi greske
ini_set('display_errors', 1);
error_reporting(E_ALL);
  
// home page url
$home_url="http://localhost/api/";
  
// stranica iz URL parametara, default stranica je 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
  
// podesi broj podataka po strani
$records_per_page = 5;
  
// racunanje query LIMIT klauzule
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>