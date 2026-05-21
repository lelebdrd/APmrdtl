<?php
session_start();
if (!isset($_SESSION['connect']) || !isset($_SESSION['id'])) {
    header('Location: ../../index.php');
    exit;
}

ob_start();// m'a permis de faire marcher le pdf

require('../../back_end/include/_inc_parametres.php');
require('../../back_end/include/_inc_connexion.php');

// Récupère les inscrits non-présents aux animations d'aujourd'hui
$aujourd_hui = date('Y-m-d');
$req_pre = $cnx->prepare("
    SELECT
        ins.nom,
        ins.prenom,
        ins.classe,
        a.Titre,
        a.DateHeureDeb,
        a.DateHeureFin
    FROM inscription i
    INNER JOIN inscrit ins  ON ins.ID = i.id_inscrit
    INNER JOIN animation a  ON a.ID   = i.id_animation
    WHERE DATE(a.DateHeureDeb) = :aujourd_hui
      AND i.presence = FALSE
    ORDER BY a.DateHeureDeb ASC, ins.nom ASC
");
$req_pre->bindValue(':aujourd_hui', $aujourd_hui, PDO::PARAM_STR);
$req_pre->execute();
$absents = $req_pre->fetchAll(PDO::FETCH_OBJ);

require('../../back_end/include/fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Absents aux animations - ' . date('d/m/Y'), 0, 1, 'C');
$pdf->Ln(4);

if (empty($absents)) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aucun absent aujourd\'hui.', 0, 1);
} else {
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(40, 8, 'Nom',       1, 0, 'L', true);
    $pdf->Cell(40, 8, 'Prénom',    1, 0, 'L', true);
    $pdf->Cell(15, 8, 'Classe',    1, 0, 'C', true);
    $pdf->Cell(60, 8, 'Animation', 1, 0, 'L', true);
    $pdf->Cell(35, 8, 'Horaire',   1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);
    foreach ($absents as $absent) {
        $horaire = date('H:i', strtotime($absent->DateHeureDeb))
                 . '-'
                 . date('H:i', strtotime($absent->DateHeureFin));

        $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1', $absent->nom),    1, 0, 'L');
        $pdf->Cell(40, 7, iconv('UTF-8', 'ISO-8859-1', $absent->prenom), 1, 0, 'L');
        $pdf->Cell(15, 7, $absent->classe ?? '-',                         1, 0, 'C');
        $pdf->Cell(60, 7, iconv('UTF-8', 'ISO-8859-1', $absent->Titre),  1, 0, 'L');
        $pdf->Cell(35, 7, $horaire,                                        1, 1, 'C');
    }
}

ob_end_clean();
$pdf->Output('D', 'absents_' . $aujourd_hui . '.pdf');
exit;