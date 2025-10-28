<?php
header('Content-Type: application/json; charset=utf-8');

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || empty($data['nom']) || empty($data['prenom']) || empty($data['telephone']) || empty($data['message'])) {
  echo json_encode(["ok" => false, "message" => "Champs manquants."]);
  exit;
}

$logDir = __DIR__ . '/storage';
if (!is_dir($logDir)) mkdir($logDir, 0777, true);
$logFile = $logDir . '/mails.log';

$message = "----- " . date('Y-m-d H:i:s') . " -----\n";
$message .= "Nom : {$data['nom']}\n";
$message .= "Prénom : {$data['prenom']}\n";
$message .= "Téléphone : {$data['telephone']}\n";
$message .= "Message : {$data['message']}\n\n";
file_put_contents($logFile, $message, FILE_APPEND);

echo json_encode(["ok" => true, "message" => "Message enregistré (local)"]);
