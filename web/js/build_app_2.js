// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  App.module('Gallery', function(Gallery, App, Backbone, Marionette, $, _) {
    var API;
    Gallery.Router = (function(superClass) {
      extend(Router, superClass);

      function Router() {
        return Router.__super__.constructor.apply(this, arguments);
      }

      Router.prototype.appRoutes = {
        '': 'showAlbums',
        'albums/:id': 'showImages',
        'albums/:id/page/:page': 'showImages',
        '*notFound': 'showAlbums'
      };

      return Router;

    })(Marionette.AppRouter);
    API = {
      showAlbums: function() {
        App.Gallery.Albums.Controller.showAlbumList();
      },
      showImages: function(id, page) {
        App.Gallery.Albums.Controller.showAlbumDetail(id, page);
      }
    };
    Gallery.Layout = (function(superClass) {
      extend(Layout, superClass);

      function Layout() {
        return Layout.__super__.constructor.apply(this, arguments);
      }

      Layout.prototype.events = {
        'click .navbar a.home': 'handleRouting'
      };

      Layout.prototype.template = '#app-layout-template';

      Layout.prototype.regions = {
        content: '#content'
      };

      Layout.prototype.handleRouting = function(e) {
        e.preventDefault();
        Backbone.history.navigate('', true);
      };

      return Layout;

    })(Marionette.LayoutView);
    App.addInitializer(function() {
      new Gallery.Router({
        controller: API
      });
    });
  });

}).call(this);
