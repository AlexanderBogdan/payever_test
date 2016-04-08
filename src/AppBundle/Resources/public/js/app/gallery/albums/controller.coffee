App.module 'Gallery.Albums', (Albums, App, Backbone, Marionette, $, _) ->
  Albums.Controller =
    showAlbumList: ->
      albumCollection = new (Albums.Collection)
      albumsListView = new (Albums.Views.AlbumCollectionView)(collection: albumCollection)
      albumCollectionPromise = albumCollection.fetch()
      layout = new (App.Gallery.Layout)
      layout.render()
      App.getRegion('main').show layout
      albumCollectionPromise.done ->
        layout.showChildView 'content', albumsListView
        return
      return
    showAlbumDetail: (id, page) ->
      page = page or 1
      # models
      album = new (Albums.Model)(id: id)
      imageCollection = new (App.Gallery.Images.Collection)
      # views
      layout = new (App.Gallery.Layout)
      layout.render()
      albumDetailLayoutView = new (Albums.Views.AlbumDetailLayoutView)
      albumDetailLayoutView.render()
      albumDetailsItemView = new (Albums.Views.AlbumDetailItemView)(model: album)
      imagesListView = new (App.Gallery.Images.Views.ImageCollectionView)(collection: imageCollection)
      App.getRegion('main').show layout
      layout.showChildView 'content', albumDetailLayoutView
      # promises
      albumPromise = album.fetch()
      imageCollectionPromise = imageCollection.fetch(null, id, page)
      albumPromise.done ->
        albumDetailLayoutView.getRegion('albumDetail').show albumDetailsItemView
        return
      imageCollectionPromise.done ->
        albumDetailLayoutView.getRegion('albumImages').show imagesListView
        return
      return
  return
