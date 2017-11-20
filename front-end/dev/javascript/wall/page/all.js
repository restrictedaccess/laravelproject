Page.all = function($) {
  var init = function() {
    $(function() {
      FastClick.attach(document.body);
    });
  };

  return {
    init: init
  };
}(jQuery);
