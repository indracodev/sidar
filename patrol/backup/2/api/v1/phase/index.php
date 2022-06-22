<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$_DELETE);
    $phaseId = $_DELETE['phase'];
    $userHash = $_DELETE['hash'];

    if (isset($phaseId) && !empty($phaseId) && $phaseId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            $sql = $conn->prepare("DELETE FROM tb_phase WHERE phaseId = ?"); $sql->bind_param('s', $phaseId);
            if ($sql->execute() === TRUE) {
                $output->status = 'success';
                echo(json_encode($output));
            } else {
                $output->status = 'failed';
                $output->action = 'delete';
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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseDate = $_GET['date'];
    $action = $_GET['action'];

    if (isset($phaseDate) && !empty($phaseDate) && $phaseDate != 'undefined' &&
        isset($action) && !empty($action) && $action != 'undefined') {
        switch ($action) {
            case 'dashboard':
                $sql = $conn->prepare("SELECT DISTINCT tb_phase.phaseId FROM tb_phase, tb_schedule WHERE tb_phase.phaseId = tb_schedule.phaseId AND tb_phase.phaseDate = ?");
                $sql->bind_param("s", $phaseDate); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $phase = [];
                    while ($row = $result->fetch_assoc()) {
                        array_push($phase, $row['phaseId']);
                    }
                    $output->status = 'success';
                    $output->phaseId = $phase;
                    echo(json_encode($output));
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }
                break;
            case 'schedule':
                $sql = $conn->prepare("SELECT phaseId FROM tb_phase WHERE phaseDate = ?");
                $sql->bind_param("s", $phaseDate); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $phase = [];
                    while ($row = $result->fetch_assoc()) {
                        array_push($phase, $row['phaseId']);
                    }
                    $output->status = 'success';
                    $output->phaseId = $phase;
                    echo(json_encode($output));
                } else {
                    $output->status = 'false';
                    echo(json_encode($output));
                }
                break;
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phaseDate = $_POST['date'];

    if (isset($phaseDate) && !empty($phaseDate) && $phaseDate != 'undefined') {
        $sql = $conn->prepare("SELECT phaseId FROM tb_phase ORDER BY uid DESC LIMIT 1"); $sql->execute();
        $phaseResult = $sql->get_result();
        if ($phaseResult->num_rows > 0) {
            while($rowCheck = $phaseResult->fetch_assoc()) {
                $phaseId = (int)$rowCheck['phaseId'] + 1;
                $sql = $conn->prepare("INSERT INTO tb_phase (phaseId, phaseDate) VALUES (?, ?)"); $sql->bind_param('ss', $phaseId, $phaseDate);
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
            $phaseId = '1';
            $sql = $conn->prepare("INSERT into tb_phase (phaseId, phaseDate) VALUES (?, ?)"); $sql->bind_param('ss', $phaseId, $phaseDate);
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