<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

class Email
{
    public static function sendBookingConfirmation($toEmail, $userName, $details)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Password = getenv('MAIL_PASSWORD');
            $mail->Username = getenv('MAIL_EMAIL');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('noreply@Kari.ma', 'Kari Morocco');
            $mail->addAddress($toEmail, $userName);

            $mail->isHTML(true);
            $mail->Subject = "Booking Confirmed - " . $details['title'];

            $mail->Body = "
                <div style='font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px;'>
                    <h2 style='color: #22d3ee;'>Marhaba, {$userName}!</h2>
                    <p>Your booking at <strong>{$details['title']}</strong> is confirmed.</p>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <p><strong>Location:</strong> {$details['location']}</p>
                    <p><strong>Check-In:</strong> {$details['start']}</p>
                    <p><strong>Check-Out:</strong> {$details['end']}</p>
                    <h3 style='color: #333;'>Total Paid: {$details['price']} DH</h3>
                    <p style='font-size: 12px; color: #777;'>Thank you for choosing Kari for your stay in Morocco!</p>
                </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
