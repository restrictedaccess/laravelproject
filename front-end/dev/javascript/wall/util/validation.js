/**
 * Validation helper
 */
Util.validation = (function () {
  var getFormData = function ($form) {
    var _key, _value, _tag, _type, _required,
        _formData = {
          error: {}
        };

    $($form + ' .js-answer-key').each(function (index, el) {
      var $el = $(el);
      _tag = $el.get(0).tagName;
      if (_tag !== 'INPUT') {
        _type = _tag;
      } else {
        _type = $el.attr('type');
      }

      //init data
      _value = 'non-data';
      _key = $el.attr('name');
      _required = $el.attr('data-required');
      _formData.error[_key] = true;
      //end
      switch (_type) {
        case 'checkbox':
          if (_key.indexOf('[]')) { //multiple checkbox
            var _getValue = [];
            $('input[name="' + _key + '"]').each(function () {
              if ($(this).prop('checked')) {
                _getValue.push($el.val());
              }
            });
            if (_getValue.length > 0) {
              _value = _getValue;
            }
          } else { //single checkbox true|false
            if ($el.prop('checked')) {
              _value = 1;
            } else {
              _value = 0;
            }
          }

          break;
        case 'radio':
          $('input[name=' + _key + ']').each(function () {
            if ($(this).prop('checked')) {
              _value = $(this).val();
            }
          });
          break;
        case 'SELECT':
          if ($el.val() != -1) {
            _value = $el.val();
          }
          break;
        default:
          _value = $el.val();
          break;
      }
      if (_value === 'non-data' && _required) {
        _formData.error[_key] = true;
      } else {
        delete _formData.error[_key];
      }
    });

    return _formData;
  };

  var formControl = function (valid, $form) {
    //control button
    var $next = $($form + ' .js-next-button, .js-submit-button');
    if (valid) {
      $next.removeAttr('disabled');
    } else {
      $next.attr('disabled', 'disabled');
    }
  };

  var actionValid = function (form) {
    form = '#form_' + form;
    var formData = {};
    $(document).on('change', form + ' .js-answer-key, .js-submit-button', function () {
      if ($(this).attr('data-required')) {
        formData = getFormData(form);
        if (jQuery.isEmptyObject(formData.error)) {
          formControl(true, form);
        } else {
          formControl(false, form);
        }
      } else {
        formControl(true, form);
      }
    });
    formData = null;
  };

  return {
    getFormData: getFormData,
    formControl: formControl,
    actionValid: actionValid
  }
})(jQuery);
