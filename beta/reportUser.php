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
    <!--daterange picker-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Custom table for this page -->
    <link href="js/table/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- inner style -->
    <style type="text/css">
    	
    </style>
</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbarUser.php';?>

		<!-- KONTEN -->
		<main class="konten">
			
			<!-- letakkan isi konten disini ! -->
              <section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                             <h4 class="card-title m-0 text-uppercase font-weight-bold">Report Per Day</h4>
                            </div>
                                <div class="card-body">
                                 <h6>Period Filter:</h6>
                                 <div class="row">
                                  <div class='col-sm-3'>
                                    <div class="form-group">
                                        <div class='' id=''>
                                            <input type='text' class="form-control" name="datefilter">
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                        </div>
                                    </div>
                                   </div>
                                 </div>
                                 </div>
                               <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th>Dept</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th>Dept</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                    </tr>
                                  </tfoot>
                                  <tbody>
                                    <tr>
                                      <td>System Architect</td>
                                      <td>Tiger Nixon</td>
                                      <td>2011/04/25</td>
                                      <td>$320,800</td>
                                    </tr>
                                    <tr>
                                      <td>Accountant</td>
                                      <td>Garrett Winters</td>
                                      <td>2011/07/25</td>
                                      <td>$170,750</td>
                                    </tr>
                                    <tr>
                                      <td>Junior Technical Author</td>  
                                      <td>Ashton Cox</td>
                                      <td>2009/01/12</td>
                                      <td>$86,000</td>
                                    </tr>
                                    <tr>
                                      <td>Financial Controller</td> 
                                      <td>Vivian Harrell</td>
                                      <td>2009/02/14</td>
                                      <td>$452,500</td>
                                    </tr>
                                    <tr>
                                      <td>Office Manager</td>  
                                      <td>Timothy Mooney</td>
                                      <td>2008/12/11</td>
                                      <td>$136,200</td>
                                    </tr>
                                    <tr>
                                      <td>Director</td>  
                                      <td>Jackson Bradshaw</td>
                                      <td>2008/09/26</td>
                                      <td>$645,750</td>
                                    </tr>
                                    <tr>
                                      <td>Support Engineer</td>
                                      <td>Olivia Liang</td>                                     
                                      <td>2011/02/03</td>
                                      <td>$234,500</td>
                                    </tr>
                                    <tr>
                                      <td>Software Engineer</td>  
                                      <td>Bruno Nash</td>
                                      <td>2011/05/03</td>
                                      <td>$163,500</td>
                                    </tr>
                                    <tr>
                                      <td>Support Engineer</td>
                                      <td>Sakura Yamamoto</td>
                                      <td>2009/08/19</td>
                                      <td>$139,575</td>
                                    </tr>
                                    <tr>
                                      <td>Developer</td>
                                      <td>Thor Walton</td>
                                      <td>2013/08/11</td>
                                      <td>$98,540</td>
                                    </tr>
                                    <tr>
                                      <td>Support Engineer</td>
                                      <td>Finn Camacho</td>
                                      <td>2009/07/07</td>
                                      <td>$87,500</td>
                                    </tr>
                                    <tr>
                                      <td>Data Coordinator</td>
                                      <td>Serge Baldwin</td>
                                      <td>2012/04/09</td>
                                      <td>$138,575</td>
                                    </tr>
                                    <tr>
                                      <td>Software Engineer</td>
                                      <td>Zenaida Frank</td>
                                      <td>2010/01/04</td>
                                      <td>$125,250</td>
                                    </tr>
                                    <tr>
                                      <td>Software Engineer</td>
                                      <td>Zorita Serrano</td>
                                      <td>2012/06/01</td>
                                      <td>$115,000</td>
                                    </tr>
                                    <tr>
                                      <td>Junior Javascript Developer</td>
                                      <td>Jennifer Acosta</td>
                                      <td>2013/02/01</td>
                                      <td>$75,650</td>
                                    </tr>
                                    <tr>
                                      <td>Sales Assistant</td>
                                      <td>Cara Stevens</td>
                                      <td>2011/12/06</td>
                                      <td>$145,600</td>
                                    </tr>
                                    <tr>
                                      <td>Regional Director</td>
                                      <td>Hermione Butler</td>
                                      <td>2011/03/21</td>
                                      <td>$356,250</td>
                                    </tr>
                                    <tr>
                                      <td>Systems Administrator</td>
                                      <td>Lael Greer</td>
                                      <td>2009/02/27</td>
                                      <td>$103,500</td>
                                    </tr>
                                    <tr>
                                      <td>Developer</td>
                                      <td>Jonas Alexander</td>
                                      <td>2010/07/14</td>
                                      <td>$86,500</td>
                                    </tr>
                                    <tr>
                                      <td>Regional Director</td>
                                      <td>Shad Decker</td>
                                      <td>2008/11/13</td>
                                      <td>$183,000</td>
                                    </tr>
                                    <tr>
                                      <td>Javascript Developer</td>
                                      <td>Michael Bruce</td>
                                      <td>2011/06/27</td>
                                      <td>$183,000</td>
                                    </tr>
                                    <tr>
                                      <td>Customer Support</td>
                                      <td>Donna Snider</td>
                                      <td>2011/01/25</td>
                                      <td>$112,000</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
     <!--table-->
     <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {

          $('input[name="datefilter"]').daterangepicker({
              autoUpdateInput: false,
              locale: {
                  cancelLabel: 'Clear'
              }
          });

          $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
          });

          $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
          });

        });
        
    </script>   
   <script src="js/table/jquery.dataTables.min.js"></script>
    <script src="js/table/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/table/datatables-demo.js"></script>
</body>
</html>