<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'myFunction' && isset($_POST['param'])) {
        myFunction($_POST['param']);
    }
}
function myFunction($param)
{
    echo $param;
}
