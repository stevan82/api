<?php
class Category{
  
    // konekcija na bazu i ime tabele
    private $conn;
    private $table_name = "categories";
  
    // property objekta
    public $id;
    public $name;
    public $description;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // koristi select drop-down lista
    public function readAll(){
        //selektuj sve podatke
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }
	// koristi select drop-down lista
public function read(){
  
    //selektuj sve podatke
    $query = "SELECT
                id, name, description
            FROM
                " . $this->table_name . "
            ORDER BY
                name";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
  
    return $stmt;
}
// koristi se kada se popunjava update forma za kategoriju
function readOne(){
  
    // upit koji cita jedan proizvod
    $query = "SELECT
                p.id,p.name, p.description
            FROM
                " . $this->table_name . " p
                
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
    $this->description = $row['description'];
    $this->id = $row['id'];
    
}
// updateovanje kategorije
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,                
                description = :description,
                id = :id
            WHERE
                id = :id";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizacija
    $this->name=htmlspecialchars(strip_tags($this->name));    
    $this->description=htmlspecialchars(strip_tags($this->description));    
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // binduj izmenjene vrednosti
    $stmt->bindParam(':name', $this->name);    
    $stmt->bindParam(':description', $this->description);    ;
    $stmt->bindParam(':id', $this->id);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

// obrisi kategoriju
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
// kreiraj kategoriju
function create(){
  
    // upit za insertovanje podatka
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name,  description=:description, created=:created";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizacija
    $this->name=htmlspecialchars(strip_tags($this->name));;
    $this->description=htmlspecialchars(strip_tags($this->description));    
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // binduj vrednosti
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":description", $this->description); 
    $stmt->bindParam(":created", $this->created);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

}
?>