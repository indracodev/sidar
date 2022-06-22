<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined') {
        $sql = $conn->prepare("SELECT userId FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $postHash); $sql->execute();
        $resultCheck = $sql->get_result();
        if ($resultCheck->num_rows > 0) {
            $sql = $conn->prepare("SELECT DISTINCT activityId FROM tb_report"); $sql->execute();
            $activityResult = $sql->get_result();
            if ($activityResult->num_rows > 0) {
                $personArray = [];
                $i = 1;
                while ($activityRow = $activityResult->fetch_assoc()) {

                    $sql = $conn->prepare("SELECT personName, tb_report.activityId, GROUP_CONCAT(checkpointName separator ' to ') as checkpointName, GROUP_CONCAT(reportLatitude) as latitude, GROUP_CONCAT(reportLongitude) as longitude, activityStart, activityEnd
                        FROM tb_activity, tb_report, tb_person
                        WHERE tb_person.personId = tb_report.personId AND tb_report.activityId = tb_activity.activityId AND tb_report.activityId = ? AND tb_activity.activityStatus = '1'");
                    $sql->bind_param('s', $activityRow['activityId']); $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $latitude = explode(',', $row['latitude']);
                            $longitude = explode(',', $row['longitude']);
                            if ($row['personName']) {
                                $date = date_create(substr($row['activityStart'], 0, 10));
                                $personArray[] = (object) [
                                    no => $i,
                                    person => ucfirst($row['personName']),
                                    checkpoint => $row['checkpointName'],
                                    startLocation => $longitude[0].','.$latitude[0],
                                    endLocation => $longitude[1].','.$latitude[1],
                                    date => date_format($date, 'd/m/Y'),
                                    time => substr($row['activityStart'], 11).' WIB - '.substr($row['activityEnd'], 11).' WIB'
                                ];
                            }

                        }
                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                    $i++;

                }
                $output->status = 'success';
                $output->person = $personArray;
                echo(json_encode($output));
            } else {
                $output->status = 'false';
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personId = $_POST['person'];
    $activityId = $_POST['activity'];
    $scheduleId = $_POST['schedule'];
    $checkpointId = $_POST['checkpoint'];
    $reportLatitude = $_POST['latitude'];
    $reportLongitude = $_POST['longitude'];
    $reportTime = date('H:i:s');
    $reportDate = date('Y-m-d');

    if (isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($checkpointId) && !empty($checkpointId) && $checkpointId != 'undefined' &&
        isset($reportLatitude) && !empty($reportLatitude) && $reportLatitude != 'undefined' &&
        isset($reportLongitude) && !empty($reportLongitude) && $reportLongitude != 'undefined' &&
        isset($activityId) && !empty($activityId) && $activityId != 'undefined' &&
        isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined') {
        $sql = $conn->prepare("SELECT checkpointName FROM tb_checkpoint WHERE checkpointId = ?");
        $sql->bind_param('s', $checkpointId); $sql->execute();
        $checkpointResult = $sql->get_result();
        if ($checkpointResult->num_rows > 0) {
            $checkpointName;
            while ($row = $checkpointResult->fetch_assoc()) {
                $checkpointName = $row['checkpointName'];
            }
            $sql = $conn->prepare("SELECT reportId FROM tb_report ORDER BY uid DESC LIMIT 1"); $sql->execute();
            $sqlResult = $sql->get_result();
            if ($sqlResult->num_rows > 0) {
                $reportId;
                while ($rowCheck = $sqlResult->fetch_assoc()) {

                    $reportId = (int)$rowCheck['reportId'] + 1;
                    $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointName, reportDate, reportTime) VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?)"); $sql->bind_param('isssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointName, $reportDate, $reportTime);
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
                $reportId = '1';
                $sql = $conn->prepare("INSERT INTO tb_report (reportId, reportLatitude, reportLongitude, activityId, personId, checkpointName, reportDate, reportTime) VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)"); $sql->bind_param('isssssss', $reportId, $reportLatitude, $reportLongitude, $activityId, $personId, $checkpointName, $reportDate, $reportTime);
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
            $output->status = 'false';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}