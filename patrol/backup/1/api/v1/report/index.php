<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined') {
        $sqlCheck = $conn->prepare("SELECT userId FROM tb_users WHERE hashWeb = ?");
        $sqlCheck->bind_param('s', $postHash);
        $sqlCheck->execute();
        $resultCheck = $sqlCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            $activitySql = $conn->prepare("SELECT DISTINCT activityId FROM tb_report");
            $activitySql->execute();
            $activityResult = $activitySql->get_result();
            if ($activityResult->num_rows > 0) {
                $personArray = [];
                $i = 1;
                while ($activityRow = $activityResult->fetch_assoc()) {
                    $sql = $conn->prepare("SELECT personName, tb_report.activityId, GROUP_CONCAT(checkpointName separator ' to ') as checkpointName, GROUP_CONCAT(reportLatitude) as latitude, GROUP_CONCAT(reportLongitude) as longitude, activityStart, activityEnd
                        FROM tb_activity, tb_report, tb_person, tb_checkpoint
                        WHERE tb_report.checkpointId = tb_checkpoint.checkpointId AND tb_person.personId = tb_report.personId AND tb_report.activityId = tb_activity.activityId AND tb_report.activityId = ? AND tb_activity.activityStatus = '1'");
                    $sql->bind_param('s', $activityRow['activityId']);
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        $person = new stdClass();
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