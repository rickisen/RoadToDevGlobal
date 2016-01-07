/* DROPDOWNS */
$(document).ready(function(){


  // FILTER BUTTON ON PLAYERS.TWIG
  $(".filter-toggle").click(function(){
      $(".show-filter").slideToggle();
  });

  // OPEN USER NAV MENU
  $(".menu-opener").click(function(){
  $(".menu-opener, .menu-opener-inner, .menu").toggleClass("active");
  });

  // LANDING PAGE FILTER DROPDOWNS

  // DP 1
  $(".dp1 dt a").on('click', function() {
  $(".dp1 dd ul").slideToggle('fast');
  });


  $(".dp1 dd ul li a").on('click', function() {
  $(".d1 dd ul").hide();
  });

  $(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dp1")) $(".dp1 dd ul").hide();
  });

  $('.mutliSelect1 input[type="checkbox"]').on('click', function() {

  var title = $(this).closest('.mutliSelect1').find('input[type="checkbox"]').val(),
    title = $(this).val() + " ";

  if ($(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel1').append(html);
    $(".hida1").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida1");
    $('.dp1 dt a').append(ret);

  }
  });

  // DP 2
  $(".dp2 dt a").on('click', function() {
  $(".dp2 dd ul").slideToggle('fast');
  });

  $(".dp2 dd ul li a").on('click', function() {
  $(".d2 dd ul").hide();
  });

  $(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dp2")) $(".dp2 dd ul").hide();
  });

  $('.mutliSelect2 input[type="checkbox"]').on('click', function() {

  var title = $(this).closest('.mutliSelect2').find('input[type="checkbox"]').val(),
    title = $(this).val() + " ";

  if ($(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel2').append(html);
    $(".hida2").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida2");
    $('.dp2 dt a').append(ret);

  }
  });

  // DP 3
  $(".dp3 dt a").on('click', function() {
  $(".dp3 dd ul").slideToggle('fast');
  });

  $(".dp3 dd ul li a").on('click', function() {
  $(".d3 dd ul").hide();
  });

  $(document).bind('click', function(e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dp3")) $(".dp3 dd ul").hide();
  });

  $('.mutliSelect3 input[type="checkbox"]').on('click', function() {

  var title = $(this).closest('.mutliSelect3').find('input[type="checkbox"]').val(),
    title = $(this).val() + " ";

  if ($(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    $('.multiSel3').append(html);
    $(".hida3").hide();
  } else {
    $('span[title="' + title + '"]').remove();
    var ret = $(".hida3");
    $('.dp3 dt a').append(ret);

  }
  });

  function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
  }

  // Lobby prompt
  $(function(){
  $(document).keypress(function(e) {
    cwrite(e.which,'Keypress event');
    if(e.which==120) custom_dialog_toggle('Keypress x','You opened this window by pressing x');
    });
  });

function custom_dialog_toggle(title,text,buttons) {
  if(typeof title !=='undefined') $('#dlg-header').html(title);
  if(typeof text !=='undefined') $('#dlg-content').html(text);
  cwrite('Current state: '+$('#dialog_state').prop("checked"),'custom_dialog_toggle');
  $('#dialog_state').prop("checked", !$('#dialog_state').prop("checked"));
}

function cwrite(str,title) {
  var ce = $('#console');
  var sg = "<p>";
  if(typeof title !=='undefined') sg = sg+"<em>"+title+"</em> ";
  sg = sg+str+"</p>";
  ce.prepend(sg);
  //if(ce.children("p").length>6) ce.children("p").first().remove();
}

});
