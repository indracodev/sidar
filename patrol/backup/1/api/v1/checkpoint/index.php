<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $postRef = $_DELETE['ref'];

    if (isset($postRef) && !empty($postRef) && $postRef != 'undefined') {
        $sql = $conn->prepare("DELETE FROM tb_checkpoint WHERE checkpointId = ?");
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
    $postCheckpoint = $_PUT['checkpoint'];
    $postRef = $_PUT['ref'];

    if (isset($postCheckpoint) && !empty($postCheckpoint) && $postCheckpoint != 'undefined' &&
        isset($postRef) && !empty($postRef) && $postRef != 'undefined') {
        $sql = $conn->prepare("UPDATE tb_checkpoint SET checkpointName=? WHERE checkpointId=?");
        $sql->bind_param('ss', $postCheckpoint, $postRef);
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
    parse_str(file_get_contents("php://input"),$_PUT);
    $postRef = $_PUT['ref'];

    if (isset($postRef) && !empty($postRef) && $postRef != 'undefined') {
        $sqlCheck = $conn->prepare("SELECT checkStatus FROM tb_checkpoint WHERE checkpointId=?");
        $sqlCheck->bind_param('s', $postRef);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            while ($row = $resultCheck->fetch_assoc()) {
                if ($row['checkStatus'] > 0) {
                    $sql = $conn->prepare("UPDATE tb_checkpoint SET checkStatus='0' WHERE checkpointId=?");
                    $sql->bind_param('s', $postRef);
                    if ($sql->execute() === TRUE) {
                        $output->status = 'success';
                        echo(json_encode($output));
                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                } else {
                    $sql = $conn->prepare("UPDATE tb_checkpoint SET checkStatus='1' WHERE checkpointId=?");
                    $sql->bind_param('s', $postRef);
                    if ($sql->execute() === TRUE) {
                        $output->status = 'success';
                        echo(json_encode($output));
                    } else {
                        $output->status = 'failed';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkpointId = $_POST['id'];
    $checkpointName = strtoupper($_POST['name']);
    $checkLatitude = '-';
    $checkLongitude = '-';
    $userHash = $_POST['hash'];
    $postDevice = $_POST['device'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'UNDEFINED') {
        $query;
        switch ($postDevice) {
            case 'web':
                $query = "SELECT userId FROM tb_users WHERE hashWeb=?";
                break;
            case 'mobile':
                $query = "SELECT userId FROM tb_users WHERE hashMobile=?";
                break;
        }
        $sqlCheck = $conn->prepare($query);
        $sqlCheck->bind_param('s', $userHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            $nameCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointName = ?");
            $nameCheck->bind_param('s', $checkpointName);
            $nameCheck->execute();
            $nameResult = $nameCheck->get_result();
            if ($nameResult->num_rows > 0) {
                $output->status = 'exist';
                echo(json_encode($output));
            } else {
                $checkpointCheck = $conn->prepare("SELECT checkpointId FROM tb_checkpoint WHERE checkpointId = ?");
                $checkpointCheck->bind_param('s', $checkpointId);
                $checkpointCheck->execute();
                $checkpointResult = $checkpointCheck->get_result();
                if ($checkpointResult->num_rows > 0) {
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
                            $sql = $conn->prepare("UPDATE tb_checkpoint SET checkpointName = ?, userName = ?, checkStatus = '0' WHERE checkpointId = ?");
                            $sql->bind_param('sss', $checkpointName, $userName, $checkpointId);
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
                            $checkStatus = '0';
                            $sql = $conn->prepare("INSERT INTO tb_checkpoint (checkpointId, checkpointName, checkStatus, userName) VALUES (?, ?, ?, ?)");
                            $sql->bind_param('ssss', $checkpointId, $checkpointName, $checkStatus, $userName);
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
        $sqlCheck = $conn->prepare($query);
        $sqlCheck->bind_param('s', $postHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            switch ($postDevice) {
                case 'web':
                    $sql = $conn->prepare("SELECT checkpointName, checkpointId, checkLatitude, checkLongitude, checkStatus, lastUpdated  FROM tb_checkpoint");
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        $checkpointArray = [];
                        $checkpoint = new stdClass();
                        while ($row = $result->fetch_assoc()) {
                            if ($row['checkStatus'] > 0) {
                                $checkpointArray[] = (object) [
                                    ref => $row['checkpointId'],
                                    name => $row['checkpointName'],
                                    location => $row['checkLongitude'].','.$row['checkLatitude'],
                                    update => $row['lastUpdated'],
                                    color => 'black',
                                    status => true
                                ];
                            } else {
                                $checkpointArray[] = (object) [
                                    ref => $row['checkpointId'],
                                    name => $row['checkpointName'],
                                    location => $row['checkLongitude'].','.$row['checkLatitude'],
                                    update => $row['lastUpdated'],
                                    color => 'red',
                                    status => false
                                ];
                            }
                        }
                        $output->status = 'success';
                        $output->checkpoint = $checkpointArray;
                        echo(json_encode($output));
                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                    break;
                case 'mobile':
                    if (isset($postId) && !empty($postId) && $postId != 'undefined') {
                        $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                        $sql->bind_param('s', $postId);
                        $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $output->status = 'success';
                                $output->checkpoint = $row['checkpointName'];
                                echo(json_encode($output));
                            }
                        } else {
                            $output->status = 'failed';
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