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

//search category
$('.filter-item').on('click', function() {
  var search_by = $(this).children('a').text();
  $('.search-by').text('By ' + search_by);
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