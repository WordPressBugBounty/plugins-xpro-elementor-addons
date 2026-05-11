(function ($) {

    "use strict";

    $(window).on("elementor/frontend/init", function () {

        if (typeof elementorModules === "undefined") {
            return;
        }

        var RipplesEffectHandler = elementorModules.frontend.handlers.Base.extend({

            dropInterval: null,

            bindEvents: function () {
                this.run();
            },

            getFxVal: function (setting) {
                return this.getElementSettings(setting);
            },

            destroyRipples: function ($element) {

                if (this.dropInterval) {
                    clearInterval(this.dropInterval);
                    this.dropInterval = null;
                }

                try {
                    if ($element.data("ripples")) {
                        $element.ripples("destroy");
                    }
                } catch (e) {}
            },

            run: function () {

                var $element = this.$element;

                this.destroyRipples($element);

                if (!$element.hasClass("xpro-ripples-effect-enabled")) {
                    return;
                }

                if (typeof $.fn.ripples === "undefined") {
                    return;
                }

                var resolution  = this.getFxVal("xpro_ripples_resolution.size") || 256,
                    dropRadius  = this.getFxVal("xpro_ripples_drop_radius.size") || 20,
                    perturbance = this.getFxVal("xpro_ripples_perturbance.size") || 0.03,
                    interactive = this.getFxVal("xpro_ripples_interactive") === "yes",
                    autoDrops   = this.getFxVal("xpro_ripples_auto_drops") === "yes",
                    interval    = this.getFxVal("xpro_ripples_auto_drops_interval") || 1000;

                try {

                    $element.ripples({
                        resolution: resolution,
                        dropRadius: dropRadius,
                        perturbance: perturbance,
                        interactive: interactive
                    });

                    var data = $element.data("ripples");

                    if (data && data.$canvas) {
                        data.$canvas.addClass("xpro-ripples-container");
                    }

                    if (autoDrops) {

                        this.dropInterval = setInterval(function () {

                            if (!$element.is(":visible")) {
                                return;
                            }

                            if ($element.data("ripples")) {

                                var x = Math.random() * $element.outerWidth(),
                                    y = Math.random() * $element.outerHeight(),
                                    r = Math.random() * 20 + 5,
                                    s = 0.03 + Math.random() * 0.05;

                                $element.ripples("drop", x, y, r, s);
                            }

                        }, interval);
                    }

                } catch (e) {

                    console.error("Xpro Ripples Error:", e.message);
                }
            }
        });

        var addRipplesHandler = function ($element) {

            elementorFrontend.elementsHandler.addHandler(
                RipplesEffectHandler,
                { $element: $element }
            );
        };

        elementorFrontend.hooks.addAction(
            "frontend/element_ready/widget",
            addRipplesHandler
        );

        elementorFrontend.hooks.addAction(
            "frontend/element_ready/section",
            addRipplesHandler
        );

        elementorFrontend.hooks.addAction(
            "frontend/element_ready/column",
            addRipplesHandler
        );

        elementorFrontend.hooks.addAction(
            "frontend/element_ready/container",
            addRipplesHandler
        );

    });

})(jQuery);