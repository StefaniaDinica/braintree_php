# Braintree PHP Example

An example Braintree integration for PHP.

## Setup Instructions

1. Install composer within the example directory. You can find instructions on how to install composer [on composer's site](https://getcomposer.org/download/).

2. Run composer:

    ```sh
    php composer.phar install
    ```

    Or if you installed composer globally:

    ```sh
    composer install
    ```

3. Copy the contents of `example.env` into a new file named `.env` and fill in your Braintree API credentials. Credentials can be found by navigating to Account > My User > View Authorizations in the Braintree Control Panel. Full instructions can be [found on our support site](https://articles.braintreepayments.com/control-panel/important-gateway-credentials#api-credentials).

4. Start the internal PHP server on port 3000:

    ```sh
    php -S localhost:3000 -t public_html
    ```
5. Testing
- For testing card payments, you can use the credit cards from https://developers.braintreepayments.com/guides/credit-cards/testing-go-live/php
- For testing PayPal payments, you can use this account:
sb-oskmw819693@personal.example.com (pass: helloworld12)
- For entering Braintree Control Panel (https://sandbox.braintreegateway.com/merchants/ykrk46bj4w2zvf29/home), use this account:
stefaniadinica (pass: helloworld12)
- For verifying transactions, enter Braintree Control Panel > Transactions
- For verifying recurrent payments, enter Braintree Control Panel > Subscriptions
- For adding a new subscription plan, enter Braintree Control Panel > Subscriptions > Plans
- For adding a PayPal Business account to Braintree, enter Braintree Control Panel > Settings icon > Processing > Payment Methods > PayPal
