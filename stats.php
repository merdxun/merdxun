<?php
require_once 'config.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    $total_votes = $pdo->query("SELECT COUNT(*) FROM electeurs WHERE a_vote = 1")->fetchColumn();
    $total_inscrits = $pdo->query("SELECT COUNT(*) FROM electeurs")->fetchColumn();
    $dernier = $pdo->query("SELECT nom_complet, bureau_id FROM electeurs WHERE a_vote = 1 ORDER BY date_vote DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "total_votes" => (int)$total_votes,
        "total_inscrits" => (int)$total_inscrits,
        "dernier_nom" => $dernier ? $dernier['nom_complet'] : "---",
        "dernier_bureau" => $dernier ? $dernier['bureau_id'] : "---"
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => true]);
}
?>