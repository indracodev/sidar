<?php 
session_start();
include "../../config.php";

$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$namaa = $_SESSION["NMUser"];
$lokasikerja = $_SESSION["Lokasikerja"] ;

date_default_timezone_set('Asia/Jakarta');
$datetimee = date('Y-m-d');
$datetime = DateTime::createFromFormat('Y-m-d', $datetimee);
$namahari = $datetime->format('D');

$datee = date('Y-m-d');
$jamet = date('H:i:s');    
$mon = date('m');
$panhari = date('Y-m-d', strtotime(' +7 day'));

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    
$useragent = $_SERVER['HTTP_USER_AGENT'];    
$latitude = '-';
$longitude = '-';
$act = 'ke halaman addform cuti';
$updatelog = "INSERT INTO log (iduser, tanggal, jam, activity, ip, userdevice,latitude, longitude) VALUE ('".$iduser."', '".$datee."', '".$jamet."', '".$act."', '".$ip."', '".$useragent."', '".$latitude."', '".$longitude."')"; 
$conn->query($updatelog); 
       			


$infouser = "SELECT * FROM masteruser WHERE id = '".$iduser."';";

$queryinfouser = $conn->query($infouser);
$arrayinfouser = mysqli_fetch_array($queryinfouser, MYSQLI_ASSOC);

$namae = $arrayinfouser['nama'];
$departement = $arrayinfouser['departemen'];
$bagian = $arrayinfouser['divisi'];
$unitusaha = $arrayinfouser['unitusaha'];
$sisacuti = $arrayinfouser['jumlahcuti'];
$kuotagrupcuti = $arrayinfouser['kuotagrupcuti'];
$ke1 = $arrayinfouser['ke'];
$ke2 = $arrayinfouser['ke2'];
$ke3 = $arrayinfouser['ke3'];
$ke4 = $arrayinfouser['ke4'];
$ke5 = $arrayinfouser['ke5'];
$grupcuti = $arrayinfouser['grupcuti'];
////////////////////////////////////////////////////////////////////////////////////////////


$infodelegasiuser = "SELECT * FROM masteruser WHERE grupcuti = '".$grupcuti."' and id != '".$iduser."';";

$queryinfodelegasiuser = $conn->query($infodelegasiuser);
$arrayinfodelegasiuser = mysqli_fetch_all($queryinfodelegasiuser, MYSQLI_ASSOC);
///////////////////////////////////////////////////////////////////////////////////////////


$infocuti = "SELECT * FROM formcuti WHERE  MONTH(cutipadatanggal) = '".$mon."' and iduser = '".$iduser."';";

$queryinfocuti= $conn->query($infocuti);
$arrayinfocuti = mysqli_fetch_all($queryinfocuti, MYSQLI_ASSOC);

if(sizeof($arrayinfocuti) >= 2){
$muncul = 'style="display:none;"';
$munculnotice = 'style="display:;color:red;margin-top:10px;"';  
}else{
$muncul = 'style="display:;"'; 
$munculnotice = 'style="display:none;"';  
}

//////////////////////////////////////////////////////////////////////////////////////////




$infokuotagrup = "SELECT * FROM isikuotacuti WHERE tanggalcuti = '".$panhari."' and grupcutiku = '".$grupcuti."';";

$querykuotagrup = $conn->query($infokuotagrup);
$arraykuotagrup = mysqli_fetch_all($querykuotagrup, MYSQLI_ASSOC);

if(sizeof($arraykuotagrup) >= $kuotagrupcuti){
$munculk = 'style="display:none;"';
$munculknotice = 'style="display:;color:red;margin-top:10px;"';  
}else{
$munculk = 'style="display:;"'; 
$munculknotice = 'style="display:none;"';  
}

//////////////////////////////////////////////////////////////////////////////////////////

if(!empty($ke1)){
$infoke1 = "SELECT * FROM masteruser WHERE id = '".$ke1."' ;";
$queryinfoke1 = $conn->query($infoke1);
$arrayinfoke1 = mysqli_fetch_array($queryinfoke1, MYSQLI_ASSOC);
}

if(!empty($ke2)){
$infoke2 = "SELECT * FROM masteruser WHERE id = '".$ke2."' ;";
$queryinfoke2 = $conn->query($infoke2);
$arrayinfoke2 = mysqli_fetch_array($queryinfoke2, MYSQLI_ASSOC);
}

if(!empty($ke3)){
$infoke3 = "SELECT * FROM masteruser WHERE id = '".$ke3."' ;";
$queryinfoke3 = $conn->query($infoke3);
$arrayinfoke3 = mysqli_fetch_array($queryinfoke3, MYSQLI_ASSOC);
}

if(!empty($ke4)){
$infoke4 = "SELECT * FROM masteruser WHERE id = '".$ke4."' ;";
$queryinfoke4 = $conn->query($infoke4);
$arrayinfoke4 = mysqli_fetch_array($queryinfoke4, MYSQLI_ASSOC);
}

if(!empty($ke5)){
$infoke5 = "SELECT * FROM masteruser WHERE id = '".$ke5."' ;";
$queryinfoke5 = $conn->query($infoke5);
$arrayinfoke5 = mysqli_fetch_array($queryinfoke5, MYSQLI_ASSOC);
}


if($_SESSION["IDUser"] == 0){
header("Location: ".$headerURL."login");
    }
    

$infoccbc = "SELECT id,nama FROM masteruser WHERE (jabatan='owner' OR jabatan='manager' OR jabatan='supervisor' OR jabatan='direktur' ) AND password != 'resign' ORDER BY nama ASC;";

$queryinfoccbc = $conn->query($infoccbc);
$arrayinfoccbc = mysqli_fetch_all($queryinfoccbc, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SIDAR</title>
	<link rel="stylesheet icon" href="../../img/ikon.png">
	<!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../../custom1.css">

    <!-- flatpicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
 
    <!-- inner style -->
    <style type="text/css">
    	input:invalid+.validity:after {
  content: '✖';
}

input:valid+.validity:after {
  content: '✓';
}
    </style>

<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'../../navbar1.php';?>

		<!-- KONTEN -->
		<main class="konten">
			  <section class="dar mb-5">
                <div class="container-fluid">
                    <div class="kiri" >
                            <form method="post" action="formcuti.php">
                            <input type="hidden" name="backlapor" value="ya">    
                            <button type="submit" class="btn btn-outline-dark border-0">
                                <i class="fa fa-reply"></i> Back
                            </button>
                            </form>
                          
                        </div><!-- end kolom kiri -->
                    <div class="card mb-3">
                    <div class="card-header py-3">
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Permohonan Cuti</h5>
                    </div>
                    <div class="card-body">
                       
                        <form method="POST" action="tambahdatacuti.php">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Name</label>
                              <input type="text" name="namax" class="form-control" id="Name" value="<?php echo $namae ;?>" placeholder="Name" required="required" disabled>
                              <input type="hidden" name="nama" class="form-control" id="Name" value="<?php echo $namae ;?>" placeholder="Name" required="required">
                              <input type="hidden" name="iduser" class="form-control" id="idu" value="<?php echo $iduser ;?>" placeholder="Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="unitusaha">Unit Usaha</label>
                              <input type="text" name="unitusahax" class="form-control" id="unitusahax" value="<?php echo $unitusaha ;?>" placeholder="unitusaha" required="required" disabled>
                              <input type="hidden" name="unitusaha" class="form-control" id="unitusaha" value="<?php echo $unitusaha ;?>" placeholder="unitusaha" required="required" >
                            </div>
                          </div>
                          
                          <div class="form-row">
                           <div class="form-group col-md-6">
                              <label for="departement">Departement</label>
                              <input type="text" name="departementx" class="form-control" id="departementx" value="<?php echo $departement ;?>" placeholder="departement" required="required" disabled>
                              <input type="hidden" name="departement" class="form-control" id="departement" value="<?php echo $departement ;?>" placeholder="departement" required="required">
                            </div>
                             <div class="form-group col-md-6">
                              <label for="divisi">Bagian</label>
                              <input type="text" name="divisix" class="form-control" id="divisix" value="<?php echo $bagian ;?>" placeholder="bagian" required="required" disabled>
                              <input type="hidden" name="divisi" class="form-control" id="divisi" value="<?php echo $bagian ;?>" placeholder="bagian" required="required">
                            </div>
                          </div>   
                          
                          <div class="form-row">
                              
                          <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Alasan</label>
                                <select onchange="doSomething(this.value);" name="alasan" id="pilihanalasan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="Cuti" selected>Choose....</option>
                                  <option value="Cuti Tahunan">Cuti Tahunan</option>
                                  <option  value="Cuti Khusus">Cuti Khusus</option>
                                  <option  value="Cuti Melahirkan">Cuti Melahirkan</option>
                                 </select>
                            </div>
                              
                          <div class="form-group col-md-6">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Cuti Pada Tanggal</label>
                            <input type="date" min="<?php echo date('Y-m-d', strtotime(' +7 day'));?>" name="tglcuti" class="form-control" id="tglcuti" value="" placeholder="dd-mm-yyyy" required="required">
                          </div>
                           
                          </div>
                          
                          <div class="form-row">
                              
                               <div class="form-group col-md-6">
                              <label for="inputEmail4">Tanggal Masuk Kerja</label>
                              <input type="date" min="<?php echo date('Y-m-d', strtotime(' +8 day'));?>" name="tglmasukkerja" class="form-control" id="tglmasukkerja" value="" placeholder="dd-mm-yyyy" required="required">
                              
                            </div>
                              
                             <div class="form-group col-md-6">
                              <label for="jumlahhari">Jumlah Hari</label>
                              <input type="number" name="jumlahhari" class="form-control" id="jumlahhari" placeholder="Jumlah Hari" required="required">
                            </div>  
                         
                           
                          </div>
                          
                          
                           <div class="form-row">
                             <div class="form-group col-md-6">
                              <label for="delegasi">Delegasi Pekerjaan Kepada</label>
                
                              <select name="delegasi" class="custom-select mr-sm-2" id="inlineFormCustomdelegasi" required="required">
                                 
                           
                                           <?php
                for($x = 0; $x < sizeof($arrayinfodelegasiuser); $x++){
                    
                  ?>
                                 <option value="<?php echo $arrayinfodelegasiuser[$x]['id'].'/'.$arrayinfodelegasiuser[$x]['nama'];?>"><?php echo $arrayinfodelegasiuser[$x]['nama']?></option>
                                 <?php }?>

                                 </select>
                            </div>
                           <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Menyetujui Pimpinan Departement</label>
                                <select name="keatasan" class="custom-select mr-sm-2" id="inlineFormCustomSelect" required="required">
                                  <option value="<?php echo $ke1 ;?>" selected><?php if(!empty($arrayinfoke1['nama'])){echo $arrayinfoke1['nama'];}else{echo 'Choose...';}  ;?></option>
                                 <?php if(!empty($arrayinfoke2['nama'])){ ?>
                                 <option value="<?php echo $ke2?>"><?php echo $arrayinfoke2['nama']?></option>
                                 <?php }?>
                                  <?php if(!empty($arrayinfoke3['nama'])){ ?>
                                 <option value="<?php echo $ke3?>"><?php echo $arrayinfoke3['nama']?></option>
                                 <?php }?>
                                  <?php if(!empty($arrayinfoke4['nama'])){ ?>
                                 <option value="<?php echo $ke4?>"><?php echo $arrayinfoke4['nama']?></option>
                                 <?php }?>
                                 <?php if(!empty($arrayinfoke5['nama'])){ ?>
                                 <option value="<?php echo $ke5?>"><?php echo $arrayinfoke5['nama']?></option>
                                 <?php }?>
                                 </select>
                            </div>
                          </div>
                          
                          <div class="form-row">
                             <div class="form-group col-md-6">
                              <label for="inputEmail4">Keperluan</label>
                              <textarea rows="3" name="keperluan" class="form-control" id="keperluan" placeholder="Keperluan" required="required"></textarea>
                            </div>
                            
                            <div class="form-group col-md-6">
                              <label for="unitusaha">Sisa Cuti</label>
                              <input type="text" name="sisacuti" class="form-control" id="sisacuti" value="<?php echo $sisacuti;?>" placeholder="sisa cuti" required="required" disabled>
                              <input type="hidden" name="sisacutix" class="form-control" id="sisacutix" value="<?php echo $sisacuti ;?>" placeholder="sisa cuti" required="required" >
                            </div>
                          
                          </div>
                          
                           <div class="form-row">
                       
                            <div class="form-group col-md-6">
                              <label for="unitusaha">Kuota Grup Cuti</label>
                              <input type="text" name="kuotagrupcuti" class="form-control" id="kuotagrupcuti" value="<?php echo $kuotagrupcuti;?>" placeholder="kuota grup cuti" required="required" disabled>
                              <input type="hidden" name="kuotagrupcutix" class="form-control" id="kuotagrupcutix" value="<?php echo $kuotagrupcuti ;?>" placeholder="kuota grup cuti" required="required" >
                            </div>
                          
                          </div>

                          <div class="form-group">
                            <div class="form-check">
                          
                            </div>
                          </div>

                          <!-- <input id="tglcuti" size="60" type="date" format="MM/DD/YYYY" placeholder="MM/DD/YYYY" /> -->


                        <button type="submit" id="sbt" class="btn btn-outline-dark" <?php echo $muncul;?>>
                            <i class="fa fa-plus"></i> KIRIM
                        </button>
                       <p <?php echo $munculnotice; ?>>Maksimal 2 cuti per bulan !!!</p>
                        <p id="noticekuota" style="display:none;">Kuota Grup Anda Tidak Mencukupi !!!</p>
                        </form>
                </div>
            </div>
            </div>
            </section><!-- end dar -->

			<!-- FOOTER -->
			<?php include'footer.php';?>

		</main><!-- end konten -->
	</div><!-- end wrapper -->

	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.1.1.min.js">
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
    function doSomething() {
        var alasanye = document.querySelector('#pilihanalasan');
        var alasanye = alasanye.value;  
      if(alasanye == 'Cuti Tahunan'){
          document.getElementById('jumlahhari').setAttribute("disabled","disabled");
          // document.getElementById('tglmasukkerja').setAttribute("disabled","disabled");
           document.getElementById('tglmasukkerja').readOnly = true;  
     }else{
      document.getElementById('jumlahhari').removeAttribute("disabled");
     // document.getElementById('tglmasukkerja').removeAttribute("disabled");
       document.getElementById('tglmasukkerja').readOnly = false;  
         }
    };
    

    </script>
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
//Flatpickr
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
  
<script>
var kemarin = new Date();
kemarin.setDate(kemarin.getDate() - 1);

console.log(kemarin);
$("#tglcuti").flatpickr({
  
    minDate: kemarin,
    enableTime: true,
    dateFormat: "m-d-Y",
    "disable": [
        function(date) {
           return (date.getDay() === 0 || date.getDay() === 6);  // disable weekends
        }
    ],
    "locale": {
        "firstDayOfWeek": 1 // set start day of week to Monday
    }
});
</script>

    <script>


    
        $(document).ready(function () {
            
           var $input = $('#tglcuti'); 
           var $jumlahhari = $('#jumlahhari');
           var $keperluan = $('#keperluan');
           var $pilihanalasan = $('#pilihanalasan');
           
        $keperluan.on('focusout', function () {
        var sisacuti = document.querySelector('#sisacuti');
        var sisacuti = sisacuti.value;  
        
        var jmlcuti = document.querySelector('#jumlahhari');
        var jmlcuti = jmlcuti.value;  
        
        var alasanya = document.querySelector('#pilihanalasan');
        var alasanya = alasanya.value;  




if(alasanya == 'Cuti Tahunan'){
      if(sisacuti < jmlcuti){
       alert('Sisa Cuti Anda Tidak Mencukupi');   
         document.getElementById("sbt").style.display = "none";
      }else{
        document.getElementById("sbt").style.display = "";   
      }
      
}else{

}
       
        });    
        
  
         $jumlahhari.on('focusout', function () {
        var sisacuti = document.querySelector('#sisacuti');
        var sisacuti = sisacuti.value;  
        
        var jmlcuti = document.querySelector('#jumlahhari');
        var jmlcuti = jmlcuti.value;  
        
        var alasanya = document.querySelector('#pilihanalasan');
        var alasanya = alasanya.value;  

if(alasanya == 'Cuti Tahunan'){
      if(sisacuti < jmlcuti){
       alert('Sisa Cuti Anda Tidak Mencukupi');   
         document.getElementById("sbt").style.display = "none";
      }else{
        document.getElementById("sbt").style.display = "";   
      }
      
}else{

}      
       
        });           
        
           console.log("asik");  
           console.log(tomorrow);
       $input.on('focusout', function () {
        var tglcuti = document.querySelector('#tglcuti');
        var tglcuti = tglcuti.value;  
        var tomorrow = new Date(tglcuti);
        var iduser = '<?php echo $iduser;?>';
        var alasanya = document.querySelector('#pilihanalasan');
        var alasanya = alasanya.value; 
      
        if(alasanya == 'Cuti Tahunan'){
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow = new Date(tomorrow).toISOString().slice(0, 10);
       // alert(tomorrow);
       // var tglcuti = date.toISOString().substring(0,10);
     document.getElementById('tglmasukkerja').value = tomorrow;
     
      document.getElementById('jumlahhari').value = 1;
      document.getElementById('jumlahhari').setAttribute("disabled","disabled");
     
     var grupcuti = '<?php echo $grupcuti;?>';
       $.ajax({
                type : 'post',
                url : 'apikuotagrupcuti.php',
                data :  'tglcutinya='+ tglcuti + '&grupcuti=' + grupcuti + '&iduser=' + iduser,
                success : function(data){
                if(data == 'habis'){
                 // document.getElementById("sbt").style.display = ""; 
                 console.log(data);
                }else{
                  // document.getElementById("sbt").style.display = "none";       
                  console.log(data);  
                }    
                
                }
       });
       
        }else{

}    

 
      
      
        });      
       
           
            
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
    <script type="text/javascript" src="../../custom.js"></script>
</body>
</html>