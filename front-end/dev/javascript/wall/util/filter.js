/*
 * filter
 */
Util.filter = (function() {
  'use strict';

  return {

    /*
     * @param {Integer} defineCount
     * @param {Object} resource
     * @param {Array} conditions
     * @return {Array} results
     */
    getResults: function(defineCount, resource, conditions) {
      var cache = {},
          results = [],
          count = 0;

      _.forEach(resource, function(v, k) {
        _.forEach(v, function(vv, kk) {
          if (_.contains(conditions, kk)) {
            if (cache[k] === undefined) {
              cache[k] = _.uniq(vv);
            } else {
              if (k === 'basic') {
                cache['basic'] = _.intersection(_.uniq(_.flatten(cache['basic'])), vv)
              } else {
                cache[k].push(vv);
                cache[k] = _.uniq(_.flatten(cache[k]));
              }
            }
          }
        });
      });

      _.forEach(cache, function(v, k) {
        if (count === 0) {
          results = v;
        } else {
          results = _.intersection(results, v);
        }
        count += 1;
      });

      return results;
    }
  }
})();
