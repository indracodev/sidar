<?php
include '../../config.php';
include '../../hash.php';
$output;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postName = $_POST['username'];
    $postPassword = $_POST['password'];
    $postDevice = $_POST['device'];
    $action = $_GET['action'];

    if (isset($postName) && !empty($postName) && isset($postPassword) && !empty($postPassword)) {
        $username = strtolower($postName) ?? '';
        $password = hash('sha256', $postPassword);
        $sql = $conn->prepare("SELECT userName, userPassword, userLevel FROM tb_users WHERE userName=? AND userPassword=?");
        $sql->bind_param("ss", $postName, $password);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["userLevel"] > 0) {
                    if ($password == $row["userPassword"] && $username == $row["userName"]) {
                        $hash = generateHash();
                        $query;
                        switch ($postDevice) {
                            case 'web':
                                $query = "UPDATE tb_users SET hashWeb=? WHERE userName=?";
                                break;
                            case 'mobile':
                                $query = "UPDATE tb_users SET hashMobile=? WHERE userName=?";
                                break;
                        }
                        $sql = $conn->prepare($query);
                        $sql->bind_param("ss", $hash, $username);
                        if ($sql->execute() === TRUE) {
                            if (!empty($action)) {
                                switch ($postDevice) {
                                    case 'web':
                                        $output->status = 'success';
                                        $output->level = $row['userLevel'];
                                        $output->hash = $hash;
                                        echo(json_encode($output));
                                        break;
                                    case 'mobile':
                                        $output->status = 'success';
                                        $output->hash = $hash;
                                        echo(json_encode($output));
                                        break;
                                }
                            } else {
                                $output->status = 'failed';
                                echo(json_encode($output));
                            }
                        } else {
                            $output->status = 'failed';
                            echo(json_encode($output));
                        }

                        $conn->close();
                    } else {
                        $output->status = 'failed';
                        echo(json_encode($output));
                    }
                } else {
                    $output->status = 'unauth';
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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postHash = $_GET['hash'];
    $postDevice = $_GET['device'];

    if (isset($postHash) && !empty($postHash) && $postHash != 'undefined' &&
        isset($postDevice) && !empty($postDevice) && $postDevice != 'undefined') {
        $query;
        switch ($postDevice) {
            case 'web':
                $query = "SELECT username, userLevel FROM tb_users WHERE hashWeb=?";
                break;
            case 'mobile':
                $query = "SELECT username FROM tb_users WHERE hashMobile=?";
                break;
        }
        $sql = $conn->prepare($query);
        $sql->bind_param("s", $postHash);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                switch ($postDevice) {
                    case 'web':
                        $output->status = 'success';
                        $output->level = $row['userLevel'];
                        echo(json_encode($output));
                        break;
                    case 'mobile':
                        $output->status = 'success';
                        echo(json_encode($output));
                        break;
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