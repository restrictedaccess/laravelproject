/**
 * Page sharing elements
 */

Widget.elements = (function () {
  return {
    selectBox: function () {
      $('.select__box').each(function() {
        var $select = $(this).children('.select__box__actual');
        var $option = $select.find('option:selected');
        $(this).prepend('<label class="select__box__label">' + $option.text().substr(0, 20) + '</label>');
        if ($(this).children('.select__box__label').length > 1) {
          $(this).children('.select__box__label:first-child').remove();
        }
        var $selectLabel = $(this).children('.select__box__label');

        $select.on('change', function() {
          var $self = $(this);
          var $current = $self.find('option:selected');
          $selectLabel.text($current.text().substr(0, 20));
          $self.blur();
        });
      });
    }
  };
})(jQuery);
