<?php

use Dotenv\Dotenv;

require_once './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once './includes/main.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather forecast</title>
    <link rel="stylesheet" href="./css/resets.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <main class="wrapper">
        <div class="container">
            <h1>Weather <b>Forecast</b></h1>
            <form action="" method="get">
                <input type="text" name="city" id="text" placeholder="New York">
                <button type="submit" name="submit" class="btn">Search</button>
            </form>
            <?php if (isset($error)) {
                echo "<p class='error-msg'>$error</p>";
            } ?>

            <section class="top-bar">
                <?php
                if (isset($weatherData))

                ?>
            </section>
            <section class="main-content"></section>


        </div>
    </main>
</body>

</html>