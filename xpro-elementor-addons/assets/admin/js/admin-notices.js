!(function (e) {
    "use strict";
    e(document).on("click", ".xpro-theme-builder-notice .notice-dismiss", function (e) {
        jQuery(document).find(".xpro-theme-builder-notice").slideUp(), jQuery.post({ url: ajaxurl, data: { action: "xpro_theme_builder_dismiss_notice" } });
    }),
        e(document).on("click", ".xpro-sales-notice .notice-dismiss", function (e) {
            jQuery(document).find(".xpro-sales-notice").slideUp(), jQuery.post({ url: ajaxurl, data: { action: "xpro_sales_dismiss_notice" } });
        });
})(jQuery);
