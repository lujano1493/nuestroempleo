(function ($, undefined) {
  "use strict";

  var $submenus = $('.submenu', '#menu .nav');

  $submenus.prevAll('a.arrow').on('click', function (ev) {
    var $li = $(this).parents('li')
      , $open = $li.siblings('.open');
    
    $open.removeClass('open').find('> .submenu').slideUp('fast');
    $li.addClass('open');
    $(this).siblings('.submenu').toggleClass('open').slideToggle('fast');

    ev.preventDefault();
  });
})(jQuery);