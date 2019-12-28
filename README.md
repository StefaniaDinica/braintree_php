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
