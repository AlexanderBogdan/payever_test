App.module 'Gallery.Albums', (Albums, App, Backbone, Marionette, $, _) ->
  class Albums.Collection extends Backbone.Collection
    url: '/albums'
    parse: (response) ->
      response.data

  return
