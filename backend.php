<?php
require 'brandingevenuepanel_new/admin/config.php';
require 'brandingevenuepanel_new/admin/functions.php';
require 'php-mailer/php-mailer/src/Exception.php';
require 'php-mailer/php-mailer/src/PHPMailer.php';
require 'php-mailer/php-mailer/PHPMailerAutoload.php';
require 'php-mailer/php-mailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['submit']) && !empty($_POST['submit'])){
    $mail = new PHPMailer();
    $AllRows = array();
  	// $targetDir = "uploads";
    // $Link = '';
    // if(is_array($_FILES)) {
    //     if(is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
    //     {
    //         $AllowedExtentions = array('gif', 'png', 'jpg', 'doc', 'docx','odt','pdf','xls','xlsx','ppt','pptx','txt');
    //         $filename = $_FILES['fileToUpload']['name'];
    //         $ext = pathinfo($filename, PATHINFO_EXTENSION);
    //         if (in_array($ext, $AllowedExtentions)) {
    //             if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],"$targetDir/".$_FILES['fileToUpload']['name'])) {

    //                 $Link = "https://creationsquare.com/websitebrief/$targetDir/".$_FILES['fileToUpload']['name'];
    //             }
    //         }
            
    //     }
    // }
    foreach($_POST as $Index=>$Value){
        if($Index != 'submit'){
            if(is_array($Value)){
                $AllRows[] =  sprintf('<tr><th>%s</th><td><strong>%s<strong></td></tr>',$Index,implode(" | ",$Value));
            }else{
                $AllRows[] = sprintf('<tr><th>%s</th><td>%s</td></tr>',$Index,$Value);

            }
            
        }
    }
    $site_name = 'Panther Dispatch';
     $to = "mirzauzair558@gmail.com";
    //$to = "shahwarafzal123@gmail.com";
             $mail->isSMTP();                                      // Set mailer to use SMTP
             $mail->Host = 'smtp-relay.sendinblue.com';                  // Specify main and backup SMTP servers, example: smtp1.example.com;smtp2.example.com
             $mail->SMTPAuth = true;                               // Enable SMTP authentication
             $mail->Username = 'younas@intersoftbpo.com';                    // SMTP username
             $mail->Password = 'rydmkhtXSnTB1YR4';                    // SMTP password
             $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
             $mail->Port = 587;                                    // TCP port to connect to
             //$mail = new PHPMailer;
             $mail->IsHTML(true);                                    // Set email format to HTML
             $mail->CharSet = 'UTF-8';

             $mail->From = 'notification@mercuryenterprisesltd.com';
             $mail->FromName = 'Creation Square';

             if(strpos($to, ',') !== false){
                 $email_addresses = explode(',', $to);
                 foreach($email_addresses as $email_address) {
                     $mail->AddAddress(trim($email_address));
                 }
             }
             else {$mail->AddAddress($to);}

             $mail->AddReplyTo($to, 'Creation Square');
             $mail->Subject = 'New Brief Form Submitted';
             $mail->Body = sprintf("

                <html>

                <head>

                <style>

                .container {
                	background: rgb(238, 238, 238);
                	padding: 80px;

                }

                @media only screen and (max-device-width: 690px) {

                .container {
                	background: rgb(238, 238, 238);
                width:100%%;
                padding:1px;

                }

                }

                .box {
                	background: #fff;
                	margin: 0px 0px 30px;
                	padding: 8px 20px 20px 20px;
                	border:1px solid #e6e6e6;
                	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);

                }

                .lead {
                	font-size:16px;

                }

                .btn{
                	background:#428bca;
                	margin-top:20px;
                	color:white !important;
                	text-decoration:none;
                	padding:10px 16px;
                	font-size:18px;
                	border-radius:3px;

                }

                hr{
                	margin-top:20px;
                	margin-bottom:20px;
                	border:1px solid #eee;

                }

                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                  }
                  th, td {
                    padding: 5px;
                    text-align: left;
                  }


                </style>

                </head>

                <body class='is-responsive'>

                <div class='container'>

                <div class='box'>

                <center>

                <img src='mainlogo.png' width='150' width='150'>

                <h2>%s</h2>

                <h3>New Website Brief Form Submitted</h3>

                </center>

                <hr>

                <p class='lead'> Dear Team, Below are the details of the website brief form: </p>

                <table style=\"width:100%%\">   
                    %s
                    <tr>
                    <th>Uploaded File</th>
                    <td>%s</td>
                    </tr>
                </table>
                </div>

                </div>

                </body>

                </html>",$site_name,implode(' ',$AllRows),sprintf('<a href="%s">Get File</a>',$Link));
             if($mail->Send()) {
                header("Location: https://creationsquare.com/success");
             }else {
                 echo 'Cant sent data to  team';
             }

    
    
}

?>