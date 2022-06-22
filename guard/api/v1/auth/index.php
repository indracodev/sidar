<?php
include '../../config.php';
include '../../hash.php';
$output;
$execute = microtime(true);
$restAPI = 'users';

// $authorization = explode(" ", getallheaders()['Authorization']);
// $hash = $authorization[1];
// $sql = $conn->prepare("SELECT uid FROM tb_users WHERE hashWeb = ?");
// $sql->bind_param('s', $hash);
// $sql->execute();
// $result = $sql->get_result();
// if ($result->num_rows > 0) {
    
// } else {
//     header('HTTP/1.1 401 Unauthorized');
//     exit;
// }

//MANUAL AUTHENTICATION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postName = $_POST['username'];
    $postPassword = $_POST['password'];
    $device = $_POST['device'];
    $action = $_GET['action'];

    if (
        isset($postName) && !empty($postName) && $postName != 'undefined' &&
        isset($postPassword) && !empty($postPassword) && $postPassword != 'undefined' &&
        isset($device) && !empty($device) && $device != 'undefined'
    ) {
        $username = strtolower($postName) ?? '';
        $password = hash('sha256', $postPassword);
        $sql = $conn->prepare(
            "SELECT userName, userPassword, userLevel
            FROM tb_users
            WHERE userName = ?
            AND userPassword = ?"
        );
        $sql->bind_param("ss", $postName, $password);
        $sql->execute();
        $result = $sql->get_result();
        $userLevel; $usernameDB; $passwordDB;
        while ($row = $result->fetch_assoc()) {
            $userLevel = $row["userLevel"];
            $usernameDB = $row["userName"];
            $passwordDB = $row["userPassword"];
        }

        if ($userLevel > 0) {
            if ($password == $passwordDB && $username == $usernameDB) {
                $hash = generateHash();
                $sql; $logNote;
                switch ($device) {
                    case 'web':
                        $sql = $conn->prepare(
                            "UPDATE tb_users
                            SET hashWeb = ?
                            WHERE userName = ?"
                        );

                        $logNote = "login on web";
                        break;
                    case 'mobile':
                        $sql = $conn->prepare(
                            "UPDATE tb_users
                            SET hashMobile = ?
                            WHERE userName = ?"
                        );

                        $logNote = "login on mobile";
                        break;
                }
                $sql->bind_param("ss", $hash, $username);

                try {
                    $conn->begin_transaction();

                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('update', ?, ?, ?)"
                    );
                    $log->bind_param('sss', $restAPI, $usernameDB, $logNote);
                    if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');
                    
                } catch (Exception $e) {
                    $output->status = 'failed';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->rollback();
                    exit();
                } finally {
                    if (!empty($action)) {
                        switch ($device) {
                            case 'web':
                                $output->status = 'success';
                                $output->execute = microtime(true) - $execute;
                                $output->level = $userLevel;
                                $output->hash = $hash;
                                break;
                            case 'mobile':
                                $output->status = 'success';
                                $output->execute = microtime(true) - $execute;
                                $output->hash = $hash;
                                break;
                        }
                        echo (json_encode($output));
                    } else {
                        $output->status = 'error';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                    }
                    $conn->commit();
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                $output->message = 'Wrong combination';
                echo (json_encode($output));
            }
        } else {
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            $output->message = 'Wrong combination';
            echo (json_encode($output));
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
    
}

//AUTO AUTHENTICATION
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $hash = $_GET['hash'];
    $device = $_GET['device'];

    if (
        isset($hash) && !empty($hash) && $hash != 'undefined' &&
        isset($device) && !empty($device) && $device != 'undefined'
    ) {
        $sql;
        switch ($device) {
            case 'web':
                $sql = $conn->prepare(
                    "SELECT username, userLevel
                    FROM tb_users
                    WHERE hashWeb = ?"
                );
                break;
            case 'mobile':
                $sql = $conn->prepare(
                    "SELECT username
                    FROM tb_users
                    WHERE hashMobile = ?"
                );
                break;
            default: break;
        }
        
        $sql->bind_param("s", $hash);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $userLevel = $result->fetch_assoc()['userLevel'];

            switch ($device) {
                case 'web':
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->level = $userLevel;
                    break;
                case 'mobile':
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    break;
            }
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
}