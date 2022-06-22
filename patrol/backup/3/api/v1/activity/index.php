<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personId = $_POST['person'];
    $checkpointId = $_POST['checkpoint'];
    $activityAction = $_POST['action'];
    $reportTime = date('H:i:s');
    $reportDate = date('Y-m-d');

    if (isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($activityAction) && !empty($activityAction) && $activityAction != 'undefined') {

        switch ($activityAction) {
            case 'start':
                $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                $sql->bind_param('s', $checkpointId); $sql->execute();
                $getCheckpoint = $sql->get_result();
                if ($getCheckpoint->num_rows > 0) {
                    $checkpointName;
                    while ($row = $getCheckpoint->fetch_assoc()) {
                        $checkpointName = $row['checkpointName'];
                    }
                    switch ($checkpointName) {
                        case 'Z':
                            $sql = $conn->prepare("SELECT DISTINCT phaseId FROM
                            tb_schedule, tb_activity WHERE tb_activity.activityId = tb_schedule.activityId AND tb_schedule.scheduleDate = ? AND tb_schedule.scheduleStart <= ? AND tb_schedule.scheduleEnd >= ? AND tb_activity.activityStatus = '0' ORDER BY tb_schedule.uid ASC LIMIT 1");
                            $sql->bind_param('sss', date('y-m-d'), date('H:i:s'), date('H:i:s')); $sql->execute();
                            $getPhase = $sql->get_result();
                            if ($getPhase->num_rows > 0) {
                                $phaseId;
                                while ($row = $getPhase->fetch_assoc()) {
                                    $phaseId = $row['phaseId'];
                                }
                                $sql = $conn->prepare("SELECT scheduleId FROM tb_schedule WHERE checkpointName = ? AND phaseId = ?");
                                $sql->bind_param('ss', $checkpointName, $phaseId); $sql->execute();
                                $getSchedule = $sql->get_result();
                                if ($getSchedule->num_rows > 0) {
                                    $scheduleId;
                                    while ($row = $getSchedule->fetch_assoc()) {
                                        $scheduleId = $row['scheduleId'];
                                    }
                                    $sql = $conn->prepare("UPDATE tb_activity SET personId = ?, checkpointStart = ?, activityStart = ? WHERE scheduleId = ?"); $sql->bind_param("ssss", $personId, $checkpointName, date('Y-m-d H:i:s'), $scheduleId);
                                    if ($sql->execute() === TRUE) {
                                        $sql = $conn->prepare("SELECT activityId FROM tb_activity WHERE scheduleId = ?");
                                        $sql->bind_param('s', $scheduleId); $sql->execute();
                                        $getActivity = $sql->get_result();
                                        if ($getActivity->num_rows > 0) {
                                            $activityId;
                                            while ($row = $getActivity->fetch_assoc()) {
                                                $activityId = $row['activityId'];
                                            }
                                            $sql = $conn->prepare("SELECT scheduleStart, scheduleEnd FROM tb_schedule WHERE scheduleId = ?");
                                            $sql->bind_param('s', $scheduleId); $sql->execute();
                                            $scheduleResult = $sql->get_result();
                                            if ($scheduleResult->num_rows > 0) {
                                                $schedule;
                                                while ($row = $scheduleResult->fetch_assoc()) {
                                                    $schedule = (object) [
                                                        checkpoint => $checkpointName,
                                                        start => $row['scheduleStart'],
                                                        end => $row['scheduleEnd']
                                                    ];
                                                }
                                                $output->status = 'success';
                                                $output->activity = $activityId;
                                                $output->schedule = $scheduleId;
                                                $output->progress = $schedule;
                                                $output->action = $activityAction;
                                                echo(json_encode($output));
                                            } else {
                                                $output->status = 'false';
                                                $output->action = $activityAction;
                                                echo(json_encode($output));
                                            }
                                        } else {
                                            $output->status = 'false';
                                            $output->action = $activityAction;
                                            echo(json_encode($output));
                                        }
                                    } else {
                                        $output->status = 'failed';
                                        $output->action = 'update';
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'unknown';
                                    $output->action = $activityAction;
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'false';
                                $output->action = $activityAction;
                                echo(json_encode($output));
                            }
                            break;
                        default:
                            $sql = $conn->prepare("SELECT DISTINCT phaseId FROM
                            tb_schedule, tb_activity WHERE tb_activity.activityId = tb_schedule.activityId AND tb_schedule.scheduleDate = ? AND tb_activity.activityStatus = '0' ORDER BY tb_schedule.uid ASC LIMIT 1");
                            $sql->bind_param('s', date('y-m-d')); $sql->execute();
                            $getPhase = $sql->get_result();
                            if ($getPhase->num_rows > 0) {
                                $phaseId;
                                while ($row = $getPhase->fetch_assoc()) {
                                    $phaseId = $row['phaseId'];
                                }
                                $sql = $conn->prepare("SELECT scheduleId FROM tb_schedule WHERE checkpointName = ? AND phaseId = ?");
                                $sql->bind_param('ss', $checkpointName, $phaseId); $sql->execute();
                                $getSchedule = $sql->get_result();
                                if ($getSchedule->num_rows > 0) {
                                    $scheduleId;
                                    while ($row = $getSchedule->fetch_assoc()) {
                                        $scheduleId = $row['scheduleId'];
                                    }
                                    $sql = $conn->prepare("UPDATE tb_activity SET personId = ?, checkpointStart = ?, activityStart = ? WHERE scheduleId = ?"); $sql->bind_param("ssss", $personId, $checkpointName, date('Y-m-d H:i:s'), $scheduleId);
                                    if ($sql->execute() === TRUE) {
                                        $sql = $conn->prepare("SELECT activityId FROM tb_activity WHERE scheduleId = ?");
                                        $sql->bind_param('s', $scheduleId); $sql->execute();
                                        $getActivity = $sql->get_result();
                                        if ($getActivity->num_rows > 0) {
                                            $activityId;
                                            while ($row = $getActivity->fetch_assoc()) {
                                                $activityId = $row['activityId'];
                                            }
                                            $sql = $conn->prepare("SELECT scheduleStart, scheduleEnd FROM tb_schedule WHERE scheduleId = ?");
                                            $sql->bind_param('s', $scheduleId); $sql->execute();
                                            $scheduleResult = $sql->get_result();
                                            if ($scheduleResult->num_rows > 0) {
                                                $schedule;
                                                while ($row = $scheduleResult->fetch_assoc()) {
                                                    $schedule = (object) [
                                                        checkpoint => $checkpointName,
                                                        start => $row['scheduleStart'],
                                                        end => $row['scheduleEnd']
                                                    ];
                                                }
                                                $output->status = 'success';
                                                $output->activity = $activityId;
                                                $output->schedule = $scheduleId;
                                                $output->progress = $schedule;
                                                $output->action = $activityAction;
                                                echo(json_encode($output));
                                            } else {
                                                $output->status = 'false';
                                                $output->action = $activityAction;
                                                echo(json_encode($output));
                                            }
                                        } else {
                                            $output->status = 'false';
                                            $output->action = $activityAction;
                                            echo(json_encode($output));
                                        }
                                    } else {
                                        $output->status = 'failed';
                                        $output->action = 'update';
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'unknown';
                                    $output->action = $activityAction;
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'false';
                                $output->action = $activityAction;
                                echo(json_encode($output));
                            }
                            break;
                    }
                } else {
                    $output->status = 'false';
                    $output->action = $activityAction;
                    echo(json_encode($output));
                }
                break;
            case 'end':
                $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                $sql->bind_param('s', $checkpointId); $sql->execute();
                $getCheckpoint = $sql->get_result();
                if ($getCheckpoint->num_rows > 0) {
                    $checkpointName;
                    while ($row = $getCheckpoint->fetch_assoc()) {
                        $checkpointName = $row['checkpointName'];
                    }
                    $sql = $conn->prepare("SELECT DISTINCT phaseId FROM tb_schedule, tb_activity WHERE tb_activity.activityId = tb_schedule.activityId AND tb_schedule.scheduleDate = ? AND tb_activity.activityStatus = '0' ORDER BY tb_schedule.uid ASC LIMIT 1");
                    $sql->bind_param('s', date('y-m-d')); $sql->execute();
                    $getPhase = $sql->get_result();
                    if ($getPhase->num_rows > 0) {
                        $phaseId;
                        while ($row = $getPhase->fetch_assoc()) {
                            $phaseId = $row['phaseId'];
                        }
                        $sql = $conn->prepare("SELECT scheduleId FROM tb_activity WHERE checkpointEnd IS NULL AND checkpointStart IS NOT NULL"); $sql->execute();
                        $getSchedule = $sql->get_result();
                        if ($getSchedule->num_rows > 0) {
                            $scheduleId;
                            while ($row = $getSchedule->fetch_assoc()) {
                                $scheduleId = $row['scheduleId'];
                            }
                            switch ($checkpointName) {
                                case 'Z':
                                    $sql = $conn->prepare("UPDATE tb_activity SET personId = ?, checkpointEnd = ?, activityEnd = ?, activityStatus = '1' WHERE scheduleId = ?"); $sql->bind_param("ssss", $personId, $checkpointName, date('Y-m-d H:i:s'), $scheduleId);
                                    if ($sql->execute() === TRUE) {
                                        $sql = $conn->prepare("SELECT tb_activity.activityId FROM
                                        tb_schedule, tb_activity WHERE tb_activity.activityId = tb_schedule.activityId AND tb_activity.activityStatus = '0' AND tb_schedule.phaseId = ?");
                                        $sql->bind_param('s', $phaseId); $sql->execute();
                                        $skip = $sql->get_result();
                                        if ($skip->num_rows > 0) {
                                            $isSuccess = false;
                                            $counter = 0;
                                            while ($rowSkip = $skip->fetch_assoc()) {

                                                if (++$counter >= $skip) {
                                                    $sql = $conn->prepare("UPDATE tb_activity SET activityStatus = '-' WHERE activityId = ?"); $sql->bind_param("s", $rowSkip['activityId']);
                                                    if ($sql->execute() === TRUE) {
                                                        $isSuccess = true;
                                                    } else {
                                                        $isSuccess = false;
                                                    }
                                                } else {
                                                    if ($isSuccess === FALSE) {
                                                        $sql = $conn->prepare("UPDATE tb_activity SET activityStatus = '-' WHERE activityId = ?"); $sql->bind_param("s", $rowSkip['activityId']);
                                                        $sql->execute();
                                                        if ($sql->execute() === TRUE) {
                                                            $isSuccess = false;
                                                        } else {
                                                            $isSuccess = true;
                                                        }
                                                    }
                                                }

                                            }
                                            if ($isSuccess === TRUE) {
                                                $sql = $conn->prepare("SELECT activityId FROM tb_activity WHERE scheduleId = ?");
                                                $sql->bind_param('s', $scheduleId); $sql->execute();
                                                $getActivity = $sql->get_result();
                                                if ($getActivity->num_rows > 0) {
                                                    $activityId;
                                                    while ($row = $getActivity->fetch_assoc()) {
                                                        $activityId = $row['activityId'];
                                                    }
                                                    $output->status = 'success';
                                                    $output->activity = $activityId;
                                                    $output->schedule = $scheduleId;
                                                    $output->isEnd = true;
                                                    echo(json_encode($output));
                                                } else {
                                                    $output->status = 'false';
                                                    echo(json_encode($output));
                                                }
                                            } else {
                                                $output->status = 'failed';
                                                $output->action = 'update';
                                                echo(json_encode($output));
                                            }
                                        } else {
                                            $sql = $conn->prepare("SELECT activityId FROM tb_activity WHERE scheduleId = ?");
                                            $sql->bind_param('s', $scheduleId); $sql->execute();
                                            $getActivity = $sql->get_result();
                                            if ($getActivity->num_rows > 0) {
                                                $activityId;
                                                while ($row = $getActivity->fetch_assoc()) {
                                                    $activityId = $row['activityId'];
                                                }
                                                $output->status = 'success';
                                                $output->activity = $activityId;
                                                $output->schedule = $scheduleId;
                                                $output->isEnd = true;
                                                echo(json_encode($output));
                                            } else {
                                                $output->status = 'false';
                                                echo(json_encode($output));
                                            }
                                        }
                                    } else {
                                        $output->status = 'failed';
                                        $output->action = 'update';
                                        echo(json_encode($output));
                                    }
                                    break;
                                default:
                                    $sql = $conn->prepare("UPDATE tb_activity SET personId = ?, checkpointEnd = ?, activityEnd = ?, activityStatus = '1' WHERE scheduleId = ?"); $sql->bind_param("ssss", $personId, $checkpointName, date('Y-m-d H:i:s'), $scheduleId);
                                    if ($sql->execute() === TRUE) {
                                        $sql = $conn->prepare("SELECT activityId FROM tb_activity WHERE scheduleId = ?");
                                        $sql->bind_param('s', $scheduleId); $sql->execute();
                                        $getActivity = $sql->get_result();
                                        if ($getActivity->num_rows > 0) {
                                            $activityId;
                                            while ($row = $getActivity->fetch_assoc()) {
                                                $activityId = $row['activityId'];
                                            }
                                            $output->status = 'success';
                                            $output->activity = $activityId;
                                            $output->schedule = $scheduleId;
                                            $output->isEnd = false;
                                            echo(json_encode($output));
                                        } else {
                                            $output->status = 'false';
                                            echo(json_encode($output));
                                        }
                                    } else {
                                        $output->status = 'failed';
                                        $output->action = 'update';
                                        echo(json_encode($output));
                                    }
                                    break;
                            }
                        } else {
                            $output->status = 'unknown';
                            echo(json_encode($output));
                        }
                    } else {
                        $output->status = 'false';
                        $output->action = $activityAction;
                        echo(json_encode($output));
                    }
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }
                break;
        }
    } elseif (isset($activityAction) && !empty($activityAction) && $activityAction != 'undefined' && $activityAction === 'schedule' &&
        isset($personId) && !empty($personId) && $personId != 'undefined') {
        $sql = $conn->prepare("SELECT activityId FROM tb_activity ORDER BY uid DESC LIMIT 1"); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            while ($rowCheck = $resultCheck->fetch_assoc()) {
                $activityId = (int)$rowCheck['activityId'] + 1;
                $sql = $conn->prepare("INSERT INTO tb_activity (activityId, personId, activityStatus) VALUES (?, ?, '0')"); $sql->bind_param("is", $activityId, $personId);
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    $output->activity = $activityId;
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'insert';
                    echo(json_encode($output));
                }
            }
        } else {
            $activityId = '1';
            $sql = $conn->prepare("INSERT INTO tb_activity (activityId, personId, activityStatus) VALUES (?, ?, '0')"); $sql->bind_param("is", $activityId, $personId);
            if ($sql->execute() === TRUE) {
                $output->status = 'success';
                echo(json_encode($output));
            } else {
                $output->status = 'failed';
                $output->action = 'insert';
                echo(json_encode($output));
            }
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseId = $_GET['phase'];
    $scheduleId = $_GET['schedule'];
    $userHash = $_GET['hash'];

    if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined') {
        $sql = $conn->prepare("SELECT phaseId FROM tb_schedule WHERE scheduleId = ?");
        $sql->bind_param('s', $scheduleId); $sql->execute();
        $phaseResult = $sql->get_result();
        if ($phaseResult->num_rows > 0) {
            $phaseId;
            while ($rowPhase = $phaseResult->fetch_assoc()) {
                $phaseId = $rowPhase['phaseId'];
            }
            $sql = $conn->prepare("SELECT checkpointName FROM tb_schedule WHERE phaseId = ?");
            $sql->bind_param('s', $phaseId); $sql->execute();
            $progress = $sql->get_result();
            if ($progress->num_rows > 0) {
                $scheduleArray = [];
                while ($rowProgress = $progress->fetch_assoc()) {

                    $sql = $conn->prepare("SELECT checkpointStart, activityStatus FROM tb_schedule, tb_activity WHERE tb_activity.activityId = tb_schedule.activityId AND tb_activity.checkpointStart = ? AND tb_schedule.phaseId = ?");
                    $sql->bind_param('ss', $rowProgress['checkpointName'], $phaseId); $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            switch ($row['activityStatus']) {
                                case '0':
                                    $scheduleArray[] = (object) [
                                        checkpoint => $row['checkpointStart'],
                                        status => 'blue'
                                    ];
                                    break;
                                case '1':
                                    $scheduleArray[] = (object) [
                                        checkpoint => $row['checkpointStart'],
                                        status => 'green'
                                    ];
                                    break;
                                default:
                                    $scheduleArray[] = (object) [
                                        checkpoint => $rowProgress['checkpointName'],
                                        status => 'red'
                                    ];
                                    break;
                            }

                        }
                    } else {
                        $scheduleArray[] = (object) [
                            checkpoint => $rowProgress['checkpointName'],
                            status => 'red'
                        ];
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
            $output->status = 'false';
            echo(json_encode($output));
        }
    } elseif (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
        isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined') {

        $sql = $conn->prepare("SELECT checkpointName, personName FROM tb_schedule, tb_person WHERE tb_person.personId = tb_schedule.personId AND tb_schedule.phaseId = ?");
        $sql->bind_param('s', $phaseId); $sql->execute();
        $progress = $sql->get_result();
        if ($progress->num_rows > 0) {
            $scheduleArray = [];
            while ($rowProgress = $progress->fetch_assoc()) {

                $sql = $conn->prepare("SELECT checkpointStart, activityStatus, activityStart, activityEnd, personName
                    FROM tb_schedule, tb_activity, tb_person
                    WHERE tb_activity.activityId = tb_schedule.activityId AND tb_person.personId = tb_activity.personId AND tb_activity.checkpointStart = ? AND tb_schedule.phaseId = ?");
                $sql->bind_param('ss', $rowProgress['checkpointName'], $phaseId); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        switch ($row['activityStatus']) {
                            case '0':
                                $scheduleArray[] = (object)[
                                    checkpoint => $rowProgress['checkpointName'],
                                    start => date('j M H:i:s', strtotime($row['activityStart'])),
                                    end => null,
                                    person => ucfirst($row['personName']),
                                    status => 'blue'
                                ];
                                break;
                            case '1':
                                $scheduleArray[] = (object) [
                                    checkpoint => $rowProgress['checkpointName'],
                                    start => date('j M H:i:s', strtotime($row['activityStart'])),
                                    end => date('j M H:i:s', strtotime($row['activityEnd'])),
                                    person => ucfirst($row['personName']),
                                    status => 'green'
                                ];
                                break;
                            default:
                                $scheduleArray[] = (object)[
                                    checkpoint => $rowProgress['checkpointName'],
                                    start => null,
                                    end => null,
                                    person => ucfirst($rowProgress['personName']),
                                    status => 'red'
                                ];
                                break;
                        }

                    }
                } else {
                    $scheduleArray[] = (object)[
                        checkpoint => $rowProgress['checkpointName'],
                        start => null,
                        end => null,
                        person => ucfirst($rowProgress['personName']),
                        status => 'red'
                    ];
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