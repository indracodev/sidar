<?php
include '../../config.php';
$output;
$execute = microtime(true);
$restAPI = 'schedule';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $userHash = $_DELETE['hash'];
    $action = $_GET['action'];

    switch ($action) {
        // REMOVE TEMPLATE SCHEDULE
        case 'template':
            $templateId = $_DELETE['template'];

            if (
                isset($templateId) && !empty($templateId) && $templateId != 'undefined' &&
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
                            "SELECT templateName
                            FROM tb_schedule_template
                            WHERE templateId = ?"
                        );
                        $sql->bind_param('s', $templateId);
                        $sql->execute();
                        $result = $sql->get_result();
                        $templateName = $result->fetch_assoc()['templateName'];

                        $sql = $conn->prepare(
                            "DELETE
                            FROM tb_schedule_template
                            WHERE templateId = ?"
                        );
                        $sql->bind_param('s', $templateId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        $logNote = "deleted template schedule '{$templateName}'";

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
            break;
        // REMOVE SCHEDULE
        case 'schedule':
            $scheduleId = $_DELETE['schedule'];

            if (
                isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
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
                            "SELECT activityId, phaseId, scheduleStart, scheduleEnd, scheduleDate
                            FROM tb_schedule
                            WHERE scheduleId = ?"
                        );
                        $sql->bind_param('s', $scheduleId);
                        $sql->execute();
                        $activity = $sql->get_result();
                        $activityId; $phaseId; $scheduleStart; $scheduleEnd; $scheduleDate;
                        if ($activity->num_rows > 0) {
                            while ($row = $activity->fetch_assoc()) {
                                $activityId = $row['activityId'];
                                $phaseId = $row['phaseId'];
                                $scheduleStart = substr($row['scheduleStart'], 0, 5);
                                $scheduleEnd = substr($row['scheduleEnd'], 0, 5);
                                $scheduleDate = date_format(date_create($row['scheduleDate']), 'd F Y');
                            }

                            // Remove Report by Activity ID
                            $sql = $conn->prepare(
                                "DELETE FROM tb_report 
                                WHERE activityId = ?"
                            );
                            $sql->bind_param('s', $activityId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');
                        }

                        // Remove Schedule by Schedule ID
                        $sql = $conn->prepare(
                            "DELETE FROM tb_schedule 
                            WHERE scheduleId = ?"
                        );
                        $sql->bind_param('s', $scheduleId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        // Remove Activity by Schedule ID
                        $sql = $conn->prepare(
                            "DELETE FROM tb_activity 
                            WHERE scheduleId = ?"
                        );
                        $sql->bind_param('s', $scheduleId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        $sql = $conn->prepare(
                            "SELECT scheduleId 
                            FROM tb_task_list 
                            WHERE scheduleId = ?"
                        );
                        $sql->bind_param('s', $scheduleId);
                        $sql->execute();
                        $schedule = $sql->get_result();
                        if ($schedule->num_rows > 0) {
                            // Remove Task List by Schedule ID
                            $sql = $conn->prepare(
                                "DELETE FROM tb_task_list 
                                WHERE scheduleId = ?
                                AND phaseId = ?"
                            );
                            $sql->bind_param('ss', $scheduleId, $phaseId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');
                        }

                        $logNote = "deleted schedule on '{$scheduleDate}' at '{$scheduleStart}' - '{$scheduleEnd}' WIB";

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
                    $output->message = 'No authentication';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // REMOVE ALL SCHEDULE
        case 'all':
            $phaseId = $_DELETE['phase'];
            if (
                isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined' &&
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
                            "SELECT scheduleId, activityId, scheduleDate
                            FROM tb_schedule
                            WHERE phaseId = ?"
                        );
                        $sql->bind_param('s', $phaseId);
                        $sql->execute();
                        $result = $sql->get_result();
                        $tempScheduleDate;
                        while ($row = $result->fetch_assoc()) {
                            //Remove Activity
                            $sql = $conn->prepare(
                                "DELETE FROM tb_activity 
                                WHERE scheduleId = ?"
                            );
                            $sql->bind_param('s', $row['scheduleId']);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                            //Remove Task List
                            $sql = $conn->prepare(
                                "DELETE FROM tb_task_list
                                WHERE scheduleId = ?
                                AND phaseId = ?"
                            );
                            $sql->bind_param('ss', $row['scheduleId'], $phaseId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                            //Remove Report
                            $sql = $conn->prepare(
                                "DELETE FROM tb_report 
                                WHERE activityId = ?"
                            );
                            $sql->bind_param('s', $row['activityId']);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                            $tempScheduleDate = date_format(date_create($row['scheduleDate']), 'd F Y');
                        }

                        //Remove Schedule
                        $sql = $conn->prepare(
                            "DELETE FROM tb_schedule 
                            WHERE phaseId = ?"
                        );
                        $sql->bind_param('s', $phaseId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        $logNote = "deleted all schedule on '{$tempScheduleDate}'";

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
                    $output->message = 'No authentication';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // REMOVE ALL SCHEDULE AND PHASE
        case 'all-phase':
            $phaseIds = $_DELETE['phase'];

            if (
                isset($phaseIds) && !empty($phaseIds) && $phaseIds != 'undefined' &&
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
                    $phase = explode(',', $phaseIds);
                    $len = count($phase);
                    $i = 0;
                    try {
                        $conn->begin_transaction();

                        $tempScheduleDate;
                        while ($i < $len) {
                            $sql = $conn->prepare(
                                "SELECT phaseDate
                                FROM tb_phase
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $phase[$i]);
                            $sql->execute();
                            $result = $sql->get_result();
                            $tempScheduleDate = date_format(date_create($result->fetch_assoc()['phaseDate']), 'd F Y');

                            $sql = $conn->prepare(
                                "SELECT activityId, scheduleId
                                FROM tb_schedule
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $phase[$i]);
                            $sql->execute();
                            $result = $sql->get_result();
                            while ($row = $result->fetch_assoc()) {
                                // Remove Activity by Activity ID
                                $sql = $conn->prepare(
                                    "DELETE FROM tb_activity
                                    WHERE activityId = ?"
                                );
                                $sql->bind_param('s', $row['activityId']);
                                if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                                // Remove Report by Activity ID
                                $sql = $conn->prepare(
                                    "DELETE FROM tb_report
                                    WHERE activityId = ?"
                                );
                                $sql->bind_param('s', $row['activityId']);
                                if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                                // Remove Task List by Schedule ID
                                $sql = $conn->prepare(
                                    "DELETE FROM tb_task_list
                                    WHERE scheduleId = ?"
                                );
                                $sql->bind_param('s', $row['scheduleId']);
                                if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');
                            }

                            // Remove Schedule by Phase ID
                            $sql = $conn->prepare(
                                "DELETE FROM tb_schedule
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $phase[$i]);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                            // Remove Phase by Phase ID
                            $sql = $conn->prepare(
                                "DELETE FROM tb_phase
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $phase[$i]);
                            if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                            $i++;
                        }

                        $logNote = "deleted all phase and schedule on '{$tempScheduleDate}'";

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
                    $output->message = 'No authentication';
                    echo (json_encode($output));
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
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $scheduleStart = $_PUT['start'];
    $scheduleEnd = $_PUT['end'];
    $userHash = $_PUT['hash'];
    $action = $_GET['action'];

    switch ($action) {
        // EDIT SCHEDULE
        case 'schedule':
            $scheduleId = $_PUT['schedule'];

            if (
                isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
                isset($scheduleStart) && !empty($scheduleStart) && $scheduleStart != 'undefined' &&
                isset($scheduleEnd) && !empty($scheduleEnd) && $scheduleEnd != 'undefined' &&
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

                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "SELECT scheduleDate
                        FROM tb_schedule
                        WHERE scheduleId = ?"
                    );
                    $sql->bind_param('s', $scheduleId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $tempScheduleDate = date_format(date_create($result->fetch_assoc()['scheduleDate']), 'd F Y');

                    $sql = $conn->prepare(
                        "UPDATE tb_schedule 
                        SET scheduleStart = ?, scheduleEnd = ?, userName = ? 
                        WHERE scheduleId = ?"
                    );
                    $sql->bind_param('ssss', $scheduleStart, $scheduleEnd, $userName, $scheduleId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $tempScheduleStart = substr($scheduleStart, 0, 5);
                    $tempScheduleEnd = substr($scheduleEnd, 0, 5);
                    $logNote = "updated schedule on '{$tempScheduleDate}' at '{$tempScheduleStart}' - '{$tempScheduleEnd}' WIB";

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
        // EDIT TEMPLATE SCHEDULE
        case 'template':
            $templateId = $_PUT['id'];
            $templateName = strtolower($_PUT['name']);
            $checkpointName = $_PUT['checkpoint'];
            $mapping = $_PUT['mapping'];
            $person = $_PUT['person'];
            $task = $_PUT['task'];

            if (
                isset($templateId) && !empty($templateId) && $templateId != 'undefined' &&
                isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
                isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
                isset($mapping) && !empty($mapping) && $mapping != 'undefined' &&
                isset($person) && !empty($person) && $person != 'undefined' &&
                isset($scheduleStart) && !empty($scheduleStart) && $scheduleStart != 'undefined' &&
                isset($scheduleEnd) && !empty($scheduleEnd) && $scheduleEnd != 'undefined' &&
                isset($task) && !empty($task) && $task != 'undefined' &&
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

                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "UPDATE tb_schedule_template
                        SET templateName = ?, templateMapping = ?, templatePerson = ?, templateCheckpoint = ?, templateStart = ?, templateEnd = ?, templateTask = ?, userName = ?
                        WHERE templateId = ?"
                    );
                    $sql->bind_param('sssssssss', $templateName, $mapping, $person, $checkpointName, $scheduleStart, $scheduleEnd, $task, $userName, $templateId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $logNote = "updated template schedule '{$templateName}'";

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
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $start = microtime(true);
    $action = $_GET['action'];

    switch ($action) {
        //GET SCHEDULE LIST
        case 'schedule':
            $phaseId = $_GET['phase'];

            if (isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined') {

                // Get Schedule ID by Phase ID
                $sql = $conn->prepare(
                    "SELECT activityId 
                    FROM tb_schedule 
                    WHERE phaseId = ?"
                );
                $sql->bind_param('s', $phaseId);
                $sql->execute();
                $results = $sql->get_result();
                $scheduleArray = [];
                while ($rows = $results->fetch_assoc()) {

                    // Get Data
                    $sql = $conn->prepare(
                        "SELECT tb_schedule.scheduleId, checkpointName, personName, mappingId, scheduleStart, scheduleEnd, scheduleDate, activityStatus 
                        FROM tb_schedule, tb_person, tb_activity 
                        WHERE tb_schedule.scheduleId = tb_activity.scheduleId 
                        AND tb_schedule.activityId = ?
                        AND tb_person.personId = tb_schedule.personId 
                        AND phaseId = ?"
                    );
                    $sql->bind_param('ss', $rows['activityId'], $phaseId);
                    $sql->execute();
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $taskArray = [];
                        $mappingName;

                        $sql = $conn->prepare(
                            "SELECT mappingName 
                            FROM tb_person_mapping 
                            WHERE mappingId = ?"
                        );
                        $sql->bind_param('s', $row['mappingId']);
                        $sql->execute();
                        $mapping = $sql->get_result();
                        if ($mapping->num_rows > 0) {
                            while ($rowMapping = $mapping->fetch_assoc()) {

                                $mappingName = $rowMapping['mappingName'];
                            }
                        } else {
                            $mappingName = null;
                        }

                        $date1 = date_create($row['scheduleDate'] . ' ' . $row['scheduleStart']);
                        $date2 = date_create(date('y-m-d H:i:s'));
                        $diff = date_diff($date1, $date2);
                        if ($diff->format("%R") == '-') {
                            $sql = $conn->prepare(
                                "SELECT tb_task.taskId, taskName, taskStatus 
                                FROM tb_task, tb_task_list, tb_schedule 
                                WHERE tb_schedule.scheduleId = tb_task_list.scheduleId 
                                AND tb_task.taskId = tb_task_list.taskId 
                                AND tb_schedule.scheduleId = ?"
                            );
                            $sql->bind_param('s', $row['scheduleId']);
                            $sql->execute();
                            $taskResult = $sql->get_result();
                            if ($taskResult->num_rows > 0) {
                                while ($rowTask = $taskResult->fetch_assoc()) {

                                    $taskArray[] = (object) [
                                        'id' => $rowTask['taskId'],
                                        'name' => ucfirst($rowTask['taskName']),
                                        'state' => $rowTask['taskStatus']
                                    ];
                                }
                            } else {
                                $taskArray = null;
                            }

                            switch ($row['activityStatus']) {
                                case '1':
                                    $scheduleArray[] = (object) [
                                        'id' => $row['scheduleId'],
                                        'mapping' => $mappingName,
                                        'person' => $row['personName'],
                                        'checkpoint' => $row['checkpointName'],
                                        'start' => $row['scheduleStart'],
                                        'end' => $row['scheduleEnd'],
                                        'task' => $taskArray,
                                        'isEdit' => false,
                                        'status' => 'green'
                                    ];
                                    break;
                                default:
                                    $scheduleArray[] = (object) [
                                        'id' => $row['scheduleId'],
                                        'mapping' => $mappingName,
                                        'person' => $row['personName'],
                                        'checkpoint' => $row['checkpointName'],
                                        'start' => $row['scheduleStart'],
                                        'end' => $row['scheduleEnd'],
                                        'task' => $taskArray,
                                        'isEdit' => true,
                                        'status' => 'white'
                                    ];
                                    break;
                            }
                        } else {
                            switch ($row['activityStatus']) {
                                case '1':
                                    $sql = $conn->prepare(
                                        "SELECT tb_task.taskId, taskName, taskStatus 
                                        FROM tb_task, tb_task_list, tb_schedule 
                                        WHERE tb_schedule.scheduleId = tb_task_list.scheduleId 
                                        AND tb_task.taskId = tb_task_list.taskId 
                                        AND tb_schedule.scheduleId = ?"
                                    );
                                    $sql->bind_param('s', $row['scheduleId']);
                                    $sql->execute();
                                    $taskResult = $sql->get_result();
                                    if ($taskResult->num_rows > 0) {
                                        while ($rowTask = $taskResult->fetch_assoc()) {

                                            $taskArray[] = (object) [
                                                'id' => $rowTask['taskId'],
                                                'name' => ucfirst($rowTask['taskName']),
                                                'state' => $rowTask['taskStatus']
                                            ];
                                        }
                                    } else {
                                        $taskArray = null;
                                    }

                                    $scheduleArray[] = (object) [
                                        'id' => $row['scheduleId'],
                                        'mapping' => $mappingName,
                                        'person' => $row['personName'],
                                        'checkpoint' => $row['checkpointName'],
                                        'start' => $row['scheduleStart'],
                                        'end' => $row['scheduleEnd'],
                                        'task' => $taskArray,
                                        'isEdit' => false,
                                        'status' => 'green'
                                    ];
                                    break;
                                default:
                                    $sql = $conn->prepare(
                                        "SELECT tb_task.taskId, taskName, taskStatus 
                                        FROM tb_task, tb_task_list, tb_schedule 
                                        WHERE tb_schedule.scheduleId = tb_task_list.scheduleId 
                                        AND tb_task.taskId = tb_task_list.taskId 
                                        AND tb_schedule.scheduleId = ?"
                                    );
                                    $sql->bind_param('s', $row['scheduleId']);
                                    $sql->execute();
                                    $taskResult = $sql->get_result();
                                    if ($taskResult->num_rows > 0) {
                                        while ($rowTask = $taskResult->fetch_assoc()) {

                                            $taskArray[] = (object) [
                                                'id' => $rowTask['taskId'],
                                                'name' => ucfirst($rowTask['taskName']),
                                                'state' => $rowTask['taskStatus']
                                            ];
                                        }
                                    } else {
                                        $taskArray = null;
                                    }

                                    $scheduleArray[] = (object) [
                                        'id' => $row['scheduleId'],
                                        'mapping' => $mappingName,
                                        'person' => $row['personName'],
                                        'checkpoint' => $row['checkpointName'],
                                        'start' => $row['scheduleStart'],
                                        'end' => $row['scheduleEnd'],
                                        'task' => $taskArray,
                                        'isEdit' => false,
                                        'status' => 'red'
                                    ];
                                    break;
                            }
                        }
                    }
                }
                $output->status = 'success';
                $output->execute = microtime(true) - $execute;
                $output->schedule = $scheduleArray;
                echo (json_encode($output));
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // GET TEMPLATE SCHEDULE
        case 'template':
            $userHash = $_GET['hash'];

            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $userCheck = $sql->get_result();
                if ($userCheck->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT templateId, templateName, lastUpdated 
                        FROM tb_schedule_template
                        ORDER BY templateName ASC"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $templateSchedule = [];
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $templateSchedule[] = (object) [
                                'id' => $row['templateId'],
                                'name' => strtoupper($row['templateName']),
                                'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated']))
                            ];
                        }
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        $output->template = $templateSchedule;
                        echo (json_encode($output));
                    } else {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        $output->template = $templateSchedule;
                        echo (json_encode($output));
                    }
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    $output->message = 'No authentication';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // GET TEMPLATE SCHEDULE DETAIL
        case 'schedule-template':
            $userHash = $_GET['hash'];
            $templateId = $_GET['template'];

            if (
                isset($templateId) && !empty($templateId) && $templateId != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $userCheck = $sql->get_result();
                if ($userCheck->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT templateName, templateMapping, templatePerson, templateCheckpoint, templateStart, templateEnd, templateTask 
                        FROM tb_schedule_template 
                        WHERE templateId = ?"
                    );
                    $sql->bind_param('s', $templateId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $name;
                    $mapping;
                    $person;
                    $checkpoint;
                    $start;
                    $end;
                    $task;
                    while ($row = $result->fetch_assoc()) {
                        $name = strtoupper($row['templateName']);
                        $mapping = explode(',', $row['templateMapping']);
                        $person = explode(',', $row['templatePerson']);
                        $checkpoint = explode(',', $row['templateCheckpoint']);
                        $start = explode(',', $row['templateStart']);
                        $end = explode(',', $row['templateEnd']);
                        $task = json_decode($row['templateTask'], true);
                    }

                    $i = 0;
                    $data = [];
                    while ($i < sizeof($checkpoint)) {
                        $dataTask = [];
                        $j = 0;
                        while ($j < sizeof($task['data'][$i])) {
                            $sql = $conn->prepare(
                                "SELECT taskName 
                                FROM tb_task 
                                WHERE taskId = ?"
                            );
                            $sql->bind_param('s', $task['data'][$i][$j]);
                            $sql->execute();
                            $taskResult = $sql->get_result();
                            while ($rowTask = $taskResult->fetch_assoc()) {
                                $dataTask[] = (object) [
                                    'id' => $task['data'][$i][$j],
                                    'name' => $rowTask['taskName']
                                ];
                            }
                            $j++;
                        }
                        $data[] = (object) [
                            'mapping' => $mapping[$i],
                            'person' => $person[$i],
                            'checkpoint' => $checkpoint[$i],
                            'start' => $start[$i],
                            'end' => $end[$i],
                            'task' => $dataTask
                        ];
                        $i++;
                    }

                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->name = $name;
                    $output->data = $data;
                    echo (json_encode($output));
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    $output->message = 'No authentication';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // GET SCHEDULE LIST 2 DAYS
        case 'activity-schedule':
            $sql = $conn->prepare(
                "SELECT DISTINCT phaseId
                FROM tb_schedule
                WHERE scheduleDate BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 1 DAY
                ORDER BY DATE(scheduleDate) ASC, TIME(scheduleStart) ASC"
            );
            $sql->execute();
            $getPhase = $sql->get_result();
            $checkpointSchedule = [];
            while ($row = $getPhase->fetch_assoc()) {

                $sql = $conn->prepare(
                    "SELECT phaseId, tb_schedule.checkpointName, tb_activity.activityId
                    FROM tb_schedule, tb_activity
                    WHERE phaseId = ?
                    AND tb_schedule.activityId = tb_activity.activityId"
                );
                $sql->bind_param('s', $row['phaseId']);
                $sql->execute();
                $getSchedule = $sql->get_result();
                while ($row = $getSchedule->fetch_assoc()) {

                    $checkpointSchedule[] = (object) [
                        'activityId' => $row['activityId'],
                        'phaseId' => $row['phaseId'],
                        'checkpoint' => $row['checkpointName'],
                        'status' => 'red'
                    ];
                }

            }

            $output->status = 'success';
            $output->execute = microtime(true) - $execute;
            $output->checkpointSchedule = $checkpointSchedule;
            echo (json_encode($output));
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mappingId = $_POST['mapping'];
    $personId = $_POST['person'];
    $checkpointName = $_POST['checkpoint'];
    $scheduleStart = $_POST['start'];
    $scheduleEnd = $_POST['end'];
    $userHash = $_POST['hash'];
    $action = $_GET['action'];

    switch ($action) {
        // ADD SCHEDULE
        case 'schedule':
            $phaseId = $_POST['phase'];
            $scheduleDate = $_POST['date'];

            if (
                isset($mappingId) && !empty($mappingId) && $mappingId != 'undefined' &&
                isset($personId) && !empty($personId) && $personId != 'undefined' &&
                isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
                isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined' &&
                isset($scheduleStart) && !empty($scheduleStart) && $scheduleStart != 'undefined' &&
                isset($scheduleEnd) && !empty($scheduleEnd) && $scheduleEnd != 'undefined' &&
                isset($scheduleDate) && !empty($scheduleDate) && $scheduleDate != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                // Get User by Hash
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];
                
                $scheduleId = date('YmdHis').sprintf('%04d', 1);
                $activityId = date('YmdHis').sprintf('%04d', 1);

                $sql = $conn->prepare(
                    "SELECT phaseId
                    FROM tb_schedule
                    WHERE phaseId = ?"
                );
                $sql->bind_param('s', $phaseId);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows < 1) {
                    try {
                        $conn->begin_transaction();
                        
                        // Insert into Table Schedule
                        $sql = $conn->prepare(
                            "INSERT INTO tb_schedule (scheduleId, mappingId, personId, activityId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                        );
                        $sql->bind_param('ssssssssss', $scheduleId, $mappingId, $personId, $activityId, $checkpointName, $phaseId, $scheduleStart, $scheduleEnd, $scheduleDate, $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');
    
                        // Insert into Table Activity
                        $sql = $conn->prepare(
                            "INSERT INTO tb_activity (activityId, personId, scheduleId, activityStatus)
                            VALUES (?, ?, ?, '0')"
                        );
                        $sql->bind_param("sss", $activityId, $personId, $scheduleId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');
    
                        $tempScheduleDate = date_format(date_create($scheduleDate), 'd F Y');
                        $logNote = "added schedule on '{$tempScheduleDate}'";
    
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
        // ADD TEMPLATE SCHEDULE
        case 'template':
            $templateName = strtolower($_POST['name']);
            $taskName = $_POST['task'];

            if (
                isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
                isset($mappingId) && !empty($mappingId) && $mappingId != 'undefined' &&
                isset($personId) && !empty($personId) && $personId != 'undefined' &&
                isset($checkpointName) && !empty($checkpointName) && $checkpointName != 'undefined' &&
                isset($scheduleStart) && !empty($scheduleStart) && $scheduleStart != 'undefined' &&
                isset($scheduleEnd) && !empty($scheduleEnd) && $scheduleEnd != 'undefined' &&
                isset($taskName) && !empty($taskName) && $taskName != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                // Get User by Hash
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];

                // Get Last Schedule Template ID
                $sql = $conn->prepare(
                    "SELECT templateId 
                    FROM tb_schedule_template 
                    ORDER BY uid DESC LIMIT 1"
                );
                $sql->execute();
                $result = $sql->get_result();
                $templateId = (int)$result->fetch_assoc()['templateId'] + 1;

                try {
                    $conn->begin_transaction();

                    // Insert into Table Schedule Template
                    $sql = $conn->prepare(
                        "INSERT INTO tb_schedule_template (templateId, templateName, templateMapping, templatePerson, templateCheckpoint, templateStart, templateEnd, templateTask, userName)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    $sql->bind_param('sssssssss', $templateId, $templateName, $mappingId, $personId, $checkpointName, $scheduleStart, $scheduleEnd, $taskName, $userName);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "added template schedule '{$templateName}'";

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
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // ADD TEMPLATE ON SCHEDULE
        case 'schedule-template':
            $templateId = strtolower($_POST['template']);
            $phaseId = $_POST['phase'];
            $date = $_POST['date'];

            if (
                isset($templateId) && !empty($templateId) && $templateId != 'undefined' &&
                isset($date) && !empty($date) && $date != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                // Get User by Hash
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];
                
                // Get Schedule Template Data
                $sql = $conn->prepare(
                    "SELECT templateMapping, templatePerson, templateCheckpoint, templateStart, templateEnd, templateTask 
                    FROM tb_schedule_template 
                    WHERE templateId = ?"
                );
                $sql->bind_param('s', $templateId);
                $sql->execute();
                $result = $sql->get_result();

                $mapping;
                $person;
                $checkpoint;
                $start;
                $end;
                $task;

                while ($row = $result->fetch_assoc()) {
                    $mapping = explode(',', $row['templateMapping']);
                    $person = explode(',', $row['templatePerson']);
                    $checkpoint = explode(',', $row['templateCheckpoint']);
                    $start = explode(',', $row['templateStart']);
                    $end = explode(',', $row['templateEnd']);
                    $task = json_decode($row['templateTask'], true);
                }

                $i = 0;
                try {
                    $conn->begin_transaction();

                    while ($i < sizeof($checkpoint)) {

                        $activityId = date('YmdHis').sprintf('%04d', $i + 1);
                        $scheduleId = date('YmdHis').sprintf('%04d', $i + 1);

                        // Insert into Table Schedule
                        $sql = $conn->prepare(
                            "INSERT INTO tb_schedule
                            (scheduleId, mappingId, personId, activityId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                        );
                        $sql->bind_param('ssssssssss', $scheduleId, $mapping[$i], $person[$i], $activityId, $checkpoint[$i], $phaseId, $start[$i], $end[$i], $date, $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        // Insert into Table Activity
                        $sql = $conn->prepare(
                            "INSERT INTO tb_activity
                            (activityId, personId, scheduleId, activityStatus) 
                            VALUES (?, ?, ?, '0')"
                        );
                        $sql->bind_param("sss", $activityId, $person[$i], $scheduleId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        $j = 0;
                        while ($j < sizeof($task['data'][$i])) {

                            // Insert into Table Task List
                            $sql = $conn->prepare(
                                "INSERT INTO tb_task_list
                                (taskId, scheduleId, phaseId, taskStatus, userName) 
                                VALUES (?, ?, ?, '0', ?)"
                            );
                            $sql->bind_param('ssss', $task['data'][$i][$j], $scheduleId, $phaseId, $userName);
                            if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                            $j++;
                        }

                        $i++;
                    }

                    $tempDate = date_format(date_create($date), 'd F Y');
                    $logNote = "added template on schedule at '{$tempDate}'";

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
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        // DUPLICATE TEMPLATE SCHEDULE
        case 'copy-template':
            $templateId = $_POST['template'];

            if (
                isset($templateId) && !empty($templateId) && $templateId != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                // Get User by Hash
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];

                // Get Last Schedule Template ID
                $sql = $conn->prepare(
                    "SELECT templateId 
                    FROM tb_schedule_template 
                    ORDER BY uid DESC LIMIT 1"
                );
                $sql->execute();
                $result = $sql->get_result();
                $tempId = (int)$result->fetch_assoc()['templateId'] + 1;

                // Get Schedule Template Data
                $sql = $conn->prepare(
                    "SELECT templateName, templateMapping, templatePerson, templateCheckpoint, templateStart, templateEnd, templateTask
                    FROM tb_schedule_template
                    WHERE templateId = ?"
                );
                $sql->bind_param('s', $templateId);
                $sql->execute();
                $result = $sql->get_result();

                $templateName;
                $tempTemplateName;
                $templateMapping;
                $templatePerson;
                $templateCheckpoint;
                $templateStart;
                $templateEnd;
                $templateTask;

                while ($row = $result->fetch_assoc()) {
                    $templateName = $row['templateName'];
                    $tempTemplateName = $row['templateName'];
                    $templateMapping = $row['templateMapping'];
                    $templatePerson = $row['templatePerson'];
                    $templateCheckpoint = $row['templateCheckpoint'];
                    $templateStart = $row['templateStart'];
                    $templateEnd = $row['templateEnd'];
                    $templateTask = $row['templateTask'];
                }

                try {
                    $conn->begin_transaction();

                    // Get Schedule Template by Name
                    $tempName = $templateName . '%';
                    $sql = $conn->prepare(
                        "SELECT templateName
                        FROM tb_schedule_template
                        WHERE templateName LIKE ?
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->bind_param('s', $tempName);
                    $sql->execute();
                    $result = $sql->get_result();
                    $str = explode('(', $result->fetch_assoc()['templateName']);
                    $temp = substr($str[1], 0, 1);
                    if ($temp) {
                        $temp = (int)$temp + 1;
                        $templateName = str_replace(' ', '', $str[0]) . ' (' . $temp . ')';
                    } else {
                        $templateName .= ' (2)';
                    }

                    // Insert into Table Schedule Template
                    $sql = $conn->prepare(
                        "INSERT INTO tb_schedule_template
                        (templateId, templateName, templateMapping, templatePerson, templateCheckpoint, templateStart, templateEnd, templateTask, userName)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    $sql->bind_param('sssssssss', $tempId, $templateName, $templateMapping, $templatePerson, $templateCheckpoint, $templateStart, $templateEnd, $templateTask, $userName);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "duplicated template schedule '{$tempTemplateName}'";

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
}