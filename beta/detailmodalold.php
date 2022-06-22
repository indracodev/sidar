<?php
include "config.php";

    if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        $sql = "SELECT * FROM masterproduk WHERE idproduk = $id";
        $result = $conn->query($sql);
        foreach ($result as $baris) { ?>
            <table class="table">
                <tr>
                    <td>Target</td>
                    <td>:</td>
                    <td><?php echo $baris['idproduk']; ?></td>
                </tr>
                <tr>
                    <td>To Do</td>
                    <td>:</td>
                    <td><?php echo $baris['namaproduk']; ?></td>
                </tr>
                <tr>
                    <td>Result</td>
                    <td>:</td>
                    <td><?php echo $baris['shortdescription']; ?></td>
                </tr>
            </table>
        <?php 
 
        }
    }
    $conn->close();
?>