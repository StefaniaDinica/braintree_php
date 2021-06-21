var threeDSecure;
var bin;

var processPaymentResponse = function(response) {
  $("#donation-forms").hide();
  if (response.success == true) {
    $("#donation-result").text("Tranzactia a fost procesata cu succes.");
  } else {
    $("#donation-result").text("Tranzactia nu a putut fi procesata.");
    console.log(response.errorString);
  }
  $("#loader-payment").hide();
  $("#donation-result").show();
};

var processNonceFromTokenResponse = function(response) {
  threeDSecure.verifyCard({
    amount: $(".text-amount").first().text(),
    nonce: response.nonce,
    bin: bin
    // challengeRequested: true
  }, function (err, res) {
    // Send response.nonce to your server for use in your integration
    if (err) {
      console.log(err);
      $("#form-payment").hide();
      $("#donation-result").text("Tranzactia nu a putut fi procesata.");
      $("#loader-payment").hide();
      $("#donation-result").show();
      return;
    }

    $.post(
      "recurrentPayment.php",
      {
        amount: $(".text-amount")
          .first()
          .text(),
        email: $("#input-email input").val(),
        payment_method_nonce: res.nonce
      },
      processPaymentResponse,
      "json"
    );
  });
};

var processDropInCreation = function(createErr, instance) {
  if (createErr) {
    console.log("Create Error", createErr);
    $("#donation-result").text("Momentan nu pot fi efectuate plati.");
    $("#loader-payment").hide();
    $("#donation-result").show();
    return;
  }

  $("#loader-payment").hide();
  $("#form-payment").show();

  $("#loader-dropin").hide();
  $("#button-dropin").show();

  $("#form-payment").submit(function(event) {
    event.preventDefault();

    instance.requestPaymentMethod({
        threeDSecure: {
          amount: $(".text-amount").first().text(),
          email: $("#input-email input").val()
        }
      },
      function(err, payload) {
        if (err) {
          $("#form-payment").hide();
          $("#donation-result").text("Tranzactia nu a putut fi procesata.");
          $("#donation-result").show();
          return;
        }

        bin = payload.details.bin;

        if ($("#selector-plan-monthly").is(":checked")) {
          $.post(
            "nonceFromToken.php",
            {
              email: $("#input-email input").val(),
              payment_method_nonce: payload.nonce
            },
            processNonceFromTokenResponse,
            "json"
          );
        } else if ($("#selector-plan-once").is(":checked")) {
          $.post(
            "simplePayment.php",
            {
              amount: $(".text-amount")
                .first()
                .text(),
              email: $("#input-email input").val(),
              payment_method_nonce: payload.nonce,
            },
            processPaymentResponse,
            "json"
          );
        }
        $("#loader-payment").show();
        $("#form-payment").hide();
      }
    );
  });
};

var processClientToken = function(response) {
  $("#form-selector").submit(function(event) {
    event.preventDefault();
  
    var emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var errors = false;
    
    if (emailReg.test($("#input-email input").val())) {
      $("#input-email .input-error").hide();
    } else {
      $("#input-email .input-error").show();
      errors = true;
    }
  
    if ($(".text-amount").first().text() != "0") {
      $("#input-amount .input-error").hide();
    } else {
      $("#input-amount .input-error").show();
      errors = true;
    }

    var captchaResponse = grecaptcha.getResponse();
    if (captchaResponse.length == 0) {
      errors = true;
      $("#recaptcha .input-error").show();
    } else {
      $("#recaptcha .input-error").hide();
    }
  
    if (!errors) {
      $("#form-selector").hide();
      $("#loader-payment").show();

      if ($("#selector-plan-monthly").is(":checked")) {
        braintree.dropin.create(
          {
            authorization: response.token,
            selector: "#bt-dropin-recurr",
            card: {
              cardholderName: {
                required: true
									}
								},
            paypal: {
              flow: "vault"
            }
          },
          processDropInCreation
        );
      } else if ($("#selector-plan-once").is(":checked")) {
        braintree.dropin.create(
            {
              authorization: response.token,
              selector: "#bt-dropin-simple",
              card: {
              cardholderName: {
                required: true
									}
								},
              paypal: {
                flow: "vault"
              },
              threeDSecure: true
            },
            processDropInCreation
          );
      }
    }
  });

  braintree.client.create({
    authorization: response.token
  }, function (err, clientInstance) {
    braintree.threeDSecure.create({
      version: 2, // Will use 3DS 2 whenever possible
      client: clientInstance
    }, function (threeDSecureErr, threeDSecureInstance) {
      if (threeDSecureErr) {
        // Handle error in 3D Secure component creation
        console.log("ERROR create threeDS" + threeDSecureErr);
        return;
      }

      threeDSecureInstance.on('lookup-complete', function (data, next) {
        // inspect the data
        // call next when ready to proceed with the challenge
        next();
      });
  
      threeDSecure = threeDSecureInstance;
    });
  });
};

$.get("clientToken.php", processClientToken, "json");
