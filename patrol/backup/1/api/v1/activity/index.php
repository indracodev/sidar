<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str(file_get_contents("php://input"),$_PATCH);
    $personId = $_POST['person'];
    $checkpointId = $_POST['checkpoint'];
    $reportLatitude = $_POST['latitude'];
    $reportLongitude = $_POST['longitude'];
    $reportTime = date('H:i:s');
    $reportDate = date('Y-m-d');

    if (isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($reportLatitude) && !empty($reportLatitude) && $reportLatitude != 'undefined' &&
        isset($reportLongitude) && !empty($reportLongitude) && $reportLongitude != 'undefined') {
        $activityCheck = $conn->prepare("SELECT activityId FROM tb_activity WHERE personId = ? AND activityStatus = '0'");
        $activityCheck->bind_param('s', $personId);
        $activityCheck->execute();
        $activityResult = $activityCheck->get_result();
        if ($activityResult->num_rows > 0) {

            while ($rowActivity = $activityResult->fetch_assoc()) {
                $activityId = $rowActivity['activityId'];
                $sql = $conn->prepare("UPDATE tb_activity SET activityEnd = ?, activityStatus = '1' WHERE personId = ? AND activityId = ?");
                $sql->bind_param('sss', date('Y-m-d H:i:s'),$personId, $activityId);
                if ($sql->execute() === TRUE) {

                    $reportCheck = $conn->prepare("SELECT reportId FROM tb_report ORDER BY reportId DESC LIMIT 1");
                    $reportCheck->execute();
                    $resultReport = $reportCheck->get_result();
                    if ($resultReport->num_rows > 0) {
                        while ($rowCheck = $resultReport->fetch_assoc()) {
                            $reportId = (int)$rowCheck['reportId'] + 1;
                            $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointId, reportDate, reportTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql->bind_param('ssssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointId, $reportDate, $reportTime);
                            if ($sql->execute() === TRUE) {
                                $checkpointCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                                $checkpointCheck->bind_param('s', $checkpointId);
                                $checkpointCheck->execute();
                                $resultCheckpoint = $checkpointCheck->get_result();
                                if ($resultCheckpoint->num_rows > 0) {
                                    while ($row = $resultCheckpoint->fetch_assoc()) {
                                        $output->status = 'success';
                                        $output->checkpoint = $row['checkpointName'];
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'false';
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        }
                    }

                } else {
                    $output->status = 'failed';
                    echo(json_encode($output));
                }
            }

        } else {

            $sqlCheck = $conn->prepare("SELECT activityId FROM tb_activity ORDER BY activityId DESC LIMIT 1");
            $sqlCheck->execute();
            $resultCheck = $sqlCheck->get_result();
            if ($resultCheck->num_rows > 0) {
                while ($rowCheck = $resultCheck->fetch_assoc()) {
                    $activityId = (int)$rowCheck['activityId'] + 1;
                    $activityStatus = '0';
                    $sql = $conn->prepare("INSERT INTO tb_activity (activityId, personId, activityStart, activityStatus) VALUES (?, ?, ?, ?)");
                    $sql->bind_param("isss", $activityId, $personId, date('Y-m-d H:i:s'), $activityStatus);
                    if ($sql->execute() === TRUE) {

                        $reportCheck = $conn->prepare("SELECT reportId FROM tb_report ORDER BY reportId DESC LIMIT 1");
                        $reportCheck->execute();
                        $resultReport = $reportCheck->get_result();
                        if ($resultReport->num_rows > 0) {
                            while ($rowCheck = $resultReport->fetch_assoc()) {
                                $reportId = (int)$rowCheck['reportId'] + 1;
                                $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointId, reportDate, reportTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $sql->bind_param('ssssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointId, $reportDate, $reportTime);
                                if ($sql->execute() === TRUE) {
                                    $checkpointCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                                    $checkpointCheck->bind_param('s', $checkpointId);
                                    $checkpointCheck->execute();
                                    $resultCheckpoint = $checkpointCheck->get_result();
                                    if ($resultCheckpoint->num_rows > 0) {
                                        while ($row = $resultCheckpoint->fetch_assoc()) {
                                            $output->status = 'success';
                                            $output->checkpoint = $row['checkpointName'];
                                            echo(json_encode($output));
                                        }
                                    } else {
                                        $output->status = 'false';
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'failed';
                                    echo(json_encode($output));
                                }
                            }
                        } else {
                            $reportId = '1';
                            $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointId, reportDate, reportTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql->bind_param('ssssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointId, $reportDate, $reportTime);
                            if ($sql->execute() === TRUE) {
                                $checkpointCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                                $checkpointCheck->bind_param('s', $checkpointId);
                                $checkpointCheck->execute();
                                $resultCheckpoint = $checkpointCheck->get_result();
                                if ($resultCheckpoint->num_rows > 0) {
                                    while ($row = $resultCheckpoint->fetch_assoc()) {
                                        $output->status = 'success';
                                        $output->checkpoint = $row['checkpointName'];
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'false';
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        }

                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                }
            } else {
                $activityId = '1';
                $activityStatus = '0';
                $sql = $conn->prepare("INSERT INTO tb_activity (activityId, personId, activityStart, activityStatus) VALUES (?, ?, ?, ?)");
                $sql->bind_param("isss", $activityId, $personId, date('Y-m-d H:i:s'), $activityStatus);
                if ($sql->execute() === TRUE) {

                    $reportCheck = $conn->prepare("SELECT reportId FROM tb_report ORDER BY reportId DESC LIMIT 1");
                    $reportCheck->execute();
                    $resultReport = $reportCheck->get_result();
                    if ($resultReport->num_rows > 0) {
                        while ($rowCheck = $resultReport->fetch_assoc()) {
                            $reportId = (int)$rowCheck['reportId'] + 1;
                            $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointId, reportDate, reportTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql->bind_param('ssssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointId, $reportDate, $reportTime);
                            if ($sql->execute() === TRUE) {
                                $checkpointCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                                $checkpointCheck->bind_param('s', $checkpointId);
                                $checkpointCheck->execute();
                                $resultCheckpoint = $checkpointCheck->get_result();
                                if ($resultCheckpoint->num_rows > 0) {
                                    while ($row = $resultCheckpoint->fetch_assoc()) {
                                        $output->status = 'success';
                                        $output->checkpoint = $row['checkpointName'];
                                        echo(json_encode($output));
                                    }
                                } else {
                                    $output->status = 'false';
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        }
                    } else {
                        $reportId = '1';
                        $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointId, reportDate, reportTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $sql->bind_param('ssssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointId, $reportDate, $reportTime);
                        if ($sql->execute() === TRUE) {
                            $checkpointCheck = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
                            $checkpointCheck->bind_param('s', $checkpointId);
                            $checkpointCheck->execute();
                            $resultCheckpoint = $checkpointCheck->get_result();
                            if ($resultCheckpoint->num_rows > 0) {
                                while ($row = $resultCheckpoint->fetch_assoc()) {
                                    $output->status = 'success';
                                    $output->checkpoint = $row['checkpointName'];
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'false';
                                echo(json_encode($output));
                            }
                        } else {
                            $output->status = 'failed';
                            echo(json_encode($output));
                        }
                    }

                } else {
                    $output->status = 'failed';
                    echo(json_encode($output));
                }
            }

        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}