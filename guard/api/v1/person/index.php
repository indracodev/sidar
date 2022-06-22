<?php
include '../../config.php';
$output;
$execute = microtime(true);
$restAPI = 'person';

//REMOVE PERSON
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $personId = $_DELETE['id'];
    $userHash = $_DELETE['hash'];

    if (
        isset($personId) && !empty($personId) && $personId != 'undefined' &&
        isset($userHash) && !empty($userHash) && $userHash != 'undefined'
    ) {
        $sql = $conn->prepare(
            "SELECT userName 
            FROM tb_users 
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userName = $result->fetch_assoc()['userName'];

        $sql = $conn->prepare(
            "SELECT personName 
            FROM tb_person 
            WHERE personId = ?"
        );
        $sql->bind_param('s', $personId);
        $sql->execute();
        $result = $sql->get_result();
        $personName = $result->fetch_assoc()['personName'];

        try {
            $conn->begin_transaction();

            $newName = $personName . ' DELETED';
            $sql = $conn->prepare(
                "UPDATE tb_person 
                SET isDeleted = '1', personName = ?, userName = ? 
                WHERE personId = ?"
            );
            $sql->bind_param('sss', $newName, $userName, $personId);
            if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

            $logNote = "deleted person '{$personName}'";

            $log = $conn->prepare(
                "INSERT INTO tb_logs
                (activity, category, userName, note)
                VALUES ('delete', ?, ?, ?)"
            );
            $log->bind_param('sss', $restAPI, $userName, $logNote);
            if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');
            
        } catch (Exception $e) {
            $output->status = 'failed';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            $conn->rollback();
            exit();
        } finally {
            $output->status = 'success';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            $conn->commit();
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $userHash = $_PUT['hash'];
    $action = $_GET['action'];

    if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
        $sql = $conn->prepare(
            "SELECT userName 
            FROM tb_users 
            WHERE hashWeb = ?"
        );
        $sql->bind_param('s', $userHash);
        $sql->execute();
        $result = $sql->get_result();
        $userName = $result->fetch_assoc()['userName'];

        switch ($action) {
            //EDIT PERSON NAME
            case 'person':
                $personName = strtolower($_PUT['person']);
                $personId = $_PUT['id'];

                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "SELECT personName 
                        FROM tb_person 
                        WHERE personId = ?"
                    );
                    $sql->bind_param('s', $personId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $tempPersonName = $result->fetch_assoc()['personName'];
    
                    $sql = $conn->prepare(
                        "UPDATE tb_person 
                        SET personName = ?, userName = ? 
                        WHERE personId = ?"
                    );
                    $sql->bind_param('sss', $personName, $userName, $personId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $logNote = "edited person '{$tempPersonName}' to '{$personName}'";

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('update', ?, ?, ?)"
                    );
                    $log->bind_param('sss', $restAPI, $userName, $logNote);
                    if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                } catch (Exception $e) {
                    $output->status = 'failed';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->rollback();
                    exit();
                } finally {
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->commit();
                }
                break;
            //EDIT MAPPING NAME
            case 'mapping':
                $mappingName = strtolower($_PUT['mapping']);
                $mappingId = $_PUT['id'];

                try {
                    $conn->begin_transaction();

                    $sql = $conn->prepare(
                        "SELECT mappingName
                        FROM tb_person_mapping
                        WHERE mappingId = ?"
                    );
                    $sql->bind_param('s', $mappingId);
                    $sql->execute();
                    $result = $sql->get_result();
                    $tempMappingName = $result->fetch_assoc()['mappingName'];

                    $sql = $conn->prepare(
                        "UPDATE tb_person_mapping 
                        SET mappingName = ?, userName = ? 
                        WHERE mappingId = ?"
                    );
                    $sql->bind_param('sss', $mappingName, $userName, $mappingId);
                    if ($sql->execute() === FALSE) throw new Exception('Statement UPDATE Failed');

                    $logNote = "edited card '{$tempMappingName}' to '{$mappingName}'";

                    $log = $conn->prepare(
                        "INSERT INTO tb_logs
                        (activity, category, userName, note)
                        VALUES ('update', ?, ?, ?)"
                    );
                    $log->bind_param('sss', $restAPI, $userName, $logNote);
                    if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                } catch (Exception $e) {
                    $output->status = 'failed';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->rollback();
                    exit();
                } finally {
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    echo (json_encode($output));
                    $conn->commit();
                }
                break;
            default:
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
                break;
        }
    } else {
        $output->status = 'error';
        $output->execute = microtime(true) - $execute;
        echo (json_encode($output));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strtolower($_POST['name']);
    $userHash = $_POST['hash'];
    $device = $_GET['device'];

    switch ($device) {
        //ADD PERSON
        case 'web':
            if (
                isset($name) && !empty($name) && $name != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT userName
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];

                $sql = $conn->prepare(
                    "SELECT personName 
                    FROM tb_person 
                    WHERE personName = ?"
                );
                $sql->bind_param('s', $name);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $output->status = 'exist';
                    echo (json_encode($output));
                } else {
                    $sql = $conn->prepare(
                        "SELECT personId 
                        FROM tb_person 
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $personId = (int)$result->fetch_assoc()['personId'] + 1;

                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "INSERT INTO tb_person
                            (personId, personName, isDeleted, userName) 
                            VALUES (?, ?, '0', ?)"
                        );
                        $sql->bind_param('sss', $personId, $name, $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        $logNote = "added person '{$name}'";

                        $log = $conn->prepare(
                            "INSERT INTO tb_logs
                            (activity, category, userName, note)
                            VALUES ('insert', ?, ?, ?)"
                        );
                        $log->bind_param('sss', $restAPI, $userName, $logNote);
                        if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        //ADD MAPPING
        case 'mobile':
            $mappingTag = $_POST['id'];

            if (
                isset($name) && !empty($name) && $name != 'undefined' &&
                isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
                isset($mappingTag) && !empty($mappingTag) && $mappingTag != 'undefined'
            ) {
                $sql = $conn->prepare(
                    "SELECT userName 
                    FROM tb_users 
                    WHERE hashMobile = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                $userName = $result->fetch_assoc()['userName'];

                $sql = $conn->prepare(
                    "SELECT mappingId 
                    FROM tb_person_mapping 
                    WHERE mappingTag = ?"
                );
                $sql->bind_param('s', $mappingTag);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $output->status = 'exist';
                    echo (json_encode($output));
                } else {
                    $sql = $conn->prepare(
                        "SELECT mappingId 
                        FROM tb_person_mapping 
                        ORDER BY uid DESC LIMIT 1"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $mappingId = (int)$result->fetch_assoc()['mappingId'] + 1;

                    try {
                        $conn->begin_transaction();

                        $sql = $conn->prepare(
                            "INSERT into tb_person_mapping
                            (mappingId, mappingTag, mappingName, username) 
                            VALUES (?, ?, ?, ?)"
                        );
                        $sql->bind_param('ssss', $mappingId, $mappingTag, $name, $userName);
                        if ($sql->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                        $logNote = "added card '{$name}'";

                        $log = $conn->prepare(
                            "INSERT INTO tb_logs
                            (activity, category, userName, note)
                            VALUES ('insert', ?, ?, ?)"
                        );
                        $log->bind_param('sss', $restAPI, $userName, $logNote);
                        if ($log->execute() === FALSE) throw new Exception('Statement INSERT Failed');

                    } catch (Exception $e) {
                        $output->status = 'failed';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->rollback();
                        exit();
                    } finally {
                        $output->status = 'success';
                        $output->execute = microtime(true) - $execute;
                        echo (json_encode($output));
                        $conn->commit();
                    }
                }
            } else {
                $output->status = 'error';
                $output->execute = microtime(true) - $execute;
                echo (json_encode($output));
            }
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userHash = $_GET['hash'];
    $action = $_GET['action'];

    switch ($action) {
        //GET PERSON LIST
        case 'person':
            $device = $_GET['device'];

            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
                isset($device) && !empty($device) && $device != 'undefined') {
                $sql;
                switch ($device) {
                    case 'web':
                        $sql = $conn->prepare(
                            "SELECT userId 
                            FROM tb_users 
                            WHERE hashWeb = ?"
                        );
                        break;
                    case 'mobile':
                        $sql = $conn->prepare(
                            "SELECT userId 
                            FROM tb_users 
                            WHERE hashMobile = ?"
                        );
                        break;
                }
                
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT personName, personId, lastUpdated 
                        FROM tb_person 
                        WHERE isDeleted = '0'
                        ORDER BY personName ASC"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $personArray = [];
                    while ($row = $result->fetch_assoc()) {
                        $personArray[] = (object) [
                            'ref' => $row['personId'],
                            'name' => ucfirst($row['personName']),
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                        ];
                    }

                    $sql = $conn->prepare(
                        "SELECT mappingId, mappingName, mappingTag, lastUpdated
                        FROM tb_person_mapping
                        ORDER BY mappingName ASC"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $mappingArray = [];
                    while ($row = $result->fetch_assoc()) {
                        $mappingArray[] = (object) [
                            'id' => $row['mappingId'],
                            'name' => ucfirst($row['mappingName']),
                            'tag' => strtoupper($row['mappingTag']),
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated']))
                        ];
                    }

                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->person = $personArray;
                    $output->mapping = $mappingArray;
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
        //GET MAPPING LIST
        case 'mapping':
            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userId 
                    FROM tb_users 
                    WHERE hashWeb = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT mappingId, mappingName, lastUpdated 
                        FROM tb_person_mapping
                        ORDER BY mappingName ASC"
                    );
                    $sql->execute();
                    $result = $sql->get_result();
                    $mappingArray = [];
                    while ($row = $result->fetch_assoc()) {

                        $mappingArray[] = (object) [
                            'id' => $row['mappingId'],
                            'name' => ucfirst($row['mappingName']),
                            'update' => date('d/m/Y (H:i)', strtotime($row['lastUpdated'])),
                        ];
                    }
                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->mapping = $mappingArray;
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
        //GET MAPPING NAME
        case 'check':
            $mappingTag = $_GET['id'];

            if (isset($userHash) && !empty($userHash) && $userHash != 'undefined' &&
                isset($mappingTag) && !empty($mappingTag) && $mappingTag != 'undefined') {
                $sql = $conn->prepare(
                    "SELECT userId 
                    FROM tb_users 
                    WHERE hashMobile = ?"
                );
                $sql->bind_param('s', $userHash);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $sql = $conn->prepare(
                        "SELECT mappingName 
                        FROM tb_person_mapping 
                        WHERE mappingTag = ?"
                    );
                    $sql->bind_param('s', $mappingTag);
                    $sql->execute();
                    $result = $sql->get_result();
                    $mappingName = $result->fetch_assoc()['mappingName'];

                    $output->status = 'success';
                    $output->execute = microtime(true) - $execute;
                    $output->mapping = ucfirst($mappingName);
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
        //GET MAPPING LIST PATROL
        case 'list':
            $sql = $conn->prepare(
                "SELECT mappingId, mappingTag
                FROM tb_person_mapping"
            );
            $sql->execute();
            $getMapping = $sql->get_result();
            $mapping = [];
            while ($row = $getMapping->fetch_assoc()) {

                $mapping[] = (object) [
                    'mappingId' => $row['mappingId'],
                    'mappingTag' => $row['mappingTag']
                ];

            }
            $output->status = 'success';
            $output->execute = microtime(true) - $execute;
            $output->mapping = $mapping;
            echo (json_encode($output));
            break;
        default:
            $output->status = 'error';
            $output->execute = microtime(true) - $execute;
            echo (json_encode($output));
            break;
    }
}
