<?php
include '../api/config.php';
?>
<div class="page">
    <div class="navbar">
        <div class="navbar-bg"></div>
        <div class="navbar-inner">
            <div class="left left-navbar">
                <a href="#" class="link back">
                    <span>Back</span>
                </a>
            </div>
            <div class="title text-align-center" style="width: 100%;">Dashboard</div>
        </div>
    </div>

    <div class="page-content">
        <div style="max-width: 1280px; margin: 0 auto;">
            <?php
            $sqlPerson = $conn->prepare("SELECT personId FROM tb_activity WHERE activityStatus = '0'");
            $sqlPerson->execute();
            $resultPerson = $sqlPerson->get_result();
            if ($resultPerson->num_rows > 0) {
                echo('
                    <div class="card card-outline">
                        <div class="card-header">
                            <span>Activity</span>
                            <a class="button button-raised" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="row no-gap">
                ');
                while ($rowPerson = $resultPerson->fetch_assoc()) {
                    echo('
                        <div class="col-100 medium-50 text-align-center padding" style="border: 1px solid #e5e5e5;">
                            <span>Person ID' . $rowPerson['personId'] . '</span>
                            <div class="timeline timeline-sides">
                    ');
                    $sqlCheck = $conn->prepare("SELECT tb_report.reportDate, tb_report.reportTime, tb_report.checkpointId FROM tb_report, tb_checkpoint WHERE tb_report.checkpointId = tb_checkpoint.checkpointId AND tb_report.personId = ?");
                    $sqlCheck->bind_param('s', $rowPerson['personId']);
                    $sqlCheck->execute();
                    $resultCheck = $sqlCheck->get_result();
                    if ($resultCheck->num_rows > 0) {
                        while ($rowCheck = $resultCheck->fetch_assoc()) {
                            $sql = $conn->prepare("SELECT checkpointName, checkpointId FROM tb_checkpoint WHERE checkStatus = '1'");
                            $sql->execute();
                            $result = $sql->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['checkpointId'] == $rowCheck['checkpointId']) {
                                        echo('
                                            <div class="timeline-item">
                                                <div class="timeline-item-date">
                                                    <span>' . date_format(date_create($rowCheck['reportDate']), 'd M') . '</span><br/>
                                                    <span>' . $rowCheck['reportTime'] . '</span>
                                                </div>
                                                <div class="timeline-item-divider" style="background: green;"></div>
                                                <div class="timeline-item-content">
                                                    <div class="timeline-item-inner">Point ' . $row['checkpointName'] . '</div>
                                                </div>
                                            </div>
                                        ');
                                    } else {
                                        echo('
                                            <div class="timeline-item">
                                                <div class="timeline-item-date"></div>
                                                <div class="timeline-item-divider"></div>
                                                <div class="timeline-item-content">
                                                    <div class="timeline-item-inner">Point ' . $row['checkpointName'] . '</div>
                                                </div>
                                            </div>
                                        ');
                                    }
                                }
                            }
                        }
                    } else {
                        $sql = $conn->prepare("SELECT checkpointName, checkpointId FROM tb_checkpoint WHERE checkStatus = '1'");
                        $sql->execute();
                        $result = $sql->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo('
                                            <div class="timeline-item">
                                                <div class="timeline-item-date"></div>
                                                <div class="timeline-item-divider"></div>
                                                <div class="timeline-item-content">
                                                    <div class="timeline-item-inner">Point ' . $row['checkpointName'] . '</div>
                                                </div>
                                            </div>
                                        ');
                            }
                        }
                    }
                    echo('
                        </div>
                    </div>
                    ');
                }
                echo('
                        </div>
                    </div>
                    <div class="card-footer justify-content-flex-end">Last Updated ' . date("d M Y H:i:s") . '</div>
                </div>
                ');
            } else {
                echo('
                    <div class="card card-outline">
                        <div class="card-header">
                            <span>Activity</span>
                            <a class="button button-raised" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg>
                            </a>
                        </div>
                    <div class="card-content">
                        <div class="padding text-align-center">
                            <span>No data result!</span>
                        </div>
                    </div>
                    <div class="card-footer justify-content-flex-end">Last Updated ' . date("d M Y H:i:s") . '</div>
                ');
            }
            ?>
        </div>
    </div>
</div>