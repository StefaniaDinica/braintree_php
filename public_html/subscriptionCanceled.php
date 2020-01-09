<?php require_once("cancelSubscription.php"); ?>

<html>
<?php require_once("../includes/head.php"); ?>
<body>
    <div class="wrapper">
      <div class="container">
      <p><?php echo $cancelSubscriptionMessage; ?></p>
      </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.21.0/js/dropin.min.js"></script>
    <script src="javascript/jquery.min.js"></script>
</body>
</html>
