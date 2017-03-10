function addProposal(e) {
  e.preventDefault();
  var title = $('#inputTitle').val();
  var description = $('#inputDescription').val();
  var author = $('#inputAuthor').val();

  if (title === "" || description === "" || author === "") {
    swal("ERRO", "Proposta inválida. Verifica os dados introduzidos.", "error");
  } else {
    var postData = {
      "title": title,
      "description": description,
      "author": author
    };
    $.ajax({
      type: "POST",
      url: "api/addProposal.php",
      contentType: "application/json",
      data: JSON.stringify(postData),
      dataType: "json",
      success: function(data) {
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          $('#inputTitle').val('');
          $('#inputDescription').val('');
          $('#inputAuthor').val('');
          swal("SUCESSO", "Proposta registada. Aguarda validação.", "success");
        }
      }
    });
  }
}

function voteProposal(e) {
  e.preventDefault();
  var id = $(this).attr("data-id");

  if (id == null || id == undefined) {
    swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
  } else {
    var postData = {
      "id": id
    };
    $.ajax({
      type: "POST",
      url: "api/voteProposal.php",
      contentType: "application/json",
      data: JSON.stringify(postData),
      dataType: "json",
      success: function(data) {
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          location.reload();
        }
      }
    });
  }
}

function acceptProposal(e) {
  e.preventDefault();
  var id = $(this).attr("data-id");

  if (id == null || id == undefined) {
    swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
  } else {
    var postData = {
      "id": id
    };
    $.ajax({
      type: "POST",
      url: "api/acceptProposal.php",
      contentType: "application/json",
      data: JSON.stringify(postData),
      dataType: "json",
      success: function(data) {
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          location.reload();
        }
      }
    });
  }
}

function rejectProposal(e) {
  e.preventDefault();
  var id = $(this).attr("data-id");

  if (id == null || id == undefined) {
    swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
  } else {
    var postData = {
      "id": id
    };
    $.ajax({
      type: "POST",
      url: "api/rejectProposal.php",
      contentType: "application/json",
      data: JSON.stringify(postData),
      dataType: "json",
      success: function(data) {
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          location.reload();
        }
      }
    });
  }
}

function login(e) {
  e.preventDefault();
  var username = $("#username").val();
  var password = $("#password").val();

  if (username === "" || password === "") {
    swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
  } else {
    var postData = {
      "username": username,
      "password": password
    };
    $.ajax({
      type: "POST",
      url: "api/login.php",
      contentType: "application/json",
      data: JSON.stringify(postData),
      dataType: "json",
      success: function(data) {
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          location.reload();
        }
      }
    });
  }
}

function logout(e) {
  e.preventDefault();
  $.ajax({
    type: "GET",
    url: "api/logout.php",
    success: function(data) {
      if (data.error)
        swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
      else {
        window.location.replace("./?page=main");
      }
    },
  });
}

$("#submit").on('click', addProposal);

$(".vote").on('click', voteProposal);

$(".accept").on('click', acceptProposal);

$(".reject").on('click', rejectProposal);

$("#login").on('click', login);

$("#logout").on('click', logout);
