<?php
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$nodar =  $_SESSION["Nodar"] ;

$idnya = $_POST["idnya"];
//$idnya = $_GET["idnya"];
$pecah = explode("/", $idnya);
$hasil = $pecah[0];
$nodarnya = $iduser."/".$hasil;
date_default_timezone_set('Asia/Jakarta');
$tggl = date('Y-m-d');
$waktu = date('H:i');

$wktgl = "|". $tggl.";".$waktu;

if($_SESSION["IDUser"] == 0){
header("Location: http://sidar.id/login");
    }
    
include "config.php";

$ambildar = "SELECT masteruser.nama, masteruser.departemen, dar.sudahbaca, dar.tanggaldar, dar.jam, dar.tanggal, dar.activity, dar.plan, dar.result, dar.tag
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE nodar = '" .$idnya . "';";

$ambilattach = "SELECT * FROM masterattach WHERE nodar = '" .$idnya . "';";
$queryattach =$conn->query($ambilattach);
$arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);




//$ambildar = "SELECT * FROM dar 
// WHERE nodar = '" .$idnya . "';";
 $querydar =$conn->query($ambildar);
 if($querydar->num_rows){
   session_start();
   $row = mysqli_fetch_array($querydar, MYSQLI_ASSOC);
   $daractivity = $row['activity'];
   $darplan = $row['plan'];
   $dartag = $row['tag'];
   $darresult = $row['result'];
   $tanggaldar = $row['tanggaldar'];
   $tanggal = $row['tanggal'];
   $jam = $row['jam'];
   $nama = $row['nama'];
   $dept = $row['departemen'];
   
   $sudahbaca = $row['sudahbaca'];


 }
 else{
    // header("location: http://www.icg.id/beta/dar/login");
   echo " gak dapat dar ";
 }
 
 $pecahsudahbaca = explode("/", $sudahbaca);
 $sdbc1 = $pecahsudahbaca[0];
 $sdbc2 = $pecahsudahbaca[1];
 $sdbc3 = $pecahsudahbaca[2];
 $sdbc4 = $pecahsudahbaca[3];
 $sdbc5 = $pecahsudahbaca[4];
 $sdbc6 = $pecahsudahbaca[5];
 
 $idbc01 = explode("|", $sdbc1);
 $idbc1 = $idbc01[0];
 $idbc02 = explode("|", $sdbc2);
 $idbc2 = $idbc02[0];
 $idbc03 = explode("|", $sdbc3);
 $idbc3 = $idbc03[0];
 $idbc04 = explode("|", $sdbc4);
 $idbc4 = $idbc04[0];
 $idbc05 = explode("|", $sdbc5);
 $idbc5 = $idbc05[0];
 $idbc06 = explode("|", $sdbc6);
 $idbc6 = $idbc06[0];


 
 $ius = "$iduser";
 
 if($sudahbaca == ""){
    $sudahbaca = $iduser . $wktgl . "/";
    $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$idnya . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }elseif ($sudahbaca != "" && $idbc1 != $iduser && $idbc2 != $iduser && $idbc3 != $iduser && $idbc4 != $iduser && $idbc5 != $iduser && $idbc6 != $iduser){
 $sudahbaca = $sudahbaca . $iduser . $wktgl . "/"; 
     
     $kirimsudahbaca .= "UPDATE dar SET sudahbaca='" .$sudahbaca . "' WHERE nodar = '" .$idnya . "' ";      
if ($conn->query($kirimsudahbaca) === TRUE) {
}else{
    
} 


 }else{
     
 }
 
  
 
$pecahtgldar = explode("-", $tanggaldar);
$daydar = $pecahtgldar[2];
$mondar = $pecahtgldar[1];
$yerdar = $pecahtgldar[0];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgldar = $daydar .'-'. $mondar .'-'. $yerdar;
 
 

$pecahtgl = explode("-", $tanggal);
$day = $pecahtgl[2];
$mon = $pecahtgl[1];
$yer = $pecahtgl[0];
/*
$dateObj   = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F'); // March
*/
$tgl = $day .'-'. $mon .'-'. $yer;

$namadownload = "report" . " ". $nama. $tgl . ".pdf" ;


$pecahjam = explode(":", $jam);
$hor = $pecahjam[0];
$min = $pecahjam[1];

$jamm = $hor .':'. $min;

$darsent = $tgl.';'.$jamm;
    
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SIDAR</title>
	<link rel="stylesheet icon" href="img/ikon.png">
	<!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="custom1.css">
   
    <!-- inner style -->
     <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar1.php';?>

		<!-- KONTEN -->
		<main  class="konten">
			
			<!-- letakkan isi konten disini ! -->
            <section class="reportDetail pt-3">
        <div class="capture-area">
                <div id="content" class="container">
                    <header>
                        <div class="kiri" >
                            <form method="post" action="report.php">
                            <button type="submit" class="btn btn-outline-dark border-0">
                                <i class="fa fa-reply"></i> Back
                            </button>
                            </form>
                          
                        </div><!-- end kolom kiri -->
                        <div class="kanan text-right mt-2">
                            
                                
                            
                                  <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:50px;text-align: left;">Name    </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $nama; ?> </label>
                            
                            </div>
                            
                            <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:94px;text-align: left;">Department  </label>
                                   <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $dept; ?></label>
                            
                            </div>
                       
                            <div class="tanggal-report" style="height: 20px;">
                                   <label class="font-weight-bold" style="width:79px;text-align: left;">DAR Date  </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $tgldar; ?> </label>
                            
                            </div>
                            
                            <div class="tanggal-report mb-4">
                                   <label class="font-weight-bold" style="width:79px;text-align: left;">DAR Sent  </label>
                                    <label class="font-weight-bold" style="width:190px;text-align: left;">: <?php echo $darsent; ?> </label>
                            
                            </div>
                        </div><!-- end kolom kanan -->
                    </header>
                    
            
                    <h5 class="font-weight-bold">Activity Today </h5>
                    <div style="WHITE-SPACE: NORMAL;padding-top: 3px;" class="ql-editor activityToday mb-5 notranslate">
                      <?php echo $daractivity; ?>
                    </div>
                 
                    <h5 class="font-weight-bold">Result</h5>
                    <div style="WHITE-SPACE: NORMAL;padding-top: 3px;" class="ql-editor activityToday mb-5 notranslate">
                    <?php echo $darresult; ?>
                    </div>
                 
                    <h5 class="font-weight-bold">Planning</h5>
                    <div style="WHITE-SPACE: NORMAL;padding-top: 3px;" class="ql-editor activityToday mb-3 notranslate">
                    <?php echo $darplan; ?>
                    </div>
                    
                     <h5 style="display:none" class="font-weight-bold">Tags</h5>
                    <p style="display:none" class="planning" style="
                    font-size: 80%;
                    font-style: italic;
                    ">
                <?php echo $dartag; ?>
                    </p>
                    
                    <br>
                    
               <div class="attachment mb-5">
                        <h5>ATTACHMENT FILE</h5>
                          <ul class="daftar-attachment">
                           
                      
                         <?php
                for($x = 0; $x < sizeof($arrayrattach); $x++){
                  ?>
                  
                       
           
                    <li class="attachment-list">
                    <a href="img/<?php echo $hasil ?>/<?php echo $arrayrattach[$x]["gambar"] ?>" class="attachment-link" target="blank"><?php echo $arrayrattach[$x]["gambar"] ?></a>
                            </li>
                   
               
                  
                  <?php } ?>
                  
            
                        </ul>
                    </div>
                  <div id="editor">
                    <button id="print" class="btn btn-outline-dark mb-5">
                       SAVE REPORT AS PDF 
                    </button>
                      <div style="display:none;" class="canvas-container"></div>
                    </div>
       </div>
                </div>
            </section><!-- end report detail -->

			<!-- FOOTER -->
			<?php include'footer.php';?>

		</main><!-- end konten -->
	</div><!-- end wrapper -->

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

    
    <!-- Custom JS -->
    <script type="text/javascript" src="custom.js"></script>
         <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <script src="https://cdn.bootcss.com/jspdf/1.3.5/jspdf.debug.js"></script>
  <script src="https://cdn.bootcss.com/html2canvas/0.5.0-beta4/html2canvas.js"></script>

   <script>
function myFunctionz() {
  window.print();
}
</script>

<script>
    
    $(function() {
  const $downloadBtn = $('#print');
  const $content = $('.capture-area');
  
  $downloadBtn.click(function(){
    const h = $content.height();
    const w = $content.width();
    const canvas = document.createElement('canvas');
    const left = $content.offset().left;
    const top = $content.offset().top;


    canvas.width = w * 2;
    canvas.height = h * 2;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    const context = canvas.getContext('2d');
    context.scale(2, 2);
    context.translate(-left - 8, -top + 10);
    
    html2canvas($content, {
      canvas,
      onrendered: function(canvas) {
        const imgData = canvas.toDataURL('image/png');

 
        const doc = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
       
           format: [w * 0.264583 + 10, h * 0.264583 + 10]
        });

     
        doc.addImage(imgData, 'PNG', 5, 5, w * 0.264583, h * 0.264583);

       
        doc.save('<?php echo $namadownload ?>');
      }
    }).then(function(canvas) {
      if ($('.canvas-container').children().length === 0) {
        const $container = $('.canvas-container');
        $container.append(canvas);
      }
    }) ;
  })
 });
    
</script>


</body>
</html>