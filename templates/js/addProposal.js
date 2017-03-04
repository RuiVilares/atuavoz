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
        console.log(data);
        if (data.error)
          swal("ERRO", "Ocorreu um erro. Tente novamente.", "error");
        else {
          swal("SUCESSO", "Proposta registada. Aguarda validação.", "success");
        }
      }
    });
  }
}

$("#submit").on('click', addProposal);
