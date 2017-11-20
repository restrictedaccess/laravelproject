/**
 * Form and/or Questions Processing
 */

Widget.form = (function () {
  // Templates for questions and answers
  var initialData, thisForm,
      inheritData = {},
      initialForm = '001',
      formTarget  = '#risk-reduction-score';

  var formList = ['001', '002', '003', '004', '005-1', '005-2', '005-3', '005-4', '006', '007-1', '007-2', '007-3', '007-4', '007-5', '007-6', '007-7', '008', '009', '010', '011', '013', '015', '017', '018', '020', '022', '023', '024', '027', '030', '031', '032', '033', '034', '035'];

  $.templates('tmplTopic', '<div class="form-topic js-form_{{:#data.current}}" id="form_{{:#data.current}}" style="display: none;">' +
    '  <h3 class="topic__title c">{{:main.title}}</h3>' +
    '  <div class="topic__cover {{:main.image}}">' +
    '  </div>' +
    '  <button type="button" name="next-question" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button" data-form="{{:#data.next}}">Next</button>' +
    '</div>');

  $.templates('tmplQuestionMain', '<div class="form-question js-form_{{:#data.current}}" id="form_{{:#data.current}}" style="display: none;">' +
    '  <div class="question__cat {{:main.id}}">' +
    '    <span class="question__icon {{:main.image}}"></span><span class="question__group">{{:main.group}}</span>' +
    '  </div>' +
    '  <div class="question__main">' +
    '    {{if !main.label}}' +
    '    <h3 class="question__title--first c">{{:main.title}}</h3>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    {{else !main.title}}' +
    '    <h4 class="question__title--second c">{{:main.label}}</h4>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    {{else}}' +
    '    <h3 class="question__title--first c">{{:main.title}}</h3>' +
    '    {{if main.help}}<p class="question__help c">{{:main.help}}</p>{{/if}}' +
    '    <div class="hr-line"></div>' +
    '    <h4 class="question__title--second c">{{:main.label}}</h4>' +
    '    {{/if}}' +
    '    {{if main.answers.template == "radio-circle"}}' +
    '      {{include main.answers tmpl="tmplRadioCircle" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "checkbox-option"}}' +
    '      {{include main.answers tmpl="tmplCheckbox" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "radio-regular"}}' +
    '      {{include main.answers tmpl="tmplRadioRegular" ~data=#data.main ~current=#data.current /}}' +
    '    {{else main.answers.template == "select-option"}}' +
    '      {{include main.answers tmpl="tmplSelect" ~data=#data.main ~current=#data.current /}}' +
    '    {{/if}}' +
    '  </div>' +
    '  {{if #data.next}}' +
    '    {{if #data.current == "008" || #data.current == "009" || #data.current == "031"}}' +
    '  <button type="button" name="next" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}">Next</button>' +
    '    {{else}}' +
    '  <button type="button" name="next" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}" disabled="">Next</button>' +
    '    {{/if}}' +
    '  {{else}}' +
    '  <button type="submit" name="" class="btn btn-block btn__regular long btn__regular--uppercase js-submit-button" id="btn_form_{{:#data.current}}" disabled="">Next</button>' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplQuestionInherit', '<div class="form-question js-form_{{:#data.current}}" id="form_{{:#data.current}}">' +
    '  <div class="question__cat {{:#data.main.id}}">' +
    '    <span class="question__icon {{:#data.main.image}}"></span><span class="question__group">{{:#data.main.group}}</span>' +
    '  </div>' +
    '  {{props #data.inherit ~data=#data.main}}' +
    '  <div class="question__main">' +
    '    <h4 class="question__title--second c">Are you currently using treatment to control <span class="b">{{>prop}}</span>? Please mark all that apply.</h4>' +
    '    <div id="{{:~data.id}}_{{>key}}" class="answers">' +
    '      {{props ~data.answers.list ~key=key}}' +
    '      <div class="radio__regular">' +
    '        <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{:~key}}{{>key}}" name="{{:~data.id}}_{{:~key}}" value="{{>key}}" data-required="true">' +
    '        <label class="radio__regular__label" for="{{:~data.id}}_{{:~key}}{{>key}}">{{>prop}}</label>' +
    '      </div>' +
    '      {{/props}}' +
    '    </div>' +
    '  </div>' +
    '  {{/props}}' +
    '  <button type="button" name="next" class="btn btn-block btn__regular long btn__regular--uppercase js-next-button" id="btn_form_{{:#data.current}}" data-form="{{:#data.next}}" disabled="">Next</button>' +
    '</div>');

  $.templates('tmplQuestionDepend', '<div class="question__depend">' +
    '  <h4 class="question__title--second c">{{:label}}</h4>' +
    '  {{if help}}<p class="question__help">{{:help}}</p>{{/if}}' +
    '  {{if answers.template == "radio-circle"}}' +
    '    {{include answers tmpl="tmplRadioCircle" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "checkbox-option"}}' +
    '    {{include answers tmpl="tmplCheckbox" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "radio-regular"}}' +
    '    {{include answers tmpl="tmplRadioRegular" ~data=#data ~current=#data.current /}}' +
    '  {{else answers.template == "select-option"}}' +
    '    {{include answers tmpl="tmplSelect" ~data=#data ~current=#data.current /}}' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplRadioCircle', '{{if list.length == 5}}' +
    '<div id="{{:~data.id}}" class="answers answers--5">' +
    '{{else list.length == 6}}' +
    '<div id="{{:~data.id}}" class="answers answers--6">' +
    '{{else list.length == 8}}' +
    '<div id="{{:~data.id}}" class="answers answers--8">' +
    '{{else}}' +
    '<div id="{{:~data.id}}" class="answers">' +
    '{{/if}}' +
    '  <div class="answers__list">' +
    '    {{props list ~default=default ~logical=logical ~suffix=suffix}}' +
    '      {{if key == 6 && prop == "Don\'t know"}}' +
    '  </div>' +
    '  {{if ~suffix}}<div class="answers__suffix">{{:~suffix}}</div>{{/if}}' +
    '  <div class="answers__list">' +
    '      {{/if}}' +
    '    <div class="radio__circle">' +
    '      {{if ~logical}}' +
    '        {{props ~logical ~item=key}}' +
    '          {{if key == ~item}}' +
    '      <input type="radio" class="radio__circle__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" onclick="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{>prop}}\', this);"{{if ~item == ~default}} checked=""{{/if}} data-required="true">' +
    '          {{/if}}' +
    '        {{/props}}' +
    '      {{else}}' +
    '      <input type="radio" class="radio__circle__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" {{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '      {{/if}}' +
    '      <label for="{{:~data.id}}_{{>key}}" class="radio__circle__inner{{if prop == "Don\'t know"}} radio__circle__inner--long{{/if}}">{{>prop}}</label>' +
    '    </div>' +
    '      {{if key == 6 && prop == "Don\'t know"}}' +
    '  </div>' +
    '      {{/if}}' +
    '    {{/props}}' +
    '  </div>' +
    '  {{if list[6] !== "Don\'t know"}}' +
    '    {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '  {{/if}}' +
    '</div>');

  $.templates('tmplRadioRegular', '<div id="{{:~data.id}}" class="answers">' +
    '  {{props list ~default=default ~logical=logical}}' +
    '  <div class="radio__regular">' +
    '    {{if ~logical}}' +
    '      {{props ~logical ~item=key}}' +
    '        {{if key == ~item}}' +
    '    <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}" onclick="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{>prop}}\', this);"{{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '        {{/if}}' +
    '      {{/props}}' +
    '    {{else}}' +
    '    <input type="radio" class="radio__regular__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}" value="{{>key}}"{{if key == ~default}} checked=""{{/if}} data-required="true">' +
    '    {{/if}}' +
    '    <label class="radio__regular__label" for="{{:~data.id}}_{{>key}}">{{>prop}}</label>' +
    '  </div>' +
    '  {{/props}}' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  $.templates('tmplCheckbox', '<div id="{{:~data.id}}" class="answers">' +
    '  {{props list ~default=default ~logical=logical}}' +
    '  <div class="checkbox__styled">' +
    '    {{if ~logical}}' +
    '    <input type="checkbox" class="checkbox__styled__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}[]" value="{{>key}}" onchange="PBS.Widget.form.handleLogic(this, \'{{:~logical}}\');"{{props ~default ~item=key}}{{if prop == ~item}} checked=""{{/if}}{{/props}}{{if ~current != "031"}} data-required="true"{{/if}}>' +
    '    {{else}}' +
    '    <input type="checkbox" class="checkbox__styled__input js-answer-key" id="{{:~data.id}}_{{>key}}" name="{{:~data.id}}[]" value="{{>key}}"{{props ~default ~item=key}}{{if prop == ~item}} checked=""{{/if}}{{/props}}{{if ~current != "031"}} data-required="true"{{/if}}>' +
    '    {{/if}}' +
    '    <label class="checkbox__styled__label" for="{{:~data.id}}_{{>key}}">{{>prop}}</label>' +
    '  </div>' +
    '  {{/props}}' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  $.templates('tmplSelect', '<div id="{{:~data.id}}" class="answers">' +
    '  <div class="select__box">' +
    '    <select class="select__box__actual js-answer-key" name="{{:~data.id}}"{{if logical}} onchange="PBS.Widget.form.handleLogic(\'{{:~current}}\', \'{{:logical}}\', this);"{{/if}} data-required="true">' +
    '      {{if ~current == "018" || ~current == "020" || ~current == "021"}}' +
    '      <option value="-1">Select your answer</option>' +
    '      {{/if}}' +
    '      {{props list ~default=default}}' +
    '      <option value="{{>key}}"{{if key == ~default}} selected=""{{/if}}>{{>prop}}</option>' +
    '      {{/props}}' +
    '    </select>' +
    '  </div>' +
    '  {{if suffix}}<div class="answers__suffix">{{:suffix}}</div>{{/if}}' +
    '</div>');

  // Handle browser history for "Back" case
  var historyPush = function (form) {
    window.location.hash = '#' + form;
    Page.rrs.handleGA(form);
  };

  var historyReplace = function (form) {
    window.location.hash = '#' + form;
  };

  // Render form on requested
  var renderMain = function (form, target) {
    // Read into the specified form, eg. data.001: {}
    var _render, _data;

    _data = initialData[form];

    if (form == '032') {
      delete _data['inherit'];
      if (!_data['inherit']) {
        _data['inherit'] = inheritData;
      }
      _render = $.render.tmplQuestionInherit(_data);
    } else {
      switch (_data.main.type) {
        case 'topic':
          _render = $.render.tmplTopic(_data);
          break;
        case 'question':
          _render = $.render.tmplQuestionMain(_data);
          break;
        default:
          _render = null;
      }
    }

    if (target) {
      $(_render).insertAfter('#form_' + target);
    } else {
      $(formTarget).append(_render);
    }

    if (form == '027') {
      renderDepend(form);
      renderDepend(form, 1);
    }

    Widget.elements.selectBox();

    _data = _render = null;
  };

  var renderDepend = function (tg, num) {
    var _render,
        _data = initialData[tg].depend,
        _tg = '#form_' + tg;

    for (var i = 0; i < _data.length; i++) {
      _data[i]['current'] = initialData[tg].current;
    }

    if (num) {
      _render = $.render.tmplQuestionDepend(_data[1]);
      $(_render).insertAfter(_tg + ' > .question__depend:eq(0)');
    } else {
      _render = $.render.tmplQuestionDepend(_data[0]);
      $(_render).insertAfter(_tg + ' > .question__main');
    }
    Widget.elements.selectBox();

    _render = _data = null;
  };

  var handleLogic = function (el, action, itself) {
    if (itself) {
      var itsId = '#' + itself.id;
      $(itsId).off('change');
    }

    if (el !== null && typeof el !== 'object') {
      var $el = $('#form_' + el);
    }

    var _action = action.split('-'),
        logic = action;

    if (_action != action) {
      logic = _action[0];
    }
    switch (logic) {
      case 'paintDepend':
        if (_action[1]) {
          if ($el.children('.question__depend').length == 1) {
            renderDepend(el, 2);
          }
        } else {
          if (!$el.children('.question__depend').length) {
            renderDepend(el);
          }
        }
        break;
      case 'destroyDepend':
        if (el == '013') {
          $('#btn_form_013').attr('data-form', '017');
        }
        $el.children('.question__depend').remove();
        break;
      case 'collectData':
        if (_action[1] == '031') {
          $('#btn_form_031').attr('data-form', '032');
          if (el.checked && !inheritData[el.value]) {
            inheritData[el.value] = $('#' + el.id).next().text();
          } else {
            delete inheritData[el.value];
          }

          el = el.id;
        }
        break;
      case 'skippable':
        if ($el.children('.js-next-button').length == 1) {
          $('#btn_form_' + el).attr('data-form', _action[1]);
        }
        break;
      case 'skipHistory':
        var elOneLv = formList[formList.indexOf(el) - 1],
            $elOneLv = $('#form_' + elOneLv),
            elTwoLv = formList[formList.indexOf(el) - 2],
            $elTwoLv = $('#form_' + elTwoLv);
        if (_action[1] == 'noskip') {
          if ($el.length == 0) {
            renderMain(el, elOneLv);
          } else {
            if (el == '032') {
              $el.remove();
              renderMain(el, elOneLv);
            }
          }
        } else {
          if ($el.length == 0) {
            renderMain(el, elTwoLv);
          }
        }
        historyReplace(el);
        $elTwoLv.hide();
        $elOneLv.hide();
        break;
      default:
        break;
    }

    Util.validation.actionValid(el);
    if (itself) {
      $(itsId).trigger('change');
    }
  };

  var readData = function () {
    var $defer = new $.Deferred;
    $.getJSON('../data/data.min.json').success(function (data) {
      initialData = data;
      $defer.resolve();
    });
    return $defer.promise();
  };

  var handleProgess = function (form) {
    var total = formList.length,
        current = formList.indexOf(form) + 1,
        percent = (current/total)*100;

    percent = percent.toFixed(0);

    $('.percent').animate({
      left: percent + '%'
    }, {
      duration: 800,
      start: function () {
        $('.progress__bar__current').animate({
          width: percent + '%'
        }, 800);
      }
    }, 800);
    $('.progress__bar__current span').text(percent);
  };

  var initialRender = function (formData) {
    historyPush(initialForm);
    var _initialRender = $.render.tmplTopic(initialData[initialForm]);
    $(formTarget).append(_initialRender);
    $('#form_' + initialForm).show();
    _initialRender = null;
  };

  return {
    formList: formList,
    readData: readData,
    renderMain: renderMain,
    renderDepend: renderDepend,
    initialRender: initialRender,
    handleLogic: handleLogic,
    handleProgess: handleProgess,
    historyPush: historyPush,
    historyReplace: historyReplace
  }
})(jQuery);
