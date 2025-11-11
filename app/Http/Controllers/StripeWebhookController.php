<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    //

    public function handle(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        Log::debug('Webhook event', [$event->type]);

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                Log::debug('Payment succeeded', [$paymentIntent->id]);
                break;
            case 'payment_intent.amount_capturable_updated':
                $paymentIntent = $event->data->object;
                Log::debug('Amount capturable updated', [$paymentIntent->id]);
                break;
            case 'payment_intent.canceled':
                $paymentIntent = $event->data->object;
                Log::debug('Payment canceled', [$paymentIntent->id]);
                break;
            case 'payment_intent.created':
                $paymentIntent = $event->data->object;
                Log::debug('Payment created', [$paymentIntent->id]);
                break;
            case 'payment_intent.partially_funded':
                $paymentIntent = $event->data->object;
                Log::debug('Payment partially funded', [$paymentIntent->id]);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                Log::debug('Payment failed', [$paymentIntent->id]);
                break;
            case 'payment_intent.processing':
                $paymentIntent = $event->data->object;
                Log::debug('Payment processing', [$paymentIntent->id]);
                break;
            case 'payment_intent.requires_action':
                $paymentIntent = $event->data->object;
                Log::debug('Payment requires action', [$paymentIntent->id]);
                break;
            case 'customer.subscription.created':
                $subscription = $event->data->object;
                Log::debug('Subscription created', [$subscription->id]);
                break;
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                Log::debug('Subscription deleted', [$subscription->id]);
                break;
            case 'customer.subscription.pending_update_applied':
                $subscription = $event->data->object;
                Log::debug('Subscription pending update applied', [$subscription->id]);
                break;
            case 'customer.subscription.pending_update_expired':
                $subscription = $event->data->object;
                Log::debug('Subscription pending update expired', [$subscription->id]);
                break;
            default:

                break;
        }
    }
}
