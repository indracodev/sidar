<?php
       
 
include "config.php";


 $roid = $_POST['rowid'];
 
$pecahh = explode("/", $roid);
$hasilid = $pecahh[0];
$id = $hasilid;

$hasiltgl = $pecahh[1];
$pecaht = explode("-", $hasiltgl);
$haridar = $pecaht[0];
$bulandar = $pecaht[1];
$tahundar = $pecaht[2];

$tgldar = $haridar.$bulandar.$tahundar;

 
 date_default_timezone_set('Asia/Jakarta');
 
  $ambilnomer = "SELECT iddetdar FROM draftddar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
   
   
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $nodar = $rowambilnomer['iddetdar'];
 
 $pecah = explode("/", $nodar);
$hasil = $pecah[1] + 1;
$nodarnya = $tgldar."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $nodarnya = $tgldar."/".$satu;
 }
 
 
    if($_POST['rowid']) {
        


      //  $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        $sql = "SELECT * FROM todo WHERE iduser = $id";
        $result = $conn->query($sql);
        $arrayresult= mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
              <div class="form-group">
              <label for="target">Target</label>
                    <select name="target" class="form-control" id="target">
                        <?php for($x = 0; $x < sizeof($arrayresult); $x++){ ?>    
                        <option value="<?php echo $arrayresult[$x]['target'] ?>"><?php echo $arrayresult[$x]['target'] ?></option>
                        
                        <? } ?>
                        </select>
                   <!--     <input type="text" class="form-control" name="target" id="target" value="<?// echo $arrayresult[0]['target'] ?>" placeholder="Target"/> -->
                    </div>
                    <div class="form-group">
                        <label for="todo">Activity</label>
                        <select name="activity" class="form-control" id="activity">
                        <?php for($x = 0; $x < sizeof($arrayresult); $x++){ ?>    
                        <option value="<?php echo $arrayresult[$x]['todo'] ?>"><?php echo $arrayresult[$x]['todo'] ?></option>
                        
                        <? } ?>
                        </select>
                    <!--    <input type="text" class="form-control" name="activity" id="activity" value="<? //echo $arrayresult[0]['todo'] ?>" placeholder="Todo"/> -->
                    </div>
                     <div class="form-group">
                        <label for="result">Result</label>
                        <select name="result" class="form-control" id="result">
                        <option value="Process">Process</option>
                        <option value="Done">Done</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Delayed">Delayed</option>
                        <option value="Pending">Pending</option>
                        </select>
                    <!--    <input type="text" class="form-control" name="result" id="result" placeholder="result"/> -->
                    </div>
                    <div class="form-group">
                    <label for="explaination">Explaination</label>
                    <textarea class="form-control"  name="explaination" id="explaination" placeholder="" rows="5"></textarea>
                    <input style="display:none;" type="text" class="form-control" name="iddetdar" id="iddetdar" value="<?php echo $nodarnya;?>" />
                    </div>
                    <div class="form-group">
                    <label for="filed">Proof</label>
                    <input type="file" class="form-control" style="height: calc(1.5em + 1rem + 3px);" name="file" id="filed"/>
                    </div>
                    <span id="uploaded_imaged"></span>
                    <br>
                    <div style="display:none" class="form-group">
                    <br>
                    <label>Date</label>
                    <div>
                  <input class="form-control" type="date" name="tgl" value="<? // echo $arrayresult[0]['date'] ?>" id="dateofbirth">
                  </div>
                    </div>
                      <div style="display:none" class="form-group">
                    <label>Due Date</label>
                  <input class="form-control" type="date" name="duetgl" value="<? // echo $arrayresult[0]['duedate'] ?>" id="dateofbirth">
                    </div>
                    
                  
        <?php 
 
       
    }
    $conn->close();
?>