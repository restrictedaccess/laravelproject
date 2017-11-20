/*
 *
 */
Widget.surveyModule = function ($) {
  var $reply = $('.js-render-reply');

  var init = function () {
    _bind();
  };

  var _bind = function () {
    $('.js-choice-reply').on('change', function () {
      _onReply($(this));
    });
  };

  var _onReply = function (e) {
    if (e.prop('checked')) {
      var _reply_type = e.val();
      $reply.filter('[data-reply!="' + _reply_type + '"]').addClass('is-hidden');
      $reply.filter('[data-reply="' + _reply_type + '"]').removeClass('is-hidden');
      $('input[name="' + _reply_type + '-willing"]').prop('checked', false);
    }
  };

  return {
    init: init
  };

}(jQuery);
