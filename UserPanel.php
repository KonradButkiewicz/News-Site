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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $email = $row['email'];
} else {
    echo "ERROR: Nie można pobrać danych użytkownika.";
}

if (isset($_POST['save'])) {
    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newEmail = $_POST['email'];

    $updateSql = "UPDATE user SET first_name = '$newFirstName', last_name = '$newLastName', email = '$newEmail' WHERE username = '$username'";
    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['success_message'] = "Zmiany zostały zapisane.";
        header("Location: UserPanel.php");
        exit();
    } else {
        echo "ERROR: Nie można zaktualizować danych użytkownika.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel użytkownika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: lightgrey;
        }

        .profile-container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .save-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h1><a href="NewsMainPage.php">STRONA GŁOWNA</a></h1>
    <h2>Profil użytkownika</h2>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']);
    }
    ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Imię:</label>
            <input type="text" name="first_name" value="<?php echo $firstName; ?>" required>
        </div>
        <div class="form-group">
            <label>Nazwisko:</label>
            <input type="text" name="last_name" value="<?php echo $lastName; ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $email; ?>" required>
        </div>
        <button class="save-btn" type="submit" name="save">Zapisz</button>
    </form>
    <br>
    <a href="NewsMainPage.php">Powrót do strony głównej</a>
</div>
</body>
</html>
