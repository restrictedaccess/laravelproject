/*
 * URL helper
 */
Util.url = (function() {

  return {

    /*
     * @param {String} path
     * @param {Object} query
     */
    getQuery: function(path) {
      var query = {},
          param = [],
          tmp   = [];

      if (!path || !/^\?.*=.*/.test(path)) { return query; };

      path = path.substr(1);
      param = path.split(/&/g);

      _.each(param, function(item, index) {
        tmp = item.split(/=/);
        query[tmp[0]] = tmp[1];
      });

      return query;
    },

    getLastPath: function() {
      return location.pathname.split('/').pop();
    },

    removeFirstPath: function(){
      var _url = location.pathname;
      var _path = _url.split('/');
      _path.splice(1, 1)
      _url = _path.join('/');
      return _url;
    },

    concatPath: function(path1, path2) {
      var path1Flag = path1.substr(-1, 1) === '/' ? true : false,
          path2Flag = path2.substr(0, 1) === '/' ? true : false,
          concatPath = '';

      if (path1Flag === true && path2Flag === true) {
        concatPath = path1 + path2.substr(1);
      } else if (path1Flag === true || path2Flag === true) {
        concatPath = path1 + path2;
      } else {
        concatPath = path1 + '/' + path2;
      }

      return concatPath;
    }

  };
})();
