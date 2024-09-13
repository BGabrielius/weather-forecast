<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'handleDayChange' && isset($_POST['param'])) {
        handleDayChange($_POST['param']);
    }
}

function handleDayChange($param)
{
    session_start();
    if (isset($_SESSION['curDay']))
        if ($param != $_SESSION['curDay']) {
            $_SESSION['curDay'] = $param;
        }
}
