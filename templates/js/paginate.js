var elements_per_page = 4;
var current_page = 0;
var last_page;
var num_elements;
var elements_in_display;
var hidden_elements;


$(document).ready(function() {
  num_elements = $("#list-all-elements > div").length;
  (num_elements != 0) ? last_page = Math.floor((num_elements - 1) / elements_per_page): last_page = 0;
  setResult();
  paginate(0);
});



function paginate(direction) {
  var j = 0;
  var i = 0;
  switch (direction) {
    case -1:
      current_page--;
      break;
    case 0:
      break;
    case 1:
      current_page++;
      break;
  }
  if (current_page == 0) {
    $('#prevPage').css("visibility", "hidden");
    if (last_page >= 1) $('#nextPage').css("visibility", "visible");
    else $('#nextPage').css("visibility", "hidden");
  } else {
    if (current_page == last_page) {
      $('#nextPage').css("visibility", "hidden");
      if (last_page >= 1) $('#prevPage').css("visibility", "visible");
      else $('#prevPage').css("visibility", "hidden");
    } else {
      $('#nextPage').css("visibility", "visible");
      $('#prevPage').css("visibility", "visible");
    }
  }
  for (var k = 0; k < num_elements; k++) {
    if (current_page * elements_per_page <= i) {
      if (j < elements_per_page) {
        elements_in_display[k].show();
      } else {
        elements_in_display[k].hide();
      }
      j++;
    } else {
      elements_in_display[k].hide();
    }
    i++;
  }
  for (var k = 0; k < hidden_elements.length; k++) hidden_elements[k].hide();
}


function setResult() {

  elements_in_display = [];
  hidden_elements = [];

  $("#list-all-elements > div").each(function() {
    elements_in_display.push($(this));
  });

  num_elements = elements_in_display.length;
  (num_elements != 0) ? last_page = Math.floor((num_elements - 1) / elements_per_page): last_page = 0;
  resetPage();
}


function resetPage() {
  current_page = 0;
  paginate(0);
}

$('#nextPage').click(function() {
  paginate(1);
});
$('#prevPage').click(function() {
  paginate(-1);
});
