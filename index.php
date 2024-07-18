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

            <section class="topbar">
                <?php
                // Celsius = Kelvin - 273.15
                if (isset($weatherData)) {
                    echo "
                    <div class='topbar-top'>
                        <div class='date-wrapper topbar-top-left'>
                            <div class='date-container'>
                                <p class='date'>" . substr($weatherData[0][0]['dt_txt'], 0, 10) . "</p>
                                <p class='date date-sub'>Today</p>
                            </div>
                            <div class='temp-container'>
                                <div class='temp-max'>
                                    <p class='temp'>" . round($weatherData[0][0]['main']['temp_max'] - 273.15) . "</p>
                                </div>
                                <div class='temp-min'>
                                    <p class='temp'>" . round($weatherData[0][0]['main']['temp_min'] - 273.15) . "</p>
                                </div>
                            </div>
                        </div>
                        <div class='date-wrapper topbar-top-right'>
                            <div class='date-container'>
                                <p class='date'>" . substr($weatherData[1][0]['dt_txt'], 0, 10) . "</p>
                                <p class='date date-sub'>Tommorow</p>
                            </div>
                            <div class='temp-container'>
                                <div class='temp-max'>
                                    <p class='temp'>" . round($weatherData[1][0]['main']['temp_max'] - 273.15) . "</p>
                                </div>
                                <div class='temp-min'>
                                    <p class='temp'>" . round($weatherData[1][0]['main']['temp_min'] - 273.15) . "</p>
                                </div>
                            </div>
                        </div>
                    </div>";
                    foreach ($weatherData[0] as $todayData) {
                        echo "<div>
                        <p>" . '' . "</p>
                        <p></p>
                        </div>";
                    }
                }
                ?>
            </section>
            <section class="main-content"></section>


        </div>
    </main>
</body>

</html>