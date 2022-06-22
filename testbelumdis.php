<?php
include "config.php";

$ambildar = "SELECT * FROM absenluarkota where iduser != '164' and iduser != '604' and iduser != '119' and iduser != '238'
and iduser != '166' and iduser != '182' and iduser != '135' and iduser != '631' and iduser != '606' and iduser != '653' and iduser != '648' 
and iduser != '623' and iduser != '632' and iduser != '455' and iduser != '134' and iduser != '179' and iduser != '654'
and iduser != '662' and iduser != '633' and iduser != '198' and iduser != '454' and iduser != '456' and iduser != '133' and iduser != '663' 
and iduser != '549' and iduser != '190' and iduser != '646' and iduser != '622' and iduser != '188' and iduser != '457' and iduser != '672' 
and iduser != '460' and iduser != '461' and iduser != '204' and iduser != '207' order by idabsen desc limit 50;";
 $querydar =$conn->query($ambildar);

   $row = mysqli_fetch_all($querydar, MYSQLI_ASSOC);

 echo sizeof($row);
         for($x = 0; $x < sizeof($row); $x++){



   echo $row[$x]['nama'].'<br>';
   echo $row[$x]['bagian'].'<br>';
   echo $row[$x]['kota'].'<br><br>';
   

         }

?>