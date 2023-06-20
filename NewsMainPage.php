<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
    <style>
        .container {
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            background-color: lightgrey;
        }
        h1 {
            margin-bottom: 20px;
        }
        .links {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: #fff;
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
    <div class="links">
        <a href="NewsWrite.php">Dodaj nowy news</a>
        <a href="Login.php">Logowanie</a>
        <a href="Register.php">Rejestracja</a>
        <a href="UserPanel.php">Przejdz do panelu uzytkownika</a>
    </div>

    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: Login.php");
        exit();
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: Login.php");
        exit();
    }
    ?>

    <h2>Witaj, <?php echo $_SESSION['username']; ?>!</h2>
    <form method="POST" action="">
        <button class="logout-btn" type="submit" name="logout">Wyloguj</button>
    </form>

    <?php
    $servername = "szuflandia.pjwstk.edu.pl";
    $username = "s27813";
    $password = "Kon.Butk";
    $dbname = "s27813";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Blad polaczenia: " . $conn->connect_error);
    }

    $newsPerPage = 3;

    $currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($currentpage - 1) * $newsPerPage;

    $sql = "SELECT * FROM newsy ORDER BY datetime DESC LIMIT $offset, $newsPerPage";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $title = $row["title"];
            $content = $row["content"];
            $datetime = $row["datetime"];
            $image = $row["img"];
            $timestamp = strtotime($datetime);
            $formattedDateTime = date('d.m.Y H:i', $timestamp);

            echo "<div>";
            echo "<h2>$title</h2>";
            echo "<p>" . substr($content, 0, 50) . "...</p>";

            echo "<p>Data publikacji: $formattedDateTime</p>";

            // wyswietlanie obrazka tylko jesli istnieje
            if (!empty($image)) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Obrazek' style='max-width: 500px; max-height: 500px;'><br>";
            }

            echo "<a href='FullNews.php?id=$id'>Czytaj więcej</a>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "Brak newsow";
    }

    $totalNewsQuery = "SELECT COUNT(*) AS total FROM newsy";
    $totalNewsResult = $conn->query($totalNewsQuery);
    $totalNews = $totalNewsResult->fetch_assoc()['total'];

    $totalPages = ceil($totalNews / $newsPerPage);

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='NewsMainPage.php?page=$i'>$i</a> ";
    }

    $conn->close();
    ?>
</div>
</body>
</html>