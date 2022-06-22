<?php
include '../../config.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"),$_DELETE);
    $postPhase = $_DELETE['phase'];

    if (isset($postPhase) && !empty($postPhase)) {
        $sql = $conn->prepare("DELETE FROM tb_phase WHERE phaseId=?");
        $sql->bind_param('s', $postPhase);
        if ($sql->execute() === TRUE) {
            $output->status = 'success';
            echo(json_encode($output));
        } else {
            $output->status = 'failed';
            echo(json_encode($output));
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postDate = $_GET['date'];

    if (isset($postDate) && !empty($postDate)) {
        $sql = $conn->prepare("SELECT phaseId FROM tb_phase WHERE phaseDate=?");
        $sql->bind_param("s", $postDate);
        $sql->execute();
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
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phaseDate = $_POST['date'];

    if (isset($phaseDate) && !empty($phaseDate)) {
        //Check existence phaseId
        $phaseCheck = $conn->prepare("SELECT phaseId FROM tb_phase ORDER BY phaseId DESC LIMIT 1");
        $phaseCheck->execute();
        $phaseResult = $phaseCheck->get_result();
        if ($phaseResult->num_rows > 0) {
            //If not null
            while($rowCheck = $phaseResult->fetch_assoc()) {
                $phaseId = (int)$rowCheck['phaseId'] + 1;
                $sql = $conn->prepare("INSERT INTO tb_phase (phaseId, phaseDate) VALUES (?, ?)");
                $sql->bind_param('ss', $phaseId, $phaseDate);
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    echo(json_encode($output));
                }
            }
        } else {
            //If null
            $phaseId = '1';
            $sql = $conn->prepare("INSERT into tb_phase (phaseId, phaseDate) VALUES (?, ?)");
            $sql->bind_param('ss', $phaseId, $phaseDate);
            if ($sql->execute() === TRUE) {
                $output->status = 'success';
                echo(json_encode($output));
            } else {
                $output->status = 'failed';
                echo(json_encode($output));
            }
        }
    } else {
        $output->status = 'error';
        echo(json_encode($output));
    }
}