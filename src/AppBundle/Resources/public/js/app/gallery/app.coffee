App.module 'Gallery', (Gallery, App, Backbone, Marionette, $, _) ->
  class Gallery.Router extends Marionette.AppRouter
    appRoutes:
      '': 'showAlbums'
      'albums/:id': 'showImages'
      'albums/:id/page/:page': 'showImages'
      '*notFound': 'showAlbums'

  API =
    showAlbums: ->
      App.Gallery.Albums.Controller.showAlbumList()
      return
    showImages: (id, page) ->
      App.Gallery.Albums.Controller.showAlbumDetail id, page
      return

  class Gallery.Layout extends Marionette.LayoutView
    events:
      'click .navbar a.home': 'handleRouting'
    template: '#app-layout-template'
    regions:
      content: '#content'
    handleRouting: (e) ->
      e.preventDefault()
      Backbone.history.navigate '', true
      return

  App.addInitializer ->
    new (Gallery.Router)(controller: API)
    return

  return
