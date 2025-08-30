<?php
// تأكد أن السكربت يُستدعى عبر POST فقط
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(403);
  exit('Invalid request method.');
}

// helper صغير لمنع حقن الهيدر
function safe_field($v) {
  $v = trim($v ?? '');
  // منع حقن الهيدر عبر إزالة \r \n
  return str_replace(["\r", "\n"], [' ', ' '], $v);
}

// اجلب الحقول (وتوافق مع أسماء أقدم إذا لزم)
$name    = safe_field($_POST['first_name'] ?? $_POST['name'] ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$subject = safe_field($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// فاليديشن أساسية
if ($name === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  exit('Please complete all required fields correctly.');
}

// إيميل الشركة (عدّل هذا)
$recipient = 'YAFEA@ainfanati.ae';

// موضوع رسالة البريد (غير موضوع العميل للحفاظ على ترتيب الصندوق)
$mail_subject = "New Contact Form Submission — {$subject}";

// المحتوى
$body  = "You have received a new message from the website contact form:\r\n\r\n";
$body .= "Name: {$name}\r\n";
$body .= "Email: {$email}\r\n";
$body .= "Subject: {$subject}\r\n\r\n";
$body .= "Message:\r\n{$message}\r\n";

// هيدرز
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "From: Website Contact <no-reply@ainfanati.ae>\r\n"; // يُفضل دومين موقعك
$headers .= "Reply-To: {$name} <{$email}>\r\n";

// الإرسال
if (mail($recipient, $mail_subject, $body, $headers)) {
  http_response_code(200);
  echo 'Thank you! Your message has been sent.';
} else {
  http_response_code(500);
  echo "Oops! Something went wrong and we couldn't send your message.";
}
