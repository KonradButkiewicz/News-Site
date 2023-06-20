<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: lightgrey;
        }
        .login-container {
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
        input[type="password"] {
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }
        .error-message {
            color: #ff0000;
        }
        .login-btn {
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
<div class="login-container">
    <h1> <a href="NewsMainPage.php">STRONA GŁOWNA </a></h1>
    <h2>Logowanie</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <?php if (isset($loginError)) { ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php } ?>
        <button class="login-btn" type="submit" name="login">Zaloguj</button>
        <a href="NewsMainPage.php">Strona glowna</a>
        <a href="Register.php">Rejestracja</a>
    </form>
</div>
</body>
</html>

<?php
session_start();

$servername = "szuflandia.pjwstk.edu.pl";
$username = "s27813";
$password = "Kon.Butk";
$dbname = "s27813";

if (isset($_SESSION['username'])) {
    header("Location: NewsMainPage.php");
    exit();
}

if (isset($_POST['login'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: NewsMainPage.php");
        exit();
    } else {
        $loginError = "Nieprawidłowy login lub hasło.";
    }

    $conn->close();
}
?>

