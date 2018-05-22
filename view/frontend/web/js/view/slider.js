define([
    'uiComponent',
    'underscore',
    'jquery',
    'AlexRyall_Slider/js/slick'
], function (Component, _, $) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();
        },

        initSlick: function (element) {
            $(element).slick({
                autoplay: this.autoplay,
                pauseOnHover: true,
                autoplaySpeed: this.speed,
                rtl: this.rtl,
                fade: this.fade
            });
        }
    });
});
