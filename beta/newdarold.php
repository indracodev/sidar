<?php 
include "config.php";
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
$keuser2 = $_SESSION["Ke2"];
$keuser3 = $_SESSION["Ke3"];
$keuser4 = $_SESSION["Ke4"];
$keuser5 = $_SESSION["Ke5"];


/*
SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE tanggal BETWEEN CAST('2020-01-28' AS DATE) AND CAST('2020-01-30' AS DATE) AND dar.iduser=1 ORDER BY dar.tanggal DESC
*/

/*

SELECT masteruser.nama, masteruser.departemen, dar.jam, dar.tanggal, dar.urid
FROM dar INNER JOIN masteruser ON masteruser.id=dar.iduser WHERE dar.activity LIKE '%ar%' AND dar.iduser=1 ORDER BY dar.tanggal DESC

*/



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

    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" type="text/css" href="custom1.css">
    


    <!-- inner style -->
    <style type="text/css">
    	
    </style>
    
       <style type="text/css">
    	tr.highlighted td {
        background-color: rgba(0,0,0,.05);
        }

        .badge-late {
         background-color: orange;
        }
        
        .badge-pendingabsence {
         background-color: teal;
        }
        
          .badge-decline {
         background-color: black;
        }
        
          .badge-absence {
         background-color: blue;
        }
        
    </style>
    
    
       <style>
    #linkk { color: black; } /* CSS link color */
  </style>


</head>
<body>

	<div class="wrapper">
		
		<!-- NAVBAR -->
		<?php include'navbar1.php';?>

		<!-- KONTEN -->
		<main class="konten">
			 <a href="logoutt.php" id="untuklogout" >
			     </a>
			<!-- letakkan isi konten disini ! -->
              <section class="dar mb-5">
                <div class="container-fluid">
               
                       <!-- DataTales Example -->
                          <div class="card shadow mb-4 mt-3">
                            <div class="card-header py-3">
              
                <div class="card-body d-flex justify-content-between align-items-center">
                                <h4 class="card-title m-0 text-uppercase font-weight-bold">TODO</h4>
                               
                                 <div class="dropdown">
                                        <div id="dropCardHeader" aria-haspopup="true" aria-expanded="false">
                                        <button class="btn btn-outline-dark" id="myBtn" data-toggle="modal" data-target="#myModal" data-id="1">
                                        <i class="fa fa-plus"></i> ADD TODO
                                             </button>
                                        </div>
                                       
                                    </div>
                                  
                                 
                                 
                                 
                                 
                                 
                                 </div>
                            </div>
                            
                                
<div class="card-body">
                      
<div class="table100">
  <table class="table">
                <thead class="text-uppercase">
                    <tr>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Status</th>
                        <th>Name</th>
                        <th class="progress_heading text-center">%Complete</th>
                        <th class="progress_heading text-center">%Impressions Goal</th>
                        <th>Revenue*</th>
                        <th>Impressions*</th>
                        <th>Fill Rate*</th>
                        <th>CPM*</th>
                    </tr>
                </thead>

                <tbody id="accordion-test">
                    <tr class="collapse-click" data-toggle="collapse" href="#collapseData1" aria-expanded="false" aria-controls="collapseData1">
                        <td data-title="Priority" class="text-center"><span class="glyphicon glyphicon-resize-vertical"></span> 1</td>
                        <td data-title="Status" class="text-center"><span class="glyphicon glyphicon-dashboard deal_status"></span></td>
                        <td data-title="Name">Toyota Direct</td>
                        <td data-title="%Complete" class="progress-middle text-center">
                            <span>50%</span>
                            <div class="progress progress-low">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 50%">
                                    <span class="sr-only">50% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="%Impressions Goal" class="progress-middle text-center">
                            <span>80%</span>
                            <div class="progress progress-high">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 80%">
                                    <span class="sr-only">80% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="Revenue*">$1,244,222</td>
                        <td data-title="Impressions">50,000</td>
                        <td data-title="Fill Rate*">20%</td>
                        <td data-title="CPM*">$250,000,000,000 <span class="glyphicon glyphicon-option-vertical pull-right" data-toggle="collapse"
                                href="#collapseData1" aria-expanded="false" aria-controls="collapseData1"></span></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="padding-0">
                            <div id="collapseData1" class="collapse table_content--inner text-uppercase">
                                <h3>Toyoto Direct - Report</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Request</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>300,000</h4>
                                        <h5>Responses</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>60%</h4>
                                        <h5>Response Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Impressions</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>60%</h4>
                                        <h5>Impression/Response</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>20%</h4>
                                        <h5>Fill Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$11.50</h4>
                                        <h5>Average CPM</h5>
                                    </div>
                                </div>
                                    <h3>Toyoto Direct - Report</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$1,244,222</h4>
                                        <h5>Revenue</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>VCR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>CTR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$6.78</h4>
                                        <h5>Average Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>3.5</h4>
                                        <h5>Average #Bids</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$7.88</h4>
                                        <h5>Average Winning Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>25%</h4>
                                        <h5>Average Premium to Floor</h5>
                                    </div>
                                </div>
                                <div class="table_content--navigator">
                                    <div class="navigator--top">
                                        <span>Edit Deal<i class="glyphicon glyphicon-pencil"></i></span>
                                        <span>Clone Deal<i class="glyphicon glyphicon-copy"></i></span>
                                    </div>
                                    <div class="navigator--bottom">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <tr class="collapse-click deal_color--even" data-toggle="collapse" href="#collapseData2" aria-expanded="false" aria-controls="collapseData2">
                        <td data-title="Priority" class="text-center"><span class="glyphicon glyphicon-resize-vertical"></span> 2</td>
                        <td data-title="Status" class="text-center"><span class="glyphicon glyphicon-dashboard deal_status"></span></td>
                        <td data-title="Name">MK Direct</td>
                        <td data-title="%Complete" class="progress-middle text-center">
                            <span>30%</span>
                            <div class="progress progress-low">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 30%">
                                    <span class="sr-only">30% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="%Impressions Goal" class="progress-middle text-center">
                            <span>100%</span>
                            <div class="progress progress-high">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 100%">
                                    <span class="sr-only">100% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="Revenue*">$1,244,222</td>
                        <td data-title="Impressions">50,000</td>
                        <td data-title="Fill Rate*">20%</td>
                        <td data-title="CPM*">$250,000,000,000 <span class="glyphicon glyphicon-option-vertical pull-right" data-toggle="collapse"
                                href="#collapseData2" aria-expanded="false" aria-controls="collapseData2"></span></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="padding-0">
                            <div id="collapseData2" class="collapse table_content--inner text-uppercase">
                                <h3>MK Direct - Report</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Request</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>300,000</h4>
                                        <h5>Responses</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>60%</h4>
                                        <h5>Response Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Impressions</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>60%</h4>
                                        <h5>Impression/Response</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>20%</h4>
                                        <h5>Fill Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$11.50</h4>
                                        <h5>Average CPM</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$1,244,222</h4>
                                        <h5>Revenue</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>VCR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>CTR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$6.78</h4>
                                        <h5>Average Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>3.5</h4>
                                        <h5>Average #Bids</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$7.88</h4>
                                        <h5>Average Winning Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>25%</h4>
                                        <h5>Average Premium to Floor</h5>
                                    </div>
                                </div>
                                <div class="table_content--navigator">
                                    <div class="navigator--top">
                                        <span>Edit Deal<i class="glyphicon glyphicon-pencil"></i></span>
                                        <span>Clone Deal<i class="glyphicon glyphicon-copy"></i></span>
                                    </div>
                                    <div class="navigator--bottom">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse-click" data-toggle="collapse" href="#collapseData3" aria-expanded="false" aria-controls="collapseData3">
                        <td data-title="Priority" class="text-center"><span class="glyphicon glyphicon-resize-vertical"></span> 3</td>
                        <td data-title="Status" class="text-center"><span class="glyphicon glyphicon-dashboard deal_status"></span></td>
                        <td data-title="Name">Toyota Direct</td>
                        <td data-title="%Complete" class="progress-middle text-center">
                            <span>50%</span>
                            <div class="progress progress-low">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 40%">
                                    <span class="sr-only">40% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="%Impressions Goal" class="progress-middle text-center">
                            <span>80%</span>
                            <div class="progress progress-high">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 80%">
                                    <span class="sr-only">80% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="Revenue*">$1,244,222</td>
                        <td data-title="Impressions">50,000</td>
                        <td data-title="Fill Rate*">20%</td>
                        <td data-title="CPM*">$250,000,000,000 <span class="glyphicon glyphicon-option-vertical pull-right" data-toggle="collapse"
                                href="#collapseData3" aria-expanded="false" aria-controls="collapseData3"></span></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="padding-0">
                            <div id="collapseData3" class="collapse table_content--inner text-uppercase">
                                <h3>Toyoto Direct - Report</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Request</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>300,000</h4>
                                        <h5>Responses</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>60%</h4>
                                        <h5>Response Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Impressions</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>60%</h4>
                                        <h5>Impression/Response</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>20%</h4>
                                        <h5>Fill Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$11.50</h4>
                                        <h5>Average CPM</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$1,244,222</h4>
                                        <h5>Revenue</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>VCR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>CTR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$6.78</h4>
                                        <h5>Average Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>3.5</h4>
                                        <h5>Average #Bids</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$7.88</h4>
                                        <h5>Average Winning Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>25%</h4>
                                        <h5>Average Premium to Floor</h5>
                                    </div>
                                </div>
                                <div class="table_content--navigator">
                                    <div class="navigator--top">
                                        <span>Edit Deal<i class="glyphicon glyphicon-pencil"></i></span>
                                        <span>Clone Deal<i class="glyphicon glyphicon-copy"></i></span>
                                    </div>
                                    <div class="navigator--bottom">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse-click deal_color--even" data-toggle="collapse" href="#collapseData4" aria-expanded="false" aria-controls="collapseData4">
                        <td data-title="Priority" class="text-center"><span class="glyphicon glyphicon-resize-vertical"></span> 4</td>
                        <td data-title="Status" class="text-center"><span class="glyphicon glyphicon-dashboard deal_status"></span></td>
                        <td data-title="Name">Kraft Direct</td>
                        <td data-title="%Complete" class="progress-middle text-center">
                            <span>10%</span>
                            <div class="progress progress-low">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 10%">
                                    <span class="sr-only">10% Complete</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="%Impressions Goal" class="progress-middle text-center">
                            <span>50%</span>
                            <div class="progress progress-high">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 50%">
                                    <span class="sr-only">50% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="Revenue*">$1,244,222</td>
                        <td data-title="Impressions">50,000</td>
                        <td data-title="Fill Rate*">20%</td>
                        <td data-title="CPM*">$250,000,000,000 <span class="glyphicon glyphicon-option-vertical pull-right" data-toggle="collapse"
                                href="#collapseData4" aria-expanded="false" aria-controls="collapseData4"></span></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="padding-0">
                            <div id="collapseData4" class="collapse table_content--inner text-uppercase">
                                <h3>Kraft Direct - Report</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Request</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>300,000</h4>
                                        <h5>Responses</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>60%</h4>
                                        <h5>Response Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Impressions</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>60%</h4>
                                        <h5>Impression/Response</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>20%</h4>
                                        <h5>Fill Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$11.50</h4>
                                        <h5>Average CPM</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$1,244,222</h4>
                                        <h5>Revenue</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>VCR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>CTR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$6.78</h4>
                                        <h5>Average Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>3.5</h4>
                                        <h5>Average #Bids</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$7.88</h4>
                                        <h5>Average Winning Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>25%</h4>
                                        <h5>Average Premium to Floor</h5>
                                    </div>
                                </div>
                                <div class="table_content--navigator">
                                    <div class="navigator--top">
                                        <span>Edit Deal<i class="glyphicon glyphicon-pencil"></i></span>
                                        <span>Clone Deal<i class="glyphicon glyphicon-copy"></i></span>
                                    </div>
                                    <div class="navigator--bottom">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse-click" data-toggle="collapse" href="#collapseData5" aria-expanded="false" aria-controls="collapseData5">
                        <td data-title="Priority" class="text-center"><span class="glyphicon glyphicon-resize-vertical"></span> 5</td>
                        <td data-title="Status" class="text-center"><span class="glyphicon glyphicon-dashboard deal_status"></span></td>
                        <td data-title="Name">Open Auction</td>
                        <td data-title="%Complete" class="progress-middle text-center">
                            <span>30%</span>
                            <div class="progress progress-low">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 30%">
                                    <span class="sr-only">30% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="%Impressions Goal" class="progress-middle text-center">
                            <span>70%</span>
                            <div class="progress progress-high">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 70%">
                                    <span class="sr-only">70% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                        <td data-title="Revenue*">$1,244,222</td>
                        <td data-title="Impressions">50,000</td>
                        <td data-title="Fill Rate*">20%</td>
                        <td data-title="CPM*">$250,000,000,000 <span class="glyphicon glyphicon-option-vertical pull-right" data-toggle="collapse"
                                href="#collapseData5" aria-expanded="false" aria-controls="collapseData5"></span></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="padding-0">
                            <div id="collapseData5" class="collapse table_content--inner text-uppercase">
                                <h3>Open Auction</h3>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Request</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>300,000</h4>
                                        <h5>Responses</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>60%</h4>
                                        <h5>Response Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>500,000</h4>
                                        <h5>Impressions</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>60%</h4>
                                        <h5>Impression/Response</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>20%</h4>
                                        <h5>Fill Rate</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$11.50</h4>
                                        <h5>Average CPM</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$1,244,222</h4>
                                        <h5>Revenue</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>VCR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>50%</h4>
                                        <h5>CTR</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner table_data--small">
                                        <h4>$6.78</h4>
                                        <h5>Average Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>3.5</h4>
                                        <h5>Average #Bids</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>$7.88</h4>
                                        <h5>Average Winning Bid</h5>
                                    </div>
                                    <div class="col-sm-2 table_data--inner">
                                        <h4>25%</h4>
                                        <h5>Average Premium to Floor</h5>
                                    </div>
                                </div>
                                <div class="table_content--navigator">
                                    <div class="navigator--top">
                                        <span>Edit Deal<i class="glyphicon glyphicon-pencil"></i></span>
                                        <span>Clone Deal<i class="glyphicon glyphicon-copy"></i></span>
                                    </div>
                                    <div class="navigator--bottom">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                </div>
                            </div>
                        </td>
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

     <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                  <h4 class="modal-title" id="labelModalKu">Contact Form</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Tutup</span>
                </button>
              
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form role="form">
                    <div class="form-group">
                        <label for="masukkanNama">Target</label>
                        <input type="text" class="form-control" id="masukkanNama" placeholder="Masukkan nama Anda"/>
                    </div>
                    <div class="form-group">
                        <label for="masukkanEmail">Todo</label>
                        <input type="text" class="form-control" id="masukkanEmail" placeholder="Masukkan email Anda"/>
                    </div>
                        <div class="form-group">
                    <label>Date</label>
                   <input class="form-control datepicker" type="text" name="tanggal" id="tanggal" data-provide="datepicker">
                    </div>
                      <div class="form-group">
                    <label>Due Date</label>
                   <input class="form-control datepicker" type="text" name="tanggal" id="tanggal" data-provide="datepicker">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary submitBtn" onclick="kirimContactForm()">KIRIM</button>
            </div>
        </div>
    </div>
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" ></script>
	<script type="text/javascript">
	$('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
	});
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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    
     <!--table-->
     <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
     
<!--     
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
       <script>
    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'detailmodal.php',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>   
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  -->
  
  
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    
         <script>
        $(function() {

          $('input[name="datefilter"]').daterangepicker({
              autoUpdateInput: false,
              locale: {
                  firstDay: 1, 
                  cancelLabel: 'Clear'
              }
          });
          
          

          $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
              
                
            
              $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
            
              var startDate = picker.startDate.format('YYYY/MM/DD');
              var endDate = picker.endDate.format('YYYY/MM/DD');
              
            $('input[name="autoClickBtn"]').val(document.getElementById('autoClickBtn').click());
              
 //function(){document.getElementById('autoClickBtn').click();}
           /*   
           $.ajax({
           method: "POST",
           url: "rec.php",
           data: {startDate: picker.startDate, endDate: picker.endDate}
        }).done(function(response){
            // Do something with response here
            console.log(response);
        }).fail(function (error) {
            // And handle errors here
            console.log(error);
        });
                    
  */
         
              
     /*         

        var activity =  document.querySelector('input[name="datefilter"]');
        activity.value = quill.root.innerHTML;
              
             $.ajax({
            type: 'POST',
            url: 'rec.php',
            data:  { startDate:startDate, endDate:endDate},
             success: function(result) {
                $('#sonuc').html(result);
            },
            error: function() {
                alert('Some error found. Please try again!');
            }
             });
             
             window.location.replace("http://www.w3schools.com");
       */      
              
          });
          
          
          
          
          

          $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
               $('input[name="autoClickBtn"]').val(document.getElementById('autoClickBtn').click());
          });


        });
        
  
    </script>
    

    
    
    <script>
    
      $(document).ready(function(){
        $('#dataTablee').DataTable({
    stateSave: true,
   
   "aaSorting": []
    });
    
    $("#dataTablee_filter").html('<form action="" method="post"><label>Search<input type="text" name="searching"> <input style="display:none;" type="submit" name="cari"> </label> </form>');
    });
    
    /*
    $(document).ready(function(){
        $('#dataTablee').DataTable({
    "searching": false,
     "paging":   true,
        "ordering": true,
        "info":     true,
   "aaSorting": []
    });
    
   //  $("#dataTablee_length").html('<b>Custom tool bar! Text/images etc.</b>');
    });
    */
</script>


    
   <script src="js/table/jquery.dataTables.min.js"></script>
    <script src="js/table/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/table/datatables-demo.js"></script>
    
    

    
    
<script>
    document.getElementById("dataTablee_filter").style.display = "none";
    document.getElementById("dataTablee_filter").innerHTML = "Hello World!";
</script>

    <script>
window.onload = function(){
   var link = document.getElementById('untuklogout');
   setInterval(function(){
    //   alert("Hello");
        link.click();
   }, 1800000);
};
    </script>


</body>
</html>