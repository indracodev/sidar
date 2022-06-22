<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userLevel FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            while ($rowCheck = $resultCheck->fetch_assoc()) {

                switch ($rowCheck['userLevel']) {
                    case '10':
                        $sql = $conn->prepare("SELECT userName, userId, lastUpdated FROM tb_users"); $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            $userArray = [];
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {

                                $userArray[] = (object) [
                                    no => $i,
                                    id => $row['userId'],
                                    name => $row['userName'],
                                    update => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                ];
                                $i++;

                            }
                            $output->status = 'success';
                            $output->users = $userArray;
                            echo(json_encode($output));
                        } else {
                            $output->status = 'false';
                            echo(json_encode($output));
                        }
                        break;
                    default:
                        $output->status = 'unauth';
                        echo(json_encode($output));
                        break;
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
    $userName = $_PUT['user'];
    $userId = $_PUT['id'];
    $userHash = $_PUT['hash'];

    if (isset($userName) && !empty($userName) && $userName != 'undefined' &&
        isset($userId) && $userId != '' && $userId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userLevel FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            while ($rowCheck = $resultCheck->fetch_assoc()) {

                switch ($rowCheck['userLevel']) {
                    case '10':
                        $sql = $conn->prepare("UPDATE tb_users SET userName = ? WHERE userId = ?"); $sql->bind_param('ss', $userName, $userId);
                        if ($sql->execute() === TRUE) {
                            $output->status = 'success';
                            echo(json_encode($output));
                        } else {
                            $output->status = 'failed';
                            $output->action = 'update';
                            echo(json_encode($output));
                        }
                        break;
                    default:
                        $output->status = 'unauth';
                        echo(json_encode($output));
                        break;
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