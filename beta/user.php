<!DOCTYPE html>
<html>
<head>

	<title>DAR</title>
    <link rel="stylesheet icon" href="img/ikon.png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
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

                <h5 class="titel">Daily activity:</h5>
                <div id="editor1" class="text mb-4"></div>
                <h5 class="titel">Planning:</h5>
                <div id="editor2" class="text mb-4"></div>
                <h5 class="titel">Tags:</h5>
                <textarea id="tags" class="tags" name="tags" oninput="auto_grow(this)"></textarea>

                <form class="mb-4">
                    <div class="form-group">
                        <label for="attachmentFiles" class="font-weight-bold">Files Attachment</label>
                        <input type="file" class="d-lg-block" multiple="" id="attachmentFiles">
                    </div>
                </form>

                <button class="btn btn-outline-dark">
                    <i class="fa fa-save"></i> SAVE DRAFT
                </button>
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#konfirmasiModal">
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
                 <button type="button" class="btn btn-outline-success">Send</button>
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

        var quill = new Quill('#editor2', {
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

</body>
</html>