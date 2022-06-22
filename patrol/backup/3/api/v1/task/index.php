<?php
include '../../config.php';
$output;

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $userHash = $_DELETE['hash'];
    $action = $_GET['action'];

    switch ($action) {
        case 'template':
            $templateName = strtolower($_DELETE['template']);

            if (isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    $sql = $conn->prepare("DELETE FROM tb_task_template WHERE templateName = ?"); $sql->bind_param('s', $templateName);
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
            break;
        case 'task':
            $taskId = $_DELETE['id'];

            if (isset($taskId) && !empty($taskId) && $taskId != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    $sql = $conn->prepare("DELETE FROM tb_task WHERE taskId = ?"); $sql->bind_param('s', $taskId);
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
            break;
        default:
            $output->status = 'unknown';
            echo(json_encode($output));
            break;
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $taskId = $_PUT['id'];
    $taskName = $_PUT['task'];
    $userHash = $_PUT['hash'];

    if (isset($taskId) && !empty($taskId) && $taskId != 'undefined' &&
        isset($taskName) && !empty($taskName) && $taskName != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
        $sql->bind_param('s', $userHash); $sql->execute();
        $userResult = $sql->get_result();
        if ($userResult->num_rows > 0) {
            while ($rowUser = $userResult->fetch_assoc()) {

                $sql = $conn->prepare("UPDATE tb_task SET taskName = ?, userName = ? WHERE taskId = ?");
                $sql->bind_param('sss', $taskName, $rowUser['userName'], $taskId); $sql->execute();
                if ($sql->execute() === TRUE) {
                    $output->status = 'success';
                    echo(json_encode($output));
                } else {
                    $output->status = 'failed';
                    $output->action = 'update';
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

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $_PATCH);
    $scheduleId = $_PATCH['id'];
    $task = $_PATCH['task'];
    $postDevice = $_GET['device'];

    switch ($postDevice) {
        case 'web':
            $userHash = $_PATCH['hash'];

            if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
                isset($task) && !empty($task) && $task != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    while ($rowUser = $userResult->fetch_assoc()) {

                        $str = explode(',', $task);
                        $i = 0;
                        $status = false;
                        while ($i < count($str)) {
                            $sql = $conn->prepare("INSERT INTO tb_task_list (taskId, scheduleId, taskStatus, userName) VALUES (?, ?, '0', ?)");
                            $sql->bind_param('sss', $str[$i], $scheduleId, $rowUser['userName']);
                            if ($sql->execute() === TRUE) {
                                $status = true;
                            } else {
                                $status = false;
                            }
                            $i++;
                        }

                        if ($status) {
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
            break;
        case 'mobile':
            $activityId = $_PATCH['activity'];
            $note = $_PATCH['note'];

            if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined' &&
                isset($activityId) && !empty($activityId) && $activityId != 'undefined' &&
                isset($task) && $task != 'undefined') {

                $sql = $conn->prepare("SELECT scheduleId FROM tb_task_list WHERE scheduleId = ?");
                $sql->bind_param('s', $scheduleId); $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    if ($task) {
                        $str = explode(',', $task);
                        $i = 0;
                        $status = false;
                        while ($i < count($str)) {

                            $sql = $conn->prepare("UPDATE tb_task_list SET taskStatus = '1' WHERE taskId = ? AND scheduleId = ?");
                            $sql->bind_param('ss', $str[$i], $scheduleId);
                            if ($sql->execute() === TRUE) {
                                $status = true;
                            } else {
                                $status = false;
                            }
                            $i++;

                        }

                        if ($status) {
                            if ($note && $note != 'undefined') {
                                $sql = $conn->prepare("UPDATE tb_report SET reportNote = ? WHERE activityId = ?");
                                $sql->bind_param('ss', $note, $activityId); $sql->execute();
                                if ($sql->execute() === TRUE) {
                                    $output->status = 'success';
                                    echo(json_encode($output));
                                } else {
                                    $output->status = 'failed';
                                    $output->action = 'update';
                                    echo(json_encode($output));
                                }
                            } else {
                                $output->status = 'success';
                                echo(json_encode($output));
                            }
                        } else {
                            $output->status = 'failed';
                            $output->action = 'update';
                            echo(json_encode($output));
                        }
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
            break;
        default:
            $output->status = 'unknown';
            echo(json_encode($output));
            break;
    }


}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $action = $_GET['action'];

    switch ($action) {
        case 'template':
            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    $sql = $conn->prepare("SELECT DISTINCT templateName FROM tb_task_template"); $sql->execute();
                    $template = $sql->get_result();
                    if ($template->num_rows > 0) {
                        $templateArray = [];
                        while ($rowTemplate = $template->fetch_assoc()) {

                            $taskArray = [];
                            $sql = $conn->prepare("SELECT tb_task.taskId, taskName, tb_task_template.lastUpdated FROM tb_task_template, tb_task WHERE tb_task.taskId = tb_task_template.taskId AND tb_task_template.templateName = ?");
                            $sql->bind_param('s', $rowTemplate['templateName']); $sql->execute();
                            $result = $sql->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $taskArray[] = (object) [
                                        id => $row['taskId'],
                                        name => ucfirst($row['taskName'])
                                    ];
                                }
                            } else {
                                $output->status = 'unknown';
                                echo(json_encode($output));
                            }
                            $templateArray[] = (object) [
                                name => ucfirst($rowTemplate['templateName']),
                                task => $taskArray
                            ];

                        }
                        $output->status = 'success';
                        $output->template = $templateArray;
                        echo(json_encode($output));
                    } else {
                        $output->status = 'unknown';
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
            break;
        case 'task':
            $postDevice = $_GET['device'];

            switch ($postDevice) {
                case 'web':
                    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                        $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                        $sql->bind_param('s', $userHash); $sql->execute();
                        $userResult = $sql->get_result();
                        if ($userResult->num_rows > 0) {
                            $sql = $conn->prepare("SELECT taskId, taskName, lastUpdated FROM tb_task"); $sql->execute();
                            $result = $sql->get_result();
                            if ($result->num_rows > 0) {
                                $taskArray = [];
                                while ($row = $result->fetch_assoc()) {
                                    $taskArray[] = (object) [
                                        id => $row['taskId'],
                                        name => ucfirst($row['taskName']),
                                        update => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                                    ];
                                }
                                $output->status = 'success';
                                $output->task = $taskArray;
                                echo(json_encode($output));
                            } else {
                                $output->status = 'unknown';
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
                    break;
                case 'mobile':
                    $scheduleId = $_GET['schedule'];

                    if (isset($scheduleId) && !empty($scheduleId) && $scheduleId != 'undefined') {
                        $sql = $conn->prepare("SELECT tb_task_list.taskId, taskName FROM tb_task_list, tb_task WHERE tb_task.taskId = tb_task_list.taskId AND scheduleId = ?");
                        $sql->bind_param('s', $scheduleId); $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            $taskArray = [];
                            while ($row = $result->fetch_assoc()) {

                                $taskArray[] = (object) [
                                    id => $row['taskId'],
                                    name => ucfirst($row['taskName'])
                                ];

                            }
                            $output->status = 'success';
                            $output->task = $taskArray;
                            echo(json_encode($output));
                        } else {
                            $output->status = 'false';
                            echo(json_encode($output));
                        }
                    } else {
                        $output->status = 'error';
                        echo(json_encode($output));
                    }
                    break;
                default:
                    $output->status = 'error';
                    echo(json_encode($output));
                    break;
            }
            break;
        default:
            $output->status = 'unknown';
            echo(json_encode($output));
            break;
    }
}

//Checked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userHash = $_POST['hash'];
    $action = $_GET['action'];

    switch ($action) {
        case 'template':
            $templateName = strtolower($_POST['template']);
            $task = $_POST['task'];

            if (isset($templateName) && !empty($templateName) && $templateName != 'undefined' &&
                isset($task) && !empty($task) && $task != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    while ($rowUser = $userResult->fetch_assoc()) {

                        $str = explode(',', $task);
                        $i = 0;
                        $status = false;
                        while ($i < count($str)) {
                            $sql = $conn->prepare("INSERT INTO tb_task_template (templateName, taskId, userName) VALUES (?, ?, ?)");
                            $sql->bind_param('sss', $templateName, $str[$i], $rowUser['userName']);
                            if ($sql->execute() === TRUE) {
                                $status = true;
                            } else {
                                $status = false;
                            }
                            $i++;
                        }

                        if ($status) {
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
            break;
        case 'task':
            $taskName = strtolower($_POST['task']);

            if (isset($taskName) && !empty($taskName) && $taskName != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare("SELECT userName FROM tb_users WHERE hashWeb = ?");
                $sql->bind_param('s', $userHash); $sql->execute();
                $userResult = $sql->get_result();
                if ($userResult->num_rows > 0) {
                    while ($rowUser = $userResult->fetch_assoc()) {

                        $sql = $conn->prepare("SELECT taskId FROM tb_task ORDER BY uid DESC LIMIT 1"); $sql->execute();
                        $taskCheck = $sql->get_result();
                        if ($taskCheck->num_rows > 0) {
                            while ($row = $taskCheck->fetch_assoc()) {
                                $taskId = (int)$row['taskId'] + 1;
                                $sql = $conn->prepare("INSERT INTO tb_task (taskId, taskName, userName) VALUES (?, ?, ?)");
                                $sql->bind_param('sss', $taskId, $taskName, $rowUser['userName']);
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
                            $taskId = '1';
                            $sql = $conn->prepare("INSERT INTO tb_task (taskId, taskName, userName) VALUES (?, ?, ?)");
                            $sql->bind_param('sss', $taskId, $taskName, $rowUser['userName']);
                            if ($sql->execute() === TRUE) {
                                $output->status = 'success';
                                echo(json_encode($output));
                            } else {
                                $output->status = 'failed';
                                $output->action = 'insert';
                                echo(json_encode($output));
                            }
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
            break;
        default:
            $output->status = 'unknown';
            echo(json_encode($output));
            break;
    }
}