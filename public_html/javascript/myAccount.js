$("#find-subscription").click(function() {
  $(".subscriptions-wrapper").hide();
  $("#loader-subscription").show();
  $("#subscription-list").empty();
  $(".cancel-subscription-result").empty();
  
  if ($("#account-email").val().length == 0) {
      $("#input-account-email .input-error").show();
  } else {
      $("#input-account-email .input-error").hide();
      $("#loader-subscription").show();

      $.post(
      "findSubscription.php",
      {
        email: $("#account-email").val()
      },
      processFindSubscriptionResponse,
      "json"
    );
  }
});

$(document).on('click', '#subscription-list button', function(){ 
  var id = $(this).attr('id').replace("cancel-subscription-", "");
  console.log(id);

  if (confirm("Esti sigur ca vrei sa opresti subscription?")) {
    $.get(
      "cancelSubscription.php",
      {
        subscriptionId: id
      },
      processCancelSubscription,
      "json"
    );
  }
});

var processCancelSubscription = function(response) {
  if (response.success) {
    $(".subscriptions-wrapper").hide();
    $("#loader-subscription").show();
    $("#subscription-list").empty();
    $(".cancel-subscription-result").empty();

    $.post(
      "findSubscription.php",
      {
        email: $("#account-email").val()
      },
      function(response) {
        processFindSubscriptionResponse(response);

        $(".cancel-subscription-result").text(response.message);
        $(".cancel-subscription-result").show();
      },
      "json"
    );
  }
}

var processFindSubscriptionResponse = function(response) {
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

    $("#subscription-list").append(
      '<li>' + 
        '<span class="subscription-price">' + subscription.price + 'Euro </span>' +
        '<span class="subscription-details">Status: ' + subscription.status +  '</span>' +
        '<span class="subscription-details">Creata la ' + newDate +  '</span>'  + 
        '<span class="subscription-details">Tranzactii:</span>' + 
        transactionsTable +
        (subscription.status.toLowerCase() === 'active' ? 
        ('<button id="cancel-subscription-' + subscription.id + '">Opreste subscriptia</button>') : '') +
      '</li>'
    );
  });

  $("#loader-subscription").hide();
  $(".subscriptions-wrapper").show();
  
  console.log(response);
};