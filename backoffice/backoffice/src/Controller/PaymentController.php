<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;

class PaymentController extends AbstractController
{

    public function __construct(private CartRepository $cartRepository, private EntityManagerInterface $em)
    {

    }

    // post user 
    /**
     * @Route("/create-payment-session", name="create_payment_session", methods={"POST"})
     */
    public function createPaymentSession(Request $request): JsonResponse
    {
        // Récupérez l'ID du panier depuis la requête (ajustez cela en fonction de votre architecture)
        $cartId = $request->request->get('cart_id'); // ID du panier à payer
       
        // Récupérez le montant total du panier depuis votre base de données (en supposant que $cartId est l'ID du panier)
        $cart = $this->cartRepository->findOneBy([
            'id' => $cartId
        ]);


        if (!$cart) {
            return $this->json(['error' => 'Panier non trouvé'], 404);
        }
        //return $this->json(['success' => 'Cart found'], 200);
        // Configurez votre clé secrète Stripe
        Stripe::setApiKey('sk_test_51NjN8iJvdTH6ljbrnzuMnmBjPLSdLKx6tn3T8OowX46FZX5Rx0us6PkrjDsn7NK0yczwNfrQWvX7zdIpq9huATUK00zzmv0bKR');

        // Créez une session de paiement Stripe
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur', // Remplacez par la devise appropriée
                        'unit_amount' => $cart->getTotalAmount() * 100, // Montant total du panier en centimes
                        'product_data' => [
                            'name' => 'Panier d\'achats', // Vous pouvez personnaliser le nom ici
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://192.168.0.49:19000/Success', // Remplacez par l'URL appropriée pour le succès
            'cancel_url' => 'http://192.168.0.49:19000/Cancel', // Remplacez par l'URL appropriée pour l'annulation
        ]);
        error_log("Arun test");
        error_log($session);
        // Renvoyez l'ID de la session de paiement au client
        return $this->json(['sessionId' => $session->url]);
    }
}