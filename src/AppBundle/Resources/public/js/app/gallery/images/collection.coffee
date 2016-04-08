App.module 'Gallery.Images', (Images, App, Backbone, Marionette, $, _) ->
  class Images.Collection extends Backbone.Collection
    fetch: (options, album_id, page) ->
      options = options or {}
      options.url = '/albums/' + album_id + '/images'
      if page
        options.url += '?page=' + page
      Backbone.Collection::fetch.call this, options
    parse: (response) ->
      @pager = response.pager
      response.data

  return
