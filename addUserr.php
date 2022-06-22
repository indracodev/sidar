<!DOCTYPE html>
<html>
<head>
	<title>SIDAR</title>
	<link rel="stylesheet icon" href="img/ikon.png">
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="custom.css">
    <!-- inner style -->
    <style type="text/css">
    	
    </style>
</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar.php';?>

		<!-- KONTEN -->
		<main class="konten">
			  <section class="dar mb-5">
                <div class="container-fluid">
                    <div class="card mb-3">
                    <div class="card-header py-3">
                      <h5 class="card-title m-0 text-uppercase font-weight-bold">Data User Management</h5>
                    </div>
                    <div class="card-body">
                        <form>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Name</label>
                              <input type="text" class="form-control" id="Name" placeholder="Name" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Login Name</label>
                              <input type="text" class="form-control" id="LoginName" placeholder="Login Name" required="required">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Unit Usaha</label>
                              <input type="text" class="form-control" id="Name" placeholder="Unit Usaha" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Departemen</label>
                              <input type="text" class="form-control" id="LoginName" placeholder="Departemen" required="required">
                            </div>
                          </div>    
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Jabatan</label>
                              <input type="text" class="form-control" id="Name" placeholder="Jabatan" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Bagian</label>
                              <input type="text" class="form-control" id="LoginName" placeholder="Bagian" required="required">
                            </div>
                          </div>
                           <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="inputEmail4">Email</label>
                              <input type="email" class="form-control" id="inputEmail" placeholder="Email" required="required">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="inputPassword4">Password</label>
                              <input type="password" class="form-control" id="inputPassword" placeholder="Password" required="required">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="telp">Telp</label>
                              <input type="text" class="form-control" id="inputTelp" placeholder="Telp" required="required">
                            </div>
                            <div class="form-group col-md-6">
                               <label class="mr-sm-2" for="inlineFormCustomSelect">Level</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Choose...</option>
                                  <option>Administrator</option>
                                  <option>HRD</option>
                                  <option>Manager</option>
                                  <option>User</option>
                                 </select>
                            </div>
                          </div>
                         <div class="row">
                         <label class="col-md-12" for="country">CC/BC</label>
                          <div class="col-md-3">
                            <select class="custom-select d-block w-100" id="cc1" required="required">
                              <option value="">Choose...</option>
                              <option>DM01</option>
                              <option>IT01</option>
                              <option>WEB01</option>
                              <option>WEB02</option>
                              <option>WEB03</option>
                              <option>WEB04</option>
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid ID.
                            </div>
                          </div>
                          <div class="col-md-3">
                            <select class="custom-select d-block w-100" id="cc2" required="required">
                              <option value="">Choose...</option>
                              <option>DM01</option>
                              <option>IT01</option>
                              <option>WEB01</option>
                              <option>WEB02</option>
                              <option>WEB03</option>
                              <option>WEB04</option>
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid ID.
                            </div>
                          </div>
                           <div class="col-md-3">
                            <select class="custom-select d-block w-100" id="cc2" required="required">
                              <option value="">Choose...</option>
                              <option>DM01</option>
                              <option>IT01</option>
                              <option>WEB01</option>
                              <option>WEB02</option>
                              <option>WEB03</option>
                              <option>WEB04</option>
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid ID.
                            </div>
                          </div>
                           <div class="col-md-3">
                            <select class="custom-select d-block w-100" id="cc2" required="required">
                              <option value="">Choose...</option>
                              <option>DM01</option>
                              <option>IT01</option>
                              <option>WEB01</option>
                              <option>WEB02</option>
                              <option>WEB03</option>
                              <option>WEB04</option>
                            </select>
                            <div class="invalid-feedback">
                              Please select a valid ID.
                            </div>
                          </div>
                        <!--button-->
                        </div>
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="gridCheck">
                              <label class="form-check-label" for="gridCheck">
                                Accept the terms of use
                              </label>
                            </div>
                          </div>
                        <button class="btn btn-outline-dark">
                            <i class="fa fa-plus"></i> ADD
                        </button>
                        <button class="btn btn-outline-dark">
                            <i class="fa fa-pencil-square-o"></i> EDIT
                        </button>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="custom.js"></script>
</body>
</html>

          