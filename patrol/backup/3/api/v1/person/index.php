<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $personId = $_DELETE['id'];
    $userHash = $_DELETE['hash'];

    if (isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("SELECT personName FROM tb_person WHERE personId = ?");
                $sql->bind_param('s', $personId); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    while ($rowPerson = $result->fetch_assoc()) {

                        $newName = $rowPerson['personName'].' DELETED';
                        $sql = $conn->prepare("UPDATE tb_person SET personStatus = '0', personName = ?, userName = ? WHERE personId = ?"); $sql->bind_param('sss', $newName, $rowUser['userName'], $personId);
                        if ($sql->execute() === TRUE) {
                            $output->status = 'success';
                            echo(json_encode($output));
                        } else {
                            $output->status = 'failed';
                            $output->action = 'update';
                            echo(json_encode($output));
                        }

                    }
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }

            }
        } else {
            $output->status = 'false';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $personName = $_PUT['person'];
    $personId = $_PUT['id'];
    $userHash = $_PUT['hash'];

    if (isset($personName) && !empty($personName) && $personName != 'undefined' &&
        isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("UPDATE tb_person SET personName = ?, userName = ? WHERE personId = ?"); $sql->bind_param('sss', $personName, $rowUser['userName'], $personId);
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'update';
                    echo(json_encode($output));
                }

            }
        } else {
            $output->status = 'false';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"),$_PATCH);
    $personId = $_PATCH['id'];

    if (isset($personId) && !empty($personId) && $personId != 'undefined') {
        $sql = $conn->prepare("SELECT personName FROM tb_person WHERE personId = ?");
        $sql->bind_param('s', $personId); $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $output->status = 'success';
                $output->person = ucfirst($row['personName']);
                echo(json_encode($output));

            }
        } else {
            $output->status = 'false';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personName = strtolower($_POST['name']);
    $userHash = $_POST['hash'];

    if (isset($personName) && !empty($personName) && $personName != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("SELECT personName FROM tb_person WHERE personName = ?");
                $sql->bind_param('s', $personName);
                $sql->execute();
                $nameResult = $sql->get_result();
                if ($nameResult->num_rows > 0) {
                    $output->status = 'exist';
                    echo(json_encode($output));
                } else {
                    $sql = $conn->prepare("SELECT personId FROM tb_person ORDER BY uid DESC LIMIT 1"); $sql->execute();
                    $personResult = $sql->get_result();
                    if ($personResult->num_rows > 0) {
                        while ($row = $personResult->fetch_assoc()) {

                            $personId = (int)$row['personId'] + 1;
                            $sql = $conn->prepare("INSERT INTO tb_person (personId, personName, personStatus, userName) VALUES (?, ?, '1', ?)"); $sql->bind_param('iss', $personId, $personName, $rowUser['userName']);
                            if ($sql->execute() === TRUE) {
                                $output->status = 'success';
                                echo(json_encode($output));
                            } else {
                                $output->status = 'failed';
                                $output->action = 'insert';
                                echo(json_encode($output));
                            }

                        }
                    } else {
                        $personId = '1';
                        $sql = $conn->prepare("INSERT INTO tb_person (personId, personName, personStatus, userName) VALUES (?, ?, '1', ?)"); $sql->bind_param('iss', $personId, $personName, $rowUser['userName']);
                        if ($sql->execute() === TRUE) {
                            $output->status = 'success';
                            echo(json_encode($output));
                        } else {
                            $output->status = 'failed';
                            $output->action = 'insert';
                            echo(json_encode($output));
                        }
                    }
                }

            }
        } else {
            $output->status = 'false';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $postDevice = $_GET['device'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($postDevice) && !empty($postDevice) && $postDevice != 'undefined') {
        $query;
        switch ($postDevice) {
            case 'web':
                $query = "SELECT userId FROM tb_users WHERE hashWeb = ?";
                break;
            case 'mobile':
                $query = "SELECT userId FROM tb_users WHERE hashMobile = ?";
                break;
        }
        $sql = $conn->prepare($query); $sql->bind_param('s', $userHash); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            $sql = $conn->prepare("SELECT personName, personId, lastUpdated  FROM tb_person WHERE personStatus = '1'");
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $personArray = [];
                while ($row = $result->fetch_assoc()) {
                    $personArray[] = (object) [
                        ref => $row['personId'],
                        name => ucfirst($row['personName']),
                        update => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                    ];
                }
                $output->status = 'success';
                $output->person = $personArray;
                echo(json_encode($output));
            } else {
                $output->status = 'false';
                echo(json_encode($output));
            }
        } else {
            $output->status = 'unauth';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}