var modal = document.getElementById("modal");

var span = document.getElementsByClassName("close")[0];

var openModal = function() {
  modal.style.display = "block";
}

var closeModal = function() {
  modal.style.display = "none";
}

var setModalContent = function(html) {
  $("#modal-content").empty();
  $("#modal-content").append(html);
}

span.onclick = function() {
  $("#modal-content").empty();
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    $("#modal-content").empty();
    modal.style.display = "none";
  }
}