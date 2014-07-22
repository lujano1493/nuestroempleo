(function ($, undefined) {
  'use strict';

  var MagicLoad = function (el, opts) {
    this.$el = $(el);
    this.opts = opts;
    /**
     * Funcionará como cache para guardar los contenedores.
     * @type {Object}
     */
    this.$containers = {};

    /**
     * Busca el primer contenedor.
     */
    this.$containers[document.URL] = this.$el
      .find('.magic-container:first')
      .data('hash', document.URL); // Cache for containers.

  }, magicload = MagicLoad.prototype;

  MagicLoad.defaults = {
    removedClass: 'container-removed'
  };

  magicload.getContainer = function (url, relatedLink) {
    /**
     * Crea un nuevo contenedor.
     * @type {[type]}
     */
    this.$container = this.createContainer(url, relatedLink);

    return this.$container.spin('html');
  };

  magicload.createContainer = function (hash, relatedLink) {
    var $container = $('<div></div>', {
      'class' : 'loading magic-container',
      'data-role' : 'magic-container',
    }).data({
      'hash': hash,
      'relatedLink': relatedLink
    }).appendTo(this.$el);

    /**
     * Almacena o reemplaza un contenedor.
     */
    this.$containers[hash] = $container;
    return $container;
  };

  magicload.load = function (url, type, relatedLink) {
    var self = this
      , $container = null;

    if (type instanceof jQuery) {
      relatedLink = type;
      type = null;
    }

    this.url = ('object' === typeof url) ? url.load : (url || document.URL);

    /**
     * Si ya se cargo esa url o no se forza a cargarlo, muestra el contenedor.
     */
    if (this.isLoaded(this.url)) {
      if (type !== 'force' && type !== 'reload') {
        return this.show(this.url);
      } else if (type === 'reload') {
        $container = this.$containers[this.url];
        this.$containers[this.url] = null;
        $container.remove();
      }
    }

    $container = this.getContainer(this.url, relatedLink);
    /**
     * Carga el HTML el contenedor que se obtuvo.
     */
    $.ajax({
      url: this.url,
      beforeSend: function(jqXHR, settings) {
        jqXHR.setRequestHeader('No-Layout', 'true');
      }
    }).done(function (response) {
      $container.prev().fadeOut('fast');
      $container
        .hide()
        .removeClass('loading').spin(false)
        .html(response).delegate('[data-close]', 'click', function (event) {
          $.h('back');
          return false;
        });

      /**
       * Vuelve a almacenar el contenedor.
       */
      self.$containers[self.url] = $container;
      self.show(self.url, type);
      self.$el.trigger('loaded.magicload', arguments);
    }).fail(function (xhr, textStatus) {
      $container.html(textStatus).append(self.closeButton());
    }).always(function () {

    });
  };

  /**
   * Verifica si ya se cargo esta url.
   * @param  {[type]}  url [description]
   * @return {Boolean}     [description]
   */
  magicload.isLoaded = function (url) {
    return !!this.$containers[url];
  };

  /**
   * Muestra el contenedor especificado con el hash (url).
   * @param  {[type]} hash url del contenedor
   * @param  {[type]} type tipo de carga
   * @return {[type]}      [description]
   */
  magicload.show = function (hash, type) {
    var self = this
      , $container = this.$containers[hash];

    $container.siblings('.magic-container:visible').fadeOut('fast', function () {
      /**
       * Remueve todos los contenedores que ya no son necesarios.
       */
      $container.siblings('.' + self.opts.removedClass).remove();
      $container.fadeIn('fast', function () {
        var title = $container.find('[data-role=title]').text();
        (type !== 'replace' && type !== 'force') && self.addToHistory(hash, title, {/*id: id*/});
      });
    });
  };

  /**
   * Esta función debe iniciar los componentes.
   * @return {[type]} [description]
   */
  magicload.initComponents = function () {
    $.fn.dynamicTable && this.$container.find('[data-component="dynamic-table"]').dynamicTable({});
    $.fn.editor && this.$container.find('[data-component=wysihtml5-editor]').editor();
    setTimeout(function () {
      $.component('suggestito');
    }, 500);
  };

  /**
   * Refresca un contenedor obligando a cargar de nuevo su contenido.
   * @param  {[type]}   hash     [description]
   * @param  {Function} callback [description]
   * @return {[type]}            [description]
   */
  magicload.refresh = function (hash, callback) {
    var $container;

    /**
     * Si hash no se específica busca el contenedor visible para reemplazarlo.
     */
    if ($.isFunction(hash)) {
      callback = hash;
      hash = this.$el.find('.magic-container:visible').data('hash');
    }

    // Al reemplazar, genera un nuevo contenedor, por lo tanto este se eliminará.
    $container = this.$containers[hash].addClass(this.opts.removedClass);
    this.load(hash, 'force', $container.data('relatedLink'));
    $container = this.$containers[hash];
    $.isFunction(callback) && callback.call(this, $container);
  };

  magicload.hide = function () {

  };

  // magicload.close = function (callback) {
  //   var self = this;

  //   if (this.opts.append) {
  //     var $container = self.$containers.pop();
  //     $container.fadeOut('fast', function () {
  //       $container.prev().fadeIn('fast');
  //       $container.remove();
  //       $.isFunction(callback) && callback();
  //     });
  //   } else {
  //     $.isFunction(callback) && callback();
  //   }
  // };

  magicload.closeButton = function () {
    return $('<a></a>', {
      'class' : 'btn btn-sm btn-default',
      'html'  : '<i class="icon-remove-sign"></i>Cerrar',
      'data-close': true
    }).on('click', function (event) {
      $.h('back');
      return false;
    });
  };

  /**
   * Agrega al historial.
   * @param {[type]} url   [description]
   * @param {[type]} title [description]
   * @param {[type]} data  [description]
   */
  magicload.addToHistory = function (url, title, data) {
    $.h('push.magicload', data, title, url);
  };

  $.fn.magicload = function (opts, relatedLink) {
    var options = $.extend({}, MagicLoad.defaults, 'object' === typeof opts ? opts : {})
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function (index) {
      var $this = $(this)
        , magic = $this.data('magicload');

      if (!magic) {
        $this.data('magicload', (magic = new MagicLoad(this, options)));
      }

      if ('string' === typeof opts) {
        magic[opts].apply(magic, args || []);
      } else if (opts.load) {
        magic.load.apply(magic, [opts, relatedLink]);
      }
    });
  };

  $.h('magicload', function (state, type, internal) {
    if (internal) {
      $('#main-content').magicload('show', state.url, 'replace');
    }
  });

  $.h('magicload.back', function (state, type, internal) {
    $('#main-content').magicload('show', state.url, 'replace');
  });
})(jQuery);