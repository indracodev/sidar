<?php
include '../../config.php';
$output;
$execute = microtime(true);
$restAPI = 'task';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $userHash = $_DELETE['hash'];
    $action = $_GET['action'];

    switch ($action) {
        //REMOVE TEMPLATE TASK
        case 'template':
            $templateName = strtolower($_DELETE['template']);

            if (
                isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
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
                            "DELETE FROM tb_task_template 
                            WHERE templateName = ?"
                        );
                        $sql->bind_param('s', $templateName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        $logNote = "deleted task template '{$templateName}'";

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
        //REMOVE TASK
        case 'task':
            $taskId = $_DELETE['id'];

            if (
                isset($taskId) && !empty($taskId) && $taskId != 'undefined' &&
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
                        "SELECT taskName
                        FROM tb_task
                        WHERE taskId = ?"
                    );
                    $sql->bind_param('s', $taskId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $tempTaskName = $result->fetch_assoc()['taskName'];

                    $sql = $conn->prepare(
                        "UPDATE tb_task 
                        SET isDeleted = '1', userName = ? 
                        WHERE taskId = ?"
                    );
                    $sql->bind_param('ss', $userName, $taskId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $logNote = "deleted task '{$tempTaskName}'";

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
    $userHash = $_PUT['hash'];
    $action = $_GET['action'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        switch ($action) {
            //EDIT TASK
            case 'task':
                $taskId = $_PUT['id'];
                $taskName = strtolower($_PUT['task']);

                if (
                    isset($taskId) && !empty($taskId) && $taskId != 'undefined' &&
                    isset($taskName) && !empty($taskName) && $taskName != 'undefined'
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
                            "SELECT taskName
                            FROM tb_task
                            WHERE taskId = ?"
                        );
                        $sql->bind_param('s', $taskId);
                        $sql->execute();
                        $result = $sql->get_result();
                        $tempTaskName = $result->fetch_assoc()['taskName'];

                        $sql = $conn->prepare(
                            "UPDATE tb_task 
                            SET taskName = ?, userName = ? 
                            WHERE taskId = ?"
                        );
                        $sql->bind_param('sss', $taskName, $userName, $taskId);
                        if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                        $logNote = "updated task '{$tempTaskName}' to '{$taskName}'";

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
            //EDIT TEMPLATE TASK
            case 'template':
                $templateName = $_PUT['template'];
                $oldTemplateName = $_PUT['_template'];
                $task = $_PUT['task'];

                if (isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
                    isset($oldTemplateName) && !empty($oldTemplateName) && $oldTemplateName != 'undefined' &&
                    isset($task) && !empty($task) && $task != 'undefined') {
                    $sql = $conn->prepare(
                        "SELECT userName 
                        FROM tb_users 
                        WHERE hashWeb = ?"
                    );

                    $sql->bind_param('s', $userHash);
                    $sql->execute();
                    $result = $sql->get_result();
                    $userName = $result->fetch_assoc()['userName'];

                    $str = explode(',', $task);
                    $i = 0;

                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "DELETE FROM tb_task_template 
                            WHERE templateName = ?"
                        );
                        $sql->bind_param('s', $oldTemplateName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                        while ($i < count($str)) {
                            $sql = $conn->prepare(
                                "INSERT INTO tb_task_template
                                (templateName, taskId, userName) 
                                VALUES (?, ?, ?)"
                            );
                            $sql->bind_param('sss', $templateName, $str[$i], $userName);
                            if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                            $i++;
                        }

                        $logNote = "updated task template '{$templateName}'";

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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $action = $_GET['action'];

    switch ($action) {
        // GET TASK TEMPLATE LIST
        case 'template':
            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {

                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT DISTINCT templateName 
                        FROM tb_task_template
                        ORDER BY templateName ASC"
                    );
                    $sql->execute();
                    $subresult = $sql->get_result();
                    $templateArray = [];
                    while ($row = $subresult->fetch_assoc()) {

                        $taskArray = [];
                        $sql = $conn->prepare(
                            "SELECT tb_task.taskId, taskName, tb_task_template.lastUpdated 
                            FROM tb_task_template, tb_task 
                            WHERE tb_task.taskId = tb_task_template.taskId 
                            AND tb_task_template.templateName = ? 
                            AND isDeleted = '0'
                            ORDER BY taskName ASC"
                        );
                        $sql->bind_param('s', $row['templateName']);
                        $sql->execute();
                        $nestedresult = $sql->get_result();
                        while ($subrow = $nestedresult->fetch_assoc()) {
                            $taskArray[] = (object) [
                                'id' => $subrow['taskId'],
                                'name' => ucfirst($subrow['taskName'])
                            ];
                        }

                        $templateArray[] = (object) [
                            'name' => ucfirst($row['templateName']),
                            'task' => $taskArray
                        ];
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->template = $templateArray;
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
        // GET TASK LIST
        case 'task':
            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT taskId, taskName, lastUpdated 
                        FROM tb_task 
                        WHERE isDeleted = '0'
                        ORDER BY taskName ASC"
                    );
                    $sql->execute();
                    $subresult = $sql->get_result();
                    $taskArray = [];
                    while ($row = $subresult->fetch_assoc()) {
                        $taskArray[] = (object) [
                            'id' => $row['taskId'],
                            'name' => ucfirst($row['taskName']),
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                        ];
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->task = $taskArray;
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
        // GET TASK REPORT DETAIL
        case 'report':
            $phaseId = $_GET['phase'];

            if (
                isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
                isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined'
            ) {
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
                        "SELECT tb_activity.activityId 
                        FROM tb_schedule, tb_activity
                        WHERE phaseId = ?
                        AND tb_schedule.activityId = tb_activity.activityId
                        ORDER BY tb_activity.activityStart ASC"
                    );
                    $sql->bind_param('s', $phaseId);
                    $sql->execute();
                    $subresult = $sql->get_result();
                    $personArray = [];
                    $i = 1;
                    while ($row = $subresult->fetch_assoc()) {
                        $sql = $conn->prepare(
                            "SELECT scheduleId, personName, tb_report.activityId,
                            GROUP_CONCAT(checkpointName separator ',') as checkpointName,
                            GROUP_CONCAT(reportLatitude) as latitude, GROUP_CONCAT(reportLongitude) as longitude, activityStart, activityEnd, reportNote
                            FROM tb_activity, tb_report, tb_person
                            WHERE tb_person.personId = tb_report.personId 
                            AND tb_report.activityId = tb_activity.activityId 
                            AND tb_report.activityId = ? 
                            AND tb_activity.activityStatus = '1'"
                        );
                        $sql->bind_param('s', $row['activityId']);
                        $sql->execute();
                        $nestedresult = $sql->get_result();
                        while ($subrow = $nestedresult->fetch_assoc()) {

                            if (!$subrow['activityId']) {
                                $personArray[] = (object) [
                                    'no' => $i,
                                    'person' => null,
                                    'checkpoint' => null,
                                    'startLocation' => null,
                                    'endLocation' => null,
                                    'task' => null,
                                    'note' => null,
                                    'date' => null,
                                    'time' => null
                                ];
                            }

                            $sql = $conn->prepare(
                                "SELECT taskName, taskStatus 
                                FROM tb_task_list, tb_task 
                                WHERE tb_task_list.taskId = tb_task.taskId 
                                AND scheduleId = ?"
                            );
                            $sql->bind_param('s', $subrow['scheduleId']);
                            $sql->execute();
                            $task = $sql->get_result();
                            if ($task->num_rows > 0) {
                                $taskArray = [];
                                while ($rowTask = $task->fetch_assoc()) {
                                    $taskArray[] = (object) [
                                        'name' => ucfirst($rowTask['taskName']),
                                        'status' => $rowTask['taskStatus'],
                                    ];
                                }
                                $latitude = explode(',', $subrow['latitude']);
                                $longitude = explode(',', $subrow['longitude']);
                                if ($subrow['personName']) {
                                    $date = date_create(substr($subrow['activityStart'], 0, 10));
                                    $personArray[] = (object) [
                                        'no' => $i,
                                        'person' => ucfirst($subrow['personName']),
                                        'checkpoint' => $subrow['checkpointName'],
                                        'startLocation' => $longitude[0] . ',' . $latitude[0],
                                        'endLocation' => $longitude[1] . ',' . $latitude[1],
                                        'task' => $taskArray,
                                        'note' => $subrow['reportNote'],
                                        'date' => date_format($date, 'd/m/Y'),
                                        'time' => substr($subrow['activityStart'], 11) . ' WIB - ' . substr($subrow['activityEnd'], 11) . ' WIB'
                                    ];
                                }
                            } else {
                                $latitude = explode(',', $subrow['latitude']);
                                $longitude = explode(',', $subrow['longitude']);
                                if ($subrow['personName']) {
                                    $date = date_create(substr($subrow['activityStart'], 0, 10));
                                    $personArray[] = (object) [
                                        'no' => $i,
                                        'person' => ucfirst($subrow['personName']),
                                        'checkpoint' => $subrow['checkpointName'],
                                        'startLocation' => $longitude[0] . ',' . $latitude[0],
                                        'endLocation' => $longitude[1] . ',' . $latitude[1],
                                        'task' => null,
                                        'note' => $subrow['reportNote'],
                                        'date' => date_format($date, 'd/m/Y'),
                                        'time' => substr($subrow['activityStart'], 11) . ' WIB - ' . substr($subrow['activityEnd'], 11) . ' WIB'
                                    ];
                                }
                            }
                        }
                        $i++;
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->report = $personArray;
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
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userHash = $_POST['hash'];
    $action = $_GET['action'];

    switch ($action) {
        // ADD TASK TEMPLATE
        case 'template':
            $templateName = strtolower($_POST['template']);
            $task = $_POST['task'];

            if (
                isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
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

                $str = explode(',', $task);
                $i = 0;

                try {
                    $conn->begin_transaction();

                    while ($i < count($str)) {
                        $sql = $conn->prepare(
                            "INSERT INTO tb_task_template
                            (templateName, taskId, userName) 
                            VALUES (?, ?, ?)"
                        );
                        $sql->bind_param('sss', $templateName, $str[$i], $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        $i++;
                    }

                    $logNote = "added task template '{$templateName}'";

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
                echo (json_encode($output));
            }
            break;
        // ADD TASK
        case 'task':
            $taskName = strtolower($_POST['task']);

            if (
                isset($taskName) && !empty($taskName) && $taskName != 'undefined' &&
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

                $sql = $conn->prepare(
                    "SELECT taskId 
                    FROM tb_task 
                    ORDER BY uid DESC LIMIT 1"
                );
                $sql->execute();
                $result = $sql->get_result();
                $taskId = (int)$result->fetch_assoc()['taskId'] + 1;

                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "INSERT INTO tb_task
                        (taskId, taskName, isDeleted, userName) 
                        VALUES (?, ?, '0', ?)"
                    );
                    $sql->bind_param('sss', $taskId, $taskName, $userName);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "added task '{$taskName}'";

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
        // SET TASK SCHEDULE
        case 'set':
            $scheduleId = $_POST['id'];
            $task = $_POST['task'];

            if (
                isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
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

                $str = explode(',', $task);
                $i = 0;
                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "SELECT phaseId, scheduleStart, scheduleEnd, scheduleDate
                        FROM tb_schedule
                        WHERE scheduleId = ?"
                    );
                    $sql->bind_param('s', $scheduleId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $phaseId; $scheduleStart; $scheduleEnd; $scheduleDate;
                    while ($row = $result->fetch_assoc()) {
                        $phaseId = $row['phaseId'];
                        $scheduleStart = substr($row['scheduleStart'], 0, 5);
                        $scheduleEnd = substr($row['scheduleEnd'], 0, 5);
                        $scheduleDate = date_format(date_create($row['scheduleDate']), 'd F Y');
                    }

                    while ($i < count($str)) {
                        $sql = $conn->prepare(
                            "INSERT INTO tb_task_list
                            (taskId, scheduleId, phaseId, taskStatus, userName) 
                            VALUES (?, ?, ?, '0', ?)"
                        );
                        $sql->bind_param('ssss', $str[$i], $scheduleId, $phaseId, $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        $i++;
                    }

                    $logNote = "added task on '{$scheduleDate}' at '{$scheduleStart}' - '{$scheduleEnd}' WIB";

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
