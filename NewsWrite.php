<!DOCTYPE html>
<html>
<head>
    <title>Dodaj nowy news</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: lightgrey;
        }
        .newswrite-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }
        .add-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="newswrite-container">
    <h1> <a href="NewsMainPage.php">STRONA GŁOWNA </a></h1>
    <h2>Dodaj nowy news</h2>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
    <label>Tytuł:</label><br>
    <input type="text" name="title" required><br><br>
    <label>Treść:</label><br>
    <textarea name="content" rows="4" cols="50" required></textarea><br><br>
    <label>Zdjęcie:</label><br>
    <input type="file" name="image" ><br><br>
    <button class="add-btn" type="submit" name="add">Dodaj news</button>
</form>
    <br>
<a href="NewsMainPage.php">Powrót do strony głównej</a>
</div>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27813";
    $password = "Kon.Butk";
    $dbname = "s27813";

    $title = $_POST["title"];
    $content = $_POST["content"];

    $image = file_get_contents($_FILES['image']['tmp_name']);
    $image = addslashes($image);

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $date = date("Y-m-d H:i:s"); // Aktualna data i godzina

    $maxIdQuery = "SELECT MAX(id) AS maxId FROM newsy";
    $maxIdResult = $conn->query($maxIdQuery);
    $row = $maxIdResult->fetch_assoc();
    $nextId = $row['maxId'] + 1;

    $sql = "INSERT INTO newsy (id, title, content, datetime, img) VALUES ('$nextId', '$title', '$content', '$date', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowy news został dodany.";
        echo "<br>";
        exit();
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
