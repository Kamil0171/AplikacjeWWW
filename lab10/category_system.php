
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sklep_nowy_pluz";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function DodajKategorie($matka, $nazwa) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO categories (matka, nazwa) VALUES (?, ?)");
    $stmt->bind_param("is", $matka, $nazwa);
    $stmt->execute();
}

function UsunKategorie($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

function EdytujKategorie($id, $nazwa) {
    global $conn;
    $stmt = $conn->prepare("UPDATE categories SET nazwa = ? WHERE id = ?");
    $stmt->bind_param("si", $nazwa, $id);
    $stmt->execute();
}

function PokazKategorie() {
    global $conn;
    $result = $conn->query("SELECT * FROM categories");
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Matka: " . $row['matka'] . " - Nazwa: " . $row['nazwa'] . "<br>";
    }
}

// Example Usage
DodajKategorie(0, 'Electronics');
PokazKategorie();
$conn->close();
?>
