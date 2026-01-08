<?php
require '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class PDF
{
    // Pass the data array into the method
    public static function renderPDF($data, $traveler_name)
    {
        $dompdf = new Dompdf();

        $html = <<<HTML
        <div style="width: 100%; max-width: 600px; margin: auto; background: white; padding: 20px; border: 1px solid #ddd; border-radius: 15px; font-family: sans-serif;">
            
            <table style="width: 100%; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px;">
                <tr>
                    <td>
                        <h1 style="color: #22d3ee; margin: 0;">KARI</h1>
                        <p style="color: #999; font-style: italic; font-size: 12px;">Rabat, Morocco</p>
                    </td>
                    <td style="text-align: right;">
                        <h2 style="margin: 0; font-size: 18px;">BOOKING RECEIPT</h2>
                        <p style="color: #999; font-size: 12px;">Date: {$data['today']}</p>
                    </td>
                </tr>
            </table>

            <div style="margin-bottom: 20px; line-height: 1.6;">
                <p><strong>Guest Name:</strong> {$traveler_name}</p>
                <p><strong>Property:</strong> {$data['title']}</p>
                <p><strong>Location:</strong> {$data['location']}</p>
                
                <table style="width: 100%; background: #f9f9f9; padding: 15px; text-align: center; border-radius: 10px; margin: 20px 0;">
                    <tr>
                        <td style="width: 50%;">
                            <small style="color: #aaa; text-transform: uppercase;">Check-In</small><br>
                            <strong>{$data['start']}</strong>
                        </td>
                        <td style="width: 50%;">
                            <small style="color: #aaa; text-transform: uppercase;">Check-Out</small><br>
                            <strong>{$data['end']}</strong>
                        </td>
                    </tr>
                </table>

                <table style="width: 100%; border-top: 2px solid #eee; padding-top: 20px;">
                    <tr>
                        <td style="font-size: 18px;">Total Paid</td>
                        <td style="text-align: right; font-size: 24px; font-weight: bold; color: #0891b2;">{$data['price']} DH</td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; color: #ccc; font-size: 10px; margin-top: 30px;">
                <p>Thank you for booking with Kari. This is a computer-generated receipt.</p>
            </div>
        </div>
HTML;

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (ob_get_length()) ob_end_clean();
        $dompdf->stream("Receipt-Kari.pdf", ["Attachment" => true]);
    }
}