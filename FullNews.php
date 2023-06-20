<!DOCTYPE html>
<html>
<head>
    <title>Pełny artykuł</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: lightgrey;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            line-height: 1.5;
        }
        .delete-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn {
            background-color: #0000ff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-btn {
            background-color: #ccc;
            color: #000;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><a href="NewsMainPage.php">STRONA GŁOWNA</a></h1>
    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: Login.php");
        exit();
    }


    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27813";
    $password = "Kon.Butk";
    $dbname = "s27813";

    function isAdminLoggedIn()
    {
        return isset($_SESSION['username']) && $_SESSION['username'] === 'admin';
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: NewsMainPage.php");
        exit();
    }

    if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM newsy WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image = $row["img"];
    ?>

    <?php
    if (isset($_SESSION['username'])) {
        echo "Witaj " . $_SESSION['username'] . "!";
        echo "<br><br>";
        echo "<a href='?logout=true' class='logout-btn'>Wyloguj</a>";
        echo "<br><br>";
    }
    ?>

    <h2><?php echo $row["title"]; ?></h2>

    <?php
    if (!empty($image)) {
        echo "<img src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Obrazek' style='max-width: 500px; max-height: 500px;'><br>";
    }
    ?>

    <p><?php echo $row["content"]; ?></p>

    <?php
    if (isAdminLoggedIn()) {
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<button class='delete-btn' type='submit' name='delete'>Usuń artykuł</button>";
        echo "</form>";
    }
    ?>

    <br>
    <button onclick="history.go(-1);" class="back-btn">Wróć do poprzedniej strony</button>
</div>
</body>
</html>

<?php
} else {
    echo "Artykuł o podanym ID nie został znaleziony.";
}
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if (isAdminLoggedIn()) {
        $deleteSql = "DELETE FROM newsy WHERE id = $id";

        if ($conn->query($deleteSql) === TRUE) {
            echo "Artykuł został pomyślnie usunięty.";
            header("Location: NewsMainPage.php");
            exit();
        } else {
            echo "Wystąpił błąd podczas usuwania artykułu: " . $conn->error;
        }
    } else {
        echo "Brak uprawnień do usunięcia artykułu.";
    }
}

$conn->close();
?>
</div>
</body>
</html>
