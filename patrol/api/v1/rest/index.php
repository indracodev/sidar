<?php
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    echo($_PUT['var']);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$_DELETE);
    echo($_DELETE['var']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo($_POST['var']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo($_GET['var']);
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"),$_PATCH);
    echo($_PATCH['var']);
}