<?php
session_start();
$iduser = $_SESSION["IDUser"] ;
$keuser = $_SESSION["Ke"] ;
//$nodar =  $_SESSION["Nodar"] ;
//$pecah = explode("/", $nodar);
//$hasil = $pecah[1] + 1;
//$nodarnya = $iduser."/".$hasil;


if($_SESSION["IDUser"] == 0){
header("Location: http://icg.id/beta/dar/login");
    }
    
include "config.php";



 $ambilstatus = "SELECT * FROM masteruser 
   WHERE id = '" .$iduser. "' ;";
   $queryambilstatus =$conn->query($ambilstatus);
 if($queryambilstatus->num_rows){
   session_start();
 $rowambilstatus = mysqli_fetch_array($queryambilstatus, MYSQLI_ASSOC);
 $statuskirim = $rowambilstatus['sudahkirim'];
 
 if($statuskirim == "sudah"){
     
     $display = "display:none;";
     
 }else{
     
 }


 }
 else{
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
   echo " gak dapat nomer ";
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
        <?php include'navbar.php';?>

        <!-- ---------------------------- 
            konten 
        ---------------------------- -->
        <main class="konten">

            <section class="dar mb-5 text-center text-lg-left">
                <header class="text-center">
                    <h4>DAILY ACTIVITY REPORT</h4>
                    <hr class="garis-judul-hijau my-0">
                </header>
                
             <form form action="datauploadd.php" method="post" enctype="multipart/form-data" class="mb-4">

                <h5 class="titel">Daily activity:</h5>
                <input name="activity" type="hidden">
                <div id="editor1" name="aktifitas" class="text mb-4"><?php echo $draftactivity; ?></div>
                
                
                <h5 class="titel">Planning:</h5>
                <input name="planning" type="hidden">
                <div id="editor2" name="isiplaning" class="text mb-4"><?php echo $draftplan; ?></div>
                
                
                <h5 class="titel">Tags:</h5>
                <textarea id="tags" class="tags" name="tags" oninput="auto_grow(this)"><?php echo $drafttag; ?></textarea>


              <input name="nodar" style="display:none;" type="text" class="form-control-file" id="nodar" value="<?php echo $nodarnya; ?>">
              <input name="iduser" style="display:none;" type="text" class="form-control-file" id="iduser" value="<?php echo $iduser; ?>">
              <input name="keuser" style="display:none;" type="text" class="form-control-file" id="keuser" value="<?php echo $keuser; ?>">

              
                    <div class="form-group">
                         <label for="attachmentFiles" class="font-weight-bold">Files Attachment</label>
                        <input type="file" name="gambar[]" class="d-lg-block" multiple="" id="attachmentFiles">
                    </div>
               

               <button type="submit" style="display:none;" name="btdraft" id="btdraft" value="savedraft" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                
                
                <button type="submit" style="display:none;" name="btdar" id="btdar" value="kirimdar" class="btn btn-outline-dark">
                    <i class="fa fa-send"></i> SEND REPORT
                </button> 

                
                 </form>
                 
                 
                 <button class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#konfirmasiModal">
                    <i class="fa fa-send"></i> SEND REPORT
                </button>
                
                 
                 
                <button onclick="draft()" style="<?php echo $display?>" class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                
              
                  
                 <button onclick="dar()" style="<?php echo $display?>" class="btn btn-outline-dark">
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
                 <button type="button"  class="btn btn-outline-success">Send</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
       <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- user JS -->
    <script type="text/javascript" src="user.js"></script>
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
var url ="rec.php";
    $.ajax({
     type: "POST",
     url : url,
     data : activity, planning      
    });
    return false;
};

</script>

<script>
        // auto resize textarea customize
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }

        // bullets and numbering customize
        $(".tags").focus(function() {
            if(document.getElementById('tags').value === ''){
                document.getElementById('tags').value +='# ';
            }
        });
        $(".tags").keyup(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                document.getElementById('tags').value +='# ';
            }
            var txtval = document.getElementById('tags').value;
            if(txtval.substr(txtval.length - 1) == '\n'){
                document.getElementById('tags').value = txtval.substring(0,txtval.length - 1);
            }
        });        
    </script>


<script>
    
    function senddar()
{


    $('button[name="btdar"]').val(document.getElementById('btdar').click());
    

}
</script>




<script>
    
    function dar()
{

    
  var y = confirm("Are you sure to send DAR?");
 if (y==true) {
     
    $('button[name="btdar"]').val(document.getElementById('btdar').click());
    
  } else {
  
  }
}
</script>


<script>
    
    function draft()
{

    
  var x = confirm("Are you sure to save draft?");
 if (x==true) {
     
    $('button[name="btdraft"]').val(document.getElementById('btdraft').click());
    
  } else {
  
  }
}
</script>

<script>
    
    var modalConfirm = function(callback){
  
  $("#btn-confirm").on("click", function(){
    $("#mi-modal").modal('show');
  });

  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    $("#result").html("CONFIRMADO");
  }else{
    //Acciones si el usuario no confirma
    $("#result").html("NO CONFIRMADO");
  }
});
</script>

</body>
</html>