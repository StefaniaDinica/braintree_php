$("#search-subscriptions").click(function() {
  $("#subscriptions-wrapper").hide();
  $("#loader-subscription").show();
  $("#subscriptions-list").empty();
  $("#result-message").empty();

  let email = $("#input-account-email input").val();

  if (email.length == 0) {
      $("#input-account-email .input-error").show();
  } else {
      $("#input-account-email .input-error").hide();
      $("#loader-subscription").show();

      searchSubscriptions(email);
  }
});

$(document).on('click', '#cancel-subscription', function(){ 
  var id = $(this).parent().attr('id');

  if (confirm("Esti sigur ca vrei sa opresti subscription?")) {
    cleanViewAndShowLoader();

    cancelSubscription(id);
  }
});

$(document).on('submit', 'form[id^="form-update-price-"]', function() { 
  event.preventDefault();

  let id = $(this).attr('id').replace("form-update-price-", "");
  let oldPriceText = $("#" + id + " .subscription-price").text();
  let oldPrice = oldPriceText.substring(0, oldPriceText.indexOf("."));

  let newPrice = $("#form-update-price-" + id + " input").val();
  if (newPrice.length <= 0 || oldPrice === newPrice) {
    $("#form-update-price-" + id + " .input-error").show();
  } else {
    $("#form-update-price-" + id + " .input-error").hide();
    
    closeModal();
    setModalContent("");

    cleanViewAndShowLoader();

    updatePrice(id, newPrice);
  }
});

$(document).on('click', '#update-price', function(){ 
  var id = $(this).parent().attr('id');

  setModalContent(
    '<form id="form-update-price-' + id + '" method="post">' + 
      '<div class="form-group">' + 
        '<input type="number" placeholder="Ex: 20"></input>' +
        '<span class="input-error">Introdu un pret valid, diferit de cel initial</span>' +
      '</div>' +
      '<input type="submit" value="Update pret" />' +
    '</form>'
  );

  $("#form-update-price-" + id + " .input-error").hide();

  openModal();
});

var createHostedFields = function(response) {
  braintree.client.create({
    authorization: response.token
  }, function (clientErr, clientInstance) {
    if (clientErr) {
      console.error(clientErr);
      return;
    }

    braintree.hostedFields.create({
      client: clientInstance,
      styles: {
        'input': {
          'font-size': '14px',
          'color': '#495057'
        },
        'input.invalid': {
          // 'color': 'red'
        },
        'input.valid': {
          // 'color': 'green'
        }
      },
      fields: {
        number: {
          selector: '#card-number',
          placeholder: '4111 1111 1111 1111'
        },
        expirationDate: {
          selector: '#expiration-date',
          placeholder: '10/2022'
        }
      }
    }, function (hostedFieldsErr, hostedFieldsInstance) {
      if (hostedFieldsErr) {
        console.error(hostedFieldsErr);
        return;
      }

      // submit.removeAttribute('disabled');

      $(document).on('submit', 'form[id^="update-payment-form-"]', function(){ 
        event.preventDefault();

        closeModal();
        setModalContent("");

        cleanViewAndShowLoader();

        var id = $(this).attr('id').replace("update-payment-form-", "");
        findSubscriptionById(id, hostedFieldsInstance);
      });
    });
  });
};

var processClientToken  = function(response) {
  $(document).on('click', '#update-payment', function(){ 
    var id = $(this).parent().attr('id');

    setModalContent(
      '<form action="/" id="update-payment-form-' + id + '" method="post">' + 
        '<label for="card-number">Card Number</label>' + 
        '<div class="hosted-field" id="card-number"></div>' +
        '<label for="expiration-date">Expiration Date</label>' +
        '<div class="hosted-field" id="expiration-date"></div>' +
        '<input type="submit" value="Update card" />' +
      '</form>'
    );

    createHostedFields(response);
    openModal();
  });
}

var cleanViewAndShowLoader = function() {
  $("#subscriptions-wrapper").hide();
  $("#loader-subscription").show();
  $("#subscriptions-list").empty();
  $("#result-message").empty();
}

var showResultMessageAndReloadSubscriptions = function(response) {
  if (response.error) {
    console.log(response.error);
  }

  $("#result-message").text(response.message);
  $("#result-message").show();

  let email = $("#input-account-email input").val();
  searchSubscriptions(email);
}

var processSearchSubscriptionsResponse = function(response) {
  response.subscriptions.forEach(subscription => {
    let date = subscription.createdAt.date.split(" ")[0];
    let tokens = date.split("-");
    let newDate = tokens[2] + "-" + tokens[1] + "-" + tokens[0];

    let transactionsTable = "<table class=\"transactions-table\">";
    transactionsTable += "<tr><th>Id</th><th>Suma achitata</th><th>Data</th></tr>";

    subscription.transactions.forEach(transaction => {
      let date = transaction.createdAt.date.split(" ")[0];
      let tokens = date.split("-");
      let newDate = tokens[2] + "-" + tokens[1] + "-" + tokens[0];
      transactionsTable +=
        "<tr><td>" + transaction.id + "</td><td>" + transaction.amount + " Euro</td><td>" + newDate + "</td>";
    });

    transactionsTable += "</table>";

    $("#subscriptions-list").append(
      '<li id="' + subscription.id +'">' + 
        '<span class="subscription-price">' + subscription.price + 'Euro </span>' +
        (subscription.status.toLowerCase() === 'active' ? 
        ('<button id="update-price">Update pret</button>') : '') + 
        '<span class="subscription-details">Status: ' + subscription.status +  '</span>' +
        '<span class="subscription-details">Creata la ' + newDate +  '</span>'  + 
        '<span class="subscription-details">Tranzactii:</span>' + 
        transactionsTable +
        (subscription.status.toLowerCase() === 'active' ? 
        ('<button id="cancel-subscription">Opreste subscriptia</button>') : '') +
        '<span class="subscription-details">Card: ' + subscription.cardMaskedNumber +  '</span>' +
        (subscription.status.toLowerCase() === 'active' ? 
        ('<button id="update-payment">Update card</button>') : '') +
      '</li>'
    );
  });

  $("#loader-subscription").hide();
  $("#subscriptions-wrapper").show();
};

var searchSubscriptions = function(email) {
  $.post(
    "searchSubscriptions.php",
    {
      email
    },
    processSearchSubscriptionsResponse,
    "json"
  );
}

var cancelSubscription = function(subscriptionId) {
  $.get(
    "cancelSubscription.php",
    {
      subscriptionId
    },
    showResultMessageAndReloadSubscriptions,
    "json"
  );
}

var findSubscriptionById = function(id, hostedFieldsInstance) {
  $.post(
    "findSubscriptionById.php",
    {
      id,
    },
    function (response) {
      tokenizeHostedFieldsAndUpdatePaymentMethod(hostedFieldsInstance, response.paymentMethodToken);
    },
    "json"
  );
}

var tokenizeHostedFieldsAndUpdatePaymentMethod = function(hostedFieldsInstance, paymentMethodToken) {
  hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
    if (tokenizeErr) {
      console.error(tokenizeErr);
      return;
    }

    updatePaymentMethod(payload.nonce, paymentMethodToken);
  });
}

var updatePaymentMethod = function(newPaymentMethodNonce, oldPaymentMethodToken) {
  $.post(
    "updatePaymentMethod.php",
    {
      newPaymentMethodNonce,
      oldPaymentMethodToken
    },
    showResultMessageAndReloadSubscriptions,
    "json"
  );
}

var updatePrice = function(subscriptionId, price) {
  $.post(
    "updatePrice.php",
    {
      subscriptionId,
      price
    },
    showResultMessageAndReloadSubscriptions,
    "json"
  );
}

$.get("clientToken.php", processClientToken, "json");