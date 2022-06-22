<?php
include '../../config.php';
$output;
$execute = microtime(true);
$restAPI = 'phase';

//REMOVE PHASE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $phaseId = $_DELETE['phase'];
    $userHash = $_DELETE['hash'];

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
                    "SELECT phaseDate
                    FROM tb_phase
                    WHERE phaseId = ?"
                );
                $sql->bind_param('s', $phaseId);
                $sql->execute();
                $result = $sql->get_result();
                $tempPhase = date_format(date_create($result->fetch_assoc()['phaseDate']), 'd F Y');

                $sql = $conn->prepare(
                    "DELETE FROM tb_phase 
                    WHERE phaseId = ?"
                );
                $sql->bind_param('s', $phaseId);
                if ($sql->execute() === FALSE) throw new Exception('Statement DELETE Failed');

                $logNote = "deleted phase on '{$tempPhase}'";

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
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseDate = $_GET['date'];
    $action = $_GET['action'];

    if (
        isset($phaseDate) && !empty($phaseDate) && $phaseDate != 'undefined' &&
        isset($action) && !empty($action) && $action != 'undefined'
    ) {
        switch ($action) {
            //GET PHASE DASHBOARD
            case 'dashboard':
                $sql = $conn->prepare(
                    "SELECT DISTINCT tb_phase.phaseId 
                    FROM tb_phase, tb_schedule 
                    WHERE tb_phase.phaseId = tb_schedule.phaseId 
                    AND tb_phase.phaseDate = ?"
                );
                $sql->bind_param("s", $phaseDate);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $phase = [];
                    while ($row = $result->fetch_assoc()) {
                        array_push($phase, $row['phaseId']);
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->phaseId = $phase;
                    echo (json_encode($output));
                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                }
                break;
            //GET PHASE SCHEDULE
            case 'schedule':
                $sql = $conn->prepare(
                    "SELECT phaseId 
                    FROM tb_phase 
                    WHERE phaseDate = ?"
                );
                $sql->bind_param("s", $phaseDate);
                $sql->execute();
                $result = $sql->get_result();
                $phase = [];
                $unknown = [];
                while ($row = $result->fetch_assoc()) {

                    $sql = $conn->prepare(
                        "SELECT scheduleStart
                        FROM tb_schedule
                        WHERE phaseId = ?
                        AND scheduleDate = ?
                        ORDER BY scheduleStart ASC LIMIT 1"
                    );
                    $sql->bind_param("ss", $row['phaseId'], $phaseDate);
                    $sql->execute();
                    $subResult = $sql->get_result();
                    $scheduleStart;
                    if ($subResult->num_rows > 0) {
                        $scheduleStart = $subResult->fetch_assoc()['scheduleStart'];
                    } else {
                        $scheduleStart = '99:99:99';
                    }

                    $hours = substr($scheduleStart, 0, 2) . ":00";
                    $tempHours = substr($scheduleStart, 0, 2) . ":59";

                    $sql = $conn->prepare(
                        "SELECT DISTINCT phaseId
                        FROM tb_schedule
                        WHERE scheduleStart BETWEEN ? AND ?
                        AND scheduleDate = ?"
                    );
                    $sql->bind_param("sss", $hours, $tempHours, $phaseDate);
                    $sql->execute();
                    $subResult = $sql->get_result();
                    $schedule = [];
                    if ($subResult->num_rows > 0) {
                        while ($subrow = $subResult->fetch_assoc()) {
                            array_push($schedule, $subrow['phaseId']);
                        }
                    } else {
                        array_push($unknown, (string)$row['phaseId']);
                    }

                    if ($scheduleStart != "99:99:99") {
                        $phase[] = (object) [
                            'group' => $hours.' - '.$tempHours,
                            'phase' => $schedule
                        ];
                    }
                }

                if (count($unknown) > 0) {
                    $phase[] = (object) [
                        'group' => 'Unknown',
                        'phase' => $unknown
                    ];
                }
                usort($phase, 'comparator');
                $output->status = 'success';
                $output->execute = microtime(true) - $execute;
                $output->phase = my_array_unique($phase);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phaseDate = $_POST['date'];
    $userHash = $_POST['hash'];
    $action = $_GET['action'];

    if (isset($phaseDate) && !empty($phaseDate) && $phaseDate != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        switch ($action) {
            //ADD PHASE
            case 'add':
                try {
                    $conn->begin_transaction();

                    $phaseId = date('YmdHis').sprintf('%04d', 1);

                    $sql = $conn->prepare(
                        "SELECT userName 
                        FROM tb_users 
                        WHERE hashWeb = ?"
                    );
                    $sql->bind_param('s', $userHash);
                    $sql->execute();
                    $result = $sql->get_result();
                    $userName = $result->fetch_assoc()['userName'];

                    $tempPhase = date_format(date_create($phaseDate), 'd F Y');
        
                    $sql = $conn->prepare(
                        "INSERT INTO tb_phase (phaseId, phaseDate) 
                        VALUES (?, ?)"
                    );
                    $sql->bind_param('ss', $phaseId, $phaseDate);
                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    $logNote = "added phase on '{$tempPhase}'";

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
                break;
            //DUPLICATE PHASE
            case 'duplicate':
                $selectDate = $_POST['date-select'];

                if (isset($selectDate) && !empty($selectDate) && $selectDate != 'undefined') {
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
                        "SELECT DISTINCT phaseId
                        FROM tb_phase
                        WHERE phaseDate = ?"
                    );
                    $sql->bind_param('s', $phaseDate);
                    $sql->execute();
                    $result = $sql->get_result();

                    try {
                        $conn->begin_transaction();
                        
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {

                            $phaseId = date('YmdHis') . sprintf('%04d', $i + 1);

                            //INSERT PHASE
                            $sql = $conn->prepare(
                                "INSERT INTO tb_phase
                                (phaseId, phaseDate) 
                                VALUES (?, ?)"
                            );
                            $sql->bind_param('ss', $phaseId, $selectDate);
                            if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                            $sql = $conn->prepare(
                                "SELECT scheduleId, mappingId, personId, checkpointName, scheduleStart, scheduleEnd
                                FROM tb_schedule
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $row['phaseId']);
                            $sql->execute();
                            $subResult = $sql->get_result();

                            $j = 0;
                            while ($subrow = $subResult->fetch_assoc()) {

                                $scheduleId = date('YmdHis') . sprintf('%02d%02d', $i, $j + 1);
                                $activityId = date('YmdHis') . sprintf('%02d%02d', $i, $j + 1);

                                //INSERT SCHEDULE
                                $sql = $conn->prepare(
                                    "INSERT INTO tb_schedule
                                    (scheduleId, mappingId, personId, activityId, checkpointName, phaseId, scheduleStart, scheduleEnd, scheduleDate, userName)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                                );
                                $sql->bind_param('ssssssssss', $scheduleId, $subrow['mappingId'], $subrow['personId'], $activityId, $subrow['checkpointName'], $phaseId, $subrow['scheduleStart'], $subrow['scheduleEnd'], $selectDate, $userName);
                                if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                                //INSERT ACTIVITY
                                $sql = $conn->prepare(
                                    "INSERT INTO tb_activity
                                    (activityId, personId, scheduleId, activityStatus)
                                    VALUES (?, ?, ?, '0')"
                                );
                                $sql->bind_param('sss', $activityId, $subrow['personId'], $scheduleId);
                                if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                                $sql = $conn->prepare(
                                    "SELECT taskId
                                    FROM tb_task_list
                                    WHERE scheduleId = ?"
                                );
                                $sql->bind_param('s', $subrow['scheduleId']);
                                $sql->execute();
                                $nestedResult = $sql->get_result();
                                while ($nestedrow = $nestedResult->fetch_assoc()) {

                                    //INSERT TASK LIST
                                    $sql = $conn->prepare(
                                        "INSERT INTO tb_task_list
                                        (taskId, scheduleId, phaseId, taskStatus, userName)
                                        VALUES (?, ?, ?, '0', ?)"
                                    );
                                    $sql->bind_param('ssss', $nestedrow['taskId'], $scheduleId, $phaseId, $userName);
                                    if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');
                                }

                                $j++;
                            }
    
                            $i++;
                        }

                        $tempPhaseDate = date_format(date_create($phaseDate), 'd F Y');
                        $tempSelectDate = date_format(date_create($selectDate), 'd F Y');

                        $logNote = "added all phase on '{$tempPhaseDate}' to '{$tempSelectDate}'";

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
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

function my_array_unique($array, $keep_key_assoc = false){
    $duplicate_keys = array();
    $tmp = array();       

    foreach ($array as $key => $val){
        // convert objects to arrays, in_array() does not support objects
        if (is_object($val))
            $val = (array)$val;

        if (!in_array($val, $tmp))
            $tmp[] = $val;
        else
            $duplicate_keys[] = $key;
    }

    foreach ($duplicate_keys as $key)
        unset($array[$key]);

    return $keep_key_assoc ? $array : array_values($array);
}

function comparator($object1, $object2) {
    return $object1->group > $object2->group;
}