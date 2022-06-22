<?php
session_start();

$headerURL = "https://localhost/sidar-git/";
	
$namaa = $_SESSION["NMUser"];

if($lokasikerja == 'ib' || $lokasikerja == 'IB'){
  $frmtlt = "";  
}else{
  $frmtlt = "display:none;";  
}

if($namaa == "Farid Ma'mun"){
    
    $scroly = 'style="overflow-y: scroll;"';
    
}else{
 $activitylog = "display:none;"; 
 $harvest = "display:none";
}


   if($_SESSION["Level"] == "admin"){
    $navbar = "";    

    }else {
        
     $navbar = "display:none;";    
    }
    

if($namaa == "HRD IB" || $namaa == "HRD IGI Pasuruan" || $namaa == "HRD IGI Gresik" || $namaa == "HRD SDA"){
    
    $scroly = 'style="overflow-y: scroll;"';
 $report = "display:none"; 
 $dar = "display:none";    
 $navbar = "display:none;";  
}elseif($namaa == "Admin HRD IB" || $namaa == "Admin HRD Pasuruan" || $namaa == "Admin HRD Gresik" || $namaa == "Admin HRD SDA"){

 $scroly = 'style="overflow-y: scroll;"';
 $report = "display:none"; 
 $dar = "display:none";    
 $navbar = "display:none;"; 
$mngnuser = "display:none"; 
}else{
$harvs = "display:none"; 
$actlog = "display:none"; 
$monitoring = "display:none"; 
$absence = "display:none";
$mngnuser = "display:none";    
    
}

if($_SESSION["Level"] == "admin" || $_SESSION["Level"] == "user"){
 $scroly = 'style="overflow-y: scroll;"';    
    
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
			<img src=<?php echo $headerURL."img/logo.png";?> class="img-fluid" width="55%">
		</a>
	</header>
	
	<ul class="accordion list-unstyled mb-0" id="sidebarMenu">
		
		<hr class="m-0">
			<a href=<?php echo $headerURL."index.php";?> class="menu-link">
		<li class="menu-list <?php echo $navactivedashbaord;?>">
				<i class="fa fa-area-chart ikon-menu"></i> DASHBOARD
		</li>
			</a>
		<hr class="m-0">
		<a style="<?php echo $dar?>" href=<?php echo $headerURL."dar.php";?> class="menu-link">
		<li style="<?php echo $dar?>"class="menu-list <?php echo $navactivedar;?>">
				<i class="fa fa-pencil ikon-menu"></i> DAR
		</li>
		</a>
		
	   <hr class="m-0">
		<a style="<?php echo $report?>" href=<?php echo $headerURL."report.php";?> class="menu-link">
		<li style="<?php echo $report?>" class="menu-list <?php echo $navactivereport;?>">
				<i class="fa fa-tasks ikon-menu"></i> REPORT
		</li>
	    </a>
		
		<hr class="m-0">
		<li class="menu-list">
			<a href="inbox.php" class="menu-link">
				<i class="fa fa-envelope ikon-menu"></i> INBOX
			</a>
		</li>	
			
			
	
		<hr style="<?php echo $absence?>" class="m-0">
		<a style="<?php echo $absence?>" href=<?php echo $headerURL."reportabsensi.php";?> class="menu-link">
		<li style="<?php echo $absence?>" class="menu-list <?php echo $navactivereportabsensi;?>">
				<i class="fa fa-map-signs ikon-menu"></i> REPORT DINAS LUAR
		</li>
		</a>
		
		<hr style="<?php echo $frmtlt; ?>" class="m-0">
		<a style="<?php echo $frmtlt; ?>" href=<?php echo $headerURL."formtelat.php";?> class="menu-link">
		<li style="<?php echo $frmtlt; ?>" class="menu-list <?php echo $navactivereportabsensi;?>">
				<i class="fa fa-calendar ikon-menu"></i> FORM IZIN TERLAMBAT (BETA VERSION)
		</li>
		</a>
		
		<hr style="<?php echo $frmtlt; ?>" class="m-0">
		<a style="<?php echo $frmtlt; ?>" href=<?php echo $headerURL."formcuti.php";?> class="menu-link">
		<li style="<?php echo $frmtlt; ?>" class="menu-list <?php echo $navactivereportabsensi;?>">
				<i class="fa fa-chain-broken ikon-menu"></i> FORM IZIN CUTI (BETA VERSION)<br>
		</li>
		</a>

		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menuizin">
				<div class="menu-link" data-toggle="collapse" data-target="#collapseMenu2">
					<i class="ikon-menu fa fa-cog"></i> FORM IZIN CUTI (STAGGING VERSION)
				</div>
			</div>
			<div class="collapse" id="collapseMenu2" aria-labelledby="menuizin" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."nfr/izinsakit";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> Izin Sakit
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" id="collapseMenu2" aria-labelledby="menuizin" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."nfr/izincuti";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> Izin Cuti
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="collapse" id="collapseMenu2" aria-labelledby="menuizin" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."nfr/izintidakdibayar";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> Izin Tidak Dibayar
							</a>
						</li>
					</ul>
				</div>
			</div>
		
		
	
		</li>



			
		<hr style="<?php echo $absence?>" class="m-0">
		<a style="<?php echo $absence?>" href=<?php echo $headerURL."updateresign.php";?> class="menu-link">
		<li style="<?php echo $absence?>" class="menu-list <?php echo $navactivereportabsensi;?>">
		<i class="fa fa-users ikon-menu"></i> SET RESIGN
		</li>
		</a>
		
			
		<hr style="<?php echo $harvs?>" class="m-0">

	
	
	<li style="<?php echo $monitoring?>" class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
				<div class="menu-link" data-toggle="collapse" data-target="#collapseMenu32">
					<i class="ikon-menu fa fa-desktop"></i> MONITORING DAR
				</div>
			</div>
			<div class="collapse" id="collapseMenu32" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."harvest.php";?> class="collapse-link">
								<i class="fa fa-hourglass-end ikon-menu"></i> LATE STATUS
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" id="collapseMenu32" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."confirmabsence.php" ;?>class="collapse-link">
							<i class="fa fa-home ikon-menu"></i> ABSENCE STATUS
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" id="collapseMenu32" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."activitylog.php";?> class="collapse-link">
							<i class="fa fa-bookmark ikon-menu"></i> ACTIVITY LOG
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" id="collapseMenu32" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."monitoring.php";?> class="collapse-link">
							<i class="fa fa-table ikon-menu"></i> MONITORING USER
							</a>
						</li>
					</ul>
				</div>
			</div>
	
	</li>
		
		<hr class="m-0" style="<?php echo $navbar?>">
		<li class="menu-list" style="<?php echo $navbar?>">
			<a href=<?php echo $headerURL."reportfilter.php";?> class="menu-link">
				<i class="fa fa-filter ikon-menu"></i> REPORT PER USER
			</a>
		</li>
		
		
			
		<hr class="m-0" style="<?php echo $mngnuser;?>">
		<li class="menu-list" style="<?php echo $mngnuser;?>">
			<a href=<?php echo $headerURL."holidaysetting.php";?> class="menu-link">
				<i class="fa fa-bell-slash ikon-menu"></i> HOLIDAY SETTING
			</a>
		</li>
		<hr class="m-0">
			<li style="<?php echo $mngnuser;?>" class="card border-0 menu-list">
			<div style="<?php echo $mngnuser;?>" class="card-header border-0" id="menu1">
				<div class="menu-link" data-toggle="collapse" data-target="#collapseMenu1">
					<i class="ikon-menu fa fa-users"></i> MANAGEMENT USER
				</div>
			</div>
			<div style="<?php echo $mngnuser;?>" class="collapse" id="collapseMenu1" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."addUser.php" ;?>class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> ADD USER
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div style="<?php echo $mngnuser;?>" class="collapse" id="collapseMenu1" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."listedituser.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> EDIT USER
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div style="<?php echo $mngnuser;?>" class="collapse" id="collapseMenu1" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."setizinabsen.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> SET IZIN ABSEN
							</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div style="<?php echo $mngnuser;?>" class="collapse" id="collapseMenu1" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."updateresign.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> SET RESIGN
							</a>
						</li>
					</ul>
				</div>
			</div>

		</li>
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
				<div class="menu-link" data-toggle="collapse" data-target="#collapseMenu3">
					<i class="ikon-menu fa fa-cog"></i> SETTING
				</div>
			</div>
			<div class="collapse" id="collapseMenu3" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."resetPassword.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> RESET PASSWORD
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" id="collapseMenu3" aria-labelledby="menu1" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."emailupdate.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> UPDATE EMAIL
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="collapse" style="<?php echo $navbar?>" id="collapseMenu2" aria-labelledby="menu2" data-parent="#sidebarMenu">
				<div class="card-body">
					<ul class="list-unstyled mb-0">
						<li>
							<a href=<?php echo $headerURL."managementUser.php";?> class="collapse-link">
								<i class="fa fa-caret-right mr-2"></i> MANAGEMENT USER
							</a>
						</li>
					</ul>
				</div>
			</div>
		
			<!--
		<div class="collapse" style="<?php // echo $activitylog?>" id="collapseMenu2" aria-labelledby="menu2" data-parent="#sidebarMenu">
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
			
		
			<div class="collapse" style="<?php //echo $harvest?>" id="collapseMenu1" aria-labelledby="menu2" data-parent="#sidebarMenu">
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
			-->
		</li>
		<!-- <hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
			  <a href="#" class="menu-link">
				<div class="menu-link" >
				   
					<i class="ikon-menu fa fa-comment-o"></i> FEEDBACK
					
				</div>
				</a>
			</div>
		</li> -->
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
			  <a href="https://play.google.com/store/apps/details?id=com.ib.sidar" class="menu-link">
				<div class="menu-link" >
				   
					<i class="ikon-menu fa fa-android"></i> SIDAR APP
					
				</div>
				</a>
			</div>
		</li>
		<hr class="m-0">
		<li class="card border-0 menu-list">
			<div class="card-header border-0" id="menu1">
			  <a href=<?php echo $headerURL."help/TATA_CARA_PENGGUNAAN_SIDAR_ver_1.03.pdf";?> class="menu-link">
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
				     <a href=<?php echo $headerURL."logout.php";?> class="menu-link">
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
			<img src=<?php echo $headerURL."img/fotouser.jpg";?> class="img-fluid">
		</div>
	</div>
</div><!-- end topbar -->

<!-- anti scroll -->
<div class="anti-scroll d-lg-none"></div>