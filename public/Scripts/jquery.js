/* DROPDOWNS */
$(document).ready(function(){


$(".dp1 dt a").on('click', function() {
$(".dp1 dd ul").slideToggle('fast');
});

$(".dp1 dd ul li a").on('click', function() {
$(".d1 dd ul").hide();
});

$(".dp2 dt a").on('click', function() {
$(".dp2 dd ul").slideToggle('fast');
});

$(".dp2 dd ul li a").on('click', function() {
$(".d2 dd ul").hide();
});

$(".dp3 dt a").on('click', function() {
$(".dp3 dd ul").slideToggle('fast');
});

$(".dp3 dd ul li a").on('click', function() {
$(".d3 dd ul").hide();
});

function getSelectedValue(id) {
return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function(e) {
var $clicked = $(e.target);
if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$('.mutliSelect input[type="checkbox"]').on('click', function() {

var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
  title = $(this).val() + ",";

if ($(this).is(':checked')) {
  var html = '<span title="' + title + '">' + title + '</span>';
  $('.multiSel').append(html);
  $(".hida").hide();
} else {
  $('span[title="' + title + '"]').remove();
  var ret = $(".hida");
  $('.dp1 dt a').append(ret);

}
});


});
