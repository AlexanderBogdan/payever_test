// Generated by CoffeeScript 1.10.0
(function() {
  var App;

  Backbone.Marionette.Region.prototype.attachHtml = function(view) {
    this.$el.hide();
    this.$el.html(view.el);
    this.$el.fadeIn('fast');
  };

  App = new Backbone.Marionette.Application;

  App.addRegions({
    main: '#app'
  });

  App.on('start', function() {
    if (Backbone.history) {
      Backbone.history.start();
    }
  });

  window.App = App;

}).call(this);
