(function ($, undefined) {
  'use strict';

  /**
    * AutoSlide Plugin
    */
  var AutoSlide = function (element, opts) {
    var $el = this.$el = $(element).css('overflow', 'hidden');
    this.opts = $.extend(opts, $el.data('component-options'));
    this.$slides = $el.children(opts.selector).not(opts.exclude);
    this.$navi = this.getMenu(opts.naviClass);
    this.totalSlides = this.$slides.size();
    this.slidesWidths = [];
    this.current = 0;

    this.makeSlides();

  }, autoslide = AutoSlide.prototype;

  AutoSlide.defaults = {
    duration    : 300,
    naviClass   : 'sliding-nav',
    naviType    : 'li',
    naviOrder   : 'after',
    selector    : '.slide',
    exclude     : '.not-slide',
    wrapperClass: 'sliding-wrapper',
    autoHeight  : true,
    defaultSlide: 0,
    itemsPerPage: 1,
    beforeSlide : function (index) {
      return true;
    }
  };

  /**
    * Set focus for first visible input in each slide.
    */
  // autoslide.automaticSlide = function () {
  //   var self = this;
  //   self.$slides.find(':input:visible:last')
  //     .not(':button')       // Exclude elements buttons
  //     .keydown(function (event) {
  //       if (event.which === 9) {
  //         event.preventDefault();
  //         self.gotoSlide('next');
  //       }
  //     });
  // };

  // autoslide.nextButton = function (slide) {
  //   var self = this
  //     , $nextLink = $('<a class="next" href="#"></a>')
  //       .on('click', function (event) {
  //         event.preventDefault();
  //         self.gotoSlide('next');
  //       }).html('Siguiente');

  //   slide.append($nextLink);
  // };

  autoslide.makeSlides = function () {
    var self = this
      , wrapperWidth = 0
      , elemWidth = this.$el.outerWidth()
      // , links = self.opts.links
      , slidesLength = self.$slides.size()
      , itemsPerPage = self.opts.itemsPerPage;

    self.$slidesWrapper = self.$slides.addClass('slide').each(function (index) {
      var $slide = $(this)
        , titleLink = $slide.data('legend') || $slide.find('legend').html() || ('' + index)
        , $itemMenu;

      if (index % itemsPerPage === 0) {
        titleLink = itemsPerPage > 1 ? (index + itemsPerPage) / itemsPerPage : titleLink;

        $itemMenu = $('<' + self.opts.naviType + ' />').html(
          !!self.opts.naviTemplate ?
          $.template(self.opts.naviTemplate, $slide.data('data')) :
          '<a href="#">' + titleLink + '</a>'
        );
        self.$navi && self.menuIsGenerated && $itemMenu.appendTo(self.$navi);
      }

      self.slidesWidths[index] = wrapperWidth;

      $slide.width(elemWidth / itemsPerPage);

      wrapperWidth += elemWidth;

      if (self.$navi && index < slidesLength - 1) {
        // self.nextButton($slide);
      }

      $slide.find('a[data-slide-nav]').on('click', function (event) {
        var nav = $(this).data('slide-nav');
        event.preventDefault();
        self.gotoSlide(nav);
      });

    }).wrapAll('<' + (self.opts.selector === 'li' ? 'ul' : 'div') + ' />').parent()
      .addClass(self.opts.wrapperClass + ' clearfix')
      .width(wrapperWidth);

    //self.automaticSlide();
    self.$navi && self.navigation();
    self.gotoSlide(self.opts.defaultSlide, false);
  };

  autoslide.getMenu = function (domEl) {
    if (!domEl) {
      return false;
    }

    if (domEl.substring(0, 1) === '#' || domEl.substring(0, 1) === '.') {
      return $(domEl);
    } else {
      this.menuIsGenerated = true;
      return $('<' + (this.opts.naviType === 'li' ? 'ul' : 'div') + ' />').addClass(domEl);
    }
  };

  autoslide.navigation = function () {
    var self = this;
    if (self.$navi) {
      self.$navi.show().on('click', this.opts.naviType + ' > a', function (event) {
        var $anchor = $(this)
          , $liParent = $anchor.parent();

        event.preventDefault();

        //$liParent.siblings().removeClass('active').end().addClass('active');
        self.gotoSlide($liParent.index());
      });

      self.menuIsGenerated && self.$el[self.opts.naviOrder](self.$navi).trigger('autoslide.navidone');
    }
  };

  autoslide.next = function () {
    this.gotoSlide('next', false);
  };

  autoslide.prev = function () {
    this.gotoSlide('prev', false);
  };

  autoslide.first = function () {
    this.gotoSlide(0, false);
  };

  autoslide.gotoSlide = function (slideIndex, validate) {
    var $slidesWrapper = this.$slidesWrapper;
    validate = (typeof validate === 'undefined' ? true : validate);

    if (validate && !this.opts.beforeSlide(slideIndex, this.$el)) {
      return;
    }

    if ('string' === typeof slideIndex) {
      if (slideIndex === 'next') ++this.current;
      if (slideIndex === 'prev') --this.current;
    } else {
      this.current = slideIndex;
    }

    var $current = $slidesWrapper.children('.slide').eq(this.current).show();

    this.$navi && this.$navi.children(this.opts.naviType).removeClass('active').eq(this.current).addClass('active');

    this.$el.animate({
      height: $current.outerHeight()
    }, this.opts.duration);

    $slidesWrapper.stop().animate({
      marginLeft: (-1 * this.slidesWidths[this.current]) + 'px'
    }, this.opts.duration, function () {
      $current.find(':input:visible').first().focus();
    });
  };

  $.fn.autoSlide = function (option) {
    var args = Array.prototype.slice.call(arguments, 1)
      , options = $.extend({}, AutoSlide.defaults, 'object' === typeof option && option);
    //opts = $.extend({}, AutoSlide.defaults, opts);

    return this.each(function (index) {
      var $this = $(this)
        , autoslide = $this.data('autoslide');

      if (!autoslide) {
        options = $.extend({}, options, $this.data());
        $this.data('autoslide', (autoslide = new AutoSlide(this, options)));
      }

      if ('string' === typeof option) {
        autoslide[option].apply(autoslide, args || []);
      }
    });
  };

  //$.component('auto-slide');

})(jQuery);