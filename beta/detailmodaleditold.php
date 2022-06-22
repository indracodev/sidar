<?php
include "config.php";

 
    if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        $sql = "SELECT * FROM draftddar WHERE iddetdar = '".$id."'";
        $result = $koneksi->query($sql);
        $rowresult = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $target = $rowresult['target'];
        
        $ambilattach = "SELECT * FROM draftattach WHERE iddetdar = '" .$id . "';";
        $queryattach = $koneksi->query($ambilattach);
        $arrayrattach = mysqli_fetch_all($queryattach, MYSQLI_ASSOC);

        
    ?>
         <!--
              <div class="form-group">
              <label for="target">Target</label>
                    <select name="target" class="form-control" id="target">
                        <?php // for($x = 0; $x < sizeof($arrayresult); $x++){ ?>    
                        <option value="<?php // echo $arrayresult[$x]['target'] ?>"><?php // echo $arrayresult[$x]['target'] ?></option>
                        
                        <? // } ?>
                        </select>
                        
                    </div>
                    -->
          

                   <div class="form-group">
                    <label for="explaination">Target</label>
                    <input type="text" class="form-control" name="target" id="target" value="<?php echo $rowresult['target'] ?>" disabled/> 
                    </div>
                    
                     <div class="form-group">
                    <label for="explaination">Activity</label>
                    <input type="text" class="form-control" name="activity" id="activity" value="<?php echo $rowresult['activity'] ?>" disabled/> 
                
                    </div>
                    
                     <div class="form-group">
                        <label for="result">Result</label>
                        <select name="result" class="form-control" id="result">
                        <option value="Process">Process</option>
                        <option value="Done">Done</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Delayed">Delayed</option>
                        <option value="Pending">Pending</option>
                        </select>
                    <!--    <input type="text" class="form-control" name="result" id="result" placeholder="result"/> -->
                    </div>
                    <div class="form-group">
                    <label for="explaination">Explanation </label>
                    <textarea class="form-control" name="explaination" id="explaination" value="" placeholder="" rows="5"><?php echo $rowresult['explaination'] ?></textarea>
                    <input style="display:none" type="text" class="form-control" name="iddetdar" id="iddetdar" value="<?php echo $id ?>"/>
                    <input style="display:none" type="text" class="form-control" name="idusr" id="idusr" value="<?php echo $rowresult['iduser'] ?>"/>
                    <input style="display:none" type="text" class="form-control" name="idtodo" id="idtodo" value="<?php echo $rowresult['idtodo'] ?>"/>
                    </div>
                    <div class="form-group">
                    <label for="explainationd">Explanation </label>
                    <input name="explanationd" id="explanationd" type="hidden">
                    <div id="editor1" name="aktifitas" class="text mb-4 notranslate"><?php echo $rowresult['explaination'] ?><br><br><br><br><br><br></div>
                    </div>
           
          
    <script>
      var icons = Quill.import("ui/icons");
    icons["undo"] = `<svg viewbox="0 0 18 18">
    <polygon class="ql-fill ql-stroke" points="6 10 4 12 2 10 6 10"></polygon>
    <path class="ql-stroke" d="M8.09,13.91A4.6,4.6,0,0,0,9,14,5,5,0,1,0,4,9"></path>
  </svg>`;
    icons["redo"] = `<svg viewbox="0 0 18 18">
    <polygon class="ql-fill ql-stroke" points="12 10 14 12 16 10 12 10"></polygon>
    <path class="ql-stroke" d="M9.91,13.91A4.6,4.6,0,0,1,9,14a5,5,0,1,1,5-5"></path>
  </svg>`;
  
    var toolbarOptions = [
          ['undo'],['redo'],['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}],
          [{'indent': '+1'}],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }]
        ];
  
  
        var toolbarOptionss = [
          ['undo'],['redo'],['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}],
          [{'indent': '+1'}],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }]
        ];

        var quill = new Quill('#editor1', {
         modules: {
            history: {
             delay: 2000,
             maxStack: 500,
             userOnly: true
          },  
       toolbar: {
      container: toolbarOptionss,
      handlers: {
        undo: function(value) {
          this.quill.history.undo();
        },
        redo: function(value) {
          this.quill.history.redo();
        }
      }
    }
        
          },
    
        
              
          
     theme: 'snow'
        });
        
    

        
    </script>
    <!-- Textarea Editor -->

    
                    <div class="form-group">
                    <label for="file">Proof</label>
                    <input type="file" class="form-control" style="height: calc(1.5em + 1rem + 3px);" name="file" id="file"/>
                    </div>
                    <span id="uploaded_image"></span>
                    <br>
                     
                        <?php
                
                for($x = 0; $x < sizeof($arrayrattach); $x++){
                  ?>
                  <div>
             
                         <a href="deletedraftimg.php?address=img/<?php echo $rowresult['iduser'] ?>/<?php echo $arrayrattach[$x]["img"] ?>" class="btn btn-light"> <strong>Delete</strong> </a>&nbsp <a href="img/<?php echo $rowresult['iduser']?>/<?php echo $arrayrattach[$x]["img"] ?>"><?php echo $arrayrattach[$x]["img"] ?></a>
                      
                 </div>
                            <?php }  ?>
                            
                            
                 <!--   <div class="form-group">
                    <br>
                    <label>Date</label>
                    <div>
                  <input class="form-control" type="date" name="tgl" value="<? // echo $arrayresult[0]['date'] ?>" id="dateofbirth">
                  </div>
                    </div>
                      <div class="form-group">
                    <label>Due Date</label>
                  <input class="form-control" type="date" name="duetgl" value="<? // echo $arrayresult[0]['duedate'] ?>" id="dateofbirth">
                    </div>
                    -->
                   
        <?php 
 
       
    }
    $koneksi->close();
?>