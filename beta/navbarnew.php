<?php
session_start();

$namaa = $_SESSION["NMUser"];

if($namaa == "Farid Ma'mun"){
    
}else{
 $activitylog = "display:none;"; 
}


    if($_SESSION["Level"] == "admin"){
    $navbar = "";    

    }else {
        
     $navbar = "display:none;";    
    }
?>

<!-- sidebar -->
<div class="sidebar">
	<header class="text-center py-5"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<a href="index.php" class="logo">
			<img src="img/logo.png" class="img-fluid" width="55%">
		</a>
	</header>
	
	<ul class="accordion list-unstyled mb-0" id="sidebarMenu">
		
		<hr class="m-0">
		<li class="menu-list">
			<a href="index.php" class="menu-link">
				<i class="fa fa-tasks ikon-menu"></i> DASHBOARD
			</a>
		</li>
		
		<hr class="m-0">
		<li class="menu-list">
			<a href="dar.php" class="menu-link">
				<i class="fa fa-pencil ikon-menu"></i> DAR
			</a>
		</li>
		<hr class="m-0">
		<li class="menu-list">
			<a href="report.php" class="menu-link">
				<i class="fa fa-tasks ikon-menu"></i> REPORT
			</a>
		</li>
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
</div><!-- end sidebar -->

<!-- topbar -->
<div class="topbar d-flex justify-content-between align-items-center">
	<button class="tombolCollapseSidebar border-0">
		<span></span>
		<span></span>
		<span></span>
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