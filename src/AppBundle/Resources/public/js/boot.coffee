Backbone.Marionette.Region::attachHtml = (view) ->
  @$el.hide()
  @$el.html view.el
  @$el.fadeIn 'fast'
  return

App = new (Backbone.Marionette.Application)
App.addRegions main: '#app'
App.on 'start', ->
  if Backbone.history
    Backbone.history.start()
  return

window.App = App