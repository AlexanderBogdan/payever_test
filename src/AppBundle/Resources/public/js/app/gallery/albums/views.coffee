App.module 'Gallery.Albums', (Albums, App, Backbone, Marionette, $, _) ->
  Albums.Views = {}

  class Albums.Views.AlbumItemView extends Marionette.ItemView
    className: 'col-sm-5ths'
    events:
      'click a': 'handleRouting'
    template: '#album-item-view-template'
    handleRouting: (e) ->
      e.preventDefault()
      id = $(e.target).data('album-id')
      Backbone.history.navigate 'albums/' + id, true
      return

  class Albums.Views.AlbumDetailItemView extends Marionette.ItemView
    template: '#album-item-detail-view-template'
    modelEvents:
      'sync': 'render'

  class Albums.Views.AlbumCollectionView extends Marionette.CollectionView
    className: 'row'
    childView: Albums.Views.AlbumItemView
    collectionEvents:
      'sync': 'render'

  class Albums.Views.AlbumDetailLayoutView extends Marionette.LayoutView
    template: '#album-detail-layout-view-template'
    childEvents:
      'generate:pager': 'onGeneratePager'
    regions:
      'albumDetail': '#album-detail'
      'albumImages': '#album-images'
      'albumPager': '#album-pager'
    onGeneratePager: (childView, pager) ->
      pagerView = Marionette.ItemView.extend(
        events:
          'click a': 'handlePageRouting'
        tagName: 'ul'
        className: 'pagination'
        template: ->
          ul = $('<ul></ul>')
          if pager.firstPageInRange > pager.first
            ul.append('<li><a href="#" data-page="' + pager.first + '">&laquo; First</a></li>');
            ul.append('<li><a href="#" data-page="' + pager.previous + '">&lsaquo; Prev</a></li>');
            ul.append('<li class="disabled"><span>...</span></li>');

          pager.pagesInRange.map (item) ->
            li = $('<li></li>')
            link = $('<a href="#" data-page="' + item + '">' + item + '</a>')
            if item == pager.current
              li.addClass 'active'
              link = $('<span>' + item + '</span>')
            li.html link
            ul.append li
            return

          if pager.lastPageInRange < pager.last
            ul.append('<li class="disabled"><span>...</span></li>');
            ul.append('<li><a href="#" data-page="' + pager.next + '">Next &rsaquo;</a></li>');
            ul.append('<li><a href="#" data-page="' + pager.last + '">Last &raquo;</a></li>');

          $(ul).html()
        handlePageRouting: (e) ->
          e.preventDefault()
          path = Backbone.history.getFragment().split('/').slice(0, 2)
          pageNum = $(e.target).data('page')
          path.push 'page'
          path.push pageNum
          Backbone.history.navigate path.join('/'), true
          return
      )
      @albumPager.show new pagerView
      return

  return
