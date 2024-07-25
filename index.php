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
    <script src="./includes/eventHandler/eventHandler.js" defer></script>
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
                <?php if (isset($weatherData)) : ?>
                    <?php
                    $minMaxDayTempArr = handleHighLowDayTemp($weatherData);
                    for ($i = 0; $i < count($minMaxDayTempArr[0]); $i++) : ?>
                        <div class='card' id="currentDay" data-param='<?php echo $i; ?>'>
                            <div class='card-top'>
                                <div class='date-container'>
                                    <p class='date'><?= substr($weatherData[$i][0]['dt_txt'], 0, 10); ?></p>
                                    <p class='date date-day'>
                                        <?php
                                        $day = $i == 0 ? "Today" : ($i == 1 ? "Tomorrow" : "");
                                        ?>
                                        <?= $day; ?>
                                    </p>
                                </div>
                                <div class='temp-container'>
                                    <div class='temp-high-container'>
                                        <p>
                                            <b>
                                                <?php
                                                if (round($minMaxDayTempArr[1][$i]) > 0) echo '+';
                                                echo round($minMaxDayTempArr[1][$i]);
                                                ?>
                                            </b>
                                            &deg;C
                                        </p>
                                    </div>
                                    <div class='temp-low-container'>
                                        <p>
                                            <b>
                                                <?php
                                                if (round($minMaxDayTempArr[0][$i]) > 0) echo '+';
                                                echo round($minMaxDayTempArr[0][$i]);
                                                ?>
                                            </b>
                                            &deg;C
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class='card-bottom'>

                            </div> -->
                        </div>
                    <?php endfor; ?>
            </section>
            <section class="main-content">
                <div class="content-first-container">

                </div>
            </section>
        <?php endif; ?>


        </div>
    </main>
</body>

</html>