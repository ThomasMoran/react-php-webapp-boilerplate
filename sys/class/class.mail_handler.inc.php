<?php
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	require 'PHPMailer/src/Exception.php';
	require 'fpdf181/fpdf.php';
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class Mail_Handler{
		public function sendVerificationEmail($email, $verificationLink) {
			// $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			// try {
			//     //Server settings
			//     $mail->SMTPDebug = 2;                                 // Enable verbose debug output
			//     $mail->isSMTP();                                      // Set mailer to use SMTP
			//     $mail->Host = 'mail.goyeti.ie';  					  // Specify main server
			// 	$mail->SMTPAuth = true;                               // Enable SMTP authentication
			//     $mail->Username = 'noreply@goyeti.ie';                // username
			//     $mail->Password = 'DLeyJ4swQGa2';                     // password
			//     $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			//     $mail->Port = 587;                                    // TCP port to connect to

			//     //Recipients
			//     $mail->setFrom('info@goyeti.ie', 'Mailer');
			//     $mail->addAddress($email);              
			//     $mail->addReplyTo('info@goyeti.ie', 'Information');
			   
			//     //Content
			//     $mail->isHTML(true);                                  // Set email format to HTML
			//     $mail->Subject = 'GoYeti.ie - please click below to verify your identity';
			//     $mail->Body = "<a href =".$verificationLink.">".$verificationLink."</a>";
			//     $mail->AltBody = $verificationLink;

			//     $mail->send();
			//     echo 'Message has been sent';
			// } catch (Exception $e) {
			//     echo 'Message could not be sent.';
			//     echo 'Mailer Error: ' . $mail->ErrorInfo;
			// }
		}

		public function sendTicketEmail($email, $pngInputPaths) {
			// Passing `true` enables exceptions
		// 	$mail = new PHPMailer(true);    
		// 	$dest = '';

		// 	try {
		// 	    //Server settings
		// 	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		// 	    $mail->isSMTP();                                      // Set mailer to use SMTP
		// 	    $mail->Host = 'mail.goyeti.ie';  					  // Specify main server
		// 		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		// 	    $mail->Username = 'noreply@goyeti.ie';                // username
		// 	    $mail->Password = 'DLeyJ4swQGa2';                     // password
		// 	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		// 	    $mail->Port = 587;                                    // TCP port to connect to

		// 	    //Recipients
		// 	    $mail->setFrom('info@goyeti.ie', 'Mailer');
		// 	    $mail->addAddress($email);              
		// 	    $mail->addReplyTo('info@goyeti.ie', 'Information');
			   
		// 	    //Content
		// 	    $mail->isHTML(true);                                  // Set email format to HTML
		// 	    $mail->Subject = 'GoYeti.ie - your ticket is attached!';
		// 	    $mail->Body = 'Thank you for your GoYeti purchase. Please find attached your ticket, and enjoy your trip!';
		// 	    $mail->AltBody = 'Thank you for your GoYeti purchase. Please find attached your ticket, and enjoy your trip!';
				
		// 		ob_start();
		// 		foreach($pngInputPaths as $pip) {
		// 			$dest = $pip.'.pdf';
		// 		    $pdf = new FPDF();
		// 			$pdf->AddPage();
		// 			$pdf->Image($pip.'.png', 10, 6, 30);
		// 			$pdf->SetFont('Arial','B', 16);
		// 			// $pdf->Cell(0,100, $digitalTicket);
		// 			$pdf->Output('F', $dest);
		// 			ob_end_flush();

		// 			$mail->AddAttachment($dest);
		// 		}

		// 	    $mail->send();
		// 	    echo 'Message has been sent';
		// 	} catch (Exception $e) {
		// 	    echo 'Message could not be sent.';
		// 	    echo 'Mailer Error: ' . $mail->ErrorInfo;
		// 	}
		}
	}
?>