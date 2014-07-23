/* global bootbox */
/* jshint camelcase: false */
/* jshint unused: false */
(function ($, undefined) {
  'use strict';
  var $doc = $(document);

  var Folderito = function (element, opts) {
    var $el = this.$el = $(element)
      , itemId = $el.data('id');

    this.$folderContainer = this.$el.closest('table').find('ul.folders[data-item-id=' + itemId + ']');

    this.init();
  }, folderito = Folderito.prototype;

  Folderito.defaults = {
    ul : {}
  };

  folderito.init = function () {
    this.$el
    //.off('click.folderito')
    .one('click.folderito', this.show.bind(this));
  };

  folderito.show = function (event) {
    var self = this
      , foldersCache = $doc.data('folders') || {}
      , controller = this.$el.data('controller');

    this.clearMenus();
    if (foldersCache && foldersCache[controller]) {
      this.render(foldersCache[controller]);
    } else {
      $.ajax({
        type    : 'GET',
        dataType: 'json',
        url     : this.$el.data('source'),
        beforeSend: function () {
          self.$el
            .append('<i class="icon-spinner icon-spin"></i>')
            .addClass('disabled spinner')
            .prop('disabled', 'disabled');
        }
      })
      .done($.proxy(this.onSuccess, this))
      .fail($.proxy(this.onError, this))
      .always($.proxy(this.always, this));
    }
    return false;
  };

  folderito.render = function (folders) {
    var self = this
      , availableFolders = this.exclude(folders);

    self.$ul = $('<ul />', {
      'class' : 'explorer'
    }).insertAfter(self.$el);

    if (availableFolders.length > 0) {
      $.each(availableFolders, function (index, folder) {
        var $li = self.linkInMenu(folder);
        self.$ul.append($li);
      });
    } else {
      var $li = $('<li><span>No hay Carpetas disponibles</span></li>');
      self.$ul.append($li);
    }

    self.$ul.on('success.ajaxlink', 'a', function (event, data) {
      self.updateFolder(data.results);
    });

    self.$ul.focus();
  };

  folderito.updateFolder = function (folders) {
    var self = this
      , controller = this.$el.data('controller')
      , _folders = $doc.data('folders')
      , folder = $.grep(_folders[controller], function (folder, index) {
        return folder.id === folders.folder_id;
      }).shift()
      , replace = folders.replace || false;

    $.each(folders.ids, function(index, itemId) {
      var $__folderContainer = $('ul.folders[data-item-id="' + itemId +'"]')
        , $li;

      if (folder && $__folderContainer.find('[data-folderito-id=' + folder.id + ']').size() === 0) {
        $li = self.linkFolder(itemId, folder);
        $__folderContainer[replace ? 'html': 'append']($li);
      }
    });

    this.clearMenus();
  };

  folderito.exclude = function(folders) {
    var __folders = []
      , inFolder = this.inFolders();

    /**
     * Si no existen folders del usuario, retorna todos.
     * @type {[type]}
     */
    if (inFolder.length === 0) {
      return folders;
    }

    for (var i = 0, _len = folders.length; i < _len; i++) {
      var f = null
        , found = false;
      for (var j = 0, _len2 = inFolder.length; j < _len2; j++) {
        f = folders[i];
        found = f.id === inFolder[j].id;
        if (found) {
          break;
        }
      }
      if (!found) {
        __folders.push(f);
      }
    }

    return __folders;
  };

  folderito.inFolders = function () {
    var /*itemId = this.$el.data('id')
      , */$folders = this.$el.closest('tr').prev().find('.folders').find('[data-folderito-id]');

    return $folders ? $folders.map(function () {
      return {
        id  : $(this).data('folderito-id'),
        folder_name: $(this).text()
      };
    }).get() : [];
  };

  folderito.onSuccess = function (data) {
    var folders = $doc.data('folders') || {}
      , controller = this.$el.data('controller');
    if (data.results) {
      folders[controller] = data.results;
      $doc.data('folders', folders);
      this.render(data.results);
    } else {
      alert('No tienes algún folder asociado a ti');
    }
  };

  folderito.onError = function (xhr, textStatus) {
    this.$el.html('Error!');
  };

  folderito.always = function () {
    this.$el
      .removeClass('disabled spinner')
      .prop('disabled', false)
      .find('.icon-spin').remove();
  };

  folderito.linkFolder = function (id, folder) {
    var $li = $('<li/>', {
      'data-folderito-id': folder.id
    }), $a = $('<a/>', {
      href: '/mis_candidatos/'+ folder.slug + '/carpeta',
      text: folder.folder_name
    }).appendTo($li)
      , $aDel = $('<a/>', {
      'class': 'text-danger btn btn-xs',
      href: '/mis_candidatos/' + id + '/quitar_de/'+ folder.slug,
      html: '&times;',
      'data-component': 'ajaxlink',
    }).appendTo($li);

    return $li;
  };

  folderito.linkInMenu = function (folder) {
    var self = this
      , id = self.$el.data('id')
      , controller = self.$el.data('controller')
      , $li = $('<li/>', {
    }), $a = $('<a/>', {
      'href' : '/' + controller + (id ? ('/' + id) : '') + '/guardar_en/' + folder.slug,
      'data-component' : 'ajaxlink',
      'data-ajaxlink-multi' : !id,
      'data-ajaxlink-target' : controller ===  'mis_ofertas' ? 'view:menu-ofertas' : false
    })
    .html(function () {
      return '<i class="icon-folder-open pull-left"></i>' + folder.folder_name;
    }).data('folderito', this).appendTo($li);
    return $li;
  };

  folderito.clearMenus = clearMenus;

  function clearMenus() {
    $('.explorer').remove();
  }

  $.fn.folderito = function (opts) {
    var options = $.extend({}, Folderito.defaults, 'object' === typeof opts ? opts : {})
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function (index) {
      var $this = $(this)
        , folderito = $this.data('folderito');

      if (!folderito) {
        $this.data('folderito', (folderito = new Folderito(this, options)));
      }

      if ('string' === typeof opts) {
        folderito[opts].apply(folderito, args || []);
      }
    });
  };

  $doc.on('click.folderito', clearMenus);

  $(document.body).on('click.folderito', '[data-component~=folderito]', function (e) {
    var $this = $(this);
    $this.folderito('show');

    return false;
  });

  $(document.body).on('success.ajaxlink', 'ul.folders[data-item-id] a', function (event, data) {
    $(event.target).parent('li').remove();
  });

  $(document.body).on('click', '.folder-change-name', function () {
    var $this = $(this)
      , id = $this.data('id');

    bootbox.prompt('Escribe el nuevo nombre de la carpeta:', function (result) {
      if (!result) return;
      $.ajax({
        type: 'POST',
        url: '/carpetas/' + id + '/cambiar_nombre.json',
        data: {
          name: result
        }
      }).done(function (results) {
        var $tr = $this.closest('tr');
        $('.alerts-container').alerto('show', results.message);

        if ($tr.is('.open-row')) {
          $tr = $tr.prev('tr');
        }

        $tr.find('.folder-name').html(result);
      }).fail(function (xhr, textStatus) {
        var jsonObj = $.parseJSON(xhr.responseText);

        $('.alerts-container').alerto('show', jsonObj.message);
      });
    });

    return false;
  });
})(jQuery);