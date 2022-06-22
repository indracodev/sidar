<?php
include '../../config.php';
$output;
$execute = microtime(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'];

    switch ($action) {
        // GET ALL ACTIVITY AND TASK
        case 'activity':
            $sql = $conn->prepare(
                "SELECT DISTINCT phaseId
                FROM tb_schedule
                WHERE scheduleDate BETWEEN CURRENT_DATE() AND CURRENT_DATE() + INTERVAL 1 DAY
                ORDER BY DATE(scheduleDate) ASC, TIME(scheduleStart) ASC"
            );
            $sql->execute();
            $getPhase = $sql->get_result();
            $schedule = [];
            while ($row = $getPhase->fetch_assoc()) {

                $sql = $conn->prepare(
                    "SELECT phaseId, tb_schedule.scheduleId, tb_schedule.checkpointName, mappingId, tb_person.personId, personName, tb_activity.activityId, scheduleDate, scheduleStart, scheduleEnd
                    FROM tb_schedule, tb_person, tb_activity
                    WHERE phaseId = ?
                    AND tb_schedule.activityId = tb_activity.activityId
                    AND tb_schedule.personId = tb_person.personId"
                );
                $sql->bind_param('s', $row['phaseId']);
                $sql->execute();
                $getSchedule = $sql->get_result();
                while ($row = $getSchedule->fetch_assoc()) {
                
                    $end; $endDate;
                    $sql = $conn->prepare(
                        "SELECT scheduleEnd, scheduleDate
                        FROM tb_schedule
                        WHERE phaseId = ?
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->bind_param('s', $row['phaseId']);
                    $sql->execute();
                    $getEnd = $sql->get_result();
                    while ($subrow = $getEnd->fetch_assoc()) {
                        $end = $subrow['scheduleEnd'];
                        $endDate = $subrow['scheduleDate'];
                    }

                    $sql = $conn->prepare(
                        "SELECT scheduleStart
                        FROM tb_schedule
                        WHERE phaseId = ?
                        ORDER BY uid ASC LIMIT 1;"
                    );
                    $sql->bind_param('s', $row['phaseId']);
                    $sql->execute();
                    $getStart = $sql->get_result();
                    $start = $getStart->fetch_assoc()['scheduleStart'];

                    // Get Task by Schedule ID
                    $sql = $conn->prepare(
                        "SELECT tb_task_list.taskId, taskName
                        FROM tb_task_list, tb_task
                        WHERE tb_task.taskId = tb_task_list.taskId
                        AND scheduleId = ?"
                    );
                    $sql->bind_param('s', $row['scheduleId']);
                    $sql->execute();
                    $getTask = $sql->get_result();
                    $task = [];
                    while ($subrow = $getTask->fetch_assoc()) {

                        $task[] = (object) [
                            'taskId' => $subrow['taskId'],
                            'taskName' => ucfirst($subrow['taskName']),
                            'taskStatus' => '0'
                        ];

                    }

                    // Set Response
                    $schedule[] = (object) [
                        'activityId' => $row['activityId'],
                        'phaseId' => $row['phaseId'],
                        'mappingId' => $row['mappingId'],
                        'personId' => $row['personId'],
                        'personName' => ucfirst($row['personName']),
                        'checkpointStart' => null,
                        'checkpointEnd' => null,
                        'scheduleId' => $row['scheduleId'],
                        'scheduleDate' => $row['scheduleDate'],
                        'scheduleStart' => $row['scheduleStart'],
                        'scheduleEnd' => $row['scheduleEnd'],
                        'scheduleCheckpoint' => $row['checkpointName'],
                        'end' => $end,
                        'endDate' => $endDate,
                        'start' => $start,
                        'group' => substr($start, 0, 2),
                        'activityStart' => null,
                        'activityEnd' => null,
                        'latitudeStart' => null,
                        'longitudeStart' => null,
                        'latitudeEnd' => null,
                        'longitudeEnd' => null,
                        'reportNote' => null,
                        'reportDate' => null,
                        'reportTime' => null,
                        'activityStatus' => '0',
                        'isUploaded' => '0',
                        'task' => $task
                    ];
                }

            }

            count($schedule) > 0 ? $output->status = 'success' : $output->status = 'false';
            $output->execute = microtime(true) - $execute;
            $output->schedule = $schedule;
            echo (json_encode($output));
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}

// GET ACTIVITY DETAIL
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseId = $_GET['phase'];
    $userHash = $_GET['hash'];

    if (
        isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined'
    ) {

        $sql = $conn->prepare(
            "SELECT checkpointName, personName
            FROM tb_schedule, tb_person, tb_activity
            WHERE tb_person.personId = tb_schedule.personId
            AND tb_schedule.scheduleId = tb_activity.scheduleId
            AND tb_schedule.phaseId = ?
            ORDER BY tb_activity.activityId ASC"
        );
        $sql->bind_param('s', $phaseId);
        $sql->execute();
        $result = $sql->get_result();
        $scheduleArray = [];
        while ($row = $result->fetch_assoc()) {

            $sql = $conn->prepare(
                "SELECT checkpointStart, activityStatus, activityStart, activityEnd, personName,
                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleStart), activityStart)) as elapseStart,
                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleEnd), activityEnd)) as elapseEnd
                FROM tb_schedule, tb_activity, tb_person
                WHERE tb_activity.activityId = tb_schedule.activityId
                AND tb_person.personId = tb_activity.personId
                AND tb_activity.checkpointStart = ?
                AND tb_schedule.phaseId = ?"
            );
            $sql->bind_param('ss', $row['checkpointName'], $phaseId);
            $sql->execute();
            $subresult = $sql->get_result();
            if ($subresult->num_rows > 0) {
                while ($subrow = $subresult->fetch_assoc()) {

                    switch ($subrow['activityStatus']) {
                        case '0':
                            $eStartStatus;
                            if (substr(detectTime($subrow['elapseStart']), 0, 1) == '+') {
                                $eStartStatus = 'blue';
                            }

                            if (substr(detectTime($subrow['elapseStart']), 0, 1) == '-') {
                                $eStartStatus = 'red';
                            }

                            $scheduleArray[] = (object)[
                                'checkpoint' => $row['checkpointName'],
                                'start' => date('j M H:i:s', strtotime($subrow['activityStart'])),
                                'elapseStart' => detectTime($subrow['elapseStart']),
                                'eStartStatus' => $eStartStatus,
                                'end' => null,
                                'elapseEnd' => null,
                                'eEndStatus' => null,
                                'person' => ucfirst($subrow['personName']),
                                'status' => 'blue'
                            ];
                            break;
                        case '1':
                            $eStartStatus;
                            $eEndStatus;
                            if (substr(detectTime($subrow['elapseStart']), 0, 1) == '+') {
                                $eStartStatus = 'blue';
                            }

                            if (substr(detectTime($subrow['elapseEnd']), 0, 1) == '+') {
                                $eEndStatus = 'blue';
                            }

                            if (substr(detectTime($subrow['elapseStart']), 0, 1) == '-') {
                                $eStartStatus = 'red';
                            }

                            if (substr(detectTime($subrow['elapseEnd']), 0, 1) == '-') {
                                $eEndStatus = 'red';
                            }

                            $scheduleArray[] = (object) [
                                'checkpoint' => $row['checkpointName'],
                                'start' => date('j M H:i:s', strtotime($subrow['activityStart'])),
                                'elapseStart' => detectTime($subrow['elapseStart']),
                                'eStartStatus' => $eStartStatus,
                                'end' => date('j M H:i:s', strtotime($subrow['activityEnd'])),
                                'elapseEnd' => detectTime($subrow['elapseEnd']),
                                'eEndStatus' => $eEndStatus,
                                'person' => ucfirst($subrow['personName']),
                                'status' => 'green'
                            ];
                            break;
                        default:
                            $scheduleArray[] = (object)[
                                'checkpoint' => $row['checkpointName'],
                                'start' => null,
                                'elapseStart' => null,
                                'eStartStatus' => null,
                                'end' => null,
                                'elapseEnd' => null,
                                'eEndStatus' => null,
                                'person' => ucfirst($row['personName']),
                                'status' => 'red'
                            ];
                            break;
                    }
                }
            } else {
                $scheduleArray[] = (object)[
                    'checkpoint' => $row['checkpointName'],
                    'starts' => null,
                    'elapseStart' => null,
                    'eStartStatus' => null,
                    'end' => null,
                    'elapseEnd' => null,
                    'eEndStatus' => null,
                    'person' => ucfirst($row['personName']),
                    'status' => 'red'
                ];
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
}

function detectTime ($time) {
    if (substr($time, 0, 1) == '-') {
        return $time;
    } else {
        return '+'.$time;
    }
}