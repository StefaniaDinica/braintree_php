var processPaymentResponse = function(response) {
  $("#donation-forms").hide();
  if (response.success == true) {
    $("#donation-result").text("Tranzactia a fost procesata cu succes.");
  } else {
    errors = response.errorString ? response.errorString : "";
    $("#donation-result").text("Tranzactia nu a putut fi procesata. " + errors);
  }
  $("#loader-payment").hide();
  $("#donation-result").show();
};

var processDropInCreation = function(createErr, instance) {
  if (createErr) {
    console.log("Create Error", createErr);
    return;
  }

  $("#loader-dropin").hide();
  $("#button-dropin").show();

  $("#form-payment").submit(function(event) {
    event.preventDefault();

    instance.requestPaymentMethod(function(err, payload) {
      if (err) {
        console.log("Request Payment Method Error", err);
        return;
      }

      if ($("#selector-plan-monthly").is(":checked")) {
        $.post(
          "recurrentPayment.php",
          {
            amount: $(".text-amount")
              .first()
              .text(),
            payment_method_nonce: payload.nonce
          },
          processPaymentResponse,
          "json"
        );
      } else if ($("#selector-plan-once").is(":checked")) {
        $.post(
          "simplePayment.php",
          {
            amount: $(".text-amount")
              .first()
              .text(),
            payment_method_nonce: payload.nonce
          },
          processPaymentResponse,
          "json"
        );
      }
      $("#loader-payment").show();
      $("#form-payment").hide();
    });
  });
};

var processClientToken = function(response) {
  console.log(response);
  braintree.dropin.create(
    {
      authorization: response.token,
      selector: "#bt-dropin"
      //   paypal: {
      //     flow: 'vault'
      //   }
    },
    processDropInCreation
  );  
}

$.get("clientToken.php", processClientToken, "json");

