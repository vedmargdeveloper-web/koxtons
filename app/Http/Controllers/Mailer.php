<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class Mailer extends Controller
{

    public function sendMail( $array ) {
        // dd("Inside the mailer");
    	if( !isset( $array['to'], $array['name'], $array['subject'], $array['message'] ) ){
    		return false;
        }
 
        $mail = new PHPMailer(true);    // Passing `true` enables exceptions
        try {
           $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = env("MAIL_HOST");  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = env("MAIL_USERNAME");                 // SMTP username
            $mail->Password = env("MAIL_PASSWORD");                           // SMTP password
            $mail->SMTPSecure = env("MAIL_ENCRYPTION");                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = env("MAIL_PORT");                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('noreply@koxtonsmart.com', 'Koxtons Mart');
            $mail->addAddress($array['to']);     // Add a recipient
            
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $array['subject'];
            $mail->Body    = $array['message'];
            if(isset($array['files'])){
                if( is_array($array['files']) ) {
                	foreach ($array['files'] as $file) {
                		$mail->addAttachment($file);
                	}
                }
                else {
                	$mail->addAttachment($array['files']);
                }
            }
            $mail->send();

            Log::info("Mail sending failed. Error: " . $mail->ErrorInfo . ". Recipient: " . $array['to']);
            return true;
            // if (!$mail->send()) {
                
            //       return false;
            // } else {
            //    Log::info("Mail sent successfully to: " . $array['to'] . " | Subject: " . $array['subject']);
            //   return true;
            // }
           
        }
        catch (Exception $e) {
            Log::info("Mail exception: " . $e->getMessage());
            return false;
        }



    }

}
