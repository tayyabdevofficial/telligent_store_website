# Stripe Webhook Setup Guide

This project already exposes the Stripe webhook endpoint at:

`POST /webhooks/stripe`

With your current local app URL, that becomes:

`http://127.0.0.1:8000/webhooks/stripe`

For production, replace the domain with your live HTTPS domain.

## 1. Set the Stripe keys in `.env`

Add these values:

```env
STRIPE_PUBLISHABLE_KEY=pk_test_xxxxx
STRIPE_SECRET_KEY=sk_test_xxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxx
```

Then clear config cache if needed:

```powershell
php artisan config:clear
```

## 2. Create the webhook endpoint in Stripe

According to Stripe's current Workbench webhook flow, open the Webhooks area in the Stripe Dashboard:

`https://dashboard.stripe.com/webhooks`

Then:

1. Click `Create new destination`.
2. Choose `Events on your account`.
3. Select these event types:
   - `checkout.session.completed`
   - `checkout.session.async_payment_succeeded`
   - `checkout.session.async_payment_failed`
   - `checkout.session.expired`
4. Choose `Webhook`.
5. Enter your endpoint URL:
   - Local with Stripe CLI forwarding: `http://127.0.0.1:8000/webhooks/stripe`
   - Production: `https://your-domain.com/webhooks/stripe`
6. Create the destination.

Stripe will show a signing secret that starts with `whsec_...`. Put that value into:

`STRIPE_WEBHOOK_SECRET`

## 3. Local testing with Stripe CLI

Stripe's docs recommend the CLI for local webhook testing.

Install and log in to Stripe CLI, then run:

```powershell
stripe listen --forward-to 127.0.0.1:8000/webhooks/stripe
```

Stripe CLI prints a webhook signing secret. For local testing, copy that secret into `.env` as:

```env
STRIPE_WEBHOOK_SECRET=whsec_xxxxx
```

Then clear config:

```powershell
php artisan config:clear
```

## 4. Trigger a real test payment

Start your Laravel app and go through checkout from the website.

Use Stripe's standard test card:

- Card number: `4242 4242 4242 4242`
- Any future expiry date
- Any 3-digit CVC
- Any postal code

## 5. What this app does when Stripe calls the webhook

The webhook handler is here:

[`app/Http/Controllers/StripeWebhookController.php`](d:/Freelancing/Local/Abdul%20Rehman%20(SKP)/telligent_store/app/Http/Controllers/StripeWebhookController.php)

Business logic is here:

[`app/Services/StripeCheckoutService.php`](d:/Freelancing/Local/Abdul%20Rehman%20(SKP)/telligent_store/app/Services/StripeCheckoutService.php)

When Stripe sends the selected Checkout events, the app updates:

- payment status
- Stripe session/payment IDs
- order status
- stored webhook payload data

## 6. Production checklist

Before going live:

1. Use your live Stripe keys instead of test keys.
2. Register the live HTTPS webhook endpoint in Stripe.
3. Use the live `whsec_...` signing secret in production `.env`.
4. Confirm your server returns `200` for successful webhook deliveries.
5. Review event deliveries in Stripe Dashboard if any webhook attempts fail.

## Official Stripe references

These steps are based on current official Stripe docs:

- Workbench event destinations: https://docs.stripe.com/workbench/event-destinations
- Checkout fulfillment/webhook events: https://docs.stripe.com/checkout/fulfillment
- Checkout lifecycle: https://docs.stripe.com/payments/checkout/how-checkout-works
