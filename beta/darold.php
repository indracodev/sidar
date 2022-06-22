<?php
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;
$q = 0;
date_default_timezone_set('Asia/Jakarta');

$datee = date('Y-m-d');
$dateee = date('d-m-Y');

$jam = date('H:i');

$day = date('d');
$year = date('Y');
 
$monthNum  = date('m');
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March



$tanggal = "$day $monthName $year"; 

if($_SESSION["IDUser"] == 0){
header("Location: http://icg.id/beta/dar/login");
    }
    
    

include "config.php";



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

 $ambilstatustanggalibur = "SELECT * FROM mastertanggal 
   WHERE $bln = 'libur'";
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
  // echo " gak dapat tanggaldar ";
 }

$ststgldar = new DateTime($statustanggaldar);
$ststgldar->modify('+1 day');
$tglterakhirdar = $ststgldar->format('Y-m-d'); 

 
$tanggal1 = new DateTime($tglterakhirdar);
$tanggal2 = new DateTime();
 
$perbedaan = $tanggal2->diff($tanggal1)->format("%a");
 
 
if ($datee == $statustanggaldar || $perbedaan == 0 || $arraytgl[0] == $datee ){
    
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
 


   

    
?>

<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" type="text/css" href="custom.css">
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
        <?php include'navbar.php' ;?>

        <!-- ---------------------------- 
            konten 
        ---------------------------- -->
        <main class="konten">

<section class="dar mb-5 text-center text-lg-left">
   
                <header class="text-center">
                    <h4>DAILY ACTIVITY REPORT</h4>
                    <hr class="garis-judul-hijau my-0">
                    
                </header>
                
            
                
                <br>
                
                 <form form action="datauploadd.php" method="post" enctype="multipart/form-data" class="mb-4">
                      <div style="<?php echo $displayselect;?>"class="row" style="margin-bottom: 1rem;">
                <div class="col-sm-2">
                              <select name="tanggaldar" id="TglDar" class="form-control">
                              <option value="<?php echo $arraytgl[0];?>" ><?php echo $arraytgl[0];?></option>
                               
                            </select>
                          
                          </div>
                      </div>
                
              <label class="d-flex justify-content-end mb-1">
<?php echo $tanggal; ?> <?php echo "- " ?><?php echo $jam; ?></label>
                
            

                <h5 class="titel">Daily activity:</h5>
                <input name="activity" type="hidden">
                <div id="editor1" name="aktifitas" class="text mb-4"><?php echo $draftactivity; ?></div>
              
                  <h5 class="titel">Result: </h5>
                <input name="result" type="hidden">
                <div id="editor3" name="result" class="text mb-4"><?php echo $draftresult; ?></div>
                  
                
                <h5 class="titel">Planning: </h5>
                <input name="planning" type="hidden">
                <div id="editor2" name="isiplaning" class="text mb-4"><?php echo $draftplan; ?></div>
                
                 
                <h5 class="titel">Tags:</h5>
                <textarea maxlength="50" id="tags" class="tags" name="tags" oninput="auto_grow(this)"><?php echo $drafttag; ?></textarea>


              <input name="nodar" style="display:none;" type="text" class="form-control-file" id="nodar" value="<?php echo $nodarnya; ?>">
              <input name="iduser" style="display:none;" type="text" class="form-control-file" id="iduser" value="<?php echo $iduser; ?>">
              <input name="keuser" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuser; ?>">

              
                    <div id="attach" class="form-group">
                         <label for="attachmentFiles" class="font-weight-bold">Files Attachment</label>
                        <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q ?>">
                    </div>
               

               <button type="submit" style="display:none;" name="btdraft" id="btdraft" value="savedraft" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                
                
                <button type="submit" style="display:none;" name="btdar" id="btdar" value="kirimdar" class="btn btn-outline-dark">
                    <i class="fa fa-send"></i> SEND REPORT
                </button> 

                
                 </form>
                 
                 
                 <button class="btn btn-outline-dark"  data-toggle="modal" data-target="#konfirmasiDraft">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                <button class="btn btn-outline-dark" style="<?php echo $display?>" data-toggle="modal" data-target="#konfirmasiModal">
                    <i class="fa fa-send"></i> SEND REPORT
                </button>
                
                 

                 
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
                 <button type="button" onclick="senddraft()" class="btn btn-outline-success">Send</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- custom JS -->
    <script type="text/javascript" src="custom.js"></script>
    <!-- Quil editor JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
       <script>
        var toolbarOptions = [
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }]
        ];

        var quill = new Quill('#editor1', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        
        var quillHtml = quill.root.innerHTML.trim();

        var quill2 = new Quill('#editor2', {
          modules: {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
        
        var quill3 = new Quill('#editor3', {
          modules: {
            toolbar: toolbarOptions
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
result.value = quill.root.innerHTML;

var url ="rec.php";
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

         var thing	  = '<div id="attach1" class="form-group"> <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>""> </div>';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach').append( $(thing) );

      $("#attachmentFiles1").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<div id="attach2" class="form-group"> <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>""> </div>';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach1').append( $(thing) );


           $("#attachmentFiles2").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<div id="attach3" class="form-group"> <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>""> </div>';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach2').append( $(thing) );

 
         $("#attachmentFiles3").change(function() {
<?php $q=$q+1; ?>

         var thing	  = '<div id="attach4" class="form-group"> <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles<?php echo $q; ?>""> </div>';
    var close	  = '<a href="#" class="close">close</a>';

    $('#attach3').append( $(thing) );

 
       
     })
 
 
       
     })
 
       
     })
     

       
     })
     
    
     
  

   });
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