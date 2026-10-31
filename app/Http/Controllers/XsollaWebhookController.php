<?php

namespace App\Http\Controllers;

use App\Services\Gateways\XsollaGateway;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class XsollaWebhookController extends Controller
{
    public function __invoke(Request $request, XsollaGateway $xsollaGateway): Response
    {
        return $xsollaGateway->handleWebhook(
            $request->getContent(),
            $request->header('Authorization'),
        );
    }
}

