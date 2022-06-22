<?php
session_start();
include "config.php";
$namaa = $_SESSION["NMUser"];
$hariinilibur = '';
if($namaa == "Farid Ma'mun"){
    
    $scroly = 'style="overflow-y: scroll;"';
    
}else{
 $activitylog = "display:none;"; 
 $harvest = "display:none";
}



if($namaa == "hrd"){
    
    $scroly = 'style="overflow-y: scroll;"';
 $report = "display:none"; 
 $dar = "display:none";    
}else{
$harvs = "display:none"; 
$actlog = "display:none"; 
$monitoring = "display:none"; 
$absence = "display:none"; 
}


    if($_SESSION["Level"] == "admin"){
    $navbar = "";    

    }else {
        
     $navbar = "display:none;";    
    }
    
    
date_default_timezone_set('Asia/Jakarta');    
$monthNum  = date('m');
$year = date('Y');
$tglhariini = date('d-m-Y');

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
   $daftartanggalibur[$t] = $rowambilstatustanggalibur[$x]["id"]."-".$monthNum."-".$year ;

   $t++;
}

$q = 0;
for ($x = 0; $x < count($rowambilstatustanggalibur); $x++) {
  
 if($daftartanggalibur[$q] == $tglhariini){
     
  //   $display = "display:none;";
  $hariinilibur = "ya";
  
     
 }
   $q++;
}


 //$jumlahlibur = count($rowambilstatustanggalibur);


 if($hariinilibur == "ya"){
     
     $extradar = "";
     
 }else{
      $extradar = "display:none";
 }

}
    
    
?>

<!-- sidebar -->
<div class="sidebar" <?php echo $scroly; ?>>
    	<div class="tombol">
    	<button onclick="myFunctionx()" class="tombolCollapseSidebarr border-0">
		<span></span>
		<span></span>
		<span></span>
	</button>
	</div>
	<header class="text-center py-5"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<a href="index.php" class="logo">
			<img src="img/logo.png" class="img-fluid" width="55%">
		</a>
	</header>
	
	<ul class="accordion list-unstyled mb-0" id="sidebarMenu">
		
		<hr class="m-0">
			<a href="index.php" class="menu-link">
		<li class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> DASHBOARD 
		</li>
			</a>
		<hr class="m-0">
		<a style="<?php echo $dar?>" href="dar.php" class="menu-link">
		<li style="<?php echo $dar?>"class="menu-list">
				<i class="fa fa-pencil ikon-menu"></i> DAR 
		</li>
		</a>
		<hr class="m-0">
		<a style="<?php echo $dar?>" href="todo.php" class="menu-link">
		<li style="<?php echo $dar?>"class="menu-list">
				<i class="fa fa-pencil ikon-menu"></i> TODO 
		</li>
		</a>
			<hr class="m-0">
		<a style="<?php echo $extradar?>" href="darextra.php" class="menu-link">
		<li style="<?php echo $extradar?>"class="menu-list">
				<i class="fa fa-pencil ikon-menu"></i> DAR EXTRA
		</li>
		</a>
				<hr class="m-0">
		<a style="<?php echo $monitoring?>" href="monitoring.php" class="menu-link">
		<li style="<?php echo $monitoring?>" class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> MONITORING
		</li>
			</a>
			
		<hr class="m-0">
		<a style="<?php echo $harvs?>" href="harvest.php" class="menu-link">
		<li style="<?php echo $harvs?>" class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> LATE STATUS
		</li>
			</a>
			
		<hr class="m-0">
		<a style="<?php echo $absence?>" href="confirmabsence.php" class="menu-link">
		<li style="<?php echo $absence?>" class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> ABSENCE STATUS
		</li>
			</a>	
			
		<hr class="m-0">
		<a style="<?php echo $actlog?>" href="activitylog.php" class="menu-link">
		<li style="<?php echo $actlog?>" class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> ACTIVITY LOG
		</li>
			</a>
		<hr class="m-0">
		<a style="<?php echo $report?>" href="report.php" class="menu-link">
		<li style="<?php echo $report?>" class="menu-list">
				<i class="fa fa-tasks ikon-menu"></i> REPORT
		</li>
			</a>
		<hr class="m-0">
		<li class="menu-list">
			<a href="inbox.php" class="menu-link">
				<i class="fa fa-envelope ikon-menu"></i> INBOX
			</a>
		</li>
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
				<div class="menu-link" data-toggle="collapse" data-target="#collapseMenu1">
					<i class="ikon-menu fa fa-cog"></i> SETTING
				</div>
			</div>
			<div class="collapse" id="collapseMenu1" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href="resetPassword.php" class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> RESET PASSWORD
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" style="<?php echo $navbar?>" id="collapseMenu1" aria-labelledby="menu2" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href="managementUser.php" class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> MANAGEMENT USER
							</a>
						</li>
					</ul>
				</div>
			</div>
					<div class="collapse" style="<?php echo $activitylog?>" id="collapseMenu1" aria-labelledby="menu2" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href="activitylog.php" class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> ACTIVITY LOG
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			
			<div class="collapse" style="<?php echo $harvest?>" id="collapseMenu1" aria-labelledby="menu2" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href="harvest.php" class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> HARVEST
							</a>
						</li>
					</ul>
				</div>
			</div>
			
		</li>
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
			  <a href="/help/TATA_CARA_PENGGUNAAN_SIDAR_ver_1.03.pdf" class="menu-link">
				<div class="menu-link" >
				   
					<i class="ikon-menu fa fa-book"></i> HELP
					
				</div>
				</a>
			</div>
		</li>
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
				<div class="menu-link" >
				     <a href="logout.php" class="menu-link">
					<i class="ikon-menu fa fa-power-off"></i> LOGOUT
					</a>
				</div>
			</div>
		</li>
		<hr class="m-0">
	</ul>
<!--
	<div class="text-center py-5"><span class="align-text-center bold">VER 1.03</span></div>
-->
</div><!-- end sidebar -->

<!-- topbar -->
<div class="topbar d-flex justify-content-between align-items-center">
	<button onclick="myFunction()" id="btncolaps" class="tombolCollapseSidebar border-0">
		<span id="spancolaps"></span>
		<span id="spancolaps1"></span>
		<span id="spancolaps2"></span>
	</button>
	<div class="akun d-flex align-items-center">
		Welcome "<i><strong><?php echo $namaa ?></strong></i>"
		<div class="mini-foto-user ml-2 rounded-circle">
			<img src="img/fotouser.jpg" class="img-fluid">
		</div>
	</div>
</div><!-- end topbar -->

<!-- anti scroll -->
<div class="anti-scroll d-lg-none"></div>