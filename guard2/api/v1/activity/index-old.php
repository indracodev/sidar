<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'];

    switch ($action) {
        case 'prepare':
            $sql = $conn->prepare(
                "SELECT tb_activity.activityId, activityStatus
                FROM tb_activity, tb_schedule
                WHERE tb_activity.activityId = tb_schedule.activityId
                AND CONCAT(scheduleDate, ' ', scheduleStart) < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE)
                AND activityStatus = '0'"
            );
            $sql->execute();
            $skipper = $sql->get_result();
            if ($skipper->num_rows > 0) {

                $isSuccess = false;

                try {
                    $conn->begin_transaction();

                    while ($row = $skipper->fetch_assoc()) {
                        $sql = $conn->prepare(
                            "UPDATE tb_activity
                            SET activityStatus = '-'
                            WHERE activityId = ?"
                        );
                        $sql->bind_param('s', $row['activityId']);
                        if ($sql->execute() === FALSE) {
                            $isSuccess = false;
                            throw new Exception('Statement UPDATE Failed');
                        }
                    }
                } catch (Exception $e) {
                    $conn->rollback();
                } finally {
                    $isSuccess = true;
                    $conn->commit();
                }

                if ($isSuccess) {
                    $output->status = 'success';
                    echo (json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'update';
                    $output->table = 'activity';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'success';
                echo (json_encode($output));
            }
            break;
        case 'finish':
            $mappingTag = $_POST['person'];
            $scheduleId = $_POST['schedule'];

            if (
                isset($mappingTag) && !empty($mappingTag) && $mappingTag != 'undefined' &&
                isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT checkpointId
                    FROM tb_checkpoint
                    WHERE checkpointName = 'Z'"
                );
                $sql->execute();
                $getCheckpoint = $sql->get_result();
                if ($getCheckpoint->num_rows > 0) {
                    $checkpointId;
                    while ($row = $getCheckpoint->fetch_assoc()) {
                        $checkpointId = $row['checkpointId'];
                    }

                    $sql = $conn->prepare(
                        "SELECT DISTINCT phaseId
                        FROM tb_schedule, tb_activity
                        WHERE tb_activity.activityId = tb_schedule.activityId
                        AND scheduleDate = CURRENT_DATE
                        AND activityStatus = '0'
                        ORDER BY tb_schedule.uid ASC LIMIT 1"
                    );
                    $sql->execute();
                    $getPhase = $sql->get_result();
                    $phaseId = '0';
                    $timeStart;
                    while ($row = $getPhase->fetch_assoc()) {
                        $phaseId = $row['phaseId'];
                        $sql = $conn->prepare(
                            "SELECT DISTINCT scheduleStart
                            FROM tb_schedule, tb_activity
                            WHERE tb_activity.activityId = tb_schedule.activityId
                            AND scheduleDate = CURRENT_DATE
                            AND phaseId = ?
                            ORDER BY tb_schedule.uid ASC LIMIT 1"
                        );
                        $sql->bind_param('s', $row['phaseId']);
                        $sql->execute();
                        $getStart = $sql->get_result();
                        while ($rowStart = $getStart->fetch_assoc()) {
                            $timeStart = $rowStart['scheduleStart'];
                        }
                    }

                    $sql = $conn->prepare(
                        "SELECT tb_person.personId, mappingName
                        FROM tb_person, tb_person_mapping, tb_schedule, tb_activity
                        WHERE tb_schedule.mappingId = tb_person_mapping.mappingId
                        AND tb_schedule.personId = tb_person.personId
                        AND tb_schedule.scheduleId = tb_activity.scheduleId
                        AND mappingTag = ?
                        AND activityStatus = '0'
                        AND scheduleDate = CURRENT_DATE
                        AND scheduleEnd >= CURRENT_TIME
                        ORDER BY scheduleDate ASC, scheduleStart ASC LIMIT 1"
                    );
                    $sql->bind_param('s', $mappingTag);
                    $sql->execute();
                    $getPerson = $sql->get_result();
                    if ($getPerson->num_rows > 0 && $timeStart <= date("H:i:s")) {
                        $personId;
                        while ($row = $getPerson->fetch_assoc()) {
                            $personId = $row['personId'];
                        }

                        try {
                            $conn->begin_transaction();

                            $sql = $conn->prepare(
                                "UPDATE tb_activity
                                SET personId = ?, checkpointEnd = 'Z', activityEnd = CURRENT_TIMESTAMP, activityStatus = '1'
                                WHERE scheduleId = ?"
                            );
                            $sql->bind_param("ss", $personId, $scheduleId);
                            if ($sql->execute() === FALSE) {
                                $output->status = 'failed';
                                $output->action = 'update';
                                $output->table = 'activity';
                                echo (json_encode($output));
                                throw new Exception('Statement UPDATE Failed');
                            }
                        } catch (Exception $e) {
                            $conn->rollback();
                        } finally {
                            $conn->commit();
                            $sql = $conn->prepare(
                                "SELECT activityId
                                FROM tb_activity
                                WHERE scheduleId = ?"
                            );
                            $sql->bind_param('s', $scheduleId);
                            $sql->execute();
                            $getActivity = $sql->get_result();
                            if ($getActivity->num_rows > 0) {
                                $activityId;
                                while ($row = $getActivity->fetch_assoc()) {
                                    $activityId = $row['activityId'];
                                }

                                $sql = $conn->prepare(
                                    "SELECT tb_activity.activityId
                                    FROM tb_activity, tb_schedule
                                    WHERE tb_activity.activityId = tb_schedule.activityId
                                    AND phaseId = ?
                                    AND activityStatus = '0'"
                                );
                                $sql->bind_param('s', $phaseId);
                                $sql->execute();
                                $getSkipper = $sql->get_result();
                                while ($row = $getSkipper->fetch_assoc()) {
                                    $sql = $conn->prepare(
                                        "UPDATE tb_activity
                                        SET activityStatus = '-'
                                        WHERE activityId = ?"
                                    );
                                    $sql->bind_param('s', $row['activityId']);
                                    $sql->execute();
                                }

                                $output->status = 'success';
                                $output->activity = $activityId;
                                $output->schedule = $scheduleId;
                                $output->person = $personId;
                                $output->checkpoint = $checkpointId;
                                echo (json_encode($output));
                            } else {
                                $output->status = 'false';
                                echo (json_encode($output));
                            }
                        }
                        
                    } else {
                        $output->status = 'unknown';
                        echo (json_encode($output));
                    }
                } else {
                    $output->status = 'unknown';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                echo (json_encode($output));
            }
            break;
        case 'activity':
            $mappingTag = $_POST['person'];
            $checkpointId = $_POST['checkpoint'];
            $state = $_GET['state'];
            $scheduleId = $_POST['schedule'];

            if (
                isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
                isset($mappingTag) && !empty($mappingTag) && $mappingTag != 'undefined' &&
                isset($state) && !empty($state) && $state != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT checkpointName
                    FROM tb_checkpoint
                    WHERE checkpointId = ?"
                );
                $sql->bind_param('s', $checkpointId);
                $sql->execute();
                $getCheckpoint = $sql->get_result();
                if ($getCheckpoint->num_rows > 0) {
                    $checkpointName;
                    while ($row = $getCheckpoint->fetch_assoc()) {
                        $checkpointName = $row['checkpointName'];
                    }

                    $sql = $conn->prepare(
                        "SELECT DISTINCT phaseId
                        FROM tb_schedule, tb_activity
                        WHERE tb_activity.activityId = tb_schedule.activityId
                        AND scheduleDate = CURRENT_DATE
                        AND activityStatus = '0'
                        ORDER BY tb_schedule.uid ASC LIMIT 1"
                    );
                    $sql->execute();
                    $getPhase = $sql->get_result();
                    $phaseId = '0';
                    $timeStart;
                    while ($row = $getPhase->fetch_assoc()) {
                        $phaseId = $row['phaseId'];

                        $sql = $conn->prepare(
                            "SELECT DISTINCT scheduleStart
                            FROM tb_schedule, tb_activity
                            WHERE tb_activity.activityId = tb_schedule.activityId
                            AND scheduleDate = CURRENT_DATE
                            AND phaseId = ?
                            ORDER BY tb_schedule.uid ASC LIMIT 1"
                        );
                        $sql->bind_param('s', $phaseId);
                        $sql->execute();
                        $getStart = $sql->get_result();
                        while ($rowStart = $getStart->fetch_assoc()) {
                            $timeStart = $rowStart['scheduleStart'];
                        }
                    }

                    if ($state == 'start') {
                        $sql = $conn->prepare(
                            "SELECT scheduleId
                            FROM tb_schedule
                            WHERE checkpointName = ?
                            AND phaseId = ?"
                        );
                        $sql->bind_param('ss', $checkpointName, $phaseId);
                        $sql->execute();
                        $getSchedule = $sql->get_result();
                        $scheduleId = '0';
                        while ($row = $getSchedule->fetch_assoc()) {
                            $scheduleId = $row['scheduleId'];
                        }
                    }

                    $sql = $conn->prepare(
                        "SELECT tb_person.personId, mappingName
                        FROM tb_person, tb_person_mapping, tb_schedule, tb_activity
                        WHERE tb_schedule.mappingId = tb_person_mapping.mappingId
                        AND tb_schedule.personId = tb_person.personId
                        AND tb_schedule.scheduleId = tb_activity.scheduleId
                        AND mappingTag = ?
                        AND activityStatus = '0'
                        AND scheduleDate = CURRENT_DATE
                        AND scheduleEnd >= CURRENT_TIME
                        ORDER BY scheduleDate ASC, scheduleStart ASC LIMIT 1"
                    );
                    $sql->bind_param('s', $mappingTag);
                    $sql->execute();
                    $getPerson = $sql->get_result();
                    if ($getPerson->num_rows > 0 && $timeStart <= date("H:i:s")) {
                        $personId;
                        while ($row = $getPerson->fetch_assoc()) {
                            $personId = $row['personId'];
                        }

                        $sql = $conn->prepare(
                            "SELECT checkpointStart
                            FROM tb_activity
                            WHERE checkpointStart = ?
                            AND scheduleId = ?"
                        );
                        $sql->bind_param('ss', $checkpointName, $scheduleId);
                        $sql->execute();
                        $isExist = $sql->get_result();
                        if ($isExist->num_rows < 1) {
                            try {
                                $conn->begin_transaction();

                                switch ($state) {
                                    case 'start':
                                        $sql = $conn->prepare(
                                            "UPDATE tb_activity
                                            SET personId = ?, checkpointStart = ?, activityStart = CURRENT_TIMESTAMP
                                            WHERE scheduleId = ?"
                                        );
                                        $sql->bind_param("sss", $personId, $checkpointName, $scheduleId);
                                        break;
                                    case 'end':
                                        $sql = $conn->prepare(
                                            "UPDATE tb_activity
                                            SET personId = ?, checkpointEnd = ?, activityEnd = CURRENT_TIMESTAMP, activityStatus = '1'
                                            WHERE scheduleId = ?"
                                        );
                                        $sql->bind_param("sss", $personId, $checkpointName, $scheduleId);
                                        break;
                                }

                                if ($sql->execute() === FALSE) {
                                    $output->status = 'failed';
                                    $output->action = 'update';
                                    $output->table = 'activity';
                                    echo (json_encode($output));
                                    throw new Exception('Statement UPDATE Failed');
                                }
                            } catch (Exception $e) {
                                $conn->rollback();
                            } finally {
                                $conn->commit();
                                $sql = $conn->prepare(
                                    "SELECT activityId
                                    FROM tb_activity
                                    WHERE scheduleId = ?"
                                );
                                $sql->bind_param('s', $scheduleId);
                                $sql->execute();
                                $getActivity = $sql->get_result();
                                if ($getActivity->num_rows > 0) {
                                    $activityId;
                                    while ($row = $getActivity->fetch_assoc()) {
                                        $activityId = $row['activityId'];
                                    }
    
                                    $sql = $conn->prepare(
                                        "SELECT scheduleStart, scheduleEnd
                                        FROM tb_schedule
                                        WHERE scheduleId = ?"
                                    );
                                    $sql->bind_param('s', $scheduleId);
                                    $sql->execute();
                                    $scheduleResult = $sql->get_result();
                                    if ($scheduleResult->num_rows > 0) {
                                        $schedule;
                                        while ($row = $scheduleResult->fetch_assoc()) {
                                            $schedule = (object) [
                                                'checkpoint' => $checkpointName,
                                                'start' => $row['scheduleStart'],
                                                'end' => $row['scheduleEnd']
                                            ];
                                        }
    
                                        $output->status = 'success';
                                        $output->activity = $activityId;
                                        $output->schedule = $scheduleId;
                                        $output->person = $personId;
                                        $output->checkpoint = $checkpointName;
                                        $output->progress = $schedule;
                                        echo (json_encode($output));
                                    } else {
                                        $output->status = 'false';
                                        echo (json_encode($output));
                                    }
                                } else {
                                    $output->status = 'false';
                                    echo (json_encode($output));
                                }
                            }
                        } else {
                            $output->status = 'false';
                            echo (json_encode($output));
                        }
                    } else {
                        $output->status = 'unknown';
                        echo (json_encode($output));
                    }
                } else {
                    $output->status = 'unknown';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                echo (json_encode($output));
            }
            break;
        case 'schedule':
            $userHash = $_GET['hash'];
            $personId = $_POST['person'];

            if (
                isset($personId) && !empty($personId) && $personId != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT userName
                    FROM tb_users
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT activityId
                        FROM tb_activity
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->execute();
                    $resultCheck = $sql->get_result();
                    $activityId = '1';
                    while ($rowCheck = $resultCheck->fetch_assoc()) {
                        $activityId = (int)$rowCheck['activityId'] + 1;
                    }

                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "INSERT INTO tb_activity (activityId, personId, activityStatus)
                            VALUES (?, ?, '0')"
                        );
                        $sql->bind_param("is", $activityId, $personId);
                        if ($sql->execute() === FALSE) {
                            $output->status = 'failed';
                            $output->action = 'insert';
                            $output->action = 'activity';
                            echo (json_encode($output));
                            throw new Exception('Statement INSERT Failed');
                        }
                    } catch (Exception $e) {
                        $conn->rollback();
                    } finally {
                        $output->status = 'success';
                        $output->activity = $activityId;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                } else {
                    $output->status = 'false';
                    echo (json_encode($output));
                }
            } else {
                $output->status = 'error';
                echo (json_encode($output));
            }
            break;
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseId = $_GET['phase'];
    $scheduleId = $_GET['schedule'];
    $userHash = $_GET['hash'];

    if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined') {
        $sql = $conn->prepare(
            "SELECT phaseId
            FROM tb_schedule
            WHERE scheduleId = ?"
        );
        $sql->bind_param('s', $scheduleId);
        $sql->execute();
        $phaseResult = $sql->get_result();
        if ($phaseResult->num_rows > 0) {
            $phaseId;
            while ($rowPhase = $phaseResult->fetch_assoc()) {
                $phaseId = $rowPhase['phaseId'];
            }
            $sql = $conn->prepare(
                "SELECT checkpointName
                FROM tb_schedule
                WHERE phaseId = ?"
            );
            $sql->bind_param('s', $phaseId);
            $sql->execute();
            $progress = $sql->get_result();
            if ($progress->num_rows > 0) {
                $scheduleArray = [];
                while ($rowProgress = $progress->fetch_assoc()) {

                    $sql = $conn->prepare(
                        "SELECT checkpointStart, activityStatus
                        FROM tb_schedule, tb_activity
                        WHERE tb_activity.activityId = tb_schedule.activityId
                        AND tb_activity.checkpointStart = ?
                        AND tb_schedule.phaseId = ?"
                    );
                    $sql->bind_param('ss', $rowProgress['checkpointName'], $phaseId);
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            switch ($row['activityStatus']) {
                                case '0':
                                    $scheduleArray[] = (object) [
                                        'checkpoint' => $row['checkpointStart'],
                                        'status' => 'blue'
                                    ];
                                    break;
                                case '1':
                                    $scheduleArray[] = (object) [
                                        'checkpoint' => $row['checkpointStart'],
                                        'status' => 'green'
                                    ];
                                    break;
                                default:
                                    $scheduleArray[] = (object) [
                                        'checkpoint' => $rowProgress['checkpointName'],
                                        'status' => 'red'
                                    ];
                                    break;
                            }
                        }
                    } else {
                        $scheduleArray[] = (object) [
                            'checkpoint' => $rowProgress['checkpointName'],
                            'status' => 'red'
                        ];
                    }
                }
                $output->status = 'success';
                $output->schedule = $scheduleArray;
                echo (json_encode($output));
            } else {
                $output->status = 'false';
                echo (json_encode($output));
            }
        } else {
            $output->status = 'false';
            echo (json_encode($output));
        }
    } elseif (
        isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined'
    ) {

        $sql = $conn->prepare(
            "SELECT checkpointName, personName
            FROM tb_schedule, tb_person
            WHERE tb_person.personId = tb_schedule.personId
            AND tb_schedule.phaseId = ?"
        );
        $sql->bind_param('s', $phaseId);
        $sql->execute();
        $progress = $sql->get_result();
        if ($progress->num_rows > 0) {
            $scheduleArray = [];
            while ($rowProgress = $progress->fetch_assoc()) {

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
                $sql->bind_param('ss', $rowProgress['checkpointName'], $phaseId);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        switch ($row['activityStatus']) {
                            case '0':
                                $eStartStatus;
                                if (substr(detectTime($row['elapseStart']), 0, 1) == '+') {
                                    $eStartStatus = 'blue';
                                }

                                if (substr(detectTime($row['elapseStart']), 0, 1) == '-') {
                                    $eStartStatus = 'red';
                                }

                                $scheduleArray[] = (object)[
                                    'checkpoint' => $rowProgress['checkpointName'],
                                    'start' => date('j M H:i:s', strtotime($row['activityStart'])),
                                    'elapseStart' => detectTime($row['elapseStart']),
                                    'eStartStatus' => $eStartStatus,
                                    'end' => null,
                                    'elapseEnd' => null,
                                    'eEndStatus' => null,
                                    'person' => ucfirst($row['personName']),
                                    'status' => 'blue'
                                ];
                                break;
                            case '1':
                                $eStartStatus;
                                $eEndStatus;
                                if (substr(detectTime($row['elapseStart']), 0, 1) == '+') {
                                    $eStartStatus = 'blue';
                                }

                                if (substr(detectTime($row['elapseEnd']), 0, 1) == '+') {
                                    $eEndStatus = 'blue';
                                }

                                if (substr(detectTime($row['elapseStart']), 0, 1) == '-') {
                                    $eStartStatus = 'red';
                                }

                                if (substr(detectTime($row['elapseEnd']), 0, 1) == '-') {
                                    $eEndStatus = 'red';
                                }

                                $scheduleArray[] = (object) [
                                    'checkpoint' => $rowProgress['checkpointName'],
                                    'start' => date('j M H:i:s', strtotime($row['activityStart'])),
                                    'elapseStart' => detectTime($row['elapseStart']),
                                    'eStartStatus' => $eStartStatus,
                                    'end' => date('j M H:i:s', strtotime($row['activityEnd'])),
                                    'elapseEnd' => detectTime($row['elapseEnd']),
                                    'eEndStatus' => $eEndStatus,
                                    'person' => ucfirst($row['personName']),
                                    'status' => 'green'
                                ];
                                break;
                            default:
                                $scheduleArray[] = (object)[
                                    'checkpoint' => $rowProgress['checkpointName'],
                                    'start' => null,
                                    'elapseStart' => null,
                                    'eStartStatus' => null,
                                    'end' => null,
                                    'elapseEnd' => null,
                                    'eEndStatus' => null,
                                    'person' => ucfirst($rowProgress['personName']),
                                    'status' => 'red'
                                ];
                                break;
                        }
                    }
                } else {
                    $scheduleArray[] = (object)[
                        'checkpoint' => $rowProgress['checkpointName'],
                        'start' => null,
                        'elapseStart' => null,
                        'eStartStatus' => null,
                        'end' => null,
                        'elapseEnd' => null,
                        'eEndStatus' => null,
                        'person' => ucfirst($rowProgress['personName']),
                        'status' => 'red'
                    ];
                }
            }
            $output->status = 'success';
            $output->schedule = $scheduleArray;
            echo (json_encode($output));
        } else {
            $output->status = 'false';
            echo (json_encode($output));
        }
    } else {
        $output->status = 'error';
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