<?php
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$lokasikerja = $_SESSION["Lokasikerja"] ;

//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;
$q = 0;
date_default_timezone_set('Asia/Jakarta');

$datee = date('Y-m-d');
$dateee = date('d-m-Y');
$tglhariini = date('Y-m-d');

$jam = date('H:i');
$day = date('d');
$year = date('Y');
 
$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March



$tanggal = "$day $monthName $year"; 

if($_SESSION["IDUser"] == 0 ){
header("Location: http://sidar.id/login");
    }
    
    

include "config.php";


if($lokasikerja == "ib"){
$mastgl = "mastertanggal1";    
    
}elseif($lokasikerja == "IGI Purwo"){
$mastgl = "mastertanggal2";    

}elseif($lokasikerja == "IGI Bambe"){
$mastgl = "mastertanggal3";    
    
}elseif($lokasikerja == "sda"){
$mastgl = "mastertanggal4";    
    
}else{
$mastgl = "mastertanggal";
    
}



$ambilattach = "SELECT * FROM draftgambar WHERE iduser = '" .$iduser . "';";
$queryattach =$conn->query($ambilattach);
$arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);



switch ($monthNum) {
    case 1:
       $bln = "januari";
        break;
    case 2:
        $bln = "februari";
        break;
    case 3:
       $bln = "maret";
        break;
    case 4:
       $bln = "april";
        break;
    case 5:
      $bln = "mei";
        break;
    case 6:
        $bln = "juni";
        break;
    case 7:
      $bln = "juli";
        break;
    case 8:
       $bln = "agustus";
        break;
    case 9:
      $bln = "september";
        break;
    case 10:
     $bln = "oktober";
        break;
    case 11:
        $bln = "november";
        break;
    case 12:
       $bln = "desember";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

 $ambilstatustanggalibur = "SELECT * FROM $mastgl WHERE $bln = 'libur'";
// $ambilstatustanggalibur = "SELECT * FROM mastertanggal WHERE januari = 'libur' OR februari = 'libur' OR maret = 'libur' OR april = 'libur' OR mei = 'libur' OR juni = 'libur' OR juli = 'libur' OR agustus = 'libur' OR september = 'libur' OR oktober = 'libur' OR november = 'libur' OR desember = 'libur'";
   $queryambilstatustanggalibur =$conn->query($ambilstatustanggalibur);
  $jumlahlibur = count($arraytgl);

 //$statuslibur = $rowambilstatustanggalibur['id'];
 
   
 if($queryambilstatustanggalibur->num_rows){

$rowambilstatustanggalibur = mysqli_fetch_all($queryambilstatustanggalibur, MYSQLI_ASSOC);


$t = 0;
$daftartanggalibur[$t];
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]. "-" .$monthNum. "-".$year ;
   $t++;
}

   $daftartanggalibur[$t] = '31-05-2020' ;
   $t++;
   $daftartanggalibur[$t] = '30-05-2020' ;
   $t++;
   $daftartanggalibur[$t] = '31-07-2020' ;
   $t++;
    $daftartanggalibur[$t] = '29-08-2020' ;
   $t++;
     $daftartanggalibur[$t] = '30-08-2020' ;
   $t++;

 $jumlahlibur = count($rowambilstatustanggalibur);


 if($statuslibur == "libur"){
     
  //   $display = "display:none;";
     
 }else{
     
 }

 }else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat libur ";
 }



 $ambilstatustanggaldar = "SELECT * FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY tanggaldar DESC;";
   $queryambilstatustanggaldar =$conn->query($ambilstatustanggaldar);
 if($queryambilstatustanggaldar->num_rows){
  
 $rowambilstatustanggaldar = mysqli_fetch_array($queryambilstatustanggaldar, MYSQLI_ASSOC);
 $statustanggaldar = $rowambilstatustanggaldar['tanggaldar'];
 


 }else{
    // header("location: http://www.icg.id/beta/dar/login");
    $arraytgl[0] = $datee;
 //  echo " gak dapat tanggaldar ";
 }

$ststgldar = new DateTime($statustanggaldar);
$ststgldar->modify('+1 day');
$tglterakhirdar = $ststgldar->format('Y-m-d'); 

 
$tanggal1 = new DateTime($tglterakhirdar);
$tanggal2 = new DateTime();
$tanggaldiff = date_diff($tanggal1,$tanggal2);
//$perbedaan = $tanggal2->diff($tanggal1)->format("%a");
$perbedaan = $tanggaldiff->format("%a%");
 
if ($arraytgl[0] == $dateee || $perbedaan == 0 || $datee == $statustanggaldar   ){
    
$displayselect = "display:none;";
$arraytgl[0] = $dateee;    
    
}else {
    
    
    
$displayselect = "";
$begin = new DateTime($tglterakhirdar);
$end = new DateTime('tomorrow');;


$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$z = 0;
$arraytgl[$z];
foreach ($period as $dt) {
  $arraytgl[$z] = $dt->format("d-m-Y");
    
    $z++;
  //  count($arraytgl);
    //unset($arrayku[2]);
}

}
   for($p = 0; $p <  sizeof($daftartanggalibur); $p++){
  for($x = 0; $x <  sizeof($arraytgl); $x++){
    //    $tmptgl = $arraytgl[$x];
    //     $tmptglibur = $daftartanggalibur[$p];
      if ($arraytgl[$x] == $daftartanggalibur[$p]){
        // unset($arraytgl[$x]);
       array_splice($arraytgl, $x, 1);
      }
  }

  }
//  $arraytgl[$x+1] = "";

// unset($arraytgl[]);

 $ambilstatus = "SELECT * FROM masteruser 
   WHERE id = '" .$iduser. "' ;";
   $queryambilstatus =$conn->query($ambilstatus);
 if($queryambilstatus->num_rows){

 $rowambilstatus = mysqli_fetch_array($queryambilstatus, MYSQLI_ASSOC);
 $statuskirim = $rowambilstatus['sudahkirim'];
 $keuser = $rowambilstatus['ke'];
 $keuserdua = $rowambilstatus['ke2'];
 $keusertiga = $rowambilstatus['ke3'];
 $keuserempat = $rowambilstatus['ke4'];
 $keuserlima = $rowambilstatus['ke5'];
 $jabatan = $rowambilstatus['jabatan'];
 
 if($statuskirim == "sudah"){
     
     $display = "display:none;";
     
 }else{
     
 }


 }else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat status ";
 }



 $ambilnomer = "SELECT nodar FROM dar 
   WHERE iduser = '" .$iduser. "' ORDER BY urid DESC LIMIT 1 ;";
   $queryambilnomer =$conn->query($ambilnomer);
 if($queryambilnomer->num_rows){
   session_start();
 $rowambilnomer = mysqli_fetch_array($queryambilnomer, MYSQLI_ASSOC);
 $nodar = $rowambilnomer['nodar'];
 
 $pecah = explode("/", $nodar);
$hasil = $pecah[1] + 1;
$nodarnya = $iduser."/".$hasil;

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
    $satu = "1";
   //echo " gak dapat nomer ";
   $nodarnya = $iduser."/".$satu;
 }



$ambildraft = "SELECT * FROM draft 
 WHERE iduser = '" .$iduser . "';";
 $querydraft =$conn->query($ambildraft);
 if($querydraft->num_rows){
   session_start();
   $row = mysqli_fetch_array($querydraft, MYSQLI_ASSOC);
   $draftactivity = $row['activity'];
   $draftplan = $row['plan'];
   $drafttag = $row['tag'];
   $draftresult = $row['result'];

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat draft ";
 }
 

 $ambiltgldarakhir = "SELECT tanggal FROM dar ORDER BY urid DESC LIMIT 1 ;";
   $queryambiltglakhir =$conn->query($ambiltgldarakhir);
 if($queryambiltglakhir->num_rows){
   session_start();
 $rowambiltgldarakhir = mysqli_fetch_array($queryambiltglakhir, MYSQLI_ASSOC);
 $tgldarterakhir = $rowambiltgldarakhir['tanggal'];
 

 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
  // echo " gak dapat nomer ";
 }



$datetime = DateTime::createFromFormat('Y-m-d', $tglhariini);
$namahari = $datetime->format('D');

if ($tglhariini == $tgldarterakhir){
$stts = "v";
 

} elseif ($tglhariini != $tgldarterakhir){
 $stts = "w";
 
if ($namahari == "Sat" && $jam >= "13:00"){
$stts = "x";

$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}    


 
}elseif ($namahari != "Sat" && $jam >= "16:00"){
    $stts = "y";
$belumkirim .= "UPDATE masteruser SET sudahkirim='belum' ";      
if ($conn->query($belumkirim) === TRUE) {
}else{
    
}   
    
    
}

}else{
    $stts = "z";
}

   
   if ($arraytgl[0] == $dateee || $perbedaan == 0 || $datee == $statustanggaldar   ){
    
$displayselect = "display:none;";
//$arraytgl[0] = $dateee;    
  
   }else{
       
   }

    
?>

<!DOCTYPE html>
<html translate="no">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title>DAR</title>
    <link rel="stylesheet icon" href="img/ikon.png">

    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- custom CSS -->
    <link rel="stylesheet" type="text/css" href="custom1.css">
    <!-- Quil editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Konten Style -->
    <style type="text/css">
        .dar header {
            padding: 2rem 0;
        }
        .dar header h4 {
          font-size: 1.2rem;
          font-weight: 800;
        }
        .dar .titel {
          font-size: 18px;
          font-weight: bold;
          letter-spacing: 1px;
        }
        .text {
            min-height: 360px;
        }
        .tags {
            width: 100%;
            min-height: 102px;
            outline: none;
            padding: 1rem;
            border-left: 0 solid #ccc;
            border-right: 0 solid #ccc;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
        /*customize quil text editor*/
        .ql-toolbar.ql-snow {
            border-left: 0 solid #ccc;
            border-right: 0 solid #ccc;
            border-bottom: 0 solid #ccc;
            background-color: #f3f3f3;
        }
        .ql-container.ql-snow {
            border-left: 0 solid #ccc;
            border-right: 0 solid #ccc;
        }
        /*tampilan ipad lansekap*/
        @media(min-width: 992px) {
            .dar {
                padding: 0 1rem;
            }
            .tags {
                border-left: 1px solid #ccc;
                border-right: 1px solid #ccc;
            }
            .ql-toolbar.ql-snow {
                border-left: 1px solid #ccc;
                border-right: 1px solid #ccc;
            }
            .ql-container.ql-snow {
                border-left: 1px solid #ccc;
                border-right: 1px solid #ccc;
            }
        }
    </style>

</head>
<body>

    <div class="wrapper">
        
        <!-- ---------------------------- 
            navbar
        ---------------------------- -->
        <?php include'navbar1.php' ;?>

        <!-- ---------------------------- 
            konten 
        ---------------------------- -->
        <main class="konten">

<section class="dar mb-5 text-center text-lg-left">

                <header class="text-center">
                    <h4>DAILY ACTIVITY REPORT <?php ?></h4>
                    <hr class="garis-judul-hijau my-0">
                    
                </header>
                
                <?php
                if($arraytgl[0] == ''){
                    
                    $arraytgl[0] = $dateee;
                    $displayselect = 'display:none';
                    
                }
            
                ?>
            
                  <button class="btn btn-outline-danger" style="float:right;margin-right:10px" data-toggle="modal" data-target="#konfirmasiLibur">
                    <i class="fa fa-home"></i> ABSENCE
                </button>
                <br>
                <br>
                
                 <form action="dataupload3.php" method="post" enctype="multipart/form-data" class="mb-4">
              
                      
                      <div style="<?php echo $displayselect;?>"class="row" style="margin-bottom: 1rem;">
                <div class="col-sm-5">
                 <?php $late2endmn = "16:00:00"; ?>
                  
                   <label style="color:red;" for="TglDar">Belum Kirim DAR</label><br>
                       <label style="color:red;" for="TglDar">DAR Date</label>
                              <select name="tanggaldar" id="TglDar" style="width:45%; display:inline-block; color:red;" class="form-control">
                              <option value="<?php echo $arraytgl[0];?>" ><?php echo $arraytgl[0];?></option>
                              
                            </select>
                            
              
                          </div>
                      </div>
                  </button>
              
                 
              <label class="d-flex justify-content-end mb-1">
<?php echo $tanggal . " -"; ?> <?php echo $jam; ?></label>
                
            

                <h5 class="titel">Daily activity:</h5>
                <input name="activity" type="hidden">
                <div id="editor1" name="aktifitas" class="text mb-4 notranslate"><?php echo $draftactivity; ?></div>
              
                  <h5 class="titel">Result: </h5>
                <input name="result" type="hidden">
                <div id="editor3" name="hasil" class="text mb-4 notranslate"><?php echo $draftresult; ?></div>
                  
                
                <h5 class="titel">Planning: </h5>
                <input name="planning" type="hidden">
                <div id="editor2" name="isiplaning"  class="text mb-4 notranslate"><?php echo $draftplan; ?></div>
                
                 
                <h5 style="display:none" class="titel">Tags:</h5>
                <textarea style="display:none" maxlength="50" id="tags" class="tags" name="tags" oninput="auto_grow(this)"><?php echo $drafttag; ?></textarea>


              <input name="nodar" style="display:none;" type="text" class="form-control-file" id="nodar" value="<?php echo $nodarnya; ?>">
              <input name="iduser" style="display:none;" type="text" class="form-control-file" id="iduser" value="<?php echo $iduser; ?>">
              <input name="keuser" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuser; ?>">
              <input name="kedua" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuserdua; ?>">
              <input name="ketiga" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keusertiga; ?>">
              <input name="keempat" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuserempat; ?>">
              <input name="kelima" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuserlima; ?>">
              <input name="jabatan" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $jabatan; ?>">   
              
                  
               
                  
              
                    <div id="attach" class="form-group">
                         <label for="attachmentFiles" class="font-weight-bold">Files Attachment</label><br>
                       
                
                             
                                <?php
                
                for($x = 0; $x < sizeof($arrayrattach); $x++){
                  ?>
                  <div>
             
                         <a href="deletedraftattach.php?address=img/<?php echo $iduser  ?>/<?php echo $arrayrattach[$x]["gambar"] ?>" class="btn btn-light"> <strong>Delete</strong> </a>&nbsp <a href="img/<?php echo $iduser  ?>/<?php echo $arrayrattach[$x]["gambar"] ?>"><?php echo $arrayrattach[$x]["gambar"] ?></a>
                      
                     
                        
                        </div>
                            <?php }  ?>
                            
                        <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q ?>">
                    </div>
               

               <button type="submit" style="display:none;" name="btdraft" id="btdraft" value="savedraft" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                
                <button style="display:none;" name="btdraftfoto" id="btdraftfoto" value="savedraftfoto" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT FOTO
                </button>
                
                   <button style="display:none;" name="btdraftlogout" id="btdraftlogout" value="savedraftlogout" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT LOGOUT
                </button>
                
                
                <button type="submit" style="display:none;" name="btdar" id="btdar" value="kirimdar" class="btn btn-outline-dark">
                    <i class="fa fa-send"></i> SEND REPORT
                </button> 

                  <button type="submit" style="display:none;" name="btnlibur" id="btnlibur" value="savelibur" class="btn btn-outline-dark">
                    <i class="fa fa-send"></i> Absence
                </button> 
                 </form>
                
                <button style="display:none;" name="btdraftmodal" id="btdraftmodal" data-toggle="modal" data-target="#konfirmasiuploadfoto" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> upload foto 
                </button> 
                 
                 <button class="btn btn-outline-dark"  data-toggle="modal" data-target="#konfirmasiDraft">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                <button class="btn btn-outline-dark" style="<?php echo $display?>" data-toggle="modal" data-target="#konfirmasiModal">
                    <i class="fa fa-send"></i> SEND REPORT
              

                 
            </section><!-- end dar -->

            <!-- FOOTER -->
            <?php include'footer.php';?>
            
        </main>

    </div><!-- end wrapper -->

    <!-- MODAL KONFIRMASI -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!-- <h5 class="modal-title" id="konfirmasiModalTitle">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex align-items-end">
                    <i class="fa fa-warning fa-2x mr-3"></i>
                    <p class="mb-0">Are you sure want to send this report?</p>
                </div>
                <div class="modal-footer border-0">
                 <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
                 <button type="button" onclick="senddar()" class="btn btn-outline-success">Send</button>
                </div>
            </div>
        </div>
    </div>


<!-- MODAL KONFIRMASI DRAFT -->
    <div class="modal fade" id="konfirmasiDraft" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!-- <h5 class="modal-title" id="konfirmasiModalTitle">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex align-items-end">
                    <i class="fa fa-warning fa-2x mr-3"></i>
                    <p class="mb-0">Are you sure want to save draft?</p>
                </div>
                <div class="modal-footer border-0">
                 <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
                 <button type="button" onclick="senddraft()" class="btn btn-outline-success">Save</button>
                </div>
            </div>
        </div>
    </div>


<!-- MODAL KONFIRMASI UPLOAD FOTO -->
    <div class="modal fade" id="konfirmasiuploadfoto" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!-- <h5 class="modal-title" id="konfirmasiModalTitle">Modal title</h5> -->
               
                </div>
                <div class="modal-body d-flex justify-content-center align-items-end">
                    <i class="fa fa-spinner fa-spin fa-2x mr-3"></i>
                    <p class="mb-0">Sedang upload file</p>
                </div>
                <div class="modal-footer border-0">
                </div>
            </div>
        </div>
    </div>


<!-- MODAL KONFIRMASI Libur -->
    <div class="modal fade" id="konfirmasiLibur" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <!-- <h5 class="modal-title" id="konfirmasiModalTitle">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex align-items-end">
                    <i class="fa fa-warning fa-2x mr-3"></i>
                    <p class="mb-0">Are you sure want to absence?</p>
                </div>
                <div class="modal-footer border-0">
                 <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
                 <button type="button" onclick="sendlibur()" class="btn btn-outline-success">Yes</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
<script>
            function myFunctionx() {
     
         document.getElementById("btncolaps").click();
         document.getElementById("btncolaps").style.visibility = "visible";
         document.getElementById("spancolaps").style.display = "block";
         document.getElementById("spancolaps1").style.display = "block";
         document.getElementById("spancolaps2").style.display = "block";    
        };

      function myFunction() {
          //  document.getElementById("btncolaps").style.visibility = "hidden";
         document.getElementById("spancolaps").style.display = "none";
         document.getElementById("spancolaps1").style.display = "none";
         document.getElementById("spancolaps2").style.display = "none";       
        };
     
    
    </script>


    <script>
        $(document).ready(function () {
	$('.tombolCollapseSidebarr').on('click', function () {
		$('.wrapper').toggleClass('geser');
		$('.sidebar').toggleClass('geser');
		$('.topbar').toggleClass('geser');
		$('.anti-scroll').toggleClass('geser');
		$('.konten').toggleClass('geser');
		$(this).toggleClass('geser');
	});
});
        
    </script>

    <!-- custom JS -->
    <script type="text/javascript" src="custom.js"></script>
    <!-- Quil editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
       <script>
      var icons = Quill.import("ui/icons");
    icons["undo"] = `<svg viewbox="0 0 18 18">
    <polygon class="ql-fill ql-stroke" points="6 10 4 12 2 10 6 10"></polygon>
    <path class="ql-stroke" d="M8.09,13.91A4.6,4.6,0,0,0,9,14,5,5,0,1,0,4,9"></path>
  </svg>`;
    icons["redo"] = `<svg viewbox="0 0 18 18">
    <polygon class="ql-fill ql-stroke" points="12 10 14 12 16 10 12 10"></polygon>
    <path class="ql-stroke" d="M9.91,13.91A4.6,4.6,0,0,1,9,14a5,5,0,1,1,5-5"></path>
  </svg>`;
  
  
        var toolbarOptions = [
          ['undo'],['redo'],['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}],
          [{'indent': '+1'}],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }]
        ];
        
        var toolbarOptionss = [
          ['undo'],['redo'],['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}],
          [{'indent': '+1'}],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }]
        ];

        var quill = new Quill('#editor1', {
         modules: {
            history: {
             delay: 2000,
             maxStack: 500,
             userOnly: true
          },  
       toolbar: {
      container: toolbarOptionss,
      handlers: {
        undo: function(value) {
          this.quill.history.undo();
        },
        redo: function(value) {
          this.quill.history.redo();
        }
      }
    }
        
          },
    
        
              
          
     theme: 'snow'
        });
        
        var quillHtml = quill.root.innerHTML.trim();



        var quill2 = new Quill('#editor2', {
            modules: {
            history: {
             delay: 2000,
             maxStack: 500,
             userOnly: true
          },  
       toolbar: {
      container: toolbarOptionss,
      handlers: {
        undo: function(value) {
          this.quill.history.undo();
        },
        redo: function(value) {
          this.quill.history.redo();
        }
      }
    }
    
            },
          theme: 'snow'
        });
        
        var quill3 = new Quill('#editor3', {
         modules: {
            history: {
             delay: 2000,
             maxStack: 500,
             userOnly: true
          },  
       toolbar: {
      container: toolbarOptionss,
      handlers: {
        undo: function(value) {
          this.quill.history.undo();
        },
        redo: function(value) {
          this.quill.history.redo();
        }
      }
    }
    
            },
          theme: 'snow'
        });
        

        
    </script>
    <!-- Textarea Editor -->
    <script>
        // auto resize textarea customize
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }

        // bullets and numbering customize
        $(".tags").focus(function() {
            if(document.getElementById('tags').value === ''){
                document.getElementById('tags').value +='#';
            }
        });
        $(".tags").keyup(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                document.getElementById('tags').value +='#';
            }
            var txtval = document.getElementById('tags').value;
            if(txtval.substr(txtval.length - 1) == '\n'){
                document.getElementById('tags').value = txtval.substring(0,txtval.length - 1);
            }
        });        
    </script>
    
    <script>


var form = document.querySelector('form');
form.onsubmit = function() {

//var justHtml.value = quill.root.innerHTML;
//var justHtml.value = "quill.root.innerHTML";
//var discussionContent =  document.querySelector('input[name=discussionContent]');
//discussionContent.value = quill.root.innerHTML;

var planning =  document.querySelector('input[name=planning]');
planning.value = quill2.root.innerHTML;

var activity =  document.querySelector('input[name=activity]');
activity.value = quill.root.innerHTML;

var result =  document.querySelector('input[name=result]');
result.value = quill3.root.innerHTML;

var url ="dataupload3.php";
    $.ajax({
     type: "POST",
     url : url,
     data : activity, planning, result      
    });
    return false;
};

</script>




<script>
    function senddar()
{


$('button[name="btdar"]').val(document.getElementById('btdar').click());
    

}
</script>



<script>
    function senddraft()
{


$('button[name="btdraft"]').val(document.getElementById('btdraft').click());
    

}
</script>


<script>
    function sendlibur()
{


$('button[name="btnlibur"]').val(document.getElementById('btnlibur').click());
    

}
</script>


<script>
    
    
    /*
    function dar()
{

    
  var y = confirm("Are you sure to send DAR?");
 if (y==true) {
     
    $('button[name="btdar"]').val(document.getElementById('btdar').click());
    
  } else {
  
  }
}


*/
</script>

<script>
   $(document).ready(function() {
  
     $("#attachmentFiles0").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>"">';
    var close	  = '<a href="#" class="close">close</a>';
$('#btdraftmodal').trigger('click');
$('#btdraftfoto').trigger('click');
    $('#attach').append( $(thing) );

      $("#attachmentFiles1").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>"">';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach').append( $(thing) );


           $("#attachmentFiles2").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>"">';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach').append( $(thing) );

 
         $("#attachmentFiles3").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>"">';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach').append( $(thing) );

 
       
     })
 
 
       
     })
 
       
     })
     

       
     })
     
    
     
  

   });
</script>

<script>
var link = document.getElementById('btdraftlogout');

window.onload = function(){
   setInterval(function(){
      // alert("Hello");
        link.click();
   }, 1800000);
};
</script>





<script>
  /*  
    function draft()
{

    
  var x = confirm("Are you sure to save draft?");
 if (x==true) {
     
    $('button[name="btdraft"]').val(document.getElementById('btdraft').click());
    
  } else {
  
  }
}
*/
</script>

</body>
</html>