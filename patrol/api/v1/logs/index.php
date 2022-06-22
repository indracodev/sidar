<?php
include '../../config.php';
$output;
$execute = microtime(true);

//GET LOGS LIST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $action = $_GET['action'];
    $date = $_GET['date'];

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
                switch ($action) {
                    case 'insert':
                        if ($date) {
                            $temp = explode(',', $date);
                            if (count($temp) > 1) {
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'insert'
                                    AND lastUpdated BETWEEN ? AND ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('ss', $temp[0], $temp[1]);
                            } else {
                                $date = $date . '%';
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'insert'
                                    AND lastUpdated LIKE ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('s', $date);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT activity, category, userName, note, lastUpdated
                                FROM tb_logs
                                WHERE activity = 'insert'
                                ORDER BY lastUpdated DESC"
                            );
                        }
                        break;
                    case 'update':
                        if ($date) {
                            $temp = explode(',', $date);
                            if (count($temp) > 1) {
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'update'
                                    AND lastUpdated BETWEEN ? AND ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('ss', $temp[0], $temp[1]);
                            } else {
                                $date = $date . '%';
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'update'
                                    AND lastUpdated LIKE ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('s', $date);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT activity, category, userName, note, lastUpdated
                                FROM tb_logs
                                WHERE activity = 'update'
                                ORDER BY lastUpdated DESC"
                            );
                        }
                        break;
                    case 'delete':
                        if ($date) {
                            $temp = explode(',', $date);
                            if (count($temp) > 1) {
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'delete'
                                    AND lastUpdated BETWEEN ? AND ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('ss', $temp[0], $temp[1]);
                            } else {
                                $date = $date . '%';
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE activity = 'delete'
                                    AND lastUpdated LIKE ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('s', $date);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT activity, category, userName, note, lastUpdated
                                FROM tb_logs
                                WHERE activity = 'delete'
                                ORDER BY lastUpdated DESC"
                            );
                        }
                        break;
                    default:
                        if ($date) {
                            $temp = explode(',', $date);
                            if (count($temp) > 1) {
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE lastUpdated BETWEEN ? AND ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('ss', $temp[0], $temp[1]);
                            } else {
                                $date = $date . '%';
                                $sql = $conn->prepare(
                                    "SELECT activity, category, userName, note, lastUpdated
                                    FROM tb_logs
                                    WHERE lastUpdated LIKE ?
                                    ORDER BY lastUpdated DESC"
                                );
                                $sql->bind_param('s', $date);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT activity, category, userName, note, lastUpdated
                                FROM tb_logs
                                ORDER BY lastUpdated DESC"
                            );
                        }
                        break;
                }
                $sql->execute();
                $result = $sql->get_result();
                $logArray = [];
                $i = 1;
                while ($row = $result->fetch_assoc()) {

                    $color;
                    switch ($row['activity']) {
                        case 'insert':
                            $color = '#4cd964';
                            break;
                        case 'update':
                            $color = '#2196f3';
                            break;
                        case 'delete':
                            $color = '#ff3b30';
                            break;
                        default: break;
                    }

                    $logArray[] = (object) [
                        'no' => $i,
                        'activity' => $row['activity'],
                        'category' => $row['category'],
                        'username' => $row['userName'],
                        'color' => $color,
                        'note' => $row['note'],
                        'update' => date('d/m/Y (H:i:s)', strtotime($row['lastUpdated'])),
                    ];

                    $i++;
                }
                $output->status = 'success';
                $output->execute = microtime(true) - $execute;
                $output->logs = $logArray;
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