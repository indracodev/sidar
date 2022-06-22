<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "main"){
  if(!isset($_POST["formid"])){
    $pesan = "Error! form input not found!";
  } else if(!isset($_POST["csingori"])){
    $pesan = "Error! SingOri input not found!";
  } else if(!isset($_POST["cluwakpr"])){
    $pesan = "Error! LuwakPr input not found!";
  } else if(!isset($_POST["cgourmet"])){
    $pesan = "Error! Gourmet input not found!";
  } else if(!isset($_POST["corgenic"])){
    $pesan = "Error! Organic input not found!";
  } else if(!isset($_POST["crainfor"])){
    $pesan = "Error! RainFor input not found!";
  } else if(!isset($_POST["cworldbl"])){
    $pesan = "Error! WorldBl input not found!";
  } else if(!isset($_POST["cbalicaf"])){
    $pesan = "Error! BaliCaf input not found!";
  } else if(!isset($_POST["cassorted"])){
    $pesan = "Error! Assorted input not found!";
  } else if(!isset($_POST["tarabica"])){
    $pesan = "Error! Arabica input not found!";
  } else if(!isset($_POST["trobusta"])){
    $pesan = "Error! Robusta input not found!";
  } else if(!isset($_POST["tblend"])){
    $pesan = "Error! Blend input not found!";
  } else if(!isset($_POST["fbeans"])){
    $pesan = "Error! Beans input not found!";
  } else if(!isset($_POST["fground"])){
    $pesan = "Error! Ground input not found!";
  } else if(!isset($_POST["fdrip"])){
    $pesan = "Error! Drip input not found!";
  } else if(!isset($_POST["fcapsule"])){
    $pesan = "Error! Capsule input not found!";
  } else if(!isset($_POST["pcan"])){
    $pesan = "Error! Can input not found!";
  } else if(!isset($_POST["ppouch"])){
    $pesan = "Error! Pouch input not found!";
  } else if(!isset($_POST["pdrip"])){
    $pesan = "Error! Drip input not found!";
  } else if(!isset($_POST["pcapsule"])){
    $pesan = "Error! Capsule input not found!";
  } else if(!isset($_POST["pbox"])){
    $pesan = "Error! Box input not found!";
  } else if(!isset($_POST["w50g"])){
    $pesan = "Error! 50 input not found!";
  } else if(!isset($_POST["w60g"])){
    $pesan = "Error! 60 input not found!";
  } else if(!isset($_POST["w100g"])){
    $pesan = "Error! 100 input not found!";
  } else if(!isset($_POST["w200g"])){
    $pesan = "Error! 200 input not found!";
  } else if(!isset($_POST["w500g"])){
    $pesan = "Error! 500 input not found!";
  } else if(!isset($_POST["w1000g"])){
    $pesan = "Error! 1000 input not found!";
  } else if(!isset($_POST["shiprcs"])){
    $pesan = "Error! HighPrcs input not found!";
  } else if(!isset($_POST["slowprcs"])){
    $pesan = "Error! LowPrcs input not found!";
  } else if(!isset($_POST["slatestprod"])){
    $pesan = "Error! LastProd input not found!";
  } else if(!isset($_POST["spopularprod"])){
    $pesan = "Error! PopProduct input not found!";
  } else {
    //Form Num
    $formID         = $_POST["formid"];
    // Collection
    $colSingOri     = $_POST["csingori"];
    $colLuwakPr     = $_POST["cluwakpr"];
    $colGourmet     = $_POST["cgourmet"];
    $colOrganic     = $_POST["corgenic"];
    $colRainFor     = $_POST["crainfor"];
    $colWorldBl     = $_POST["cworldbl"];
    $colBaliCaf     = $_POST["cbalicaf"];
    $colAssorted    = $_POST["cassorted"];
    // Type
    $typArabica     = $_POST["tarabica"];
    $typRobusta     = $_POST["trobusta"];
    $typBlend       = $_POST["tblend"];
    // Form
    $frmBeans       = $_POST["fbeans"];
    $frmGround      = $_POST["fground"];
    $frmDrip        = $_POST["fdrip"];
    $frmCapsule     = $_POST["fcapsule"];
    //Packaging
    $pckCan         = $_POST["pcan"];
    $pckPouch       = $_POST["ppouch"];
    $pckDrip        = $_POST["pdrip"];
    $pckCapsule     = $_POST["pcapsule"];
    $pckBox         = $_POST["pbox"];
    //Weight
    $wgh50          = $_POST["w50g"];
    $wgh60          = $_POST["w60g"];
    $wgh100         = $_POST["w100g"];
    $wgh200         = $_POST["w200g"];
    $wgh500         = $_POST["w500g"];
    $wgh1000        = $_POST["w1000g"];
    //Sort By
    $srtHighPrcs    = $_POST["shiprcs"];
    $srtLowPrcs     = $_POST["slowprcs"];
    $srtLastProd    = $_POST["slatestprod"];
    $srtPopProduct  = $_POST["spopularprod"];
    //sort checker
    $sortNoVal = 0;
    if($srtHighPrcs == 1){
      $sortNoVal = $sortNoVal + 1;
    }
    if($srtLowPrcs == 1){
      $sortNoVal = $sortNoVal + 1;
    }
    if($srtLastProd == 1){
      $sortNoVal = $sortNoVal + 1;
    }
    if($srtPopProduct == 1){
      $sortNoVal = $sortNoVal + 1;
    }

    if($sortNoVal >= 2){
      $pesan = "Sorry! sort cannot more than one selected";
    } else {
      $sql = "SELECT * FROM masterproduk WHERE status = 'aktif' ";

      //Category
      if($colSingOri == 1 || $colLuwakPr == 1 || $colGourmet == 1 || $colOrganic == 1 || $colRainFor == 1 || $colWorldBl == 1 || $colBaliCaf == 1 || $colAssorted == 1){
        $countThis = 0;
        $sqlcategory = " AND categoryname IN "."(";
        if($colSingOri == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"single origin"';
          $countThis++;
        }
        if($colLuwakPr == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"luwak prestige"';
          $countThis++;
        }
        if($colGourmet == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"gourmet"';
          $countThis++;
        }
        if($colOrganic == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"organic"';
          $countThis++;
        }
        if($colRainFor == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"rainforest"';
          $countThis++;
        }
        if($colWorldBl == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"world blend"';
          $countThis++;
        }
        if($colBaliCaf == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"balicafe"';
          $countThis++;
        }
        if($colAssorted == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlcategory = $sqlcategory.$commaval.'"assorted"';
          $countThis++;
        }
        $sqlcategory = $sqlcategory.")";
      } else {
        $sqlcategory = "";
      }

      //Type
      if($typArabica == 1 || $typRobusta == 1 || $typBlend == 1){
        $countThis = 0;
        $sqltype = " AND tipekopi IN "."(";
        if($typArabica == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqltype = $sqltype.$commaval.'"arabica"';
          $countThis++;
        }
        if($typRobusta == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqltype = $sqltype.$commaval.'"robusta"';
          $countThis++;
        }
        if($typBlend == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqltype = $sqltype.$commaval.'"blend"';
          $countThis++;
        }
        $sqltype = $sqltype.")";
      } else {
        $sqltype = "";
      }

      // Form
      if($frmBeans == 1 || $frmGround == 1 || $frmDrip == 1 || $frmCapsule == 1){
        $countThis = 0;
        $sqlForm = " AND kind IN "."(";
        if($frmBeans == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlForm = $sqlForm.$commaval.'"beans"';
          $countThis++;
        }
        if($frmGround == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlForm = $sqlForm.$commaval.'"ground"';
          $countThis++;
        }
        if($frmDrip == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlForm = $sqlForm.$commaval.'"drip"';
          $countThis++;
        }
        if($frmCapsule == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlForm = $sqlForm.$commaval.'"capsules"';
          $countThis++;
        }
        $sqlForm = $sqlForm.")";
      } else {
        $sqlForm = "";
      }

      //Packaging
      if($pckCan == 1 || $pckPouch == 1 || $pckDrip == 1 || $pckCapsule == 1 || $pckBox == 1){
        $countThis = 0;
        $sqlPck = " AND kemasan IN "."(";
        if($pckCan == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlPck = $sqlPck.$commaval.'"can"';
          $countThis++;
        }
        if($pckPouch == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlPck = $sqlPck.$commaval.'"pouch"';
          $countThis++;
        }
        if($pckDrip == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlPck = $sqlPck.$commaval.'"drip"';
          $countThis++;
        }
        if($pckCapsule == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlPck = $sqlPck.$commaval.'"Capsule"';
          $countThis++;
        }
        if($pckBox == 1){
          if($countThis >= 1){
            $commaval = ", ";
          } else {
            $commaval = "";
          }
          $sqlPck = $sqlPck.$commaval.'"ground box"';
          $countThis++;
        }
        $sqlPck = $sqlPck.")";
      } else {
        $sqlPck = "";
      }

      //Sort By
      if($srtHighPrcs == 1 || $srtLowPrcs == 1 || $srtLastProd == 1 || $srtPopProduct == 1){
        if($srtHighPrcs == 1){
          $sqlSrt = " ORDER BY harga DESC";
        }
        if($srtLowPrcs == 1){
          $sqlSrt = " ORDER BY harga ASC";
        }
        if($srtLastProd == 1){
          $sqlSrt = " ORDER BY idproduk DESC";
        }
        if($srtPopProduct == 1){
          $sqlSrt = " ORDER BY jumlahstock DESC";
        }
      } else {
        $sqlSrt = "";
      }

      //SQL
      include "config.php";
      $sqlResult = $sql.$sqlcategory.$sqltype.$sqlForm.$sqlPck.$sqlSrt;
      $getResult = $conn->query($sqlResult);
      $pid = 0;
      while($fetchResult = $getResult->fetch_assoc()){
        $daJson[$pid]["id"] = $fetchResult["idproduk"];
        $daJson[$pid]["img"] = $fetchResult["gambar"];
        $daJson[$pid]["name"] = $fetchResult["namaproduk"];
        $daJson[$pid]["bawahnama"] = $fetchResult["bawahnama"];
        $daJson[$pid]["price"] = $fetchResult["harga"];
        $daJson[$pid]["discount"] = $fetchResult["hargadiskon"];
        $daJson[$pid]["stock"] = $fetchResult["jumlahstock"];
        $daJson[$pid]["package"] = $fetchResult["kemasan"];
        $daJson[$pid]["categoryname"] = $fetchResult["categoryname"];
        $daJson[$pid]["coffeetype"] = $fetchResult["tipekopi"];
        $daJson[$pid]["kind"] = $fetchResult["kind"];
        $daJson[$pid]["gramature"] = $fetchResult["gramature"];
        $pid++;
      }
      $printJson = json_encode($daJson);
      echo $printJson;
      exit();
    }
  }
} else {
  $pesan = "Error! no action detected!";
}

$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
