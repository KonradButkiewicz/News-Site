<!DOCTYPE html>
<html>
<head>
    <title>Rejestracja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: lightgrey;
        }

        .register-container {
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

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .error-message {
            color: #ff0000;
        }

        .register-btn {
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
<div class="register-container">
    <h1><a href="NewsMainPage.php">STRONA GŁOWNA</a></h1>
    <h2>Rejestracja</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Imię:</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="form-group">
            <label>Nazwisko:</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <?php if (isset($registerError)) { ?>
            <p class="error-message"><?php echo $registerError; ?></p>
        <?php } ?>
        <button class="register-btn" type="submit" name="register">Zarejestruj</button>
        <a href="Login.php">Logowanie</a>
        <a href="NewsMainPage.php">Strona główna</a>
    </form>
</div>
</body>
</html>

<?php
$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27813";
$password = "Kon.Butk";
$dbname = "s27813";

if (isset($_POST['register'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $checkUsernameQuery = "SELECT id FROM user WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    if ($checkUsernameResult->num_rows > 0) {
        $registerError = "Nazwa użytkownika już istnieje.";
    } else {
        $sql = "INSERT INTO user (id, first_name, last_name, username, password, email) VALUES (NULL, '$firstName', '$lastName', '$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            header("Location: NewsMainPage.php");
            exit();
        } else {
            $registerError = "Wystąpił błąd podczas rejestracji.";
        }
    }

    $conn->close();
}
?>
