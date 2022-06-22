<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $postRef = $_DELETE['ref'];

    if (isset($postRef) && !empty($postRef) && $postRef != 'undefined') {
        $sql = $conn->prepare("DELETE FROM tb_person WHERE personId = ?");
        $sql->bind_param('s', $postRef);
        if ($sql->execute() === TRUE) {
            $output->status = 'success';
            echo(json_encode($output));
        } else {
            $output->status = 'failed';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $postPerson = $_PUT['person'];
    $postRef = $_PUT['ref'];

    if (isset($postPerson) && !empty($postPerson) && $postPerson != 'undefined' &&
        isset($postRef) && !empty($postRef) && $postRef != 'undefined') {
        $sql = $conn->prepare("UPDATE tb_person SET personName=? WHERE personId = ?");
        $sql->bind_param('ss', $postPerson, $postRef);
        if ($sql->execute() === TRUE) {
            $output->status = 'success';
            echo(json_encode($output));
        } else {
            $output->status = 'failed';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"),$_PATCH);
    $postId = $_PATCH['id'];

    if (isset($postId) && !empty($postId) && $postId != 'undefined') {
        $sql = $conn->prepare("SELECT personName FROM tb_person WHERE personId = ?");
        $sql->bind_param('s', $postId);
        $sql->execute();
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personId = $_POST['id'];
    $personName = strtolower($_POST['name']);
    $userHash = $_POST['hash'];
    $postDevice = $_POST['device'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($personName) && !empty($personName) && $personName != 'undefined') {
        $query;
        switch ($postDevice) {
            case 'web':
                $query = "SELECT userId FROM tb_users WHERE hashWeb = ?";
                break;
            case 'mobile':
                $query = "SELECT userId FROM tb_users WHERE hashMobile = ?";
                break;
        }
        $sqlCheck = $conn->prepare($query);
        $sqlCheck->bind_param('s', $userHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            $nameCheck = $conn->prepare("SELECT personName FROM tb_person WHERE personName = ?");
            $nameCheck->bind_param('s', $personName);
            $nameCheck->execute();
            $nameResult = $nameCheck->get_result();
            if ($nameResult->num_rows > 0) {
                $output->status = 'exist';
                echo(json_encode($output));
            } else {
                $personCheck = $conn->prepare("SELECT personId FROM tb_person WHERE personId = ?");
                $personCheck->bind_param('s', $personId);
                $personCheck->execute();
                $personResult = $personCheck->get_result();
                if ($personResult->num_rows > 0) {
                    $query;
                    switch ($postDevice) {
                        case 'web':
                            $query = "SELECT userName FROM tb_users WHERE hashWeb = ?";
                            break;
                        case 'mobile':
                            $query = "SELECT userName FROM tb_users WHERE hashMobile = ?";
                            break;
                    }
                    $userCheck = $conn->prepare($query);
                    $userCheck->bind_param('s', $userHash);
                    $userCheck->execute();
                    $userResult = $userCheck->get_result();
                    if ($userResult->num_rows > 0) {
                        while ($rowUser = $userResult->fetch_assoc()) {
                            $userName = $rowUser['userName'];
                            $sql = $conn->prepare("UPDATE tb_person SET personName = ?, userName = ? WHERE personId = ?");
                            $sql->bind_param('sss', $personName, $userName, $personId);
                            if ($sql->execute() === TRUE) {
                                $output->status = 'success';
                                echo(json_encode($output));
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        }
                    } else {
                        $output->status = 'false';
                        echo(json_encode($output));
                    }
                } else {
                    $query;
                    switch ($postDevice) {
                        case 'web':
                            $query = "SELECT userName FROM tb_users WHERE hashWeb = ?";
                            break;
                        case 'mobile':
                            $query = "SELECT userName FROM tb_users WHERE hashMobile = ?";
                            break;
                    }
                    $userCheck = $conn->prepare($query);
                    $userCheck->bind_param('s', $userHash);
                    $userCheck->execute();
                    $userResult = $userCheck->get_result();
                    if ($userResult->num_rows > 0) {
                        while ($rowUser = $userResult->fetch_assoc()) {
                            $userName = $rowUser['userName'];
                            $sql = $conn->prepare("INSERT INTO tb_person (personId, personName, userName) VALUES (?, ?, ?)");
                            $sql->bind_param('sss', $personId, $personName, $userName);
                            if ($sql->execute() === TRUE) {
                                $output->status = 'success';
                                echo(json_encode($output));
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        }
                    } else {
                        $output->status = 'false';
                        echo(json_encode($output));
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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];
    $postDevice = $_GET['device'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined' &&
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
        $sqlCheck = $conn->prepare($query);
        $sqlCheck->bind_param('s', $postHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            $sql = $conn->prepare("SELECT personName, personId, lastUpdated  FROM tb_person");
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $personArray = [];
                $person = new stdClass();
                while ($row = $result->fetch_assoc()) {
                    $personArray[] = (object) [
                        ref => $row['personId'],
                        name => $row['personName'],
                        update => $row['lastUpdated'],
                    ];
                }
                $output->status = 'success';
                $output->person = $personArray;
                echo(json_encode($output));
            } else {
                $output->status = 'failed';
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