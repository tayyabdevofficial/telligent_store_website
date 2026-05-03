<?php

namespace App\Http\Controllers;

use App\Services\StripeCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripeCheckoutService $stripeCheckoutService): Response
    {
        $stripeCheckoutService->handleWebhook($request->getContent(), $request->header('Stripe-Signature'));

        return response()->noContent();
    }
}
