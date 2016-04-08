App.module 'Gallery.Images', (Images, App, Backbone, Marionette, $, _) ->
  Images.Views = {}
  class Images.Views.ImageItemView extends Marionette.ItemView
    className: 'col-sm-5ths col-xs-6'
    template: '#image-item-view-template'

  class Images.Views.ImageCollectionView extends Marionette.CollectionView
    className: 'row'
    childView: Images.Views.ImageItemView
    collectionEvents:
      'sync': 'render'
    onBeforeRender: ->
      if @collection.pager && @collection.pager.pageCount > 1
        @triggerMethod 'generate:pager', @collection.pager
      return

  return
