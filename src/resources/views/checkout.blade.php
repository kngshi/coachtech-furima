<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var sessionId = '{{ $session_id }}';

        stripe.redirectToCheckout({ sessionId: sessionId }).then(function (result) {
            if (result.error) {
                console.error(result.error.message);
            }
        });
    </script>
</body>
</html>