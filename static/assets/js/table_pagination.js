// Basic example
$(document).ready(function () {
  $('#dtBasicExample').DataTable({
    "pagingType": "number" // "simple" option for 'Previous' and 'Next' buttons only
  });
  $('.dataTables_length').addClass('bs-select');
});