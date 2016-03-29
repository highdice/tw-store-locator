/*
 * INITIALIZATION
 */

var loader = document.getElementById('loader');

$(function() {
  $( "#date_opened" ).datepicker();
});

//start loading
startLoading();

$(document).ready(function() {
  //finish loading
  finishedLoading();
});

/*
 * EVENTS
 */

//event for sidebar animation 
$('.sidebar-js-button').on('click', function () {
  var container = $('#sidebar-content-container');
  var items = $('.sidebar-js-button');
  var selected = $(this);

  items.removeClass('sidebar-item-active');
  selected.addClass('sidebar-item-active');

  if(container.is(':visible')) {
    if(selected.hasClass('selected')) {
      container.stop(false, true).toggle('slide', 200);
      selected.removeClass('selected');
      selected.removeClass('sidebar-item-active');
    }
    else {
      items.removeClass('selected');
      selected.addClass('selected');
    }
  }
  else {
    container.stop(false, true).toggle('slide', 200);
    selected.addClass('selected');
  }
});

$('#sidebar-hide').on('click', function() {
  $('#sidebar').fadeOut(300);
  $('#sidebar-content-container').fadeOut(300);
  $('#search-container').fadeOut(300);
  $('#sidebar-show').delay(300).fadeIn(300);
});

$('#sidebar-show').on('click', function() {
  $('.sidebar-js-button').removeClass('sidebar-item-active');
  $('#sidebar-show').fadeOut(300);
  $('#search-container').delay(300).fadeIn(300);
  $('#sidebar').delay(300).fadeIn(300);
});

$('.show-filter-button').on('click', function() {
  $(this).hide();
  $('.hide-filter-button').show();
  $('.search-filter-container').fadeIn(300);
});

$('.hide-filter-button').on('click', function() {
  $(this).hide();
  $('.show-filter-button').show();
  $('.search-filter-container').fadeOut(300);
});

/*
 * FUNCTIONS
 */

//function to start loading
function startLoading() {
    loader.className = '';
}

//function to end loading
function finishedLoading() {
    loader.className = 'done';
    setTimeout(function() {
        loader.className = 'hide';
    }, 300);
}