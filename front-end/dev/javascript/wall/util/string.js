/*
 * String helper
 */
Util.string = (function() {

  return {

    /*
     * @param {String}
     * @return {String}
     */
    sprintf: function(format) {
      var regex = /(%d|%s){1}/,
          args  = [],
          len   = arguments.length;

      for (var i = 1; i < len; i++) {
        args.push(arguments[i]);
      }

      len = args.length;
      var str = format;

      for (var i = 0; i < len; i++) {
        str = str.replace(regex, args[i]);
      }

      return str;
    },

    /*
     * @param {String}
     * @return {String}
     */
    stripHTML: function(val) {
      var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
      return val.replace(tags, '');
    },

    /*
     * @param {String/Number}
     * @param {Number}
     * @param {String}
     * @return {String}
     */
    leftPad: function(str, pad, spacer) {
      spacer = spacer || '0';
      pad    = pad || 0;
      var target = '';
      for (var i = 0; i < pad; i++) {
        target = target + spacer;
      }

      return (target + str).slice(-1 * pad);
    },

    /*
     * @param {Number}
     * @return {String}
     */
    csv: function(val) {
      return String(val).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
    }

  }

})();
