App.module 'Gallery.Albums', (Albums, App, Backbone, Marionette, $, _) ->
  class Albums.Model extends Backbone.Model
    url: ->
      '/albums/' + @id
    parse: (response) ->
      response.data

  return
