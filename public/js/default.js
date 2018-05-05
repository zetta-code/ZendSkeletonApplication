// togglePassword /////
function togglePassword(id) {
    var $self = $(id);

    if ($self.is('input[type=password]')) {
        $self.prop('type', 'text');
    } else if ($self.is('input[type=text]')) {
        $self.prop('type', 'password');
    }
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
// .TOOLTIP /////
$('[data-toggle="tooltip"]').tooltip();
// /TOOLTIP /////

$(function () {
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
});
