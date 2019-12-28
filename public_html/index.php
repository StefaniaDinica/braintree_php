<?php require_once("../includes/braintree_init.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>
    <div class="wrapper">
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

                <input id="input-amount" type="number" placeholder="€ Introduceți suma dorită în Euro" />

                <p>Total: <span class="text-amount">0</span>.00 €</p>

                <button type="submit">Doneaza <span class="text-amount">0</span>.00 € / luna</button>
            </form>

            <form id="form-payment">
                <div id="loader-dropin" class="lds-default center">
                    <div></div><div></div><div></div>
                    <div></div><div></div><div></div>
                    <div></div><div></div><div></div>
                    <div></div><div></div><div></div>
                </div>

                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
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

    <script src="https://js.braintreegateway.com/web/dropin/1.21.0/js/dropin.min.js"></script>
    <script src="javascript/jquery.min.js"></script>
    <script src="javascript/donationForms.js"></script>
    <script src="javascript/payment.js"></script>
</body>
</html>
