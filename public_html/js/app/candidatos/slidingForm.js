(function ($) {

	var $div_slide = $('div.sliding').first()
		, $fieldsets = $div_slide.children('form')
		, $formWrapper = $div_slide.parent()
		, $navi = $('<ul></ul>').attr('id', 'navigation').addClass('menu')
		, fieldsetLength = $fieldsets.size()
		, current = 1
		, stepsWidth = 0
		, fWidths = [];
	if ($div_slide.hasClass('before')) {
		$div_slide.before($navi);
	} else {
		$div_slide.after($navi);
	}
	$fieldsets.each(function (index) {
		var $fieldset = $(this).find("fieldset")
			, legend = $fieldset.find('legend').html()
			, $itemMenu = $('<li></li>').html('<a href="#">' + legend +'</a>');

		fWidths[index] = stepsWidth;
		stepsWidth += $fieldset.width();
		
		$itemMenu.appendTo($navi);

		$fieldset.find(':input').last().keydown(function (event) {
			if (event.which === 9) {
				//$('#navigation li:nth-child(' + (1 + current) + ') a').click();
				$navi.find('li > a').eq(current).click();
				$(this).blur();
				event.preventDefault();
			}
		});

	});

	$div_slide.width(stepsWidth);
	$fieldsets.first().find(':input').first().focus();
	$navi.show().on('click', 'a', function (event) {
			var $this = $(this)
			, $parent = $this.parent()
			, prev = current;
			
		
		$this.closest('ul').find('li').removeClass('selected');
		$parent.addClass('selected');

		current = $parent.index() + 1;
		$div_slide.stop().animate({
			marginLeft: '-' + fWidths[current - 1] + 'px'
		}, 500, function () {			
			$div_slide.children().eq(current).find(':input').first().focus();
		});
		event.preventDefault();
	});

})(jQuery);