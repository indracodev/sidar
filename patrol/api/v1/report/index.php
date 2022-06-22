<?php
include '../../config.php';
$output;
$execute = microtime(true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];
    $filterName = $_GET['name'] == 'undefined' ? '' : $_GET['name'];
    $filterDate = $_GET['date'] == 'undefined' ? '' : $_GET['date'];
    $filterMonth = $_GET['month'] == 'undefined' ? '' : $_GET['month'];
    $filterStart = $_GET['start'] == 'undefined' ? '' : $_GET['start'];
    $filterEnd = $_GET['end'] == 'undefined' ? '' : $_GET['end'];
    $action = $_GET['action'];

    switch ($action) {
        //GET REPORT BY DATE
        case 'date':
            if (isset($postHash) && !empty($postHash) && $postHash != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userId
                    FROM tb_users
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $postHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {

                    if (!empty($filterName) || !empty($filterDate) || !empty($filterMonth) || !empty($filterStart) || !empty($filterEnd)) {
                        
                        $personName = $filterName.'%';
                        if (!empty($filterDate)) {
                            $reportDate = $filterDate.'%';
                        } else if (!empty($filterMonth)) {
                            $reportDate = $filterMonth.'%';
                        } else {
                            $reportDate = '%';
                        }
                        $scheduleStart = $filterStart.'%';

                        if (!empty($filterStart) && !empty($filterEnd)) {
                            $sql = $conn->prepare(
                                "SELECT DISTINCT reportDate
                                FROM tb_report, tb_person, tb_schedule
                                WHERE reportDate != '0000-00-00'
                                AND tb_person.personId = tb_report.personId
                                AND tb_schedule.activityId = tb_report.activityId
                                AND personName LIKE ?
                                AND reportDate LIKE ?
                                AND scheduleStart BETWEEN ? AND ?
                                ORDER BY reportDate DESC LIMIT 30"
                            );
                            $sql->bind_param('ssss', $personName, $reportDate, $filterStart, $filterEnd);
                        } else {
                            $sql = $conn->prepare(
                                "SELECT DISTINCT reportDate
                                FROM tb_report, tb_person, tb_schedule
                                WHERE reportDate != '0000-00-00'
                                AND tb_person.personId = tb_report.personId
                                AND tb_schedule.activityId = tb_report.activityId
                                AND personName LIKE ?
                                AND reportDate LIKE ?
                                AND scheduleStart LIKE ?
                                ORDER BY reportDate DESC LIMIT 30"
                            );
                            $sql->bind_param('sss', $personName, $reportDate, $scheduleStart);
                        }
                    } else {
                        $sql = $conn->prepare(
                            "SELECT DISTINCT reportDate
                            FROM tb_report
                            WHERE reportDate != '0000-00-00'
                            ORDER BY reportDate DESC LIMIT 30"
                        );
                    }

                    $sql->execute();
                    $result = $sql->get_result();
                    $reportDate = [];
                    while ($row = $result->fetch_assoc()) {

                        if (!empty($filterName) || !empty($filterDate) || !empty($filterMonth) || !empty($filterStart) || !empty($filterEnd)) {
                            if (!empty($filterStart) && !empty($filterEnd)) {
                                $sql = $conn->prepare(
                                    "SELECT COUNT(DISTINCT tb_schedule.phaseId) as phase 
                                    FROM tb_phase, tb_schedule, tb_activity, tb_person
                                    WHERE tb_schedule.phaseId = tb_phase.phaseId
                                    AND tb_activity.activityId = tb_schedule.activityId
                                    AND tb_person.personId = tb_schedule.personId
                                    AND phaseDate = ?
                                    AND personName LIKE ?
                                    AND scheduleStart BETWEEN ? AND ?
                                    AND checkpointStart != 'null'
                                    AND activityStatus = '1'"
                                );
                                $sql->bind_param('ssss', $row['reportDate'], $personName, $filterStart, $filterEnd);
                            } else {
                                $sql = $conn->prepare(
                                    "SELECT COUNT(DISTINCT tb_schedule.phaseId) as phase 
                                    FROM tb_phase, tb_schedule, tb_activity, tb_person
                                    WHERE tb_schedule.phaseId = tb_phase.phaseId
                                    AND tb_activity.activityId = tb_schedule.activityId
                                    AND tb_person.personId = tb_schedule.personId
                                    AND phaseDate = ?
                                    AND personName LIKE ?
                                    AND scheduleStart LIKE ?
                                    AND checkpointStart != 'null'
                                    AND activityStatus = '1'"
                                );
                                $sql->bind_param('sss', $row['reportDate'], $personName, $scheduleStart);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT COUNT(DISTINCT tb_schedule.phaseId) as phase 
                                FROM tb_phase, tb_schedule, tb_activity 
                                WHERE tb_schedule.phaseId = tb_phase.phaseId 
                                AND tb_activity.activityId = tb_schedule.activityId 
                                AND phaseDate = ? 
                                AND checkpointStart != 'null'
                                AND activityStatus = '1'"
                            );
                            $sql->bind_param('s', $row['reportDate']);
                        }

                        $sql->execute();
                        $subResult = $sql->get_result();
                        $phaseCount = $subResult->fetch_assoc()['phase'];

                        if (!empty($filterName) || !empty($filterDate) || !empty($filterMonth) || !empty($filterStart) || !empty($filterEnd)) {
                            if (!empty($filterStart) && !empty($filterEnd)) {
                                $sql = $conn->prepare(
                                    "SELECT DISTINCT tb_schedule.phaseId
                                    FROM tb_phase, tb_schedule, tb_activity, tb_person
                                    WHERE tb_schedule.phaseId = tb_phase.phaseId
                                    AND tb_activity.activityId = tb_schedule.activityId
                                    AND tb_person.personId = tb_schedule.personId
                                    AND phaseDate = ?
                                    AND personName LIKE ?
                                    AND scheduleStart BETWEEN ? AND ?
                                    AND checkpointStart != 'null'
                                    AND activityStatus = '1'"
                                );
                                $sql->bind_param('ssss', $row['reportDate'], $personName, $filterStart, $filterEnd);
                            } else {
                                $sql = $conn->prepare(
                                    "SELECT DISTINCT tb_schedule.phaseId
                                    FROM tb_phase, tb_schedule, tb_activity, tb_person
                                    WHERE tb_schedule.phaseId = tb_phase.phaseId
                                    AND tb_activity.activityId = tb_schedule.activityId
                                    AND tb_person.personId = tb_schedule.personId
                                    AND phaseDate = ?
                                    AND personName LIKE ?
                                    AND scheduleStart LIKE ?
                                    AND checkpointStart != 'null'
                                    AND activityStatus = '1'"
                                );
                                $sql->bind_param('sss', $row['reportDate'], $personName, $scheduleStart);
                            }
                        } else {
                            $sql = $conn->prepare(
                                "SELECT DISTINCT tb_schedule.phaseId
                                FROM tb_phase, tb_schedule, tb_activity 
                                WHERE tb_schedule.phaseId = tb_phase.phaseId 
                                AND tb_activity.activityId = tb_schedule.activityId 
                                AND phaseDate = ? 
                                AND checkpointStart != 'null'
                                AND activityStatus = '1'"
                            );
                            $sql->bind_param('s', $row['reportDate']);
                        }

                        $sql->execute();
                        $subResult = $sql->get_result();
                        $phase = [];
                        while ($subrow = $subResult->fetch_assoc()) {
                            $sql = $conn->prepare(
                                "SELECT
                                SUBSTRING_INDEX(GROUP_CONCAT(scheduleStart ORDER BY scheduleStart ASC), ',', 1) AS start,
                                SUBSTRING_INDEX(GROUP_CONCAT(scheduleStart ORDER BY scheduleStart DESC), ',', 1) AS finish
                                FROM tb_schedule
                                WHERE phaseId = ?"
                            );
                            $sql->bind_param('s', $subrow['phaseId']);
                            $sql->execute();
                            $nestedresult = $sql->get_result();
                            $scheduleStart = $nestedresult->fetch_assoc()['start'];

                            $hours = substr($scheduleStart, 0, 2) . ":00";
                            $tempHours = substr($scheduleStart, 0, 2) . ":59";

                            $sql = $conn->prepare(
                                "SELECT DISTINCT phaseId
                                FROM tb_schedule
                                WHERE scheduleStart BETWEEN ? AND ?
                                AND scheduleDate = ?"
                            );
                            $sql->bind_param("sss", $hours, $tempHours, $row['reportDate']);
                            $sql->execute();
                            $nestedResult = $sql->get_result();
                            $schedule = [];
                            while ($nestedrow = $nestedResult->fetch_assoc()) {
                                array_push($schedule, $nestedrow['phaseId']);
                            }

                            $phase[] = (object) [
                                'id' => $schedule,
                                'schedule' => $hours . ' - ' . $tempHours
                            ];
                        }

                        $date = date_create(substr($row['reportDate'], 0, 10));
                        $reportDate[] = (object) [
                            'id' => $row['reportDate'],
                            'date' => date_format($date, 'd F Y'),
                            'phase' => my_array_unique($phase),
                            'count' => $phaseCount
                        ];
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->data = $reportDate;
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
        //DOWNLOAD ALL REPORT
        case 'download':
            $filterName = $_GET['name'] == 'undefined' ? '' : $_GET['name'];
            $filterDate = $_GET['date'] == 'undefined' ? '' : $_GET['date'];
            $filterMonth = $_GET['month'] == 'undefined' ? '' : $_GET['month'];
            $filterStart = $_GET['start'] == 'undefined' ? '' : $_GET['start'];
            $filterEnd = $_GET['end'] == 'undefined' ? '' : $_GET['end'];

            header( "Content-Type: application/vnd.ms-excel" );
            if (!empty($filterDate)) {
                header( "Content-disposition: attachment; filename=Patrol Report (".$filterDate.").xls" );
            } else if (!empty($filterName)) {
                header( "Content-disposition: attachment; filename=Patrol Report (".ucwords($filterName).").xls" );
            } else if (!empty($filterStart)) {
                header( "Content-disposition: attachment; filename=Patrol Report (".$filterStart.").xls" );
            } else if (!empty($filterStart) && !empty($filterEnd)) {
                header( "Content-disposition: attachment; filename=Patrol Report (".$filterStart." - ".$filterEnd.").xls" );
            } else {
                header( "Content-disposition: attachment; filename=Patrol Report.xls" );
            }

            echo "
                <table border='1'>
                    <tr style='background: black; color: white;'>
                        <th>NO.</th>
                        <th>DATE</th>
                        <th>SECURITY</th>
                        <th>GPS</th>
                        <th>CHECKPOINT START</th>
                        <th>CHECKPOINT END</th>
                        <th>SCHEDULE START</th>
                        <th>ONSITE START</th>
                        <th>DIFFERENCE START</th>
                        <th>SCHEDULE END</th>
                        <th>ONSITE END</th>
                        <th>DIFFERENCE END</th>
                    </tr>
            ";

            if (!empty($filterName) || !empty($filterDate) || !empty($filterMonth) || !empty($filterStart) || !empty($filterEnd)) {
                
                $tpersonName = $filterName.'%';
                if (!empty($filterDate)) {
                    $reportDate = $filterDate.'%';
                } else if (!empty($filterMonth)) {
                    $reportDate = $filterMonth.'%';
                } else {
                    $reportDate = '%';
                }
                $tscheduleStart = $filterStart.'%';

                if (!empty($filterStart) && !empty($filterEnd)) {
                    $sql = $conn->prepare(
                        "SELECT DISTINCT reportDate
                        FROM tb_report, tb_person, tb_schedule
                        WHERE reportDate != '0000-00-00'
                        AND tb_person.personId = tb_report.personId
                        AND tb_schedule.activityId = tb_report.activityId
                        AND personName LIKE ?
                        AND reportDate LIKE ?
                        AND scheduleStart BETWEEN ? AND ?
                        ORDER BY reportDate ASC"
                    );
                    $sql->bind_param('ssss', $tpersonName, $reportDate, $filterStart, $filterEnd);
                } else {
                    $sql = $conn->prepare(
                        "SELECT DISTINCT reportDate
                        FROM tb_report, tb_person, tb_schedule
                        WHERE reportDate != '0000-00-00'
                        AND tb_person.personId = tb_report.personId
                        AND tb_schedule.activityId = tb_report.activityId
                        AND personName LIKE ?
                        AND reportDate LIKE ?
                        AND scheduleStart LIKE ?
                        ORDER BY reportDate ASC"
                    );
                    $sql->bind_param('sss', $tpersonName, $reportDate, $tscheduleStart);
                }
            } else {
                $sql = $conn->prepare(
                    "SELECT DISTINCT reportDate 
                    FROM tb_report 
                    WHERE reportDate != '0000-00-00' 
                    ORDER BY reportDate ASC"
                );
            }

            $sql->execute();
            $result = $sql->get_result();
            $no = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    if (!empty($filterName) || !empty($filterDate) || !empty($filterMonth) || !empty($filterStart) || !empty($filterEnd)) {
                        
                        if (!empty($filterStart) && !empty($filterEnd)) {
                            $sql = $conn->prepare(
                                "SELECT DISTINCT tb_activity.activityId, phaseDate, personName, checkpointStart, checkpointEnd, scheduleStart, activityStart, scheduleEnd, activityEnd,
                                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleStart), activityStart)) as elapseStart,
                                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleEnd), activityEnd)) as elapseEnd
                                FROM tb_phase, tb_person, tb_schedule, tb_activity
                                WHERE tb_schedule.phaseId = tb_phase.phaseId
                                AND tb_person.personId = tb_activity.personId
                                AND tb_activity.activityId = tb_schedule.activityId
                                AND phaseDate = ?
                                AND personName LIKE ?
                                AND scheduleStart BETWEEN ? AND ?
                                AND checkpointStart IS NOT NULL
                                ORDER BY activityStart ASC;"
                            );
                            $sql->bind_param('ssss', $row['reportDate'], $tpersonName, $filterStart, $filterEnd);
                        } else {
                            $sql = $conn->prepare(
                                "SELECT DISTINCT tb_activity.activityId, phaseDate, personName, checkpointStart, checkpointEnd, scheduleStart, activityStart, scheduleEnd, activityEnd,
                                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleStart), activityStart)) as elapseStart,
                                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleEnd), activityEnd)) as elapseEnd
                                FROM tb_phase, tb_person, tb_schedule, tb_activity
                                WHERE tb_schedule.phaseId = tb_phase.phaseId
                                AND tb_person.personId = tb_activity.personId
                                AND tb_activity.activityId = tb_schedule.activityId
                                AND phaseDate = ?
                                AND personName LIKE ?
                                AND scheduleStart LIKE ?
                                AND checkpointStart IS NOT NULL
                                ORDER BY activityStart ASC;"
                            );
                            $sql->bind_param('sss', $row['reportDate'], $tpersonName, $tscheduleStart);
                        }
                    } else {
                        $sql = $conn->prepare(
                            "SELECT DISTINCT tb_activity.activityId, phaseDate, personName, checkpointStart, checkpointEnd, scheduleStart, activityStart, scheduleEnd, activityEnd,
                            SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleStart), activityStart)) as elapseStart,
                            SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CONCAT(scheduleDate, ' ', scheduleEnd), activityEnd)) as elapseEnd
                            FROM tb_phase, tb_person, tb_schedule, tb_activity 
                            WHERE tb_schedule.phaseId = tb_phase.phaseId
                            AND tb_person.personId = tb_activity.personId
                            AND tb_activity.activityId = tb_schedule.activityId 
                            AND phaseDate = ?
                            AND checkpointStart IS NOT NULL
                            ORDER BY activityStart ASC;"
                        );
                        $sql->bind_param('s', $row['reportDate']);
                    }
    
                    $sql->execute();
                    $subResult = $sql->get_result();
                    while ($subrow = $subResult->fetch_assoc()) {
    
                        $sql = $conn->prepare(
                            "SELECT reportLatitude, reportLongitude
                            FROM tb_report
                            WHERE activityId = ?"
                        );
                        $sql->bind_param('s', $subrow['activityId']);
                        $sql->execute();
                        $nestedResult = $sql->get_result();
                        $latitude = [];
                        $longitude = [];
                        while ($nestedRow = $nestedResult->fetch_assoc()) {
                            array_push($latitude, $nestedRow['reportLatitude']);
                            array_push($longitude, $nestedRow['reportLongitude']);
                        }
    
                        $phaseDate = $subrow['phaseDate'];
                        $personName = strtoupper($subrow['personName']);
                        $checkpointStart = $subrow['checkpointStart'];
                        $tempStart = strtolower($checkpointStart);
                        $checkpointEnd = $subrow['checkpointEnd'];
                        $tempEnd = strtolower($checkpointEnd);
                        $scheduleStart = $subrow['scheduleStart'];
                        $activityStart = explode(' ', $subrow['activityStart']);
                        $elapseStart = detectTime($subrow['elapseStart']);
                        $scheduleEnd = $subrow['scheduleEnd'];
                        $activityEnd = explode(' ', $subrow['activityEnd']);
                        $elapseEnd = detectTime($subrow['elapseEnd']);
                        $mapboxLink = "https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s-$tempStart+66cc66($longitude[0],$latitude[0]),pin-s-$tempEnd+007aff($longitude[1],$latitude[1])/auto/640x640@2x?access_token=pk.eyJ1IjoiZG9rb3RlbGVrIiwiYSI6ImNrNTUydHU0eTBwdDYzZXBubnU1cGg0bnMifQ.3mx4XwIRpMPjdcEssgS4lg&attribution=false&logo=false";
                        if (substr($elapseStart, 0, 1) == '+') {
                            $elapseStart = "<td style='background: blue; color: white;'>$elapseStart</td>";
                        }

                        if (substr($elapseEnd, 0, 1) == '+') {
                            $elapseEnd = "<td style='background: blue; color: white;'>$elapseEnd</td>";
                        }

                        if (substr($elapseStart, 0, 1) == '-') {
                            $elapseStart = "<td style='background: red; color: white;'>$elapseStart</td>";
                        }

                        if (substr($elapseEnd, 0, 1) == '-') {
                            $elapseEnd = "<td style='background: red; color: white;'>$elapseEnd</td>";
                        }
                        echo "
                            <tr style='text-align: center;'>
                                <td>$no</td>
                                <td>$phaseDate</td>
                                <td>$personName</td>
                                <td><a href='$mapboxLink'>Click here!</a></td>
                                <td>Poin $checkpointStart</td>
                                <td>Poin $checkpointEnd</td>
                                <td>$scheduleStart WIB</td>
                                <td>$activityStart[1] WIB</td>
                                $elapseStart
                                <td>$scheduleEnd WIB</td>
                                <td>$activityEnd[1] WIB</td>
                                $elapseEnd
                            </tr>
                        ";
                        $no++;
                    }
    
                }
            } else {
                echo "
                    <tr style='text-align: center;'>
                        <td colspan='12'>There is no data to show!</td>
                    </tr>
                ";
            }

            echo '</table>';
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
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

function detectTime ($time) {
    if (substr($time, 0, 1) == '-') {
        return $time;
    } else {
        return '+'.$time;
    }
}