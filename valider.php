<?php
require_once 'config.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['id_national'])) {
    echo json_encode(["success" => false, "message" => "Veuillez entrer un ID"]);
    exit;
}

$id = $data['id_national'];
$bureau = $data['bureau_id'] ?? "Non spécifié";

try {
    $stmt = $pdo->prepare("SELECT nom_complet, a_vote FROM electeurs WHERE id_national = ?");
    $stmt->execute([$id]);
    $electeur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$electeur) {
        echo json_encode(["success" => false, "message" => "Électeur introuvable dans la base"]);
    } elseif ($electeur['a_vote'] == 1) {
        echo json_encode(["success" => false, "message" => "ALERTE : Cet électeur a déjà voté !"]);
    } else {
        $update = $pdo->prepare("UPDATE electeurs SET a_vote = 1, date_vote = NOW(), bureau_id = ? WHERE id_national = ?");
        $update->execute([$bureau, $id]);
        echo json_encode(["success" => true, "message" => "Vote validé pour " . $electeur['nom_complet']]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur technique"]);
}
?>