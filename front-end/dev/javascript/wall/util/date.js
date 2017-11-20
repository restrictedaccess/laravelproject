/**
 * date utility
 */
Util.date = (function() {

  // Get date of today
  var today = function() {
    // Dateオブジェクトを生成
    var now = new Date();
    var y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var h = now.getHours();
    var i = now.getMinutes();
    return y + '-' + m + '-' + d + '-' + h + '-'+ i;
  };

  return {

    latest: {

      latestKey: 'latest',

      /*
       * @return {Boolean}
       * ローカルストレイジを使って最近アクセスしたのが今日かどうか判定
       */
      isToday: function() {
        var now       = new Date(),
            latest    = new Date(Util.storage.get(this.latestKey)),
            diffYear  = now.getFullYear()     === latest.getFullYear(),
            diffMonth = (now.getMonth() + 1)  === (latest.getMonth() + 1),
            diffDate  = now.getDate()         === latest.getDate(),
            diffHours = now.getHours()        <  8; // バッチが十分に回りきったあとの時間がだいたい8時

        if (diffYear && diffMonth && diffDate || diffHours) {
          return true;
        }
        // if (diffHours) {
        //   return true;
        // }
        return false;
      },

      /*
       * @return {String} latestKey
       */
      getLatestKey: function() {
        return this.latestKey;
      }
    },

    today: today
  }
})();
