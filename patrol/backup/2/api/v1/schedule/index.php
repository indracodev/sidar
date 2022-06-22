<?php
include '../../config.php';
$output;

//checked
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $scheduleId = $_PUT['schedule'];
    $scheduleStart = $_PUT['start'];
    $scheduleEnd = $_PUT['end'];
    $userHash = $_PUT['hash'];

    if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
        isset($scheduleStart) && !empty($scheduleStart) && $scheduleStart != 'undefined' &&
        isset($scheduleEnd) && !empty($scheduleEnd) && $scheduleEnd != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("UPDATE tb_schedule SET scheduleStart = ?, scheduleEnd = ?, userName = ? WHERE scheduleId=?");
                $sql->bind_param('ssss', $scheduleStart, $scheduleEnd, $rowUser['userName'], $scheduleId);
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
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$_DELETE);
    $postSchedule = $_DELETE['schedule'];
    $userHash = $_DELETE['hash'];

    if (isset($postSchedule) && !empty($postSchedule) && $postSchedule != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            $sql = $conn->prepare("DELETE FROM tb_schedule WHERE scheduleId = ?");
            $sql->bind_param('s', $postSchedule);
            if ($sql->execute() === TRUE) {
                $sql = $conn->prepare("DELETE FROM tb_activity WHERE scheduleId = ?");
                $sql->bind_param('s', $postSchedule);
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'delete';
                    echo(json_encode($output));
                }
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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseId = $_GET['phase'];

    if (isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined') {
        $sql = $conn->prepare("SELECT scheduleId, checkpointName, scheduleStart, scheduleEnd, personName FROM tb_schedule, tb_person WHERE tb_person.personId = tb_schedule.personId AND tb_schedule.phaseId = ?");
        $sql->bind_param('s', $phaseId); $sql->execute();
        $progress = $sql->get_result();
        if ($progress->num_rows > 0) {
            $scheduleArray = [];
            while ($rowProgress = $progress->fetch_assoc()) {

                $sql = $conn->prepare("SELECT tb_schedule.scheduleId, checkpointName, personName, scheduleStart, scheduleEnd, scheduleDate, activityStatus  FROM
                tb_schedule, tb_person, tb_activity WHERE tb_schedule.activityId = tb_activity.activityId AND tb_schedule.scheduleId = ? AND tb_person.personId = tb_schedule.personId AND phaseId = ?");
                $sql->bind_param('ss', $rowProgress['scheduleId'], $phaseId); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $date1=date_create($row['scheduleDate'].' '.$row['scheduleStart']);
                        $date2=date_create(date('y-m-d H:i:s'));
                        $diff=date_diff($date1,$date2);
                        if ($diff->format("%R") == '-') {
                            $scheduleArray[] = (object) [
                                id => $row['scheduleId'],
                                person => $row['personName'],
                                checkpoint => $row['checkpointName'],
                                start => $row['scheduleStart'],
                                end => $row['scheduleEnd'],
                                isEdit => true,
                                status => 'white'
                            ];
                        } else {
                            switch ($row['activityStatus']) {
                                case '1':
                                    $scheduleArray[] = (object) [
                                        id => $row['scheduleId'],
                                        person => $row['personName'],
                                        checkpoint => $row['checkpointName'],
                                        start => $row['scheduleStart'],
                                        end => $row['scheduleEnd'],
                                        isEdit => false,
                                        status => 'green'
                                    ];
                                    break;
                                default:
                                    $scheduleArray[] = (object) [
                                        id => $row['scheduleId'],
                                        person => $row['personName'],
                                        checkpoint => $row['checkpointName'],
                                        start => $row['scheduleStart'],
                                        end => $row['scheduleEnd'],
                                        isEdit => false,
                                        status => 'red'
                                    ];
                                    break;
                            }
                        }

                    }
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }

            }
            $output->status = 'success';
            $output->schedule = $scheduleArray;
            echo(json_encode($output));
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
    $personId = $_POST['person'];
    $activityId = $_POST['activity'];
    $checkpointName = $_POST['checkpoint'];
    $phaseId = $_POST['phase'];
    $scheduleStart = $_POST['start'];
    $scheduleEnd = $_POST['end'];
    $scheduleDate = $_POST['date'];
    $userHash = $_POST['hash'];

    if (isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($activityId) && !empty($activityId) && $activityId != 'undefined' &&
        isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
        isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT scheduleId FROM tb_schedule ORDER BY uid DESC LIMIT 1"); $sql->execute();
        $scheduleResult = $sql->get_result();
        if ($scheduleResult->num_rows > 0) {
            while ($rowCheck = $scheduleResult->fetch_assoc()) {

                $scheduleId = (int)$rowCheck['scheduleId'] + 1;
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    while ($rowUser = $userResult->fetch_assoc()) {

                        $sql = $conn->prepare("INSERT INTO tb_schedule (scheduleId, personId, activityId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); $sql->bind_param('sssssssss', $scheduleId, $personId, $activityId, $checkpointName, $phaseId, $scheduleStart, $scheduleEnd, $scheduleDate, $rowUser['userName']);
                        if ($sql->execute() === TRUE) {
                            $sql = $conn->prepare("UPDATE tb_activity SET scheduleId = ? WHERE activityId = ?"); $sql->bind_param('ss', $scheduleId, $activityId);
                            if ($sql->execute() === TRUE) {
                                $output->status = 'success';
                                $output->action = 'update';
                                echo(json_encode($output));
                            } else {
                                $output->status = 'failed';
                                $output->action = 'update';
                                echo(json_encode($output));
                            }
                        } else {
                            $output->status = 'failed';
                            $output->action = 'insert';
                            echo(json_encode($output));
                        }

                    }
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }

            }
        } else {
            $scheduleId = '1';
            $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
            $sql->bind_param('s', $userHash); $sql->execute();
            $userResult = $sql->get_result();
            if ($userResult->num_rows > 0) {
                while ($rowUser = $userResult->fetch_assoc()) {

                    $userName = $rowUser['userName'];
                    $sql = $conn->prepare("INSERT INTO tb_schedule (scheduleId, personId, activityId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); $sql->bind_param('sssssssss', $scheduleId, $personId, $activityId, $checkpointName, $phaseId, $scheduleStart, $scheduleEnd, $scheduleDate, $userName);
                    if ($sql->execute() === TRUE) {
                        $sql = $conn->prepare("UPDATE tb_activity SET scheduleId = ? WHERE activityId = ?"); $sql->bind_param('ss', $scheduleId, $activityId);
                        if ($sql->execute() === TRUE) {
                            $output->status = 'success';
                            echo(json_encode($output));
                        } else {
                            $output->status = 'failed';
                            $output->action = 'update';
                            echo(json_encode($output));
                        }
                    } else {
                        $output->status = 'failed';
                        $output->action = 'insert';
                        echo(json_encode($output));
                    }

                }
            } else {
                $output->status = 'false';
                echo(json_encode($output));
            }
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}