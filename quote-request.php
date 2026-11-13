<?php
/**
 * Handles the cruise quote, travel quote and call-back forms.
 * - Emails the request to notify_email (config.php)
 * - Optionally forwards it to a GoHighLevel inbound webhook
 * Returns JSON for the on-page form, or redirects back when JS is off.
 * PHP 7.4+ compatible.
 */
$cfg = require __DIR__ . '/config.php';
session_start();

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'fetch';

function finish($ok, $error, $isAjax) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('ok' => $ok, 'error' => $error));
    } else {
        header('Location: index.php?sent=' . ($ok ? '1' : '0'));
    }
    exit;
}
function field($key, $max = 300) {
    $v = isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
    $v = str_replace(array("\r", "\n"), ' ', $v);           // no header injection
    return mb_substr($v, 0, $max);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { finish(false, 'Invalid request.', $isAjax); }

// Spam: honeypot + simple rate limit (one submission per 20 seconds per visitor)
if (field('website') !== '') { finish(true, '', $isAjax); }
if (isset($_SESSION['last_quote']) && time() - $_SESSION['last_quote'] < 20) {
    finish(false, 'Please wait a moment before sending again.', $isAjax);
}

$types = array('cruise' => 'Cruise Quote Request', 'quote' => 'Travel Quote Request', 'callback' => 'Call-Back Request');
$type  = field('form_type', 20);
if (!isset($types[$type])) { $type = 'quote'; }

$data = array(
    'Name'             => field('name', 120),
    'Email'            => field('email', 160),
    'Phone'            => field('phone', 40),
    'Trip type'        => $type === 'cruise' ? 'Cruise' : field('trip_type', 60),
    'Destination'      => field('destination', 160),
    'Cruise line'      => field('cruise_line', 80),
    'Sailing month'    => field('sailing_month', 20),
    'Stateroom'        => field('stateroom', 40),
    'Travel dates'     => field('dates', 120),
    'Travellers'       => field('travellers', 120),
    'Best time to call'=> field('best_time', 40),
    'Message'          => isset($_POST['message']) ? mb_substr(trim((string)$_POST['message']), 0, 2000) : '',
);

if ($data['Name'] === '' || !filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
    finish(false, 'Please enter your name and a valid email address.', $isAjax);
}
if ($type === 'callback' && $data['Phone'] === '') {
    finish(false, 'Please enter a phone number so we can call you back.', $isAjax);
}

// ---- Email ----
$subject = $types[$type] . ' — ' . $data['Name'] . ' (sunclubtravel.com)';
$body = $types[$type] . " from the SunClub Travel website\n" . str_repeat('-', 48) . "\n";
foreach ($data as $k => $v) {
    if ($v !== '') { $body .= str_pad($k . ':', 20) . $v . "\n"; }
}
$body .= "\nSubmitted: " . date('Y-m-d H:i') . "\nPage: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '') . "\n";

$headers  = 'From: SunClub Website <' . $cfg['from_email'] . ">\r\n";
$headers .= 'Reply-To: ' . $data['Name'] . ' <' . $data['Email'] . ">\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$mailed = @mail($cfg['notify_email'], '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

// ---- GoHighLevel webhook (optional) ----
$pushed = false;
if (!empty($cfg['ghl_webhook_url']) && function_exists('curl_init')) {
    $parts = explode(' ', $data['Name'], 2);
    $payload = array(
        'first_name'   => $parts[0],
        'last_name'    => isset($parts[1]) ? $parts[1] : '',
        'email'        => $data['Email'],
        'phone'        => $data['Phone'],
        'source'       => 'sunclubtravel.com - ' . $types[$type],
        'form_type'    => $type,
        'trip_type'    => $data['Trip type'],
        'destination'  => $data['Destination'],
        'cruise_line'  => $data['Cruise line'],
        'sailing_month'=> $data['Sailing month'],
        'stateroom'    => $data['Stateroom'],
        'travel_dates' => $data['Travel dates'],
        'travellers'   => $data['Travellers'],
        'best_time'    => $data['Best time to call'],
        'message'      => $data['Message'],
    );
    $ch = curl_init($cfg['ghl_webhook_url']);
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 8,
    ));
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $pushed = ($code >= 200 && $code < 300);
}

// Backup log (outside public view via .htaccess) so no lead is ever lost
$logDir = __DIR__ . '/data';
if (!is_dir($logDir)) { @mkdir($logDir, 0750, true); }
@file_put_contents($logDir . '/leads.csv',
    '"' . implode('","', array_map(function ($v) { return str_replace('"', '""', $v); }, array_merge(array(date('c'), $type), array_values($data)))) . "\"\n",
    FILE_APPEND | LOCK_EX);

$_SESSION['last_quote'] = time();

if ($mailed || $pushed) { finish(true, '', $isAjax); }
finish(false, 'We could not send your request right now. Please call 1-877-691-3551.', $isAjax);
