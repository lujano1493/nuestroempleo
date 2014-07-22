(function ($, undefined) {
  'use strict';

  var to = {
    right : {
      left: '100%',
      right: '-100%'
    },
    left : {
      left: '-100%',
      right: '100%'
    },
    top: {
      top: '-100%',
      bottom: '100%'
    },
    bottom: {
      top: '100%',
      bottom: '-100%'
    },
    center: {
      left: '0%',
      right: '0%',
      bottom: '0%',
      top: '0%'
    }
  };

  var SlideModal = function (el, opts) {
    this.opts = opts;
    this.$el = $(el)
      .delegate('[data-close=slidemodal]', 'click.slidemodal', $.proxy(this.hide, this));
    this.init();
  }, slidemodal = SlideModal.prototype;

  SlideModal.defaults = {
    slideFrom: 'left',
    slideTo: 'left',
    show: true
  };

  slidemodal.init = function () {
    var self = this;
    this.$el.css(to[this.opts.slideFrom]);
    if (this.opts.slides) {
      var $sliding = self.$el.find('.sliding');
      this.$el.on('shown.slide.modal', function () {
        var slide = self.relatedTarget && $(self.relatedTarget).data('slide');
        if (slide) {
          $sliding.autoSlide('gotoSlide', slide, false);
        } else {
          $sliding.autoSlide('first');
        }
      });

      self.$el.find('[data-slide]').on('click', function () {
        $sliding.autoSlide('gotoSlide', $(this).data('slide'), false);
      });
    }
  };

  slidemodal.toggle = function (relatedTarget) {
    return this[!this.isShown ? 'show' : 'hide'](relatedTarget);
  };

  slidemodal.show = function (relatedTarget) {
    var self = this;
    if (this.isShown) {
      return false;
    }

    this.relatedTarget = relatedTarget;
    this.isShown = true;

    this.$el.show().animate(to.center, 500, function() {
      self.$el.addClass('in')
        .focus().trigger('shown.slide.modal');
    });
  };

  slidemodal.hide = function () {
    var self = this
      , opts = self.opts;

    if (this.isShown) {
      this.$el.animate(to[opts.slideTo], 500, function() {
        self.$el.removeClass('in').hide()
          .trigger('hidden.slide.modal');
        self.isShown = false;
        self.$el.css($.extend({}, to.center, to[opts.slideFrom]));
      });
    }

    return false;
  };

  $.fn.slidemodal = function (option, relatedTarget) {
    return this.each(function() {
      var $this = $(this)
        , slidemodal = $this.data('slidemodal')
        , opts = $.extend({}, SlideModal.defaults, $this.data());

      if (!slidemodal) {
        $this.data('slidemodal', (slidemodal = new SlideModal(this, opts)));
      }

      if ('string' === typeof option) {
        slidemodal[option](relatedTarget);
      } else if (opts.show) {
        slidemodal.show(relatedTarget);
      }
    });
  };

  $(document).on('click.slidemodal', '[data-toggle="slidemodal"]', function (e) {
    var $this = $(this)
      , href    = $this.attr('href')
      , $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
      , option  = $target.data('slidemodal') ? 'toggle' : $.extend({remote: !/#/.test(href) && href}, $target.data(), $this.data());

    e.preventDefault();

    $target.slidemodal(option, this);
      // .one('hide', function () {
      //   if ($this.is(':visible')) {
      //     $this.focus();
      //   }
      // });
    return false;
  }).on('shown.slide.modal',  '.slidemodal', function () { $(document.body).addClass('modal-open'); })
    .on('hidden.slide.modal', '.slidemodal', function () { $(document.body).removeClass('modal-open'); });

})(jQuery);
