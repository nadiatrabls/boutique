<?php
namespace Boutique\Controllers;

use Boutique\Models\CommandesModel;


class TrackingController extends Controller
{
    /**
     * ✅ Affichage de la page de suivi des commandes
     */
    public function index()
    {
        $this->render('tracking');
    }

    /**
     * ✅ Suivi de la commande via Ajax
     */
    public function trackOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = isset($_POST['order_id']) ? htmlspecialchars(trim($_POST['order_id'])) : null;
            $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;

            // Validation des champs
            if (empty($orderId) || empty($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
                exit;
            }

            // Récupération des détails de la commande
            $commandesModel = new CommandesModel();
            $orderDetails = $commandesModel->getOrderTrackingDetails($orderId, $email);

            // Vérification de l'existence de la commande
            if ($orderDetails) {
                // Définir les étapes du suivi
                $steps = [];
                if ($orderDetails->status === 'confirmée') {
                    $steps = [1];
                    $message = "Votre commande a été confirmée.";
                } elseif ($orderDetails->status === 'en préparation') {
                    $steps = [1, 2];
                    $message = "Votre commande est en cours de préparation.";
                } elseif ($orderDetails->status === 'expédiée') {
                    $steps = [1, 2, 3];
                    $message = "Votre commande a été expédiée.";
                } elseif ($orderDetails->status === 'livrée') {
                    $steps = [1, 2, 3, 4];
                    $message = "Votre commande a été livrée.";
                } else {
                    $message = "Statut de commande inconnu.";
                }

                echo json_encode([
                    'status' => 'found',
                    'steps' => $steps,
                    'message' => $message
                ]);
            } else {
                echo json_encode(['status' => 'not_found', 'message' => 'Commande introuvable.']);
            }
            exit;
        } else {
            http_response_code(405); // Méthode non autorisée
            exit;
        }
    }
}
