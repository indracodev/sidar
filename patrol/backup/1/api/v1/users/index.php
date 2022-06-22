<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined') {
        $sqlCheck = $conn->prepare("SELECT userLevel FROM tb_users WHERE hashWeb = ?");
        $sqlCheck->bind_param('s', $postHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            while ($rowCheck = $resultCheck->fetch_assoc()) {
                if($rowCheck['userLevel'] == '10') {
                    $sql = $conn->prepare("SELECT userName, userId, lastUpdated  FROM tb_users");
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        $userArray = [];
                        $users = new stdClass();
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            $userArray[] = (object) [
                                no => $i,
                                id => $row['userId'],
                                name => $row['userName'],
                                update => $row['lastUpdated'],
                            ];
                            $i++;
                        }
                        $output->status = 'success';
                        $output->users = $userArray;
                        echo(json_encode($output));
                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                } else {
                    $output->status = 'unauth';
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