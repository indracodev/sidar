<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $checkpointId = $_DELETE['id'];
    $userHash = $_DELETE['hash'];

    if (isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            $sql = $conn->prepare("DELETE FROM tb_checkpoint WHERE checkpointId = ?"); $sql->bind_param('s', $checkpointId);
            if ($sql->execute() === TRUE) {
                $output->status = 'success';
                echo(json_encode($output));
            } else {
                $output->status = 'failed';
                $output->action = 'delete';
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
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $checkpointName = $_PUT['checkpoint'];
    $checkpointId = $_PUT['id'];
    $latitude = $_PUT['latitude'];
    $longitude = $_PUT['longitude'];
    $userHash = $_PUT['hash'];

    if (isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("UPDATE tb_checkpoint SET checkpointName = ?, userName = ? WHERE checkpointId = ?"); $sql->bind_param('sss', $checkpointName, $rowUser['userName'], $checkpointId);
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
    } elseif (isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($latitude) && !empty($latitude) && $latitude != 'undefined' &&
        isset($longitude) && !empty($longitude) && $longitude != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("UPDATE tb_checkpoint SET checkLatitude = ?, checkLongitude = ? WHERE checkpointId =?"); $sql->bind_param('sss', $latitude, $longitude, $checkpointId);
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'update';
                    echo(json_encode($output));
                }

            }
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $checkpointId = $_PUT['id'];
    $userHash = $_PUT['hash'];

    if (isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("SELECT checkStatus FROM tb_checkpoint WHERE checkpointId = ?");
                $sql->bind_param('s', $checkpointId); $sql->execute();
                $resultCheck = $sql->get_result();
                if ($resultCheck->num_rows > 0) {
                    while ($row = $resultCheck->fetch_assoc()) {

                        switch ($row['checkStatus']) {
                            case '0':
                                $sql = $conn->prepare("UPDATE tb_checkpoint SET checkStatus = '1', userName = ? WHERE checkpointId=?"); $sql->bind_param('ss', $rowUser['userName'], $checkpointId);
                                if ($sql->execute() === TRUE) {
                                    $output->status = 'success';
                                    echo(json_encode($output));
                                } else {
                                    $output->status = 'failed';
                                    $output->action = 'update';
                                    echo(json_encode($output));
                                }
                                break;
                            case '1':
                                $sql = $conn->prepare("UPDATE tb_checkpoint SET checkStatus = '0', userName = ? WHERE checkpointId=?"); $sql->bind_param('ss', $rowUser['userName'], $checkpointId);
                                if ($sql->execute() === TRUE) {
                                    $output->status = 'success';
                                    echo(json_encode($output));
                                } else {
                                    $output->status = 'failed';
                                    $output->action = 'update';
                                    echo(json_encode($output));
                                }
                                break;
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkpointId = $_POST['id'];
    $checkpointName = strtoupper($_POST['name']);
    $checkLatitude = '-';
    $checkLongitude = '-';
    $userHash = $_POST['hash'];
    $postDevice = $_POST['device'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashMobile = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointName = ?");
                $sql->bind_param('s', $checkpointName); $sql->execute();
                $nameResult = $sql->get_result();
                if ($nameResult->num_rows > 0) {
                    $output->status = 'exist';
                    echo(json_encode($output));
                } else {
                    $sql = $conn->prepare("SELECT checkpointId FROM tb_checkpoint WHERE checkpointId = ?");
                    $sql->bind_param('s', $checkpointId); $sql->execute();
                    $checkpointResult = $sql->get_result();
                    if ($checkpointResult->num_rows > 0) {
                        $sql = $conn->prepare("UPDATE tb_checkpoint SET checkpointName = ?, userName = ?, checkStatus = '0' WHERE checkpointId = ?"); $sql->bind_param('sss', $checkpointName, $rowUser['userName'], $checkpointId);
                        if ($sql->execute() === TRUE) {
                            $output->status = 'success';
                            echo(json_encode($output));
                        } else {
                            $output->status = 'failed';
                            $output->action = 'update';
                            echo(json_encode($output));
                        }
                    } else {
                        $sql = $conn->prepare("INSERT INTO tb_checkpoint (checkpointId, checkpointName, checkStatus, userName) VALUES (?, ?, '0', ?)"); $sql->bind_param('sss', $checkpointId, $checkpointName, $rowUser['userName']);
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
    $postHash = $_GET['hash'];
    $postDevice = $_GET['device'];
    $postId = $_GET['id'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined' &&
        isset($postDevice) && !empty($postDevice) && $postDevice != 'undefined') {
        $query;
        switch ($postDevice) {
            case 'web':
                $query = "SELECT userId FROM tb_users WHERE hashWeb=?";
                break;
            case 'mobile':
                $query = "SELECT userId FROM tb_users WHERE hashMobile=?";
                break;
        }
        $sql = $conn->prepare($query);
        $sql->bind_param('s', $postHash); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            switch ($postDevice) {
                case 'web':
                    $sql = $conn->prepare("SELECT checkpointName, checkpointId, checkLatitude, checkLongitude, checkStatus, lastUpdated  FROM tb_checkpoint"); $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        $checkpointArray = [];
                        while ($row = $result->fetch_assoc()) {
                            switch ($row['checkStatus']) {
                                case '0':
                                    $checkpointArray[] = (object) [
                                        ref => $row['checkpointId'],
                                        name => $row['checkpointName'],
                                        location => $row['checkLongitude'].','.$row['checkLatitude'],
                                        update => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                        color => 'red',
                                        status => false
                                    ];
                                    break;
                                case '1':
                                    $checkpointArray[] = (object) [
                                        ref => $row['checkpointId'],
                                        name => $row['checkpointName'],
                                        location => $row['checkLongitude'].','.$row['checkLatitude'],
                                        update => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                        color => 'black',
                                        status => true
                                    ];
                                    break;
                            }
                        }
                        $output->status = 'success';
                        $output->checkpoint = $checkpointArray;
                        echo(json_encode($output));
                    } else {
                        $output->status = 'false';
                        echo(json_encode($output));
                    }
                    break;
                case 'mobile':
                    if (isset($postId) && !empty($postId) && $postId != 'undefined') {
                        $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                        $sql->bind_param('s', $postId); $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $output->status = 'success';
                                $output->checkpoint = $row['checkpointName'];
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
                    break;
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