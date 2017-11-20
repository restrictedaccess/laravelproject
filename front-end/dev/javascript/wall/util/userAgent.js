/*
 * storage
 */

Util.userAgent = (function() {

  return {
    /*
     * @param {String}
     * @return {Boolean}
     */
    isAndroid2X: function() {
      var ua = navigator.userAgent;
      var androidversion = parseFloat(ua.slice(ua.indexOf("Android")+8));
      // alert(androidversion);
      if( ua.indexOf("Android") > 0 || androidversion > 2.3) {
        return true;
      } else{
        return false;
      }
    }
  }
})();
