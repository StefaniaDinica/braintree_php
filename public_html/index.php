<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>

<body>
    <div class="routes-container">
        <ul class="routes">
            <li><button id="donations-page-link">Go to Donations Page</button></li>
            <li><button id="myAccount-page-link">Go to MyAccount Page</button></li>
            <li><button id="generate-document">Generate Document</button></li>
        </ul>
    </div>
    <div id="donations-page">
        <div class="donations-wrapper">
            <div id="donation-forms" class="checkout container">
                <form id="form-selector">
                    <ul id="list-selector-plan">
                        <li>
                            <input type="radio" id="selector-plan-monthly" name="item-selector-plan" checked="true">
                            <label for="selector-plan-monthly">Lunar</label>
                        </li>
                        <li>
                            <input type="radio" id="selector-plan-once" name="item-selector-plan">
                            <label for="selector-plan-once">Singular</label>
                        </li>
                    </ul>

                    <ul id="list-selector-amount">
                        <li>
                            <input type="radio" id="selector-amount-5" name="item-selector-amount" checked="true" data-amount="5">
                            <label for="selector-amount-5">5 Euro</label>
                        </li>
                        <li>
                            <input type="radio" id="selector-amount-10" name="item-selector-amount" data-amount="10">
                            <label for="selector-amount-10">10 Euro</label>
                        </li>
                        <li>
                            <input type="radio" id="selector-amount-25" name="item-selector-amount" data-amount="25">
                            <label for="selector-amount-25">25 Euro</label>
                        </li>
                        <li>
                            <input type="radio" id="selector-amount-50" name="item-selector-amount" data-amount="50">
                            <label for="selector-amount-50">50 Euro</label>
                        </li>
                        <li>
                            <input type="radio" id="selector-amount-other" name="item-selector-amount">
                            <label for="selector-amount-other">Alta suma</label>
                        </li>
                    </ul>

                    <div id="input-amount" class="form-group">
                        <input type="number" placeholder="€ Introduceți suma dorită în Euro" />
                        <span class="input-error">Te rugam sa introduci o suma valida</span>
                    </div>

                    <div id="input-email" class="form-group">
                        <input type="text" placeholder="Introduceți email-ul" />
                        <span class="input-error">Te rugam sa introduci un email valid</span>
                    </div>

                    <p>Total: <span class="text-amount">0</span>.00 €</p>

                    <div id="recaptcha" class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                        <span class="input-error">Te rugăm să validezi casuta</span>
                    </div>

                    <button type="submit">Doneaza <span class="text-amount">0</span>.00 € <span id="frequency">/ luna</span></button>
                </form>

                <form id="form-payment">
                    <div id="loader-dropin" class="lds-default center">
                        <div></div><div></div><div></div>
                        <div></div><div></div><div></div>
                        <div></div><div></div><div></div>
                        <div></div><div></div><div></div>
                    </div>

                    <div id="bt-dropin-wrapper" class="bt-drop-in-wrapper">
                        <div id="bt-dropin-simple"></div>
                        <div id="bt-dropin-recurr"></div>
                        <button id="button-dropin" class="hide" type="submit"><span>Plateste</span></button>
                    </div>
                </form>
            </div>
            <div id="loader-payment" class="lds-default center hide">
                <div></div><div></div><div></div>
                <div></div><div></div><div></div>
                <div></div><div></div><div></div>
                <div></div><div></div><div></div>
            </div>
            <div id="donation-result" class="checkout container">
            </div> 
        </div>
    </div>



    <div class="my-account-wrapper" id="myAccount-page">
        <div class="form-account-email">
            <div id="input-account-email" class="form-group">
                <input type="email" placeholder="Type email" size="25"></input>
                <span class="input-error">Please type an email</span>
            </div>
            <button id="search-subscriptions">Find subscriptions</button>
        </div>
        <h3 id="result-message" class="result-message"></h3>
        <div id="loader-subscription" class="lds-default center hide">
            <div></div><div></div><div></div>
            <div></div><div></div><div></div>
            <div></div><div></div><div></div>
            <div></div><div></div><div></div>
        </div>
        <div id="subscriptions-wrapper" class="subscriptions-wrapper">
            <h3>Subscriptions</h3>
            <ul id="subscriptions-list" class="subscriptions-list">
            </ul>
        </div>
    </div>

    <div id="modal" class="modal">
        <div id="modal-content" class="modal-content">
            <span class="close">&times;</span>
        </div>
    </div>

    <!-- Load the Drop-in component -->
    <script src="https://js.braintreegateway.com/web/dropin/1.30.1/js/dropin.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.78.3/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.78.3/js/data-collector.min.js"></script>
    <!-- Load the 3D Secure component. -->
    <script src='https://js.braintreegateway.com/web/3.78.3/js/three-d-secure.min.js'></script>
    <!-- Load the Hosted Fields component. -->
    <script src='https://js.braintreegateway.com/web/3.78.3/js/hosted-fields.min.js'></script>
    
    <!-- Captcha -->
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script src="javascript/jquery.min.js"></script>
    <script src="javascript/inits.js"></script>
    <script src="javascript/donationForms.js"></script>
    <script src="javascript/payment.js"></script>
    <script src="javascript/myAccount.js"></script>
    <script src="javascript/modal.js"></script>
</body>
</html>
