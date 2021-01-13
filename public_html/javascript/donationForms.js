$("#donation-result").hide();
$("#form-payment").hide();
$("#input-amount").hide();
$("#input-amount span").hide();
$("#input-email span").hide();
$(".text-amount").text(
  $("input[name='item-selector-amount']:checked").data("amount")
);

$("#selector-plan-monthly").click(function() {
  $("#list-selector-amount").show();
  $("#input-amount").hide();
  $("#input-amount input").val("");
  $("#input-amount .input-error").hide();
  $(".text-amount").text(
    $("input[name='item-selector-amount']:checked").data("amount")
  );
  $("#frequency").text("/ luna");
});

$("#selector-plan-once").click(function() {
  $("#list-selector-amount").hide();
  $("#selector-amount-5").click();
  $("#input-amount").show();
  $("#input-amount input").val("");
  $("#input-amount .input-error").hide();
  $(".text-amount").text("0");
  $("#frequency").text("");
});

$("input[name='item-selector-amount']").click(function() {
  $("#input-amount").hide();
  $(".text-amount").text($(this).data("amount"));
});

$("#selector-amount-other").click(function() {
  $("#input-amount").show();
  $(".text-amount").text("0");
});

$("#input-amount input").on("keyup", function() {
  if ($(this).val().length == 0) {
    $(".text-amount").text("0");
  } else {
    $(".text-amount").text($(this).val());
  }
});
