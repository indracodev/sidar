<?php
include "auth.php";
$do = $_GET["do"];
$status = "failed";
$pesan = "";
$daJson = array();

if($do == "mailcode"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key detected!";
  } else if(!isset($_POST["email"])){
    $pesan = "Error! no email detected!";
  } else {
    $hash = $_POST["hash"];
    $email = $_POST["email"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($email == ""){
      $pesan = "Sorry! email cannot be empty!";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! cannot perform this action. no security found";
      } else {
        $checkIsset = $conn->query("SELECT * FROM apiforget WHERE apiforget_email = '".$email."' AND apiforget_date = NOW() ");
        $countIsset = $checkIsset->num_rows;
        if($countIsset >= 3){
          $pesan = "Sorry! Too many request Try again tommorow";
        } else {
          //Get Email Data
          $getUserData = $conn->query("SELECT * FROM masterpelanggan WHERE email = '".$email."' ");
          $countUserData = $getUserData->num_rows;
          if($countUserData != 1){
            $pesan = "Sorry! invalid email";
          } else {
            //Get Existing Request
            $getExist = $conn->query("SELECT * FROM apiforget WHERE apiforget_email = '".$email."' ");
            $countExist = $getExist->num_rows;
            if($countExist != 0){
              $conn->query("UPDATE apiforget SET apiforget_status = 'expired' WHERE apiforget_email = '".$email."' ");
            }
            //Generate
            $codeGenerate = rand(1000,9999);
            $checkGenCode = $conn->query("SELECT * FROM apiforget WHERE apiforget_email = '".$email."' AND apiforget_date = NOW() AND apiforget_otp = '".$codeGenerate."' ");
            $countGenCode = $checkGenCode->num_rows;
            while($countGenCode != 0){
              $codeGenerate = rand(1000,9999);
              $checkGenCode = $conn->query("SELECT * FROM apiforget WHERE apiforget_email = '".$email."' AND apiforget_date = NOW() AND apiforget_otp = '".$codeGenerate."' ");
              $countGenCode = $checkGenCode->num_rows;
            }
            //Insert Listing
            $conn->query("INSERT INTO apiforget VALUES(NULL, '".$hash."', '".$email."', '".$codeGenerate."', NOW(), NOW(), '0', 'active')");
            //Send Email
            require('phpmailer/PHPMailer.php');
            require('phpmailer/SMTP.php');
            require('phpmailer/Exception.php');
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try{
              //Send SMTP
              $mail->isSMTP();
              $mail->Host     = 'supresso.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'ecommerce@supresso.com';
              $mail->Password = 's{Vi(jz?B#sZ';
              $mail->SMTPSecure = 'ssl';
              $mail->Port     = 465;
              //Recipients
              $mail->setFrom('ecommerce@supresso.com', 'supresso.com');
              $mail->addAddress($email, 'User Supresso');
              //Content
              $mail->isHTML(true);
              $mail->Subject = 'Supresso - Reset Password';
              $mail->Body = `
              <html lang="en" style="padding: 0; margin: 0; background-color: #ffffff; width: 100%!important">
              <head>
              	<meta charset="utf-8">
              	<title>Supresso - Reset Password</title>
              	<link rel="stylesheet icon" type="text" href="https://supresso.com/newsletter/mtemplate/img/logo.png">
              </head>
              <body style="padding: 0; margin: 0; background-color: #ffffff; width: 100%!important">
              	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important"><tbody>
              		<tr style="display: none; max-height: 0; overflow: hidden"><td valign="top" align="left">
              			<module name="preheader" label="Preheader"></module>
              			<editable name="preheader">Supresso - Tracking Order</editable>
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
              			&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
              		</td></tr>
              		<tr><td valign="top" align="left">
              			<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important"><tbody>
              				<tr><td valign="top" align="left">
              					<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important"><tbody>
              						<tr><td valign="top" align="left" height="20"></td></tr>
              						<tr><td valign="top" align="left">
              							<p style="font-size: 0;">
              								<img src="https://supresso.com/newsletter/mtemplate/img/logo.png" width="71" style="width:100%;height:auto;max-width:71px">
              							</p>
              						</td></tr>
              						<tr><td valign="top" align="left" height="80"></td></tr>
              						<tr><td valign="top" align="left">
              							<h1 style="font-size: 2em; font-family: sans-serif; padding: 0; margin-top: 0;">
              								<strong>Do you want to change your password?</strong>
              							</h1>
              							<p style="font-family: sans-serif; padding: 0; margin-top: 0;">
              								We recieve a request to change your <b>Supresso Mobile App</b> password recently. If this activity is not suspicious for you, so enter this code in your <b>Supresso Mobile App</b>:
              							</p>
              						</td></tr>
              						<tr><td valign="top" align="left" height="30"></td></tr>
              					</tbody></table>
              				</td></tr>
              				<tr><td valign="top" align="left">
              					<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important; border-top: solid 1px #878787;"><tbody>
              						<!-- tracking item -->
              						<tr><td valign="top" align="left">
              							<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; border-bottom: solid 1px #878787;"><tbody>
              								<tr><td valign="top" align="left" height="20"></td></tr>
              								<tr><td valign="top" align="left">
              									<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important;">
                                  <tbody>
                                    <tr>
                                      <td valign="center" align="left" style="text-align:center; font-size: 2em; font-family: sans-serif; padding: 0; margin-top: 0;">
                                        <h1>'.$codeGenerate.'</h1>
                                      </td>
                                    </tr>
                                  </tbody>
                              </table>
              								</td>
                              </tr>
              								<tr>
                                <td valign="top" align="left" height="20">
                                </td>
                              </tr>
                            </table>
              						</td></tr>
              						<!-- end tracking item -->
              					</tbody></table>
              				</td></tr>
              				<tr><td valign="top" align="left">
              					<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important"><tbody>
              						<tr><td valign="top" align="left" height="30"></td></tr>

              						<tr><td valign="top" align="left" height="30"></td></tr>
              						<tr><td valign="top" align="left">
              							<p style="font-family: sans-serif; padding: 0; margin-top: 0;">Best Regards,</p>
              							<p style="font-family: sans-serif; padding: 0; margin-top: 0;">
              								<strong>Supresso</strong>
              							</p>
              						</td></tr>
              						<tr><td valign="top" align="left" height="30"></td></tr>
              					</tbody></table>
              				</td></tr>
              			</tbody></table>
              		</td></tr>
              		<tr><td valign="top" align="left">
              			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; background-color: #fafafb"><tbody><tr><td valign="top" align="left">
              				<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important"><tbody><tr><td valign="top" align="left">
              					<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important"><tbody><tr><td valign="top" align="left">
              						<p style="font-size: 0">
              							<img src="https://supresso.com/newsletter/mtemplate/img/signature_light.png" width="640" style="width: 100%; height: auto; max-width: 640px">
              						</p>
              					</td></tr></tbody></table>
              				</td></tr></tbody></table>
              			</td></tr></tbody></table>
              		</td></tr>
              			<tr><td valign="top" align="left">
              			<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;"><tbody><tr><td valign="top" align="left">
              				<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;"><tbody>
              					<tr><td valign="top" align="left" height="30"></td></tr>
              					<tr><td valign="top" align="left">
              						<p align="justify" style="font-family: sans-serif; padding: 0; margin: 0; font-size: 60%; color: #fd4f00;">
              							Important warning and disclaimer :
              						</p>
              					</td></tr>
              					<tr><td valign="top" align="left" height="5"></td></tr>
              					<tr><td valign="top" align="left">
              						<p align="justify" style="font-family: sans-serif; padding: 0; margin: 0; font-size: 60%; color: #bcbec0;">
              							This message and any attachments are intended for the named and correctly identified addressee only. This message may contain confidential, proprietary, legally privileged or commercially sensitive information. No waiver of confidentiality or privilege is intended or authorized by this transmission. If you are not the intended recipient of this message you must not directly or indirectly use, reproduce, distribute, disclose, print, reply on, disseminate, or copy any part of the message or its attachments and if you have received this message in error, please notify the sender immediately by return e-mail and delete it from your system. The accuracy of the information in this e-mail is not guaranteed. Any opinions contained in this message are those of the author and are not given or endorsed unless otherwise clearly indicated in this message, and the authority of the author to act for and on behalf of Indraco Pte. Ltd. and its Subsidiaries is duly verified.
              						</p>
              					</td></tr>
              					<tr><td valign="top" align="left" height="30"></td></tr>
              					<tr><td valign="top" align="left">
              						<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0"><tbody>
              							<tr>
              								<td valign="top" align="left">
              									<table width="248.5" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 248.5px!important;"><tbody><tr><td valign="top" align="left"></td></tr></tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;"><tbody>
              										<tr><td valign="top" align="left">
              											<p style="font-size: 0">
              												<a href="https://web.facebook.com/supressocoffee/" target="_blank" style="text-decoration: none">
              													<img src="https://supresso.com/newsletter/mtemplate/img/ikon_fb_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
              												</a>
              											</p>
              										</td></tr>
              									</tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;"><tbody><tr><td valign="top" align="left"></td></tr></tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;"><tbody>
              										<tr><td valign="top" align="left">
              											<p style="font-size:0">
              												<a href="https://www.instagram.com/supressocoffee/" target="_blank" style="text-decoration: none">
              													<img src="https://supresso.com/newsletter/mtemplate/img/ikon_ig_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
              												</a>
              											</p>
              										</td></tr>
              									</tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;"><tbody><tr><td valign="top" align="left"></td></tr></tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;"><tbody>
              										<tr><td valign="top" align="left">
              											<p style="font-size: 0">
              												<a href="https://api.whatsapp.com/send?phone=6281219998998&text=Hi%20Supresso," target="_blank" style="text-decoration: none">
              													<img src="https://supresso.com/newsletter/mtemplate/img/ikon_phone_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
              												</a>
              											</p>
              										</td></tr>
              									</tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;"><tbody><tr><td valign="top" align="left"></td></tr></tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;"><tbody>
              										<tr><td valign="top" align="left">
              											<p style="font-size: 0">
              												<a href="https://g.page/supressocoffeegallery?share" target="_blank" style="text-decoration: none">
              													<img src="https://supresso.com/newsletter/mtemplate/img/ikon_map_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
              												</a>
              											</p>
              										</td></tr>
              									</tbody></table>
              								</td>
              								<td valign="top" align="left">
              									<table width="248.5" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 248.5px!important;"><tbody><tr><td valign="top" align="left"></td></tr></tbody></table>
              								</td>
              							</tr>
              						</tbody></table>
              					</td></tr>
              					<tr><td valign="top" align="left" height="20"></td></tr>
              					<tr><td valign="top" align="left">
              						<p align="center" style="font-family: sans-serif; padding: 0; margin: 0">
              							<a href="https://supresso.com/sg/emailtemplate/orderConfirmation.html" target="_blank" style="text-decoration: none; color: #000000; display: inline-block; vertical-align: middle; padding-right: 1rem; margin-right: 1rem; border-right: solid 1px #565656">
              								<small><small>View Web Version</small></small>
              							</a>
              							<a href="https://www.supresso.com/sg/pp.php" target="_blank" style="text-decoration: none; color: #000000; display: inline-block; vertical-align: middle; padding-right: 1rem; margin-right: 1rem; border-right: solid 1px #565656">
              								<small><small>Privacy Policy</small></small>
              							</a>
              							<a href="https://www.supresso.com/sg/unsubscribed/?email='.$email.'" target="_blank" style="text-decoration: none; color: #000000">
              								<small><small>Unsubscribe</small></small>
              							</a>
              						</p>
              					</td></tr>
              					<tr><td valign="top" align="left" height="20"></td></tr>
              				</tbody></table>
              			</td></tr></tbody></table>
              		</td></tr>
              		<tr><td valign="top" align="left">
              			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; border-top: solid 1px #d4d4d4;"><tbody><tr><td valign="top" align="left">
              				<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;"><tbody><tr><td valign="top" align="left">
              					<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;"><tbody>
              						<tr><td valign="top" align="left" height="20"></td></tr>
              						<tr><td valign="top" align="left">
              							<p align="center" style="font-family: sans-serif; padding: 0; margin: 0">
              								<small><small>
              									Copyright &copy; 2021 Supresso. All rights reserved.
              									<br>
              									333A Orchard Road #03-11 Mandarin Gallery Singapore 238897
              								</small></small>
              							</p>
              						</td></tr>
              						<tr><td valign="top" align="left" height="20"></td></tr>
              					</tbody></table>
              				</td></tr></tbody></table>
              			</td></tr></tbody></table>
              		</td></tr>
              	</tbody></table>
              	<!-- <script type="text/javascript">
              		[].forEach.call(document.querySelectorAll("*"), function(a){a.style.outline="1px solid green";})
              	</script> -->
              </body>
              `;
              $mail->AltBody = 'Your reset code is : '.$codeGenerate;
              $mail->send();
              $status = "Success";
              $pesan = "Code sended! Check your email and enter the code";
              $daJson["email"] = $email;
            } catch (Exception $e){
              $pesan = "Error! mail cannot send message. Error: {$mail->ErrorInfo}";
            }
          }
        }
      }
    }
  }
} else if($do == "sendcode"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security key found!";
  } else if(!isset($_POST["email"])){
    $pesan = "Error! no email detected!";
  } else if(!isset($_POST["code"])){
    $pesan = "Error! no code detected!";
  } else {
    $hash = $_POST["hash"];
    $mail = $_POST["email"];
    $code = $_POST["code"];
    if($hash == ""){
      $pesan = "Sorry! security code cannot be empty!";
    } else if($mail == ""){
      $pesan = "Sorry! email cannot be empty!";
    } else if($code == ""){
      $pesan = "Sorry! code cannot be empty!";
    } else {
      include "config.php";
      //Hash checking
      $getHashData = $conn->query("SELECT * FROM apihash WHERE apihash_hash = '".$hash."' ");
      $countHashData = $getHashData->num_rows;
      if($countHashData != 1){
        $pesan = "Sorry! cannot perform this action. no security found";
      } else {
        //Get Request
        $getRequest = $conn->query("SELECT * FROM apiforget WHERE apihash_hash = '".$hash."' AND apiforget_mail = '".$mail."' ");
        $countRequest = $getRequest->num_rows;
        if($countRequest == 0){
          $pesan = "Sorry! no request with this email";
        } else {
          //Check request date and status
          $getRequest1 = $conn->query("SELECT * FROM apiforget WHERE apihash_hash = '".$hash."' AND apiforget_mail = '".$mail."' AND apiforget_date = NOW() AND apiforget_status = 'active' ");
          $countRequest1 = $getRequest1->num_rows;
          if($countRequest1 == 0){
            $pesan = "Sorry! this request is expired";
          } else if($countRequest1 >= 2){
            //If more than one request active
            $pesan = "Sorry! there was an error. Please try again";
          } else {
            //Request found and Init Request
            $fetchRequest = $getRequest1->fetch_assoc();
            $requestID = $fetchRequest["apiforget_id"];
            $requestCode = $fetchRequest["apiforget_otp"];
            $requestTry = $fetchRequest["apiforget_trytimes"];
            //Attempt checker
            if($requestTry >= 4){
              $pesan = "Sorry! too many attempt detected. Aborting";
            } else {
              //Code match checker
              if($requestCode != $code){
                $requestTryNow = $requestTry + 1;
                $conn->query("UPDATE apiforget SET apiforget_trytimes = '".$requestTryNow."' WHERE apiforget_id = '".$requestID."' ");
                $pesan = "Sorry! Code does not match";
              } else {
                //Code match and change status
                $conn->query("UPDATE apiforget SET apiforget_status = 'permited' WHERE apiforget_id = '".$requestID."'");
                $status = "Success";
                $pesan = "Code match, fill new password";
                $daJson["email"] = $email;
              }
            }
          }
        }
      }
    }
  }
} else if($do == "changepass"){
  if(!isset($_POST["hash"])){
    $pesan = "Error! no security input found!";
  } else if(!isset($_POST["email"])){
    $pesan = "Error! no email input found!";
  } else if(!isset($_POST["newpass"])){
    $pesan = "Error! no password input found!";
  } else {
    $hash = $_POST["hash"];
    $email = $_POST["email"];
    $newpass = $_POST["newpass"];
    if($hash == ""){
      $pesan = "Sorry! security key cannot be empty!";
    } else if($email == ""){
      $pesan = "Sorry! email cannot be empty!";
    } else if($newpass == ""){
      $pesan = "Sorry! new password cannot be empty!";
    } else {
      include "config.php";
      //Get request data
      $getRequest = $conn->query("SELECT * FROM apiforget WHERE apihash_hash = '".$hash."' AND apiforget_email = '".$email."' AND apiforget_status = 'permited' AND apiforget_date = NOW() ");
      $countRequest = $getRequest->num_rows;
      if($countRequest != 1){
        $pesan = "Sorry! no request found or request not completed yet";
      } else {
        $fetchRequest = $getRequest->fetch_assoc();
        $requestID = $fetchRequest["apiforget_id"];
        $conn->query("UPDATE apiforget SET apiforget_status = 'completed' WHERE apiforget_id = '".$requestID."' ");
        //Pass Hashed
        $passHash = hash('sha256',$newpass);
        //Change Password
        $conn->query("UPDATE masterpelanggan SET password = '".$passHash."' WHERE email = '".$email."' ");
        $status = "Success";
        $pesan = "Password changed! please login with your new password";
      }
    }
  }
} else {
  $pesan = "Error! there was an error with the parameter action!";
}
$daJson["message"] = $pesan;
$daJson["status"] = $status;
$printJson = json_encode($daJson);
echo $printJson;
exit();
?>
