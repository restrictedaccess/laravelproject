/*
 * dispatcher
 */

Util.dispatcher = function(page, callback) {
  this.page_func = this.page_func || [];

  if (callback) return this.page_func.push([page, callback]);
  for(var i = 0, l = this.page_func.length; i < l; ++i) {
    var func = this.page_func[i];
    var match = page.match(func[0]);
    match && func[1](match);
  }
};
