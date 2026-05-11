(function ($) {
    "use strict";

    $(window).on("elementor/frontend/init", function () {
        if (typeof elementorModules === "undefined") return;

        var RevealEffectHandler = elementorModules.frontend.handlers.Base.extend({
            bindEvents: function () {
                this.run();
            },

            getFxVal: function (setting) {
                return this.getElementSettings(setting);
            },

            getBgColorsFromRepeater: function (repeaterItems) {
                if (!repeaterItems || !Array.isArray(repeaterItems)) {
                    return ['#111'];
                }
                
                var bgColors = [];
                
                repeaterItems.forEach(function (item) {
                    if (item.xpro_reveal_overlay_color) {
                        bgColors.push(item.xpro_reveal_overlay_color);
                    }
                });
                
                if (bgColors.length === 0) {
                    bgColors = ['#111'];
                }
                
                return bgColors;
            },

            run: function () {
                var $element = this.$element;

                if (!$element.hasClass("xpro-reveal-effect-enabled")) return;

                var selectorType   = this.getFxVal("xpro_reveal_selector_type") || "default";
                var customSelector = this.getFxVal("xpro_reveal_custom_selector") || null;
                var direction      = this.getFxVal("xpro_reveal_direction") || "lr";
                var showContent    = this.getFxVal("xpro_reveal_content_show") === "yes" ? false : true;
                var layers         = parseInt(this.getFxVal("xpro_reveal_layers")) || 1;
                var easing         = this.getFxVal("xpro_reveal_easing") || "easeOutExpo";
                var duration       = this.getFxVal("xpro_reveal_duration.size") || 700;
                var delay          = this.getFxVal("xpro_reveal_delay.size") || 120;
                var coverArea       = this.getFxVal("xpro_reveal_cover_area") || 0;
              
                
                var repeaterItems = this.getFxVal("xpro_reveal_overlay_items") || [];
                var bgColors = this.getBgColorsFromRepeater(repeaterItems);

                // var onStart   = this.getFxVal("xpro_reveal_on_start");
                // var onHalfway = this.getFxVal("xpro_reveal_on_halfway");
                // var onComplete= this.getFxVal("xpro_reveal_on_complete");

                var targets = [];
                if (selectorType === "custom" && customSelector) {
                    targets = $element.find(customSelector).toArray();
                } else {
                    targets = [$element[0]];
                }

                targets.forEach(function (el) {
                    var rev = new RevealFx(el, {
                        isContentHidden: showContent,
                        layers: layers,
                        // onStart: function (el, layers) {
                        //     if (onStart) new Function(onStart).call(el, el, layers);
                        // },
                        // onHalfway: function (el, layers) {
                        //     if (onHalfway) new Function(onHalfway).call(el, el, layers);
                        // },
                        // onComplete: function (el, layers) {
                        //     if (onComplete) new Function(onComplete).call(el, el, layers);
                        // }
                    });

                    function runReveal() {
                        rev.reveal({
                            direction: direction,
                            bgColors: bgColors,
                            easing: easing,
                            duration: duration,
                            delay: delay,
                            coverArea: coverArea,
                        });
                    }

                    var observer = new IntersectionObserver(function (entries, obs) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                runReveal();
                                obs.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.2 });

                    observer.observe(el);
                });
            }
        });

        var addRevealHandler = function ($element) {
            elementorFrontend.elementsHandler.addHandler(RevealEffectHandler, { $element: $element });
        };

        elementorFrontend.hooks.addAction("frontend/element_ready/widget", addRevealHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/section", addRevealHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/column", addRevealHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/container", addRevealHandler);

    });
})(jQuery);