<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"),$_PUT);
    $postSchedule = $_PUT['schedule'];
    $postStart = $_PUT['start'];
    $postEnd = $_PUT['end'];

    if (isset($postSchedule) && !empty($postSchedule) && $postSchedule != 'undefined' &&
        isset($postStart) && !empty($postStart) &&
        isset($postEnd) && !empty($postEnd)) {
        $sql = $conn->prepare("UPDATE tb_schedule SET scheduleStart=?, scheduleEnd=? WHERE scheduleId=?");
        $sql->bind_param('sss', $postStart, $postEnd, $postSchedule);
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

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$_DELETE);
    $postSchedule = $_DELETE['schedule'];

    if (isset($postSchedule) && !empty($postSchedule) && $postSchedule != 'undefined') {
        $sql = $conn->prepare("DELETE FROM tb_schedule WHERE scheduleId=?");
        $sql->bind_param('s', $postSchedule);
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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postPhase = $_GET['phase'];

    if (isset($postPhase) && !empty($postPhase)) {
        $sql = $conn->prepare("SELECT scheduleId, checkpointName, personName, scheduleStart, scheduleEnd, scheduleDate  FROM tb_schedule, tb_person WHERE tb_person.personId = tb_schedule.personId AND phaseId = ? ORDER BY scheduleStart ASC");
        $sql->bind_param('s', $postPhase);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $scheduleArray = [];
            $schedule = new stdClass();
            while ($row = $result->fetch_assoc()) {
                $dateActivity = substr($row['scheduleDate'], 0, 10).' '.substr($row['scheduleStart'], 0, 2).'%';
                $activitySql = $conn->prepare("SELECT activityStart FROM tb_activity WHERE activityStart LIKE ?");
                $activitySql->bind_param('s', $dateActivity);
                $activitySql->execute();
                $activityResult = $activitySql->get_result();
                if ($activityResult->num_rows > 0) {
                    $timeActivity;
                    while ($rowActivity = $activityResult->fetch_assoc()) {
                        $timeActivity = substr($rowActivity['activityStart'], 11, 2).'%';
                    }
                    $scheduleSql = $conn->prepare("SELECT scheduleId FROM tb_activity, tb_schedule WHERE scheduleStart LIKE ?");
                    $scheduleSql->bind_param('s', $timeActivity);
                    $scheduleSql->execute();
                    $scheduleResult = $scheduleSql->get_result();
                    if ($scheduleResult->num_rows > 0) {
                        $date1=date_create($row['scheduleDate']);
                        $date2=date_create(date("Y-m-d"));
                        $diff=date_diff($date1,$date2);
                        if ($diff->format("%R%a") > 0) {
                            $scheduleArray[] = (object) [
                                id => $row['scheduleId'],
                                person => $row['personName'],
                                checkpoint => $row['checkpointName'],
                                start => $row['scheduleStart'],
                                end => $row['scheduleEnd'],
                                isEdit => false,
                                status => 'powderblue'
                            ];
                        } else {
                            $scheduleArray[] = (object) [
                                id => $row['scheduleId'],
                                person => $row['personName'],
                                checkpoint => $row['checkpointName'],
                                start => $row['scheduleStart'],
                                end => $row['scheduleEnd'],
                                isEdit => true,
                                status => 'powderblue'
                            ];
                        }
                    } else {
                        $date1=date_create($row['scheduleDate']);
                        $date2=date_create(date("Y-m-d"));
                        $diff=date_diff($date1,$date2);
                        if ($diff->format("%R%a") > 0) {
                            $scheduleArray[] = (object) [
                                id => $row['scheduleId'],
                                person => $row['personName'],
                                checkpoint => $row['checkpointName'],
                                start => $row['scheduleStart'],
                                end => $row['scheduleEnd'],
                                isEdit => false,
                                status => 'white'
                            ];
                        } else {
                            $scheduleArray[] = (object) [
                                id => $row['scheduleId'],
                                person => $row['personName'],
                                checkpoint => $row['checkpointName'],
                                start => $row['scheduleStart'],
                                end => $row['scheduleEnd'],
                                isEdit => true,
                                status => 'white'
                            ];
                        }
                    }
                } else {
                    $date1=date_create($row['scheduleDate']);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date1,$date2);
                    if ($diff->format("%R%a") > 0) {
                        $scheduleArray[] = (object) [
                            id => $row['scheduleId'],
                            person => $row['personName'],
                            checkpoint => $row['checkpointName'],
                            start => $row['scheduleStart'],
                            end => $row['scheduleEnd'],
                            isEdit => false,
                            status => 'white'
                        ];
                    } else {
                        $scheduleArray[] = (object) [
                            id => $row['scheduleId'],
                            person => $row['personName'],
                            checkpoint => $row['checkpointName'],
                            start => $row['scheduleStart'],
                            end => $row['scheduleEnd'],
                            isEdit => true,
                            status => 'white'
                        ];
                    }
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personId = $_POST['person'];
    $checkpointName = $_POST['checkpoint'];
    $phaseId = $_POST['phase'];
    $scheduleStart = $_POST['start'];
    $scheduleEnd = $_POST['end'];
    $scheduleDate = $_POST['date'];
    $userHash = $_POST['user'];
    if (isset($personId) && !empty($personId) &&
        isset($checkpointName) && !empty($checkpointName) &&
        isset($phaseId) && !empty($phaseId) &&
        isset($userHash) && !empty($userHash)) {
        $scheduleCheck = $conn->prepare("SELECT scheduleId FROM tb_schedule ORDER BY scheduleId DESC LIMIT 1");
        $scheduleCheck->execute();
        $scheduleResult = $scheduleCheck->get_result();
        if ($scheduleResult->num_rows > 0) {
            while ($rowCheck = $scheduleResult->fetch_assoc()) {
                $scheduleId = (int)$rowCheck['scheduleId'] + 1;
                $userCheck = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $userCheck->bind_param('s', $userHash);
                $userCheck->execute();
                $userResult = $userCheck->get_result();
                if ($userResult->num_rows > 0) {
                    while ($rowUser = $userResult->fetch_assoc()) {
                        $userName = $rowUser['userName'];
                        $sql = $conn->prepare("INSERT INTO tb_schedule (scheduleId, personId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $sql->bind_param('ssssssss', $scheduleId, $personId, $checkpointName, $phaseId, $scheduleStart, $scheduleEnd, $scheduleDate, $userName);
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
        } else {
            $scheduleId = '1';
            $userCheck = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
            $userCheck->bind_param('s', $userHash);
            $userCheck->execute();
            $userResult = $userCheck->get_result();
            if ($userResult->num_rows > 0) {
                while ($rowUser = $userResult->fetch_assoc()) {
                    $userName = $rowUser['userName'];
                    $sql = $conn->prepare("INSERT INTO tb_schedule (scheduleId, personId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $sql->bind_param('ssssssss', $scheduleId, $personId, $checkpointName, $phaseId, $scheduleStart, $scheduleEnd, $scheduleDate, $userName);
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
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}