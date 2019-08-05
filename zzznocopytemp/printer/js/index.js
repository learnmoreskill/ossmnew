var $container = document.querySelector('.js-container');
var $expand = document.querySelector('.js-sidebar-expand');

$expand.addEventListener('click', function(evt) {
  toggleClass($container, ['-collapsed', '-expanded']);
});

function toggleClass(el, className) {
  if ( Array.isArray(className) ) {
    className.map(function(c) {
      toggleClass(el, c);
    });
  } else {
    var classNames = el.className.split(' ');
    var index;

    el.className = (index = classNames.indexOf(className)) === -1
      ? classNames.join(' ') + ' ' + className
      : splice(classNames, index, 1).join(' ');
  }
}

function splice(arr, index, count) {
  arr.splice(index, count);
  return arr;
}


$(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});