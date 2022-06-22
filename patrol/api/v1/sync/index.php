<?php
include '../../config.php';
$output;
$execute = microtime(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activityId         = $_POST["activityId"];
    $personId           = $_POST["personId"];
    $scheduleId         = $_POST["scheduleId"];
    $phaseId            = $_POST["phaseId"];
    $checkpointStart    = $_POST["checkpointStart"];
    $checkpointEnd      = $_POST["checkpointEnd"];
    $activityStart      = $_POST["activityStart"] == '0000-00-00 00:00:00' ? NULL : $_POST["activityStart"];
    $activityEnd        = $_POST["activityEnd"] == '0000-00-00 00:00:00' ? NULL : $_POST["activityEnd"];
    $activityStatus     = $_POST["activityStatus"] != '1' ? NULL : $_POST["activityStatus"];
    //Table Report
    $latitudeStart      = $_POST["latitudeStart"];
    $longitudeStart     = $_POST["longitudeStart"];
    $latitudeEnd        = $_POST["latitudeEnd"];
    $longitudeEnd       = $_POST["longitudeEnd"];
    $reportNote         = $_POST["reportNote"];
    $reportDate         = $_POST["reportDate"];
    $reportTime         = $_POST["reportTime"];
    //Table Tasklist
    $tasks              = addslashes($_POST["tasks"]);

    if (
        isset($activityId) && !empty($activityId) && $activityId != 'null' &&
        isset($personId) && !empty($personId) && $personId != 'null' &&
        isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'null' &&
        isset($phaseId) && !empty($phaseId) && $phaseId != 'null' &&
        isset($checkpointStart) && !empty($checkpointStart) && $checkpointStart != 'null' &&
        isset($checkpointEnd) && !empty($checkpointEnd) && $checkpointEnd != 'null' &&
        isset($activityStart) && !empty($activityStart) && $activityStart != 'null' &&
        isset($activityEnd) && !empty($activityEnd) && $activityEnd != 'null' &&
        isset($activityStatus) && !empty($activityStatus) && $activityStatus != 'null'
    ) {
            
        if (
            isset($latitudeStart) && !empty($latitudeStart) && $latitudeStart != 'null' &&
            isset($longitudeStart) && !empty($longitudeStart) && $longitudeStart != 'null' &&
            isset($latitudeEnd) && !empty($latitudeEnd) && $latitudeEnd != 'null' &&
            isset($longitudeEnd) && !empty($longitudeEnd) && $longitudeEnd != 'null' &&
            isset($reportNote) && !empty($reportNote) && $reportNote != 'null' &&
            isset($reportDate) && !empty($reportDate) && $reportDate != 'null' &&
            isset($reportTime) && !empty($reportTime) && $reportTime != 'null'
        ) {

            if (isset($tasks) && !empty($tasks) && $tasks != 'null') {

                $sql = $conn->prepare(
                    "SELECT uid
                    FROM tb_activity
                    WHERE activityId = ?
                    AND personId = ?"
                );
                $sql->bind_param('ss', $activityId, $personId);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {

                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "SELECT activityStatus
                            FROM tb_activity
                            WHERE activityId = ?
                            AND personId = ?"
                        );
                        $sql->bind_param('ss', $activityId, $personId);
                        $sql->execute();
                        $result = $sql->get_result();
                        $temp = $result->fetch_assoc()['activityStatus'];

                        if ($temp == '0') {
                            //UPDATE ACTIVITY
                            $sql = $conn->prepare(
                                "UPDATE tb_activity
                                SET checkpointStart = ?, checkpointEnd = ?, activityStart = ?, activityEnd = ?, activityStatus = '1'
                                WHERE activityId = ?
                                AND personId = ?"
                            );
                            $sql->bind_param('ssssss', $checkpointStart, $checkpointEnd, $activityStart, $activityEnd, $activityId, $personId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');
                        }

                        $sql = $conn->prepare(
                            "SELECT uid
                            FROM tb_report
                            WHERE activityId = ?
                            AND personId = ?"
                        );
                        $sql->bind_param('ss', $activityId, $personId);
                        $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows < 1) {

                            $reportId = date('YmdHis').sprintf('%04d', 1);

                            //INSERT REPORT START
                            $sql = $conn->prepare(
                                "INSERT INTO tb_report
                                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
                            );
                            $sql->bind_param('sssssssss', $reportId, $latitudeStart, $longitudeStart, $activityId, $personId, $checkpointStart, $reportNote, $reportDate, $reportTime);
                            if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                            //INSERT REPORT END
                            $sql = $conn->prepare(
                                "INSERT INTO tb_report
                                VALUES (NULL, ?, ?, ?, ?, ?, ?, NULL, ?, ?, NOW())"
                            );
                            $sql->bind_param('ssssssss', $reportId, $latitudeEnd, $longitudeEnd, $activityId, $personId, $checkpointEnd, $reportDate, $reportTime);
                            if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');
                        }

                        $arrayData = json_decode(stripslashes($tasks), true);
                        foreach($arrayData as $data){
                            //UPDATE TASK LIST
                            $sql = $conn->prepare(
                                "UPDATE tb_task_list
                                SET taskStatus = ?
                                WHERE scheduleId = ?
                                AND taskId = ?
                                AND phaseId = ?"
                            );
                            $sql->bind_param('ssss', $data['taskStatus'], $scheduleId, $data['taskId'], $phaseId);
                            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');
                        }
                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $conn->commit();
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        $output->activityId = $activityId;
                        echo (json_encode($output));
                    }

                } else {
                    $output->status = 'error';
                    $output->execute = microtime(true) - $execute;
                    $output->message = 'Activity not found';
                    echo (json_encode($output));
                }

            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                $output->message = 'Tasks is empty';
                echo (json_encode($output));
            }

        } else {
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            $output->message = 'Report is empty';
            echo (json_encode($output));
        }

    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        $output->message = 'Activity is empty';
        echo (json_encode($output));
    }
}