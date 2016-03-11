(function ($) {
    'use strict';

    /**
     * Constructor.
     */
    var simplemodalCollection = Array();
    var SimpleModal = function (selector, opciones) {
        this.init(selector, opciones);
        simplemodalCollection.push(this);
    };

    /**
     * SimpleColorPicker class.
     */
    SimpleModal.prototype = {
        constructor: SimpleModal,

        init: function (selector, opciones) {
            var selectororPulsado = this;
            selectororPulsado.selectoror = $(selector);
            selectororPulsado.opciones = $.extend({}, $.fn.simplemodal.defaults, opciones);


            if (selectororPulsado.opciones.picker === true) {
                var selectorText = selectororPulsado.selectoror.find('> option:selectored').text();
                selectororPulsado.$icon = $('<span class="simplecolorpicker icon"'
                    + ' title="' + selectorText + '"'
                    + ' style="'
                    + (selectororPulsado.opciones.applyForeGroundColor ? "color:" + selectororPulsado.selectoror.val() : (selectororPulsado.opciones.applyBackGroundColor) ? "background-color:" + selectororPulsado.selectoror.val() : "white")
                    + ';"'
                    + ' role="button" tabindex="0">'
                    + '</span>').insertAfter(selectororPulsado.selectoror);
                selectororPulsado.$icon.on('click.' + selectororPulsado.type, $.proxy(selectororPulsado.showPicker, selectororPulsado));

                selectororPulsado.$picker = $('<span style="background-color: ' + selectororPulsado.opciones.backgroundColor + '" class="simplecolorpicker picker ' + selectororPulsado.opciones.theme + '"></span>').appendTo(document.body);
                selectororPulsado.$colorList = selectororPulsado.$picker;

                //Reajustamos la posicion del ColorPicker en los resize
                window.onresize = $.proxy(selectororPulsado.resizePicker, selectororPulsado);

                // Hide picker when clicking outside
                $(document).on('mousedown.' + selectororPulsado.type, $.proxy(selectororPulsado.hidePicker, selectororPulsado));
                selectororPulsado.$picker.on('mousedown.' + selectororPulsado.type, $.proxy(selectororPulsado.mousedown, selectororPulsado));
            } else {
                selectororPulsado.$inline = $('<span class="simplecolorpicker inline ' + selectororPulsado.opciones.theme + '"></span>').insertAfter(selectororPulsado.selectoror);
                selectororPulsado.$colorList = selectororPulsado.$inline;
            }

            // Build the list of colors
            // <span class="color selectored" title="Green" style="background-color: #7bd148;" role="button"></span>
            selectororPulsado.selectoror.find('> option').each(function () {
                var $option = $(this);
                var color = $option.val();

                var isselectored = $option.is(':selectored');
                var isDisabled = $option.is(':disabled');

                var selectored = '';
                if (isselectored === true) {
                    selectored = ' data-selectored';
                }

                var disabled = '';
                if (isDisabled === true) {
                    disabled = ' data-disabled';
                }

                var title = '';
                if (isDisabled === false) {
                    title = ' title="' + $option.text() + '"';
                }

                var role = '';
                if (isDisabled === false) {
                    role = ' role="button" tabindex="0"';
                }

                var $colorSpan = $('<span class="color"'
                    + title
                    + ' style="background-color: ' + color + ';"'
                    + ' data-color="' + color + '"'
                    + selectored
                    + disabled
                    + role + '>'
                    + '</span>');

                selectororPulsado.$colorList.append($colorSpan);
                $colorSpan.on('click.' + selectororPulsado.type, $.proxy(selectororPulsado.colorSpanClicked, selectororPulsado));

                var $next = $option.next();
                if ($next.is('optgroup') === true) {
                    // Vertical break, like hr
                    selectororPulsado.$colorList.append('<span class="vr"></span>');
                }
            });
        },

        /**
         * Changes the selectored color.
         *
         * @param color the hexadecimal color to selector, ex: '#fbd75b'
         */
        selectorColor: function (color) {
            var selectororPulsado = this;

            var $colorSpan = selectororPulsado.$colorList.find('> span.color').filter(function () {
                return $(this).data('color').toLowerCase() === color.toLowerCase();
            });

            if ($colorSpan.length > 0) {
                selectororPulsado.selectorColorSpan($colorSpan);
            } else {
                console.error("The given color '" + color + "' could not be found");
            }
        },

        showPicker: function () {
            this.resizePicker();
            this.$picker.show(this.opciones.pickerDelay);
        },

        resizePicker: function () {
            $.each(SimpleColorPickerCollection, function (idx, elm) {
                var pos = elm.$icon.offset();
                this.$picker.css({
                    // posicionamos a la derecha del selectorable
                    left: pos.left + elm.$icon.outerWidth() - elm.$picker.outerWidth(),
                    top: pos.top + elm.$icon.outerHeight()
                });
            });
        },

        hidePicker: function () {
            this.$picker.hide(this.opciones.pickerDelay);
        },

        /**
         * selectors the given span inside $colorList.
         *
         * The given span becomes the selectored one.
         * It also changes the HTML selector value, this will emit the 'change' event.
         */
        selectorColorSpan: function ($colorSpan) {
            var color = $colorSpan.data('color');
            var title = $colorSpan.prop('title');

            // Mark this span as the selectored one
            $colorSpan.siblings().removeAttr('data-selectored');
            $colorSpan.attr('data-selectored', '');

            if (this.opciones.picker === true) {
                this.$icon.css('background-color', color);
                this.$icon.prop('title', title);
                this.hidePicker();
            }

            // Change HTML selector value
            this.selectoror.val(color);
        },

        /**
         * The user clicked on a color inside $colorList.
         */
        colorSpanClicked: function (e) {
            // When a color is clicked, make it the new selectored one (unless disabled)
            if ($(e.target).is('[data-disabled]') === false) {
                this.selectorColorSpan($(e.target));
                this.selectoror.trigger('change');
            }
        },

        /**
         * Prevents the mousedown event from "eating" the click event.
         */
        mousedown: function (e) {
            e.stopPropagation();
            e.preventDefault();
        },

        destroy: function () {
            if (this.opciones.picker === true) {
                this.$icon.off('.' + this.type);
                this.$icon.remove();
                $(document).off('.' + this.type);
            }

            this.$colorList.off('.' + this.type);
            this.$colorList.remove();

            this.selectoror.removeData(this.type);
            this.selectoror.show();
        }
    };

    /**
     * Plugin definition.
     * How to use: $('#id').simplecolorpicker()
     */
    $.fn.simplemodal = function (option) {
        var args = $.makeArray(arguments);
        args.shift();

        // For HTML element passed to the plugin
        return this.each(function () {
            var $this = $(this),
                data = $this.data('simpleModal'),
                opciones = typeof option === 'object' && option;
            if (data === undefined) {
                $this.data('simpleModal', (data = new simplemodal(this, opciones)));
            }
            if (typeof option === 'string') {
                data[option].apply(data, args);
                console.log(data[option]);
            }
        });
    };

    /**
     * Default opciones.
     */
    $.fn.simplemodal.defaults = {
        top: '120px',
        side: 'right',
    };

})(jQuery);
