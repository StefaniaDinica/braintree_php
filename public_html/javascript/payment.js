var threeDSecure;

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
    // challengeRequested: true
  }, function (err, res) {
    if (err) {
      console.log(err);
      return;
    }
    // Send response.nonce to your server for use in your integration
    if (err) {
      $("#form-payment").hide();
      $("#donation-result").text("Tranzactia nu a putut fi procesata.");
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
    return;
  }

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
              // device_data: $("input[name='device_data']").val()
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
  braintree.dropin.create(
    {
      authorization: response.token,
      selector: "#bt-dropin",
      paypal: {
        flow: "vault"
      },
      threeDSecure: true
    },
    processDropInCreation
  );

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

    // braintree.dataCollector.create({
    //   client: clientInstance
    // }, function (err, dataCollectorInstance) {
    //   if (err) {
    //     console.log("Error create data collector")
    //     return;
    //   }
    //   // At this point, you should access the dataCollectorInstance.deviceData value and provide it
    //   // to your server, e.g. by injecting it into your form as a hidden input.
    //   var form = document.getElementById('form-payment');
    //   var deviceDataInput = document.createElement('input');
    //   deviceDataInput.name = 'device_data';
    //   deviceDataInput.type = 'hidden';
    //   form.appendChild(deviceDataInput);

    //   deviceDataInput.value = dataCollectorInstance.deviceData;
    // });
  });
};

$.get("clientToken.php", processClientToken, "json");