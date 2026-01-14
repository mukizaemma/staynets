<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #0071c2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .booking-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #0071c2;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .reference-number {
            background-color: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            margin: 15px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #0071c2;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Confirmation</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $user->name }},</p>
        <p>Thank you for your booking! We have received your reservation request and will contact you soon to confirm your booking.</p>
        
        <div class="reference-number">
            Your Booking Reference: {{ $booking->reference_number }}
        </div>
        
        <div class="info-box">
            <strong>Important:</strong> Please keep this reference number for your records. You will need it for any inquiries about your booking.
        </div>
        
        <div class="booking-details">
            <h3>Booking Summary</h3>
            
            @if($booking->property)
            <div class="detail-row">
                <span class="detail-label">Property:</span>
                <span class="detail-value">{{ $booking->property->name }}</span>
            </div>
            @endif
            
            @if($booking->unit)
            <div class="detail-row">
                <span class="detail-label">Room/Unit:</span>
                <span class="detail-value">{{ $booking->unit->name }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Check-in Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Check-out Date:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Number of Nights:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} nights</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Number of Guests:</span>
                <span class="detail-value">{{ $booking->guests_count }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value"><strong>${{ number_format($booking->total_amount, 2) }}</strong></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Booking Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-pending">{{ ucfirst($booking->booking_status) }}</span>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value">{{ ucfirst($booking->payment_status) }}</span>
            </div>
        </div>
        
        <div class="info-box">
            <p><strong>What's Next?</strong></p>
            <p>Our team will review your booking and contact you within 24 hours to confirm availability and provide payment instructions.</p>
        </div>
        
        <p>If you have any questions or need to make changes to your booking, please contact us using your booking reference number.</p>
        
        <p>Thank you for choosing us!</p>
        <p>Best regards,<br>The Accommodation Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated confirmation email. Please do not reply to this email.</p>
        <p>For inquiries, please contact: info@iremetech.com</p>
    </div>
</body>
</html>


