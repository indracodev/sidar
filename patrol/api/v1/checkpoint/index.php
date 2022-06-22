<?php
include '../../config.php';
$output;
$execute = microtime(true);
$restAPI = 'checkpoint';

//REMOVE CHECKPOINT
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $checkpointId = $_DELETE['id'];
    $userHash = $_DELETE['hash'];

    if (
        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined'
    ) {
        $sql = $conn->prepare(
            "SELECT userName
            FROM tb_users
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userName = $result->fetch_assoc()['userName'];
        if ($result->num_rows > 0) {
            try {
                $conn->begin_transaction();

                $sql = $conn->prepare(
                    "SELECT checkpointName
                    FROM tb_checkpoint
                    WHERE checkpointId = ?"
                );
                $sql->bind_param('s', $checkpointId);
                $sql->execute();
                $result = $sql->get_result();
                $tempCheckpointName = $result->fetch_assoc()['checkpointName'];

                $sql = $conn->prepare(
                    "UPDATE tb_checkpoint
                    SET isDeleted = '1'
                    WHERE checkpointId = ?"
                );
                $sql->bind_param('s', $checkpointId);
                if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                $logNote = "deleted checkpoint '{$tempCheckpointName}'";

                $log = $conn->prepare(
                    "INSERT INTO tb_logs
                    (activity, category, userName, note)
                    VALUES ('delete', ?, ?, ?)"
                );
                $log->bind_param('sss', $restAPI, $userName, $logNote);
                if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

            } catch (Exception $e) {
                $output->status = 'failed';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
                $conn->rollback();
                exit();
            } finally {
                $output->status = 'success';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
                $conn->commit();
            }
        } else {
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $checkpointId = $_PUT['id'];
    $userHash = $_PUT['hash'];
    $action = $_GET['action'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare(
            "SELECT userName
            FROM tb_users
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userName = $result->fetch_assoc()['userName'];

        $sql = $conn->prepare(
            "SELECT checkpointName
            FROM tb_checkpoint
            WHERE checkpointId = ?"
        );
        $sql->bind_param('s', $checkpointId);
        $sql->execute();
        $result = $sql->get_result();
        $tempCheckpointName = $result->fetch_assoc()['checkpointName'];

        switch ($action) {
            //EDIT CHECKPOINT NAME
            case 'edit':
                $checkpointName = $_PUT['checkpoint'];
    
                if (
                    isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
                    isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined'
                ) {
                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "UPDATE tb_checkpoint
                            SET checkpointName = ?, userName = ?
                            WHERE checkpointId = ?"
                        );
                        $sql->bind_param('sss', $checkpointName, $userName, $checkpointId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                        $logNote = "edited checkpoint name '{$tempCheckpointName}' to '{$checkpointName}'";

                        $log = $conn->prepare(
                            "INSERT INTO tb_logs
                            (activity, category, userName, note)
                            VALUES ('update', ?, ?, ?)"
                        );
                        $log->bind_param('sss', $restAPI, $userName, $logNote);
                        if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                }
                break;
            //SET CHECKPOINT LOCATION
            case 'set':
                $latitude = $_PUT['latitude'];
                $longitude = $_PUT['longitude'];
    
                if (
                    isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
                    isset($latitude) && !empty($latitude) && $latitude != 'undefined' &&
                    isset($longitude) && !empty($longitude) && $longitude != 'undefined'
                ) {
                    try {
                        $conn->begin_transaction();
        
                        $sql = $conn->prepare(
                            "UPDATE tb_checkpoint
                            SET checkLatitude = ?, checkLongitude = ?, userName = ?
                            WHERE checkpointId =?"
                        );
                        $sql->bind_param('ssss', $latitude, $longitude, $userName, $checkpointId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                        $logNote = "updated location of checkpoint '{$tempCheckpointName}'";

                        $log = $conn->prepare(
                            "INSERT INTO tb_logs
                            (activity, category, userName, note)
                            VALUES ('update', ?, ?, ?)"
                        );
                        $log->bind_param('sss', $restAPI, $userName, $logNote);
                        if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');
    
                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                }
                break;
            //TOGGLE ENABLE/DISABLE CHECKPOINT
            case 'toggle':
                if (isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined') {
                    $sql = $conn->prepare(
                        "SELECT checkStatus
                        FROM tb_checkpoint
                        WHERE checkpointId = ?"
                    );
                    $sql->bind_param('s', $checkpointId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $checkStatus = $result->fetch_assoc()['checkStatus'];
    
                    try {
                        $conn->begin_transaction();

                        $logNote;
                        switch ($checkStatus) {
                            // Enable Checkpoint
                            case '0':
                                $sql = $conn->prepare(
                                    "UPDATE tb_checkpoint
                                    SET checkStatus = '1', userName = ?
                                    WHERE checkpointId = ?"
                                );
                                $sql->bind_param('ss', $userName, $checkpointId);
                                if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                                $logNote = "enabled checkpoint '{$tempCheckpointName}'";

                                break;
                            // Disable Checkpoint
                            case '1':
                                $sql = $conn->prepare(
                                    "UPDATE tb_checkpoint
                                    SET checkStatus = '0', userName = ?
                                    WHERE checkpointId = ?"
                                );
                                $sql->bind_param('ss', $userName, $checkpointId);
                                if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                                $logNote = "disabled checkpoint '{$tempCheckpointName}'";

                                break;
                            default:
                                break;
                        }

                        $log = $conn->prepare(
                            "INSERT INTO tb_logs
                            (activity, category, userName, note)
                            VALUES ('update', ?, ?, ?)"
                        );
                        $log->bind_param('sss', $restAPI, $userName, $logNote);
                        if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                }
                break;
            default:
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
                break;
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

//ADD CHECKPOINT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkpointId = $_POST['id'];
    $checkpointName = strtoupper($_POST['name']);
    $checkLatitude = '-';
    $checkLongitude = '-';
    $userHash = $_POST['hash'];

    if (
        isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined'
    ) {
        $sql = $conn->prepare(
            "SELECT userName
            FROM tb_users
            WHERE hashMobile = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userName = $result->fetch_assoc()['userName'];

        $sql = $conn->prepare(
            "SELECT checkpointName
            FROM tb_checkpoint
            WHERE checkpointName = ?"
        );
        $sql->bind_param('s', $checkpointName);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $output->status = 'exist';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
        } else {
            $sql = $conn->prepare(
                "SELECT checkpointName
                FROM tb_checkpoint
                WHERE checkpointId = ?"
            );
            $sql->bind_param('s', $checkpointId);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "UPDATE tb_checkpoint
                        SET checkpointName = ?, userName = ?, checkStatus = '0', isDeleted = '0'
                        WHERE checkpointId = ?"
                    );
                    $sql->bind_param('sss', $checkpointName, $userName, $checkpointId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $logNote = "added checkpoint '{$checkpointName}'";

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('insert', ?, ?, ?)"
                    );
                    $log->bind_param('sss', $restAPI, $userName, $logNote);
                    if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                } catch (Exception $e) {
                    $output->status = 'failed';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->rollback();
                    exit();
                } finally {
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->commit();
                }
            } else {
                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "INSERT INTO tb_checkpoint (checkpointId, checkpointName, checkStatus, isDeleted, userName)
                        VALUES (?, ?, '0', '0', ?)"
                    );
                    $sql->bind_param('sss', $checkpointId, $checkpointName, $userName);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "added checkpoint '{$checkpointName}'";

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('insert', ?, ?, ?)"
                    );
                    $log->bind_param('sss', $restAPI, $userName, $logNote);
                    if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');
                    
                } catch (Exception $e) {
                    $output->status = 'failed';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->rollback();
                    exit();
                } finally {
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->commit();
                }
            }
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $device = $_GET['device'];

    switch ($device) {
        //GET CHECKPOINT LIST
        case 'web':
            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userId 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT checkpointName, checkpointId, checkLatitude, checkLongitude, checkStatus, lastUpdated 
                        FROM tb_checkpoint 
                        WHERE isDeleted = '0' 
                        ORDER BY uid ASC"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $checkpointArray = [];
                    while ($row = $result->fetch_assoc()) {
                        switch ($row['checkStatus']) {
                            case '0':
                                $checkpointArray[] = (object) [
                                    'ref' => $row['checkpointId'],
                                    'name' => $row['checkpointName'],
                                    'location' => $row['checkLongitude'] . ',' . $row['checkLatitude'],
                                    'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                    'color' => 'red',
                                    'status' => false
                                ];
                                break;
                            case '1':
                                $checkpointArray[] = (object) [
                                    'ref' => $row['checkpointId'],
                                    'name' => $row['checkpointName'],
                                    'location' => $row['checkLongitude'] . ',' . $row['checkLatitude'],
                                    'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                    'color' => 'black',
                                    'status' => true
                                ];
                                break;
                        }
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->checkpoint = $checkpointArray;
                    echo (json_encode($output));
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        case 'mobile':
            $action = $_GET['action'];

            switch ($action) {
                //GET CHECKPOINT LIST PATROL
                case 'list':
                    $sql = $conn->prepare(
                        "SELECT checkpointName, checkpointId
                        FROM tb_checkpoint 
                        WHERE isDeleted = '0' 
                        ORDER BY checkpointName DESC"
                    );
                    $sql->execute();
                    $getCheckpoint = $sql->get_result();
                    $checkpoint = [];
                    while ($row = $getCheckpoint->fetch_assoc()) {
        
                        $checkpoint[] = (object) [
                            'checkpointId' => $row['checkpointId'],
                            'checkpointName' => $row['checkpointName']
                        ];
        
                    }

                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->checkpoint = $checkpoint;
                    echo (json_encode($output));
                    break;
                //GET CHECKPOINT NAME
                default:
                    $checkpointId = $_GET['id'];

                    if (
                        isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
                        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined'
                    ) {
                        $sql = $conn->prepare(
                            "SELECT userId 
                            FROM tb_users 
                            WHERE hashMobile = ?"
                        );
                        $sql->bind_param('s', $userHash);
                        $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            $sql = $conn->prepare(
                                "SELECT checkpointName 
                                FROM tb_checkpoint 
                                WHERE checkpointId = ?
                                AND isDeleted = '0'"
                            );
                            $sql->bind_param('s', $checkpointId);
                            $sql->execute();
                            $result = $sql->get_result();
                            $checkpointName = $result->fetch_assoc()['checkpointName'];

                            $output->status = 'success';
                            $output->execute = microtime(true) - $execute;
                            $output->checkpoint = $checkpointName;
                            echo (json_encode($output));
                        } else {
                            $output->status = 'error';
                            $output->execute = microtime(true) - $execute;
                            echo (json_encode($output));
                        }
                    } else {
                        $output->status = 'error';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                    }
                    break;
            }
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}
