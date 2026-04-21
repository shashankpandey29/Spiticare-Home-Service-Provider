<?php
header("Content-Type: application/json");

// 1. Get user message
$data = json_decode(file_get_contents("php://input"), true);
$message = strtolower(trim($data['message'] ?? ''));

// 2. Extended Knowledge Base
$knowledge = [

    // Greetings
    "greeting" => "Hey 👋 Welcome to SpitiCare Support! 
    I can help you with services, booking, payment, cancellation, pricing, and more.",

    // Services
    "services" => "SpitiCare offers Electrician, Plumber, AC Repair, Home Cleaning, Appliance Repair, and Maintenance services.",

    // Booking
    "booking"  => "Booking is easy 😊 
    Login → Select service → Choose date & time → Confirm booking.",

    // Payment
    "payment"  => "We accept UPI, Debit Card, Credit Card, Net Banking, and Cash on Service.",

    // Pricing
    "pricing" => "Service charges depend on the type of service and issue. 
    Exact price is shown before booking confirmation.",

    // Cancellation
    "cancel"   => "You can cancel or reschedule a booking up to 1 hour before the service time without any charge.",

    // Service timing
    "timing" => "Our service timings are from 9:00 AM to 9:00 PM, all days of the week.",

    // Safety
    "safety" => "All our professionals are background-verified and follow proper safety guidelines.",

    // Service areas
    "area" => "SpitiCare services are available in selected cities. 
    Please enter your location during booking to check availability.",

    // Refund
    "refund" => "Refunds (if applicable) are processed within 3–5 working days.",

    // Support
    "support"  => "You can contact our support team via this chat or call +91-XXXXXXXXXX."
];

// 3. Intent Detection Logic
function detectIntent($msg) {

    // Greeting detection
    if (preg_match("/\b(hi|hello|hey|hii|good morning|good evening)\b/", $msg))
        return "greeting";

    if (strpos($msg, "book") !== false || strpos($msg, "booking") !== false)
        return "booking";

    if (strpos($msg, "payment") !== false || strpos($msg, "pay") !== false || strpos($msg, "upi") !== false)
        return "payment";

    if (strpos($msg, "price") !== false || strpos($msg, "cost") !== false || strpos($msg, "charges") !== false)
        return "pricing";

    if (strpos($msg, "cancel") !== false || strpos($msg, "reschedule") !== false)
        return "cancel";

    if (strpos($msg, "time") !== false || strpos($msg, "timing") !== false || strpos($msg, "working hours") !== false)
        return "timing";

    if (strpos($msg, "safe") !== false || strpos($msg, "security") !== false)
        return "safety";

    if (strpos($msg, "area") !== false || strpos($msg, "location") !== false || strpos($msg, "city") !== false)
        return "area";

    if (strpos($msg, "refund") !== false || strpos($msg, "money back") !== false)
        return "refund";

    if (strpos($msg, "service") !== false || strpos($msg, "electrician") !== false || strpos($msg, "plumber") !== false)
        return "services";

    if (strpos($msg, "help") !== false || strpos($msg, "support") !== false)
        return "support";

    return "unknown";
}

// 4. Get intent
$intent = detectIntent($message);

// 5. Response Handling
if ($intent === "unknown") {
    $response = "Sorry 😔 I didn’t understand that.
    You can ask about services, booking, payment, pricing, or support.";
} else {
    $response = $knowledge[$intent];
}

// 6. Send response
echo json_encode(["reply" => $response]);
?>
