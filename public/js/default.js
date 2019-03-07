jQuery(function($) {
    $.extend({
        // FORM FUNCTION
        form: function(url, data, method) {
            if (method == null) method = 'POST';
            if (data == null) data = {};

            var form = $('<form>').attr({
                method: method,
                action: url
            }).css({
                display: 'none'
            });

            var addData = function(name, data) {
                if ($.isArray(data)) {
                    for (var i = 0; i < data.length; i++) {
                        var value = data[i];
                        addData(name + '[]', value);
                    }
                } else if (typeof data === 'object') {
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            addData(name + '[' + key + ']', data[key]);
                        }
                    }
                } else if (data != null) {
                    form.append($('<input>').attr({
                        type: 'hidden',
                        name: String(name),
                        value: String(data)
                    }));
                }
            };

            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    addData(key, data[key]);
                }
            }

            return form.appendTo('body');
        }
    });
});

// togglePassword /////
function togglePassword(id) {
    var $self = $(id);

    if ($self.is('input[type=password]')) {
        $self.prop('type', 'text');
    } else if ($self.is('input[type=text]')) {
        $self.prop('type', 'password');
    }
}

// toggleButton /////
function toggleButtonClass(changedId, activeClass) {
    changedId = '#' + changedId;

    $(changedId).closest('.btn-group').find('.btn').removeClass(activeClass).addClass('btn-outline-secondary');
    $(changedId).parent().removeClass('btn-outline-secondary').addClass(activeClass);
    return true;
}
function toggleYesNoButtonClass(changedId) {
    changedId = '#' + changedId;
    var isYesButton = $(changedId).parent().hasClass('btn-yes'),
        isExtraButton = $(changedId).parent().hasClass('btn-extra');
    if (isExtraButton) {
        $(changedId).closest('.btn-group').find('.btn').removeClass('btn-success btn-danger active').addClass('btn-outline-secondary');
    } else {
        var otherButton = isYesButton ? '.btn-no' : '.btn-yes',
            otherLabel = $(changedId).parent().parent().find(otherButton),
            thisAdd, otherRemove, thisRemove, otherAdd;
        if ($(changedId).prop('checked')) {
            thisRemove = 'btn-outline-secondary';
            otherAdd = 'btn-outline-secondary';
            if (isYesButton) {
                thisAdd = 'btn-success';
                otherRemove = 'btn-danger';
            } else {
                thisAdd = 'btn-danger';
                otherRemove = 'btn-success';
            }
        } else {
            thisAdd = 'btn-secondary';
            if (isYesButton) {
                thisAdd = 'btn-success';
                otherRemove = 'btn-danger';
            } else {
                thisAdd = 'btn-danger';
                otherRemove = 'btn-success';
            }
        }
        $(changedId).parent().removeClass(thisRemove).addClass(thisAdd);
        $(otherLabel).removeClass(otherRemove).addClass(otherAdd);
    }
    return true;
}
function initToggleButtons() {
    $('.btn-yes input:checked,.btn-no input:checked').trigger('change').parent().addClass('active');
    $('.btn-toggle input:checked').trigger('change').parent().addClass('active');
}

// uploadImg /////
function uploadImg(id) {
    $('#' + id + '-upload').change(function () {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                var selectedImage = e.target.result,
                    ext = file.name.split('.').pop();
                $('#' + id + '-preview').attr('src', selectedImage);
                $('#' + id + '-label').text(
                    file.name.length > 12
                        ? file.name.substring(0, 12-ext.length) + '...' + ext
                        : file.name
                );
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}

// uploadImg /////
function checkReCaptcha() {
    var response = grecaptcha.getResponse(),
        div = $('.g-recaptcha');

    if(response.length == 0) {
        div.addClass('animated shake');
        setTimeout(function () {
            div.removeClass('animated shake');
        }, 1000);
        return false;
    } else {
        return true;
    }
}

// postLink{
function postLink(e) {
    e.preventDefault();
    var open = $('.modal-post-link');
    if (open.length > 0) {
        open.modal('hide');
    }

    var link = $(this), modal = $('<div class="modal modal-post-link fade" id="postLinkModal" tabindex="-1" role="dialog" aria-labelledby="postLinkModalLabel" aria-hidden="true">\n' +
        '  <div class="modal-dialog modal-dialog-centered" role="document">\n' +
        '    <div class="modal-content">\n' +
        '      <div class="modal-header">\n' +
        '        <h5 class="modal-title" id="postLinkModalLabel">Modal title</h5>\n' +
        '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
        '          <span aria-hidden="true">&times;</span>\n' +
        '        </button>\n' +
        '      </div>\n' +
        '      <div class="modal-body"></div>\n' +
        '      <div class="modal-footer">\n' +
        '        <form name="post_link" style="display:none;" method="post" action="/"><input type="hidden" name="_method" value="POST"></form>\n' +
        '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\n' +
        '        <button type="button" class="btn btn-primary modal-submit">Submit</button>\n' +
        '      </div>\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</div>')
        .on('show.bs.modal', function () {
            var target = link,
                modal = $(this),// Button that triggered the modal
                url = target.data('pl-url'),
                title = target.data('pl-title'),
                body = target.data('pl-body'),
                form = modal.find('.modal-footer form'),
                closeTitle = target.data('pl-close'),
                closeClass = target.data('pl-close-class'),
                submit = modal.find('.modal-footer .modal-submit'),
                submitTitle = target.data('pl-submit'),
                submitClass = target.data('pl-submit-class');
            form.attr('action', url);

            if (title !== undefined) {
                modal.find('.modal-title').html(title);
            }
            if (body !== undefined) {
                modal.find('.modal-body').html(body);
            } else {
                modal.find('.modal-body').addClass('d-none');
            }

            if (closeTitle !== undefined) {
                modal.find('.modal-footer .btn-secondary').html(closeTitle);
            }
            if (closeClass !== undefined) {
                modal.find('.modal-footer .btn-secondary').removeClass('btn btn-secondary').addClass(closeClass);
            }

            submit.click(function () {
                form.submit();
                modal.modal('hide');
            });
            if (submitTitle !== undefined) {
                submit.html(submitTitle);
            }
            if (submitClass !== undefined) {
                submit.removeClass('bnt btn-primary').addClass(submitClass);
            }
        })
        .on('hidden.bs.modal', function () {
            $(this).remove();
        });

    $('body').append(modal);
    modal.modal();
}
// }postLink

(function () {
    // MASK JQUERY /////
    $('input.mask-int').mask('0#');
    $('input.mask-float').mask('DR', {
        translation: {
            D: {pattern: /[0-9,]/},
            R: {pattern: /[0-9,]/, recursive: true}
        }
    });
    $('input.mask-nota').mask('90,99', {
        translation: {
            v: {pattern: /[,/.]/, fallback: ','},
        },
        reverse: true
    });
    $('input.mask-enem').mask('0999v9', {
        translation: {
            v: {pattern: /[,]/, fallback: ','}
        },
        optional: true
    });
    $('input.mask-cep').mask('00000-000');
    $('input.mask-cpf').mask('000.000.000-00');
    $('input.mask-date').mask('00/00/0000');
    $('input.mask-timeHM').mask('09:09');
    // MONEY INPUT /////
    jQuery.fn.putCursorAtEnd = function () {
        return this.each(function () {
            // Cache references
            var $el = $(this),
                el = this;

            // Only focus if input isn't already
            if (!$el.is(':focus')) {
                $el.focus();
            }

            // If this function exists... (IE 9+)
            if (el.setSelectionRange) {
                // Double the length because Opera is inconsistent about whether a carriage return is one character or two.
                var len = $el.val().length * 2;

                // Timeout seems to be required for Blink
                setTimeout(function () {
                    el.setSelectionRange(len, len);
                }, 1);
            } else {
                // As a fallback, replace the contents with itself
                // Doesn't work in Chrome, but Chrome supports setSelectionRange
                $el.val($el.val());
            }

            // Scroll to the bottom, in case we're in a tall textarea
            // (Necessary for Firefox and Chrome)
            this.scrollTop = 999999;
        });
    };
    $('input.mask-money').mask('#.##0,00', {reverse: true}).on('mouseup keyup keydown keypress', function () {
        var val = this.value,
            precision = 2,
            decimalSep = ',';
        if (val) {
            if (val.length <= precision) {
                while (val.length < precision) {
                    val = '0' + val;
                }
                val = '0' + decimalSep + val;
            } else {
                var parts = val.split(decimalSep);
                parts[0] = parts[0].replace(/^0+/, '');
                if (parts[0].length === 0) {
                    parts[0] = '0';
                }
                val = parts.join(decimalSep);
            }
            this.value = val;
        }
        $(this).putCursorAtEnd();
    });
    $('input.mask-credit-card').mask('0000 0000 0000 0000');
    // MASK TELEFONE /////
    $('input.mask-phone').each(function () {
        var $this = $(this);
        $this.mask(($this.val().length === 15 ? '(00) 00000-0000' : '(00) 0000-00009'), {
            onKeyPress: function(phone, e, field, options){
                $('input.mask-phone').mask((phone.length === 15 ? '(00) 00000-0000' : '(00) 0000-00009'), options);
            },
        });
    });
    ///////////////

    // .TOOLTIP /////
    $('[data-toggle="tooltip"]').tooltip();
    // /TOOLTIP /////

    initToggleButtons();
    $('.post-link').click(postLink);
})();

(function () {
    var itemsAction = $('.items-action'),
        itemsBtn = $('.items-btn'),
        itemsLabel = $('.items-label'),
        itemsAll = $('.items-all'),
        itemsCheckbox = $('.items-checkbox'),
        items = [];

    function itemsInit() {
        itemsCheckbox.filter(':checked').each(function() {
            items.push($(this).val());
        });
        itemsChanged();
    }

    function itemSelect () {
        var self = $(this);
        if(self.prop('checked')) {
            items.push(self.val());
        } else {
            items.splice(items.indexOf(self.val()), 1);
        }
        itemsChanged();
    }

    function itemsChanged() {
        if (items.length > 1) {
            if(items.length === itemsCheckbox.length && itemsAll.prop('checked') === false) {
                itemsAll.prop('checked', true)
                    .prop('indeterminate', false);
            }else if(items.length < itemsCheckbox.length && itemsAll.prop('checked') === true) {
                itemsAll.prop('checked', false)
                    .prop('indeterminate', true);
            }
            itemsLabel.text(items.length + ' items selecionados');
            itemsBtn.removeClass('d-none');
        } else if (items.length === 1) {
            itemsAll.prop('indeterminate', true);
            itemsLabel.text('1 item selecionado');
            itemsBtn.removeClass('d-none');
        } else {
            itemsAll.prop('checked', false)
                .prop('indeterminate', false);
            itemsLabel.text('Nenhum item selecionado');
            itemsBtn.addClass('d-none');
        }
    }

    function itemAllChanged() {
        if(itemsAll.prop('checked')) {
            itemsCheckbox.not(':checked').each(function() {
                var self = $(this);
                self.prop('checked', true);
                items.push(self.val());
            });
        } else {
            itemsCheckbox.filter(':checked').each(function() {
                $(this).prop('checked', false);
            });
            items = [];
        }
        itemsChanged();
    }

    function itemAction(event) {
        event.preventDefault();
        var self = $(this);
        $.form(self.data('url'), {
            step: 1,
            items: JSON.stringify(items)
        }).submit().remove();
    }

    itemsAction.click(itemAction);
    itemsCheckbox.change(itemSelect);
    itemsAll.change(itemAllChanged);
    itemsInit();
})();