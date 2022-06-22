<?php
include '../../config.php';
include '../../hash.php';
$output;
$execute = microtime(true);
$restAPI = 'users';

//GET USER LIST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare(
            "SELECT userLevel 
            FROM tb_users 
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userLevel = $result->fetch_assoc()['userLevel'];

        switch ($userLevel) {
            case '10':
                $sql = $conn->prepare(
                    "SELECT userName, userId, userLevel, lastUpdated 
                    FROM tb_users"
                );
                $sql->execute();
                $result = $sql->get_result();
                $userArray = [];
                $i = 1;
                while ($row = $result->fetch_assoc()) {

                    if ($row['userLevel'] > 0) {
                        $userArray[] = (object) [
                            'no' => $i,
                            'id' => $row['userId'],
                            'name' => $row['userName'],
                            'status' => 'black',
                            'level' => $row['userLevel'],
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                        ];
                    } else {
                        $userArray[] = (object) [
                            'no' => $i,
                            'id' => $row['userId'],
                            'name' => $row['userName'],
                            'status' => 'red',
                            'level' => $row['userLevel'],
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                        ];
                    }
                    $i++;
                }
                $output->status = 'success';
                $output->execute = microtime(true) - $execute;
                $output->users = $userArray;
                echo (json_encode($output));
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

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $userId = $_PUT['id'];
    $userHash = $_PUT['hash'];
    $action = $_GET['action'];

    if (
        isset($userId) && !empty($userId) && $userId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined'
    ) {
        switch ($action) {
            //EDIT USER NAME
            case 'update':
                $userName = $_PUT['user'];

                if (isset($userName) && !empty($userName) && $userName != 'undefined') {
                    $sql = $conn->prepare(
                        "SELECT userLevel 
                        FROM tb_users 
                        WHERE hashWeb = ?"
                    );
                    $sql->bind_param('s', $userHash);
                    $sql->execute();
                    $result = $sql->get_result();
                    $userLevel = $result->fetch_assoc()['userLevel'];

                    switch ($userLevel) {
                        case '10':
                            try {
                                $conn->begin_transaction();

                                $sql = $conn->prepare(
                                    "SELECT userName
                                    FROM tb_users
                                    WHERE userId = ?"
                                );
                                $sql->bind_param('s', $userId);
                                $sql->execute();
                                $result = $sql->get_result();
                                $tempUserName = $result->fetch_assoc()['userName'];
        
                                $sql = $conn->prepare(
                                    "UPDATE tb_users 
                                    SET userName = ? 
                                    WHERE userId = ?"
                                );
                                $sql->bind_param('ss', $userName, $userId);
                                if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                                $logNote = "updated user name '{$tempUserName}' to '{$userName}'";

                                $log = $conn->prepare(
                                    "INSERT INTO tb_logs
                                    (activity, category, userName, note)
                                    VALUES ('update', ?, 'root', ?)"
                                );
                                $log->bind_param('ss', $restAPI, $logNote);
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
                break;
            //Disable User
            case 'disable':
                $sql = $conn->prepare(
                    "SELECT userLevel 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userLevel = $result->fetch_assoc()['userLevel'];

                switch ($userLevel) {
                    case '10':
                        try {
                            $conn->begin_transaction();

                            $sql = $conn->prepare(
                                "SELECT userName
                                FROM tb_users
                                WHERE userId = ?"
                            );
                            $sql->bind_param('s', $userId);
                            $sql->execute();
                            $result = $sql->get_result();
                            $tempUserName = $result->fetch_assoc()['userName'];
    
                            $sql = $conn->prepare(
                                "UPDATE tb_users 
                                SET userLevel = '0' 
                                WHERE userId = ?"
                            );
                            $sql->bind_param('s', $userId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                            $logNote = "disabled user '{$tempUserName}'";

                            $log = $conn->prepare(
                                "INSERT INTO tb_logs
                                (activity, category, userName, note)
                                VALUES ('update', ?, 'root', ?)"
                            );
                            $log->bind_param('ss', $restAPI, $logNote);
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
                        break;
                    default:
                        $output->status = 'error';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        break;
                }
                break;
            //ENABLE USER
            case 'enable':
                $sql = $conn->prepare(
                    "SELECT userLevel 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userLevel = $result->fetch_assoc()['userLevel'];

                switch ($userLevel) {
                    case '10':
                        try {
                            $conn->begin_transaction();

                            $sql = $conn->prepare(
                                "SELECT userName
                                FROM tb_users
                                WHERE userId = ?"
                            );
                            $sql->bind_param('s', $userId);
                            $sql->execute();
                            $result = $sql->get_result();
                            $tempUserName = $result->fetch_assoc()['userName'];
    
                            $sql = $conn->prepare(
                                "UPDATE tb_users 
                                SET userLevel = '1' 
                                WHERE userId = ?"
                            );
                            $sql->bind_param('s', $userId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                            $logNote = "enabled user '{$tempUserName}'";

                            $log = $conn->prepare(
                                "INSERT INTO tb_logs
                                (activity, category, userName, note)
                                VALUES ('update', ?, 'root', ?)"
                            );
                            $log->bind_param('ss', $restAPI, $logNote);
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
                        break;
                    default:
                        $output->status = 'error';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        break;
                }
                break;
            //FORCE USER LOGOUT
            case 'logout':
                $sql = $conn->prepare(
                    "SELECT userLevel 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userLevel = $result->fetch_assoc()['userLevel'];

                switch ($userLevel) {
                    case '10':
                        try {
                            $conn->begin_transaction();

                            $hashWeb = generateHash();
                            $hashMobile = generateHash();

                            $sql = $conn->prepare(
                                "SELECT userName
                                FROM tb_users
                                WHERE userId = ?"
                            );
                            $sql->bind_param('s', $userId);
                            $sql->execute();
                            $result = $sql->get_result();
                            $tempUserName = $result->fetch_assoc()['userName'];
    
                            $sql = $conn->prepare(
                                "UPDATE tb_users 
                                SET hashWeb = ?, hashMobile = ? 
                                WHERE userId = ?"
                            );
                            $sql->bind_param('sss', $hashWeb, $hashMobile, $userId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                            $logNote = "forced logout user '{$tempUserName}'";

                            $log = $conn->prepare(
                                "INSERT INTO tb_logs
                                (activity, category, userName, note)
                                VALUES ('update', ?, 'root', ?)"
                            );
                            $log->bind_param('ss', $restAPI, $logNote);
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
                        break;
                    default:
                        $output->status = 'unauth';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        break;
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

//ADD USER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = strtolower($_POST['user']);
    $userPassword = hash('sha256', $_POST['password']);
    $userHash = $_POST['hash'];

    if (
        isset($userName) && !empty($userName) && $userName != 'undefined' &&
        isset($userPassword) && $userPassword != '' && $userPassword != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined'
    ) {
        $sql = $conn->prepare(
            "SELECT userLevel 
            FROM tb_users 
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userLevel = $result->fetch_assoc()['userLevel'];

        switch ($userLevel) {
            case '10':
                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "SELECT userId
                        FROM tb_users
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $userId = (int)$result->fetch_assoc()['userId'] + 1;

                    $sql = $conn->prepare(
                        "INSERT INTO tb_users 
                        (userId, userName, userPassword, userLevel)
                        VALUES (?, ?, ?, '0')"
                    );
                    $sql->bind_param('sss', $userId, $userName, $userPassword);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "added user '{$userName}'";

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('insert', ?, 'root', ?)"
                    );
                    $log->bind_param('ss', $restAPI, $logNote);
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