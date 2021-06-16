$("#donations-page").hide();
$("#myAccount-page").hide();
$("#input-account-email .input-error").hide();

$("#subscriptions-wrapper").hide();

$("#donations-page-link").click(function() {
    $("#myAccount-page").hide();
    $("#donations-page").show();
});
$("#myAccount-page-link").click(function() {
    $("#donations-page").hide();
    $("#myAccount-page").show();
});