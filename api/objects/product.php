<?php
class Product{
  
    // database konekcije i ime tabele
    private $conn;
    private $table_name = "products";
  
    // svojstva objekta
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
  
    // konstruktor sa $db kao database konekcija
    public function __construct($db){
        $this->conn = $db;
    }
	// citaj proizvode
function read(){
  
    // upit koji selektuje sve
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // izvrsi upit
    $stmt->execute();
  
    return $stmt;
}

// kreiraj proizvod
function create(){
  
    // upit za insertovanje podatka
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizacija
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // binduj vrednosti
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
// koristi se kada se popunjava update forma za proizvod
function readOne(){
  
    // upit koji cita jedan proizvod
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
  
    // pripremi upit
    $stmt = $this->conn->prepare( $query );
  
    // binduj id proizvoda koji se cita
    $stmt->bindParam(1, $this->id);
  
    // izvrsi upit
    $stmt->execute();
  
    // preuzmi red iz baze
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // setuj vrednosti propertiju objekta
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}
// updateovanje proizvoda
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizacija
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // binduj izmenjene vrednosti
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// obrisi proizvod
function delete(){
  
    // upit za brisanje
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizuj
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // binduj id reda za brisanje
    $stmt->bindParam(1, $this->id);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// pretrazi proizvode
function search($keywords){
  
    // select all query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizuj
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
  
    // izvrsi upit
    $stmt->execute();
  
    return $stmt;
}
// citaj proizvode sa paginacijom
public function readPaging($from_record_num, $records_per_page){
  
    // select upit
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";
  
    // pripremi upit
    $stmt = $this->conn->prepare( $query );
  
    // binduj vrednosti parametara
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  
    // izvrsi upit
    $stmt->execute();
  
    // vrati vrednosti iz baze
    return $stmt;
}
// koristi se za stranicenje proizvoda
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
}
}
?>