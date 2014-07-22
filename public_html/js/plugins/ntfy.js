(function ($, w, undefined) {
  'use strict';

  var cache = {}
    , timestamp = new Date();

  var Ntfy = function (el, opts) {
      this.$el = $(el);
      this.opts = opts;
      this.init();
    }
    , ntfy = Ntfy.prototype
    , insertLink = function ($item) {
      var $a = $('<a />', {
          'href' : '/notificaciones/' + $item.data('id') + '/leido',
          'data-component': 'ajaxlink',
          'data-no-confirm': true,
          'data-ajax-type': 'GET',
          'html' : '<i class="icon-circle"></i>',
          'class': 'unread-link'
        }).on('success.ajaxlink', function (event, data) {
          // var type = $item.closest('[data-ntfy-type]').data('ntfyType');
          $item.removeClass('unread');
          $item.closest('#ntfy-menu').ntfy('updateCount', data.results.totales);
        });

      $item.prepend($a);
    };

  ntfy.defaults = {
    types: ['default'],
  };

  ntfy.init = function () {
    var self = this;

    this.$el.find('.ntfy[data-id]').each(function () {
      insertLink($(this));
    });

    this.$el.on('click', '.ntfy-link', function (ev) {
      var $this = $(this)
        , $ntfy = $this.closest('.ntfy');

      ev.stopPropagation();
      if ($ntfy.hasClass('unread')) {
        $ntfy.find('.unread-link')
          .on('success.ajaxlink', function () {
            window.location.href = $this[0].href;
          })
          .trigger('click.ajaxlink');
      } else {
        window.location.href = $this[0].href;
      }

      return false;
    }).on('click', '.ntfy', function (ev) {
      var $this = $(this);
      if (!$(ev.target).is('a') || !$(ev.target).is('a > i')) {
        $this.find('.ntfy-link').trigger('click');
      }
      return false;
    });

    this.$el.on('ntfy.added', function (event, type, isNew) {
      isNew && self.updateCount(type);
    });

    this.$el.on('ntfy.removed', function (event, type) {
      self.updateCount(type);
    });
  };

  ntfy.add = function (type, data) {
    if (type && !data) {
      data = type;
      type = (data.meta && data.meta.type) || 'default';
    }

    var isNew = !!data.meta.isNew
      , $ntfyContainer = this.getContainer(type)
      , $ul = $ntfyContainer && $ntfyContainer.find('ul');

    if ($ntfyContainer && $ul) {
      $ul[isNew ? 'prepend' : 'append'](
        this.message(data, type)
      );
      $ul.find('li.delete').remove();
      $ul.trigger('ntfy.added', [type, isNew]);
      $(document).trigger('receiver-ntfy.ntfy', data);
      isNew && this.popover($ntfyContainer.find('[data-toggle=dropdown]'), {
        title: 'Nuevo Mensaje',
        content: (data.data && data.data.title) || data,
        placement: 'bottom'
      }, true);
    }
  };

  ntfy.message = function (data, type) {
    console.log(type);
    var html = $.isPlainObject(data) ? $.template('#tmpl-' + (data.meta.tmpl || type), data) : data
      , $li = $('<li></li>', {
        // 'data-id': 243
        'html': html
      }).on('click', function () {
        $(this).toggleClass('open');
      });

    insertLink($li.find('.ntfy'));
    return $li;
  };

  ntfy.updateCount = function (type) {
    var self = this
      , $item
      , $totalCount
      , v;

    type = type || 'default';

    if ('object' === typeof type) {
      $.each(type, function (key, value) {
        $item = self.getContainer(key);

        $item && (($totalCount = $item.find('.ntfy-total')) && $totalCount.text(value));

        $totalCount.toggleClass('new-ntfys', value > 0);
      });
    } else if ('string' === typeof type) {
      $item = this.getContainer(type);

      $item && (($totalCount = $item.find('.ntfy-total')) && $totalCount.text(v = (+$totalCount.text() + 1)));
      $totalCount.toggleClass('new-ntfys', v > 0);
    }

    // var $item = this.getContainer(type)
    //   , $totalCount = $item.find('.ntfy-total')
    //   , $lis = $item.find('ul li .ntfy.unread');

    // $totalCount.text($lis.size());
  };

  ntfy.remove = function (type, id) {
    if (type && !id) {
      id = type;
      type = 'default';
    }

    var $item = this.getContainer(type);
    $item.find('li[data-id=' + id + ']').hide('fast', function () {
      $(this).remove();
      $item.trigger('ntfy.removed', [type]);
    });
  };

  ntfy.getContainer = function (type) {
    if (cache[type]) {
      return cache[type];
    }

    var $ntfy = this.$el.find('[data-ntfy-type=' + type + ']');

    return $ntfy.size() > 0 ? (cache[type] = $ntfy) : false;
  };

  ntfy.popover = function ($el, opts, destroy) {
    $el.popover(opts).popover('show');

    if (!!destroy) {
      setTimeout(function () {
        $el.popover('destroy');
      }, 2000);
    }
  };

  ntfy.get = function (opts, callback) {
    var $container
      , self = this
      , data = {};

    data = $.extend({
      limit: 10,
      offset: 0,
      type: null,
      timestamp: (timestamp.getTime() / 1000)
    }, opts || {});
    $container = self.getContainer(data.type || 'notificacion');

    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: '/notificaciones.json',
      beforeSend: function () {
        if ($container) {
          $container.find('.btn-actions').spin('tiny');
        }
      },
      data: data
    }).done(function (response) {
      callback(response);
    }).fail(function () {

    }).always(function () {
      if ($container) {
        $container.find('.btn-actions').spin(false);
      }
    });
  };

  $.fn.ntfy = function (opts) {
    var options = 'object' === typeof opts && $.extend({}, Ntfy.defaults, opts)
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function (index) {
      var $this = $(this)
        , ntfy = $this.data('ntfy');

      if (!ntfy) {
        $this.data('ntfy', (ntfy = new Ntfy(this, options)));
      }

      if ('string' === typeof opts) {
        ntfy[opts].apply(ntfy, args || []);
      }
    });
  };

  $(document).on('ready', function () {
    var $ntfy = $('#ntfy-menu');

    $ntfy.ntfy();
  });

})(jQuery, window);