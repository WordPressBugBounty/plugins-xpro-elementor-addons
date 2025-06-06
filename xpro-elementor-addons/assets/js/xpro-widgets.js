!(function (e, t) {
    "use strict";
    let o = {
        init: function () {
            let t = {
                widget: o.BackgroundOverlay,
                "xpro-simple-gallery.default": o.SimpleGallery,
                "xpro-simple-portfolio.default": o.SimplePortfolio,
                "xpro-progress-bar.default": o.ProgressBar,
                "xpro-pie-chart.default": o.PieChart,
                "xpro-counter.default": o.Counter,
                "xpro-horizontal-menu.default": o.HorizontalMenu,
                "xpro-team.default": o.Team,
                "xpro-before-after.default": o.BeforeAfter,
                "xpro-content-toggle.default": o.ContentToggle,
                "xpro-news-ticker.default": o.NewsTicker,
                "xpro-table.default": o.Table,
                "xpro-icon-box.default": o.IconBox,
                "xpro-post-grid.default": o.PostGrid,
                "xpro-hot-spot.default": o.HotSpot,
                "xpro-image-scroller.default": o.ImageScroller,
                "xpro-horizontal-timeline.default": o.HorizontalTimeline,
                "xpro-contact-form.default": o.ContactForm,
                "xpro-search.default": o.Search,
                "xpro-course-grid.default": o.CourseGrid,
                "xpro-woo-product-grid.default": o.ProductGrid,
                "xpro-hero-slider.default": o.HeroSlider,
            };
            e.each(t, function (e, t) {
                elementorFrontend.hooks.addAction("frontend/element_ready/" + e, t);
            }),
                e("body").on("click.onWrapperLink", "[data-xpro-element-link]", function () {
                    var t,
                        o,
                        i = e(this),
                        n = i.data("xpro-element-link"),
                        r = i.data("id"),
                        a = document.createElement("a");
                    (a.id = "xpro-addons-wrapper-link-" + r),
                        (a.href = n.url),
                        (a.target = n.is_external ? "_blank" : "_self"),
                        (a.rel = n.nofollow ? "nofollow noreferer" : ""),
                        (a.style.display = "none"),
                        document.body.appendChild(a),
                        (t = document.getElementById(a.id)).click(),
                        (o = setTimeout(function () {
                            document.body.removeChild(t), clearTimeout(o);
                        }));
                }),
                e("[data-xpro-equal-height]").each(function () {
                    var t = e(this),
                        o = e(this).data("xpro-equal-height");
                    if ("widgets" === o) {
                        let i = e(this).find(".elementor-widget"),
                            n = 0;
                        i.each(function () {
                            n = Math.max(n, e(this).outerHeight());
                        }),
                            i.css({ minHeight: n + "px" });
                    } else {
                        let r = 0;
                        setTimeout(function () {
                            t.find(o).each(function () {
                                r = Math.max(r, e(this).outerHeight());
                            }),
                                t.find(o).css({ minHeight: r + "px" });
                        }, 100);
                    }
                });
        },
        BackgroundOverlay: function e(t) {
            t.hasClass("elementor-element-edit-mode") && t.addClass("xpro-widget-bg-overlay");
        },
        getElementSettings: function (e, t) {
            var i = {},
                n = e.data("model-cid");
            if (elementorFrontend.isEditMode() && n) {
                var r = elementorFrontend.config.elements.data[n],
                    a = r.attributes.widgetType || r.attributes.elType,
                    l = elementorFrontend.config.elements.keys[a];
                l ||
                    ((l = elementorFrontend.config.elements.keys[a] = []),
                    jQuery.each(r.controls, function (e, t) {
                        t.frontend_available && l.push(e);
                    })),
                    jQuery.each(r.getActiveControls(), function (e) {
                        -1 !== l.indexOf(e) && (i[e] = r.attributes[e]);
                    });
            } else i = e.data("settings") || {};
            return o.getItems(i, t);
        },
        getItems: function (e, t) {
            if (t) {
                var o = t.split("."),
                    i = o.splice(0, 1);
                if (!o.length) return e[i];
                if (!e[i]) return;
                return this.getItems(e[i], o.join("."));
            }
            return e;
        },
        SimpleGallery: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-elementor-gallery-wrapper"),
                r = t.find(".xpro-elementor-gallery-filter > ul"),
                a = r.attr("data-default-filter");
            setTimeout(function () {
                n.cubeportfolio({
                    filters: r,
                    layoutMode: "grid",
                    defaultFilter: a,
                    animationType: i.filter_animation,
                    gridAdjustment: "responsive",
                    mediaQueries: [
                        { width: elementorFrontend.config.breakpoints.lg, cols: i.item_per_row || 3, options: { gapHorizontal: i.margin.size || 0, gapVertical: i.margin.size || 0 } },
                        { width: elementorFrontend.config.breakpoints.md, cols: i.item_per_row_tablet || 2, options: { gapHorizontal: i.margin_tablet.size || 0, gapVertical: i.margin_tablet.size || 0 } },
                        { width: 0, cols: i.item_per_row_mobile || 1, options: { gapHorizontal: i.margin_mobile.size || 0, gapVertical: i.margin_mobile.size || 0 } },
                    ],
                    caption: i.hover_effect || "zoom",
                    displayType: "sequentially",
                    displayTypeSpeed: 80,
                });
            }, 500),
                "none" !== i.popup &&
                    n.lightGallery({
                        pager: !0,
                        addClass: "xpro-gallery-popup-style-" + i.popup,
                        selector: "[data-xpro-lightbox]",
                        thumbnail: "yes" === i.thumbnail,
                        exThumbImage: "data-src",
                        thumbWidth: 130,
                        thumbMargin: 15,
                        closable: !1,
                        showThumbByDefault: "yes" === i.thumbnail_by_default,
                        thumbContHeight: 150,
                        subHtmlSelectorRelative: !0,
                        hideBarsDelay: 99999999,
                        share: "yes" === i.share,
                        download: "yes" === i.download,
                    });
            let l = t.find(".xpro-filter-dropdown-tablet,.xpro-filter-dropdown-mobile"),
                s = t.find('[data-filter="' + a + '"]'),
                p = l.find("li.cbp-filter-item-active").text();
            l.find(".xpro-select-content").text(p || s.text()),
                l.on("click", function () {
                    e(this).toggleClass("active");
                }),
                l.find(".cbp-l-filters-button > li").on("click", function () {
                    l.find(".xpro-select-content").text(e(this).text());
                });
        },
        SimplePortfolio: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-elementor-gallery-wrapper"),
                r = t.find(".xpro-elementor-gallery-filter > ul"),
                a = r.attr("data-default-filter");
            u(),
                setTimeout(function () {
                    n.cubeportfolio({
                        filters: r,
                        layoutMode: "grid",
                        defaultFilter: a,
                        animationType: i.filter_animation,
                        gridAdjustment: "responsive",
                        lightboxGallery: !1,
                        mediaQueries: [
                            { width: elementorFrontend.config.breakpoints.lg, cols: i.item_per_row || 3, options: { gapHorizontal: i.margin.size || 0, gapVertical: i.margin.size || 0 } },
                            { width: elementorFrontend.config.breakpoints.md, cols: i.item_per_row_tablet || 2, options: { gapHorizontal: i.margin_tablet.size || 0, gapVertical: i.margin_tablet.size || 0 } },
                            { width: 0, cols: i.item_per_row_mobile || 1, options: { gapHorizontal: i.margin_mobile.size || 0, gapVertical: i.margin_mobile.size || 0 } },
                        ],
                        caption: i.hover_effect || "zoom",
                        displayType: "sequentially",
                        displayTypeSpeed: 80,
                    });
                }, 500);
            let l = t.find(".xpro-filter-dropdown-tablet,.xpro-filter-dropdown-mobile"),
                s = t.find('[data-filter="' + a + '"]'),
                p = l.find("li.cbp-filter-item-active").text();
            l.find(".xpro-select-content").text(p || s.text()),
                l.on("click", function () {
                    e(this).toggleClass("active");
                }),
                l.find(".cbp-l-filters-button > li").on("click", function () {
                    l.find(".xpro-select-content").text(e(this).text());
                });
            var d = null;
            let c = new TimelineLite();
            function f(o, i) {
                let n = e(o).data("title");
                "false" !== (d = e(o).data("src-preview")) &&
                    (e(o).siblings().removeClass("xpro-preview-demo-item-open"),
                    e(o).addClass("xpro-preview-demo-item-open"),
                    t.find(".xpro-preview .xpro-preview-prev-demo,.xpro-preview .xpro-preview-next-demo").removeClass("xpro-preview-inactive"),
                    e(o).prev("[data-src-preview]").length <= 0 && t.find(".xpro-preview .xpro-preview-prev-demo").addClass("xpro-preview-inactive"),
                    e(o).next("[data-src-preview]").length <= 0 && t.find(".xpro-preview .xpro-preview-next-demo").addClass("xpro-preview-inactive"),
                    t.find(".xpro-preview .xpro-preview-header-info").html(""),
                    n && t.find(".xpro-preview .xpro-preview-header-info").append(`<div class="xpro-preview-demo-name">${n}</div>`),
                    t.find(".xpro-preview .xpro-preview-iframe").attr("src", d),
                    e("body").addClass("xpro-preview-active"),
                    t.find(".xpro-preview").addClass("active"));
            }
            function u() {
                t.find(".xpro-preview-demo-item").removeClass("xpro-preview-demo-item-open"),
                    t.find(".xpro-preview .xpro-preview-iframe").removeAttr("src"),
                    e("body").removeClass("xpro-preview-active"),
                    t.find(".xpro-preview").removeClass("active");
            }
            function m() {
                "1" === i.popup_animation && c.to(t.find(".xpro-portfolio-loader-style-1 li"), { duration: 0.4, scaleX: 1, transformOrigin: "bottom right" }),
                    "2" === i.popup_animation && c.to(t.find(".xpro-portfolio-loader-style-2 li"), { duration: 0.4, scaleX: 1, transformOrigin: "bottom left" }),
                    setTimeout(function () {
                        "1" === i.popup_animation && c.to(t.find(".xpro-portfolio-loader-style-1 li"), { duration: 0.4, scaleX: 0, transformOrigin: "bottom left" }),
                            "2" === i.popup_animation && c.to(t.find(".xpro-portfolio-loader-style-2 li"), { duration: 0.4, scaleX: 0, transformOrigin: "bottom right" });
                    }, 2500);
            }
            c.seek(0).clear(),
                (c = new TimelineLite()),
                t.find(".xpro-preview-iframe").on("load", function () {
                    e(this).addClass("loaded"), e(this).contents().find("html").attr("id", "xpro-portfolio-html-main");
                }),
                t.on("click", ".xpro-preview-type-popup", function (t) {
                    e(t.target).is(".xpro-preview-demo-import-open") || (m(), f(this, t));
                }),
                t.on("click", ".xpro-preview-type-link", function (t) {
                    let o = "";
                    return "" !== (o = e(this).data("src-preview")) && window.open(o, i.preview_target), !1;
                }),
                t.on("click", ".xpro-preview-type-none", function (e) {
                    return !1;
                }),
                t.on("click", ".xpro-preview-prev-demo", function (e) {
                    var o = t.find(".xpro-preview-demo-item-open").prev("[data-src-preview]");
                    o.length > 0 && (m(), f(o, e)), e.preventDefault();
                }),
                t.on("click", ".xpro-preview-next-demo", function (e) {
                    var o = t.find(".xpro-preview-demo-item-open").next("[data-src-preview]");
                    o.length > 0 && (m(), f(o, e)), e.preventDefault();
                }),
                t.on("click", ".xpro-preview-close", function (e) {
                    e.preventDefault(),
                        e.stopPropagation(),
                        m(),
                        setTimeout(function () {
                            u();
                        }, 2e3);
                });
        },
        ProgressBar: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-progress-count"),
                r = t.find(".xpro-progress-track");
            t.find(".xpro-progress-bar").waypoint(
                function () {
                    "yes" === i.show_count &&
                        n.animate(
                            { Counter: i.value },
                            {
                                duration: 1e3 * i.duration.size || 3e3,
                                easing: "swing",
                                step: function (t) {
                                    e(this).text(Math.ceil(t)),
                                        e(this)
                                            .parents(".xpro-progress-counter")
                                            .find(".xpro-progress-count-less")
                                            .text(100 - Math.ceil(t));
                                },
                            }
                        ),
                        r.animate({ width: i.value + "%" }, 1e3 * i.duration.size || 3e3);
                },
                { offset: "100%" }
            );
        },
        PieChart: function (t) {
            let i = o.getElementSettings(t);
            t.find(".xpro-pie-chart").easyPieChart({
                scaleColor: "transparent",
                lineWidth: i.chart_bar_size.size,
                lineCap: i.layout,
                barColor: function () {
                    var e = this.renderer.getCtx(),
                        t = this.renderer.getCanvas(),
                        o = e.createLinearGradient(0, 0, t.width, 0);
                    return o.addColorStop(0, i.bar_color_1 || "#6ec1e4"), o.addColorStop(1, i.bar_color_2 || "#6ec1e4"), o;
                },
                trackColor: i.track_color || "#f5f5f5",
                size: i.chart_size.size,
                rotate: 0,
                animate: 1e3 * i.duration.size || 2e3,
            }),
                t.find(".xpro-pie-chart").waypoint(
                    function () {
                        t.find(".xpro-pie-chart-count").animate(
                            { Counter: i.value },
                            {
                                duration: 1e3 * i.duration.size || 2e3,
                                easing: "swing",
                                step: function (t) {
                                    e(this).text(Math.ceil(t) + "%");
                                },
                            }
                        ),
                            t.find(".xpro-pie-chart").data("easyPieChart").update(i.value);
                    },
                    { offset: "100%" }
                );
        },
        Counter: function (t) {
            let i = o.getElementSettings(t);
            let r = "";
            let a = t.find(".xpro-counter-lottie-animation");
            i.lottie_url ? (r = i.lottie_url.url) : i.svg_upload && (r = i.svg_upload.url),
            lottie.loadAnimation({ container: a[0], renderer: "svg", loop: i.loop || !0, autoplay: i.autoplay || !0, path: r });
            "yes" === i.animate_counter &&
                new Waypoint({
                    element: t.find(".xpro-counter-wrapper")[0],
                    handler: function () {
                        t.find(".xpro-counter-item > .value").animate(
                            { Counter: i.value },
                            {
                                duration: 1e3 * i.duration.size || 2e3,
                                easing: "swing",
                                step: function (t) {
                                    e(this).text(Math.ceil(t));
                                },
                            }
                        ),
                            this.destroy();
                    },
                    offset: "100%",
                });
        },
        HorizontalMenu: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-elementor-horizontal-menu-toggler"),
                r = t.find(".xpro-elementor-horizontal-menu-close"),
                a = t.find(".xpro-elementor-horizontal-menu-overlay"),
                l = t.find(".dropdown > a > .xpro-dropdown-menu-toggle");
                e(".xpro-elementor-nav-link").on("click", function (t) {
                    r.click();
                });
            if (
                (t.find(".dropdown li").each(function (t) {
                    if (e("ul", this).length) {
                        let o = e("ul:first", this);
                        o.offset().left + o.width() <= e(window).width() ? e(this).removeClass("xpro-edge") : e(this).addClass("xpro-edge");
                    }
                }),
                "yes" === i.one_page_navigation)
            ) {
                function s(o = !1) {
                    var n = e(document).scrollTop(),
                        r = i.scroll_offset.size || 100;
                    t.find(".xpro-elementor-horizontal-navbar-nav li").each(function () {
                        let i = e(this),
                            a = i.find(".xpro-elementor-nav-link").attr("href"),
                            l = a.indexOf("#");
                        if (-1 !== l) {
                            let s = e(a.substring(l));
                            o && s.length && t.find(".xpro-elementor-horizontal-navbar-nav li:not(:first-child)").removeClass("current_page_item"),
                                s.length && s.position().top - r <= n && s.position().top + s.height() > n && (t.find(".xpro-elementor-horizontal-navbar-nav li").removeClass("current_page_item"), i.addClass("current_page_item"));
                        }
                    });
                }
                e(".xpro-elementor-nav-link").on("click", function (t) {
                    r.click();
                    let o = e(this).attr("href"),
                        n = o.indexOf("#");
                    if (-1 !== n) {
                        let r = e(o.substring(n));
                        if (r.length) {
                            var a = this.hash;
                            t.stopPropagation(),
                                e("html, body").animate({ scrollTop: e(r).offset().top - (i.scroll_offset.size || 100) + 20 }, 500, function () {
                                    window.location.hash = a;
                                });
                        }
                    }
                }),
                    s(!0),
                    e(document).on("scroll", function () {
                        s();
                    });
            }
            if ("none" !== i.responsive_show) {
                let p = "tablet" === i.responsive_show ? 1025 : 768;
                n.on("click", function (e) {
                    e.preventDefault(), t.find(".xpro-elementor-horizontal-navbar-wrapper").toggleClass("active"), t.find(".xpro-elementor-horizontal-menu-overlay").toggleClass("active");
                }),
                    r.on("click", function (e) {
                        e.preventDefault(), t.find(".xpro-elementor-horizontal-navbar-wrapper").removeClass("active"), t.find(".xpro-elementor-horizontal-menu-overlay").removeClass("active");
                    }),
                    a.on("click", function (o) {
                        o.preventDefault(), t.find(".xpro-elementor-horizontal-navbar-wrapper").removeClass("active"), e(this).removeClass("active");
                    }),
                    l.on("click", function (t) {
                        e(window).width() < p && (t.preventDefault(), t.stopPropagation(), e(this).parent().toggleClass("active"), e(this).parent().next(".xpro-elementor-dropdown-menu").slideToggle());
                    }),
                    e(window).resize(function () {
                        e(window).width() > p ? t.find(".xpro-elementor-dropdown-menu").show() : t.find(".xpro-elementor-dropdown-menu").hide(),
                            t.find(".xpro-elementor-horizontal-navbar-wrapper").removeClass("active"),
                            t.find(".xpro-elementor-horizontal-menu-overlay").removeClass("active"),
                            t.find(".dropdown > a").removeClass("active");
                    });
            }
        },
        Team: function (t) {
            let i = o.getElementSettings(t);
            if (
                ("3" === i.layout &&
                    t.find(".xpro-team-layout-3").hover(
                        function () {
                            e(this).find(".xpro-team-description").slideDown(200);
                        },
                        function () {
                            e(this).find(".xpro-team-description").slideUp(200);
                        }
                    ),
                "7" === i.layout &&
                    t.find(".xpro-team-layout-7").hover(
                        function () {
                            e(this).find(".xpro-team-description").slideDown(200), e(this).find(".xpro-team-social-list").slideDown(250);
                        },
                        function () {
                            e(this).find(".xpro-team-description").slideUp(200), e(this).find(".xpro-team-social-list").slideUp(250);
                        }
                    ),
                "8" === i.layout &&
                    t.find(".xpro-team-layout-8").hover(
                        function () {
                            e(this).find(".xpro-team-content").slideDown(200);
                        },
                        function () {
                            e(this).find(".xpro-team-content").slideUp(200);
                        }
                    ),
                "9" === i.layout)
            ) {
                let n = t.find(".xpro-team-image > img").height(),
                    r = t.find(".xpro-team-inner-content").height();
                t.find(".xpro-team-inner-content").width(n), t.find(".xpro-team-inner-content").css("left", r + "px");
            }
            "14" === i.layout &&
                t.find(".xpro-team-layout-14").hover(
                    function () {
                        e(this).find(".xpro-team-description").slideDown(200), e(this).find(".xpro-team-social-list").slideDown(250);
                    },
                    function () {
                        e(this).find(".xpro-team-description").slideUp(200), e(this).find(".xpro-team-social-list").slideUp(250);
                    }
                );
        },
        BeforeAfter: function (e) {
            let t = o.getElementSettings(e);
            e.find(".xpro-compare-item").XproCompare({
                default_offset_pct: t.visible_ratio.size / 100 || 0.5,
                orientation: t.orientation,
                is_wiggle: "yes" === t.wiggle,
                wiggle_timeout: t.wiggle ? 1e3 * t.wiggle_timeout.size : 1e3,
                move_on_hover: "yes" === t.mouse_move,
            });
        },
        ContentToggle: function (t) {
            o.getElementSettings(t),
                t.find(".xpro-content-toggle-button").on("click", function (t) {
                    t.preventDefault(), e(this).parents(".xpro-content-toggle-button-wrapper").toggleClass("active");
                });
        },
        NewsTicker: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-news-ticker"),
                r;
                
            e(".e-route-panel-editor-content").length && (r = ".elementor-preview-responsive-wrapper"),
                n.owlCarousel({
                    items: 1,
                    smartSpeed: 1e3,
                    loop: !0,
                    nav: !1,
                    dots: !1,
                    mouseDrag: !1,
                    touchDrag: !1,
                    rtl: "rtl" === i.direction,
                    responsiveBaseElement: r,
                    autoplay: "yes" === i.autoplay,
                    autoplayTimeout: "yes" === i.autoplay ? 1e3 * i.autoplay_timeout.size : 3e3,
                    animateOut: "fade" === i.effect && "fadeOut",
                    animateIn: "fade" === i.effect && "fadeIn",
                }),
                t.find(".xpro-news-ticker-next").click(function () {
                    n.trigger("next.owl.carousel", [1e3]),
                        t.find(".xpro-news-ticker-pause").find("i").removeClass("fa-pause"),
                        t.find(".xpro-news-ticker-pause").find("i").addClass("fa-play"),
                        t.find(".xpro-news-ticker-pause").addClass("active"),
                        n.trigger("stop.owl.autoplay");
                }),
                t.find(".xpro-news-ticker-prev").click(function () {
                    n.trigger("prev.owl.carousel", [1e3]),
                        t.find(".xpro-news-ticker-pause").find("i").removeClass("fa-pause"),
                        t.find(".xpro-news-ticker-pause").find("i").addClass("fa-play"),
                        t.find(".xpro-news-ticker-pause").addClass("active"),
                        n.trigger("stop.owl.autoplay");
                }),
                t.find(".xpro-news-ticker-close").click(function () {
                    t.find(".xpro-news-ticker-wrapper").fadeOut("slow");
                });
        },
        Table: function (t) {
            let o = t.find(".xpro-table-head-column-cell");
            t.find(".xpro-table-body-row").each(function (t, i) {
                e(i)
                    .find(".xpro-table-body-row-cell")
                    .each(function (t, i) {
                        e(i).prev().prop("colspan") > 1 && 0 !== e(i).prop("colspan") && (t += e(i).prev().prop("colspan") - 1), e(i).prepend('<div class="xpro-table-head-column-cell">' + o.eq(t).html() + "</div>");
                    });
            });
        },
        IconBox: function (e) {
            let t = o.getElementSettings(e),
                i = e.find(".elementor-widget-xpro-icon-box"),
                n = e.find(".xpro-box-icon-item"),
                r = "",
                a = e.find("#xpro-icon-box-lottie");
            "" !== t.hover_animation &&
                i.hover(
                    function () {
                        n.addClass("animated " + t.icon_hover_animation);
                    },
                    function () {
                        n.removeClass("animated " + t.icon_hover_animation);
                    }
                ),
                t.lottie_url ? (r = t.lottie_url.url) : t.svg_upload && (r = t.svg_upload.url),
                lottie.loadAnimation({ container: a[0], renderer: "svg", loop: t.loop || !0, autoplay: t.autoplay || !0, path: r });
        },
        PostGrid: function (e) {
            let t = o.getElementSettings(e),
                i = e.find(".xpro-post-grid-main");
            e.find(".xpro-post-grid-item"),
                i.cubeportfolio({
                    layoutMode: "grid",
                    gridAdjustment: "responsive",
                    lightboxGallery: !1,
                    mediaQueries: [
                        { width: elementorFrontend.config.breakpoints.lg, cols: t.column_grid || 3, options: { gapHorizontal: t.space_between.size, gapVertical: t.space_between.size } },
                        { width: elementorFrontend.config.breakpoints.md, cols: t.column_grid_tablet || 2, options: { gapHorizontal: t.space_between_tablet.size || 0, gapVertical: t.space_between_tablet.size || 0 } },
                        { width: 0, cols: t.column_grid_mobile || 1, options: { gapHorizontal: t.space_between_mobile.size || 0, gapVertical: t.space_between_mobile.size || 0 } },
                    ],
                    displayType: "default",
                    displayTypeSpeed: 0,
                });
        },
        HotSpot: function (t) {
           let i= o.getElementSettings(t);
                t.find(".xpro-post-grid-main"),
                t.find(".xpro-hotspot-type-click").on("click", function (t) {
                    t.preventDefault(), e(this).find(".xpro-hotspot-tooltip-text").toggleClass("active");
                });
                function showTooltipsSequentially() {
                var tooltips = t.find(".xpro-hotspot-animations");
                var index = 0;
                var duration =  3 * 1000;
                tooltips.css({ opacity: 0 });
                function showNextTooltip() {
                    tooltips.stop(true, true).css({ opacity: 0 });
                    var currentTooltip = jQuery(tooltips[index]);
                        currentTooltip.stop(true, true).animate({ opacity: 1 }, 500, function () {
                                setTimeout(function () {
                                    currentTooltip.animate({ opacity: 0 }, 500, function () {
                                        index = (index + 1) % tooltips.length;
                                        showNextTooltip();
                                    });
                                }, duration);
                            });
                        }
                    showNextTooltip();
                }
                setTimeout(showTooltipsSequentially, 500);
        },
        ImageScroller: function (e) {
            let t = o.getElementSettings(e),
                i = e.find(".xpro-scroll-image-inner"),
                n = e.find(".xpro-image-scroll-img > img"),
                r = 0;
            "mouse-hover" === t.trigger_type &&
                i.imagesLoaded(function () {
                    (r = "vertical" === t.direction_type ? n.height() - i.height() : n.width() - i.width()),
                        "yes" === t.reverse
                            ? (n.css("transform", ("vertical" === t.direction_type ? "translateY" : "translateX") + "( -" + r + "px)"),
                              i.hover(
                                  function () {
                                      n.css("transform", ("vertical" === t.direction_type ? "translateY" : "translateX") + "(0px)");
                                  },
                                  function () {
                                      n.css("transform", ("vertical" === t.direction_type ? "translateY" : "translateX") + "( -" + r + "px)");
                                  }
                              ))
                            : i.hover(
                                  function () {
                                      n.css("transform", ("vertical" === t.direction_type ? "translateY" : "translateX") + "( -" + r + "px)");
                                  },
                                  function () {
                                      n.css("transform", ("vertical" === t.direction_type ? "translateY" : "translateX") + "(0px)");
                                  }
                              );
                });
        },
        HorizontalTimeline: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-horizontal-timeline"),
                r,
                a = 767;
            function l() {
                if ("yes" === i.reverse && e(window).width() >= a) {
                    let o = t.find(".xpro-horiz-equal-height > div"),
                        n = 0;
                    o.each(function () {
                        n = Math.max(n, e(this).outerHeight());
                    }),
                        o.parent().css({ minHeight: n + "px" });
                } else {
                    let r = t.find(".xpro-horizontal-timeline-content > div"),
                        l = 0;
                    r.each(function () {
                        l = Math.max(l, e(this).outerHeight());
                    }),
                        r.parent().css({ minHeight: l + "px" });
                    let s = t.find(".xpro-horizontal-timeline-date > div"),
                        p = 0;
                    s.each(function () {
                        p = Math.max(p, e(this).outerHeight());
                    }),
                        s.parent().css({ minHeight: p + "px" });
                }
            }
            e(".e-route-panel-editor-content").length && (r = ".elementor-preview-responsive-wrapper"),
                e(".elementor-editor-active").length && (a = 750),
                n.owlCarousel({
                    loop: "yes" === i.loop,
                    center: "yes" === i.center,
                    nav: "yes" === i.nav,
                    navText: ["", ""],
                    dots: "yes" === i.dots,
                    mouseDrag: "yes" === i.mouse_drag,
                    rtl: "yes" === i.rtl,
                    touchDrag: !0,
                    autoHeight: !1,
                    autoWidth: "yes" === i.custom_width,
                    responsiveBaseElement: r,
                    autoplay: "yes" === i.autoplay,
                    autoplayTimeout: "yes" === i.autoplay ? 1e3 * i.autoplay_timeout.size : 3e3,
                    autoplayHoverPause: !0,
                    smartSpeed: 500,
                    responsive: { 0: { items: i.item_per_row_mobile || 1 }, 768: { items: i.item_per_row_tablet || 1 }, 1024: { items: i.item_per_row || 2 } },
                }),
                setTimeout(function () {
                    l();
                }, 300),
                e(window).on("resize", function () {
                    setTimeout(function () {
                        l();
                    }, 500);
                });
        },
        ContactForm: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-contact-form"),
                r = (t.find(".xpro-contact-form-submit-button"), t.find(".xpro-contact-form-submit-button > i")),
                a = !1,
                l = n.attr("action");
                function safe_tags(str) {
                    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') ;
                }
            n.on("submit", function (o) {
                o.preventDefault(), r.show();
                let s = n.serializeArray(),
                    p = [],
                    d = !0,
                    c = null,
                    f = "",
                    u = 0;
                if (
                    (i.recaptcha && (a = t.find(".g-recaptcha-response").val()),
                    e.each(s, function (e, o) {
                        "" !== o.value && "g-recaptcha-response" !== o.name && ((p[u] = { name: t.find("label[for=" + o.name.replaceAll("[]", "") + "]").text() || "", value: o.value }), u++);
                    }),
                    p.length ? (f = p.map((e) => Object.entries(e).reduce((e, t, o) => `${e}${o > 0 ? "&&" : ""}${t[0]}=${t[1]}`, ""))) : (d = !1),
                    t.find('.xpro-contact-form-require [required="required"]').each(function (t) {
                        "" === e(this).val() && (d = !1);
                    }),
                    !d)
                ) {
                    (c = '<div class="xpro-alert xpro-alert-danger">' + safe_tags(i.required_field_message) + "</div>"), t.find(".xpro-contact-form-message").hide().html(c).slideDown(), r.hide();
                    return;
                }
                if (i.recaptcha && !a) {
                    (c = '<div class="xpro-alert xpro-alert-danger">' + safe_tags(i.captcha_message) + "</div>"), t.find(".xpro-contact-form-message").hide().html(c).slideDown(), r.hide();
                    return;
                }
                t.find(".xpro-contact-form-message").slideUp(),
                    e.ajax({ method: "POST", url: l, data: { postData: JSON.stringify(f), formName: i.form_name, formSubject: i.form_subject, captcha: a } }).done(function (e) {
                        e.success
                            ? ((c = '<div class="xpro-alert xpro-alert-success">' + safe_tags(i.success_message) + "</div>"), t.find(".xpro-contact-form-message").hide().html(c).slideDown())
                            : ((c = '<div class="xpro-alert xpro-alert-danger">' + safe_tags(i.error_message) + "</div>"), t.find(".xpro-contact-form-message").hide().html(c).slideDown()),
                            r.hide(),
                            i.recaptcha && grecaptcha.reset();
                    });
            });
        },
        Search: function (e) {
            let t = o.getElementSettings(e);
            ("4" === t.layout || "5" === t.layout) &&
                (e.find(".xpro-elementor-search-button").on("click", function (t) {
                    t.preventDefault(), t.stopPropagation(), e.find(".xpro-elementor-search-layout-4 .xpro-elementor-search-inner").fadeIn(400), e.find(".xpro-elementor-search-layout-5 .xpro-elementor-search-inner").slideDown(400);
                }),
                e.find(".xpro-elementor-search-button-close").on("click", function (t) {
                    t.preventDefault(), t.stopPropagation(), e.find(".xpro-elementor-search-layout-4 .xpro-elementor-search-inner").fadeOut(400), e.find(".xpro-elementor-search-layout-5 .xpro-elementor-search-inner").slideUp(400);
                }));
        },
        CourseGrid: function (e) {
            let t = o.getElementSettings(e),
                i = e.find(".xpro-post-grid-main");
            e.find(".xpro-post-grid-item"),
                i.cubeportfolio({
                    layoutMode: "grid",
                    gridAdjustment: "responsive",
                    mediaQueries: [
                        { width: elementorFrontend.config.breakpoints.lg, cols: t.column_grid || 3, options: { gapHorizontal: t.space_between.size, gapVertical: t.space_between.size } },
                        { width: elementorFrontend.config.breakpoints.md, cols: t.column_grid_tablet || 2, options: { gapHorizontal: t.space_between_tablet.size || 0, gapVertical: t.space_between_tablet.size || 0 } },
                        { width: 0, cols: t.column_grid_mobile || 1, options: { gapHorizontal: t.space_between_mobile.size || 0, gapVertical: t.space_between_mobile.size || 0 } },
                    ],
                    displayType: "default",
                    displayTypeSpeed: 0,
                });
        },
        ProductGrid: function (t) {
            let i = o.getElementSettings(t),
                n = t.find(".xpro-woo-product-grid-main");
            t.find(".xpro-woo-product-grid-item"),
                t.find(".xpro-hv-qv-btn").click(function (o) {
                    o.preventDefault();
                    let i = e(this).attr("id"),
                        n = { action: "load_quick_view_product_data", nonce: XproElementorAddons.nonce, id: i };
                    e.ajax({
                        url: XproElementorAddons.ajax_url,
                        type: "post",
                        data: n,
                        dataType: "html",
                        cache: !1,
                        beforeSend: function () {
                            t.find(".xpro-qv-loader-wrapper").css("display", "unset"), t.find(".xpro-qv-popup-wrapper").css("display", "none");
                        },
                        complete: function () {
                            t.find(".xpro-qv-loader-wrapper").css("display", "none"), t.find(".xpro-qv-popup-wrapper").css("display", "unset"), t.find(".xpro-qv-popup-overlay").css({ opacity: "1", visibility: "visible" });
                        },
                        success: function (o) {
                            t.find("#xpro_elementor_fetch_qv_data").html(o),
                                e(".xpro-woo-qv-content-sec .variations_form").wc_variation_form().find(".variations select:eq(0)").trigger("change"),
                                e(".xpro-woo-qv-content-sec .variations_form").trigger("wc_variation_form");
                        },
                    });
                }),
                t.on("click", ".xpro-woo-qv-cross", function (e) {
                    e.preventDefault(), t.find(".xpro-qv-popup-wrapper").css("display", "none"), t.find(".xpro-qv-popup-overlay").css({ opacity: "0", visibility: "hidden" });
                }),
                t.on("click", ".xpro-qv-popup-overlay", function (e) {
                    e.preventDefault(), t.find(".xpro-qv-popup-wrapper").css("display", "none"), t.find(".xpro-qv-popup-overlay").css({ opacity: "0", visibility: "hidden" });
                }),
                e(document).keyup(function (e) {
                    27 === e.keyCode && (t.find(".xpro-qv-popup-wrapper").css("display", "none"), t.find(".xpro-qv-popup-overlay").css({ opacity: "0", visibility: "hidden" }));
                }),
                t.on("click", "#xpro_elementor_fetch_qv_data .single_add_to_cart_button:not(.disabled)", function (o) {
                    if ((o.preventDefault(), "" !== e(this).parents("form").attr("action"))) return (window.location.href = e(this).parents("form").attr("action")), !1;
                    let i = e(this).closest("form");
                    if (!i[0].checkValidity()) return i[0].reportValidity(), !1;
                    let n = e(this),
                        r = e(this).val();
                    if ((e('input[name="variation_id"]').val(), e('input[name="quantity"]').val(), t.find(".woocommerce-grouped-product-list-item").length)) {
                        let a = e("input.qty"),
                            l = [];
                        e.each(a, function (t, o) {
                            let i = e(this).attr("name");
                            (i = (i = i.replace("quantity[", "")).replace("]", "")), (i = parseInt(i)), e(this).val() && (l[i] = e(this).val());
                        });
                    }
                    let s = i.serialize();
                    n.is(".single_add_to_cart_button") &&
                        (n.removeClass("added"),
                        n.addClass("loading"),
                        e.ajax({
                            url: XproElementorAddons.ajax_url,
                            type: "POST",
                            data: "action=add_cart_single_product_ajax&product_id=" + r + "&nonce=" + XproElementorAddons.nonce + "&" + s,
                            success: function (t) {
                                e(document.body).trigger("wc_fragment_refresh"), n.removeClass("loading"), n.addClass("added");
                            },
                        }));
                }),
                n.cubeportfolio({
                    layoutMode: "grid",
                    gridAdjustment: "responsive",
                    mediaQueries: [
                        { width: elementorFrontend.config.breakpoints.lg, cols: i.column_grid || 3, options: { gapHorizontal: i.space_between.size, gapVertical: i.space_between.size } },
                        { width: elementorFrontend.config.breakpoints.md, cols: i.column_grid_tablet || 2, options: { gapHorizontal: i.space_between_tablet.size || 0, gapVertical: i.space_between_tablet.size || 0 } },
                        { width: 0, cols: i.column_grid_mobile || 1, options: { gapHorizontal: i.space_between_mobile.size || 0, gapVertical: i.space_between_mobile.size || 0 } },
                    ],
                    displayType: "default",
                    displayTypeSpeed: 0,
                });
        },
        HeroSlider: function (t) {
            o.getElementSettings(t);
            var i = t.find(".xpro-hero-slider").data("xpro-hero-slider-setting");
            new Swiper(t.find(".xpro-hero-slider")[0], {
                parallax: !0,
                speed: 100 * i.slide_speed,
                spaceBetween: 0,
                effect: i.slide_effect,
                fadeEffect: { crossFade: !0 },
                loop: i.loop,
                autoplay: { enabled: i.autoplay, disableOnInteraction: !0, delay: i.autoplay_timeout ? 1e3 * i.autoplay_timeout : 3e3 },
                pagination: { el: t.find(".swiper-pagination")[0], clickable: !0 },
                navigation: { nextEl: t.find(".swiper-button-next")[0], prevEl: t.find(".swiper-button-prev")[0] },
                allowTouchMove: i.mouse_drag,
            }).on("slideChangeTransitionStart", function () {
                var t = this;
                e(t.slides[t.activeIndex])
                    .find("[data-animation]")
                    .each(function () {
                        var o = e(this),
                            i = "animated " + o.data("animation");
                        o.addClass(i).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                            o.removeClass(i);
                        }),
                            e(t.slides).removeClass("xpro-animation-init"),
                            e(t.slides[t.activeIndex]).addClass("xpro-animation-init");
                    });
            });
        },
    };
    e(window).on("elementor/frontend/init", o.init);
})(jQuery, window.elementorFrontend);
