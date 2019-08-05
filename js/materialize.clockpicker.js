! function() {
    function t(t) {
        return document.createElementNS(r, t)
    }

    function i(t) {
        return (t < 10 ? "0" : "") + t
    }

    function e(t) {
        var i = ++v + "";
        return t ? t + i : i
    }

    function s(s, n) {
        function r(t, i) {
            var e = h.offset(),
                s = /^touch/.test(t.type),
                o = e.left + f,
                c = e.top + f,
                r = (s ? t.originalEvent.touches[0] : t).pageX - o,
                l = (s ? t.originalEvent.touches[0] : t).pageY - c,
                u = Math.sqrt(r * r + l * l),
                m = !1;
            if (!i || !(u < b - w || u > b + w)) {
                t.preventDefault();
                var v = setTimeout(function() {
                    V.popover.addClass("clockpicker-moving")
                }, 200);
                p && h.append(V.canvas), V.setHand(r, l, !i, !0), a.off(d).on(d, function(t) {
                    t.preventDefault();
                    var i = /^touch/.test(t.type),
                        e = (i ? t.originalEvent.touches[0] : t).pageX - o,
                        s = (i ? t.originalEvent.touches[0] : t).pageY - c;
                    (m || e !== r || s !== l) && (m = !0, V.setHand(e, s, !1, !0))
                }), a.off(k).on(k, function(t) {
                    a.off(k), t.preventDefault();
                    var e = /^touch/.test(t.type),
                        s = (e ? t.originalEvent.changedTouches[0] : t).pageX - o,
                        p = (e ? t.originalEvent.changedTouches[0] : t).pageY - c;
                    (i || m) && s === r && p === l && V.setHand(s, p), "hours" === V.currentView ? V.toggleView("minutes", A / 2) : n.autoclose && (V.minutesView.addClass("clockpicker-dial-out"), setTimeout(function() {
                        V.done()
                    }, A / 2)), h.prepend(z), clearTimeout(v), V.popover.removeClass("clockpicker-moving"), a.off(d)
                })
            }
        }
        var l = c(M),
            h = l.find(".clockpicker-plate"),
            m = l.find(".picker__holder"),
            v = l.find(".clockpicker-hours"),
            P = l.find(".clockpicker-minutes"),
            C = l.find(".clockpicker-am-pm-block"),
            x = "INPUT" === s.prop("tagName"),
            T = x ? s : s.find("input"),
            _ = c("label[for=" + T.attr("id") + "]"),
            V = this;
        if (this.id = e("cp"), this.element = s, this.holder = m, this.options = n, this.isAppended = !1, this.isShown = !1, this.currentView = "hours", this.isInput = x, this.input = T, this.label = _, this.popover = l, this.plate = h, this.hoursView = v, this.minutesView = P, this.amPmBlock = C, this.spanHours = l.find(".clockpicker-span-hours"), this.spanMinutes = l.find(".clockpicker-span-minutes"), this.spanAmPm = l.find(".clockpicker-span-am-pm"), this.footer = l.find(".picker__footer"), this.amOrPm = "PM", n.twelvehour) {
            var H = ['<div class="clockpicker-am-pm-block">', '<button type="button" class="btn-floating btn-flat clockpicker-button clockpicker-am-button">', "AM", "</button>", '<button type="button" class="btn-floating btn-flat clockpicker-button clockpicker-pm-button">', "PM", "</button>", "</div>"].join("");
            c(H);
            n.ampmclickable ? (this.spanAmPm.empty(), c('<div id="click-am">AM</div>').on("click", function() {
                V.spanAmPm.children("#click-am").addClass("text-primary"), V.spanAmPm.children("#click-pm").removeClass("text-primary"), V.amOrPm = "AM"
            }).appendTo(this.spanAmPm), c('<div id="click-pm">PM</div>').on("click", function() {
                V.spanAmPm.children("#click-pm").addClass("text-primary"), V.spanAmPm.children("#click-am").removeClass("text-primary"), V.amOrPm = "PM"
            }).appendTo(this.spanAmPm)) : (c('<button type="button" class="btn-floating btn-flat clockpicker-button am-button" tabindex="1">AM</button>').on("click", function() {
                V.amOrPm = "AM", V.amPmBlock.children(".pm-button").removeClass("active"), V.amPmBlock.children(".am-button").addClass("active"), V.spanAmPm.empty().append("AM")
            }).appendTo(this.amPmBlock), c('<button type="button" class="btn-floating btn-flat clockpicker-button pm-button" tabindex="2">PM</button>').on("click", function() {
                V.amOrPm = "PM", V.amPmBlock.children(".am-button").removeClass("active"), V.amPmBlock.children(".pm-button").addClass("active"), V.spanAmPm.empty().append("PM")
            }).appendTo(this.amPmBlock))
        }
        T.attr("type", "text"), n.darktheme && l.addClass("darktheme"), c('<button type="button" class="btn-flat clockpicker-button" tabindex="' + (n.twelvehour ? "3" : "1") + '">' + n.donetext + "</button>").click(c.proxy(this.done, this)).appendTo(this.footer), this.spanHours.click(c.proxy(this.toggleView, this, "hours")), this.spanMinutes.click(c.proxy(this.toggleView, this, "minutes")), T.on("focus.clockpicker click.clockpicker", c.proxy(this.show, this));
        var S, B, D, E, I = c('<div class="clockpicker-tick"></div>');
        if (n.twelvehour)
            for (S = 1; S < 13; S += 1) B = I.clone(), D = S / 6 * Math.PI, E = b, B.css("font-size", "140%"), B.css({
                left: f + Math.sin(D) * E - w,
                top: f - Math.cos(D) * E - w
            }), B.html(0 === S ? "00" : S), v.append(B), B.on(u, r);
        else
            for (S = 0; S < 24; S += 1) {
                B = I.clone(), D = S / 6 * Math.PI;
                var O = S > 0 && S < 13;
                E = O ? g : b, B.css({
                    left: f + Math.sin(D) * E - w,
                    top: f - Math.cos(D) * E - w
                }), O && B.css("font-size", "120%"), B.html(0 === S ? "00" : S), v.append(B), B.on(u, r)
            }
        for (S = 0; S < 60; S += 5) B = I.clone(), D = S / 30 * Math.PI, B.css({
            left: f + Math.sin(D) * b - w,
            top: f - Math.cos(D) * b - w
        }), B.css("font-size", "140%"), B.html(i(S)), P.append(B), B.on(u, r);
        if (h.on(u, function(t) {
                0 === c(t.target).closest(".clockpicker-tick").length && r(t, !0)
            }), p) {
            var z = l.find(".clockpicker-canvas"),
                U = t("svg");
            U.setAttribute("class", "clockpicker-svg"), U.setAttribute("width", y), U.setAttribute("height", y);
            var j = t("g");
            j.setAttribute("transform", "translate(" + f + "," + f + ")");
            var L = t("circle");
            L.setAttribute("class", "clockpicker-canvas-bearing"), L.setAttribute("cx", 0), L.setAttribute("cy", 0), L.setAttribute("r", 2);
            var N = t("line");
            N.setAttribute("x1", 0), N.setAttribute("y1", 0);
            var X = t("circle");
            X.setAttribute("class", "clockpicker-canvas-bg"), X.setAttribute("r", w);
            var Y = t("circle");
            Y.setAttribute("class", "clockpicker-canvas-fg"), Y.setAttribute("r", 5), j.appendChild(N), j.appendChild(X), j.appendChild(Y), j.appendChild(L), U.appendChild(j), z.append(U), this.hand = N, this.bg = X, this.fg = Y, this.bearing = L, this.g = j, this.canvas = z
        }
        o(this.options.init)
    }

    function o(t) {
        t && "function" == typeof t && t()
    }
    var c = window.jQuery,
        n = c(window),
        a = c(document),
        r = "http://www.w3.org/2000/svg",
        p = "SVGAngle" in window && function() {
            var t, i = document.createElement("div");
            return i.innerHTML = "<svg/>", t = (i.firstChild && i.firstChild.namespaceURI) == r, i.innerHTML = "", t
        }(),
        l = function() {
            var t = document.createElement("div").style;
            return "transition" in t || "WebkitTransition" in t || "MozTransition" in t || "msTransition" in t || "OTransition" in t
        }(),
        h = "ontouchstart" in window,
        u = "mousedown" + (h ? " touchstart" : ""),
        d = "mousemove.clockpicker" + (h ? " touchmove.clockpicker" : ""),
        k = "mouseup.clockpicker" + (h ? " touchend.clockpicker" : ""),
        m = navigator.vibrate ? "vibrate" : navigator.webkitVibrate ? "webkitVibrate" : null,
        v = 0,
        f = 135,
        b = 110,
        g = 80,
        w = 20,
        y = 2 * f,
        A = l ? 350 : 1,
        M = ['<div class="clockpicker picker">', '<div class="picker__holder">', '<div class="picker__frame">', '<div class="picker__wrap">', '<div class="picker__box">', '<div class="picker__date-display">', '<div class="clockpicker-display">', '<div class="clockpicker-display-column">', '<span class="clockpicker-span-hours text-primary"></span>', ":", '<span class="clockpicker-span-minutes"></span>', "</div>", '<div class="clockpicker-display-column clockpicker-display-am-pm">', '<div class="clockpicker-span-am-pm"></div>', "</div>", "</div>", "</div>", '<div class="picker__calendar-container">', '<div class="clockpicker-plate">', '<div class="clockpicker-canvas"></div>', '<div class="clockpicker-dial clockpicker-hours"></div>', '<div class="clockpicker-dial clockpicker-minutes clockpicker-dial-out"></div>', "</div>", '<div class="clockpicker-am-pm-block">', "</div>", "</div>", '<div class="picker__footer">', "</div>", "</div>", "</div>", "</div>", "</div>", "</div>"].join("");
    s.DEFAULTS = {
        "default": "",
        fromnow: 0,
        donetext: "Done",
        autoclose: !1,
        ampmclickable: !1,
        darktheme: !1,
        twelvehour: !0,
        vibrate: !0
    }, s.prototype.toggle = function() {
        this[this.isShown ? "hide" : "show"]()
    }, s.prototype.locate = function() {
        var t = this.element,
            i = this.popover;
        t.offset(), t.outerWidth(), t.outerHeight(), this.options.align;
        i.show()
    }, s.prototype.show = function(t) {
        if (this.setAMorPM = function(t) {
                var i = t,
                    e = "pm" == t ? "am" : "pm";
                this.options.twelvehour && (this.amOrPm = i.toUpperCase(), this.options.ampmclickable ? (this.spanAmPm.children("#click-" + i).addClass("text-primary"), this.spanAmPm.children("#click-" + e).removeClass("text-primary")) : (this.amPmBlock.children("." + e + "-button").removeClass("active"), this.amPmBlock.children("." + i + "-button").addClass("active"), this.spanAmPm.empty().append(this.amOrPm)))
            }, !this.isShown) {
            o(this.options.beforeShow), c(":input").each(function() {
                c(this).attr("tabindex", -1)
            });
            var e = this;
            this.input.blur(), this.popover.addClass("picker--opened"), this.input.addClass("picker__input picker__input--active"), c(document.body).css("overflow", "hidden"), this.isAppended || (this.options.hasOwnProperty("container") ? this.popover.appendTo(this.options.container) : this.popover.insertAfter(this.input), this.setAMorPM("pm"), n.on("resize.clockpicker" + this.id, function() {
                e.isShown && e.locate()
            }), this.isAppended = !0);
            var s = ((this.input.prop("value") || this.options["default"] || "") + "").split(":");
            if (this.options.twelvehour && "undefined" != typeof s[1] && (s[1].includes("AM") ? this.setAMorPM("am") : this.setAMorPM("pm"), s[1] = s[1].replace("AM", "").replace("PM", "")), "now" === s[0]) {
                var r = new Date(+new Date + this.options.fromnow);
                r.getHours() >= 12 ? this.setAMorPM("pm") : this.setAMorPM("am"), s = [r.getHours(), r.getMinutes()]
            }
            this.hours = +s[0] || 0, this.minutes = +s[1] || 0, this.spanHours.html(i(this.hours)), this.spanMinutes.html(i(this.minutes)), this.toggleView("hours"), this.locate(), this.isShown = !0, a.on("click.clockpicker." + this.id + " focusin.clockpicker." + this.id, function(t) {
                var i = c(t.target);
                0 === i.closest(e.popover.find(".picker__wrap")).length && 0 === i.closest(e.input).length && e.hide()
            }), a.on("keyup.clockpicker." + this.id, function(t) {
                27 === t.keyCode && e.hide()
            }), o(this.options.afterShow)
        }
    }, s.prototype.hide = function() {
        o(this.options.beforeHide), this.input.removeClass("picker__input picker__input--active"), this.popover.removeClass("picker--opened"), c(document.body).css("overflow", "visible"), this.isShown = !1, c(":input").each(function(t) {
            c(this).attr("tabindex", t + 1)
        }), a.off("click.clockpicker." + this.id + " focusin.clockpicker." + this.id), a.off("keyup.clockpicker." + this.id), this.popover.hide(), o(this.options.afterHide)
    }, s.prototype.toggleView = function(t, i) {
        var e = !1;
        "minutes" === t && "visible" === c(this.hoursView).css("visibility") && (o(this.options.beforeHourSelect), e = !0);
        var s = "hours" === t,
            n = s ? this.hoursView : this.minutesView,
            a = s ? this.minutesView : this.hoursView;
        this.currentView = t, this.spanHours.toggleClass("text-primary", s), this.spanMinutes.toggleClass("text-primary", !s), a.addClass("clockpicker-dial-out"), n.css("visibility", "visible").removeClass("clockpicker-dial-out"), this.resetClock(i), clearTimeout(this.toggleViewTimer), this.toggleViewTimer = setTimeout(function() {
            a.css("visibility", "hidden")
        }, A), e && o(this.options.afterHourSelect)
    }, s.prototype.resetClock = function(t) {
        var i = this.currentView,
            e = this[i],
            s = "hours" === i,
            o = Math.PI / (s ? 6 : 30),
            c = e * o,
            n = s && e > 0 && e < 13 ? g : b,
            a = Math.sin(c) * n,
            r = -Math.cos(c) * n,
            l = this;
        p && t ? (l.canvas.addClass("clockpicker-canvas-out"), setTimeout(function() {
            l.canvas.removeClass("clockpicker-canvas-out"), l.setHand(a, r)
        }, t)) : this.setHand(a, r)
    }, s.prototype.setHand = function(t, e, s, o) {
        var n, a = Math.atan2(t, -e),
            r = "hours" === this.currentView,
            l = Math.PI / (r || s ? 6 : 30),
            h = Math.sqrt(t * t + e * e),
            u = this.options,
            d = r && h < (b + g) / 2,
            k = d ? g : b;
        if (u.twelvehour && (k = b), a < 0 && (a = 2 * Math.PI + a), n = Math.round(a / l), a = n * l, u.twelvehour ? r ? 0 === n && (n = 12) : (s && (n *= 5), 60 === n && (n = 0)) : r ? (12 === n && (n = 0), n = d ? 0 === n ? 12 : n : 0 === n ? 0 : n + 12) : (s && (n *= 5), 60 === n && (n = 0)), r ? this.fg.setAttribute("class", "clockpicker-canvas-fg") : n % 5 == 0 ? this.fg.setAttribute("class", "clockpicker-canvas-fg") : this.fg.setAttribute("class", "clockpicker-canvas-fg active"), this[this.currentView] !== n && m && this.options.vibrate && (this.vibrateTimer || (navigator[m](10), this.vibrateTimer = setTimeout(c.proxy(function() {
                this.vibrateTimer = null
            }, this), 100))), this[this.currentView] = n, this[r ? "spanHours" : "spanMinutes"].html(i(n)), !p) return void this[r ? "hoursView" : "minutesView"].find(".clockpicker-tick").each(function() {
            var t = c(this);
            t.toggleClass("active", n === +t.html())
        });
        o || !r && n % 5 ? (this.g.insertBefore(this.hand, this.bearing), this.g.insertBefore(this.bg, this.fg), this.bg.setAttribute("class", "clockpicker-canvas-bg clockpicker-canvas-bg-trans")) : (this.g.insertBefore(this.hand, this.bg), this.g.insertBefore(this.fg, this.bg), this.bg.setAttribute("class", "clockpicker-canvas-bg"));
        var v = Math.sin(a) * (k - w),
            f = -Math.cos(a) * (k - w),
            y = Math.sin(a) * k,
            A = -Math.cos(a) * k;
        this.hand.setAttribute("x2", v), this.hand.setAttribute("y2", f), this.bg.setAttribute("cx", y), this.bg.setAttribute("cy", A), this.fg.setAttribute("cx", y), this.fg.setAttribute("cy", A)
    }, s.prototype.done = function() {
        o(this.options.beforeDone), this.hide(), this.label.addClass("active");
        var t = this.input.prop("value"),
            e = i(this.hours) + ":" + i(this.minutes);
        this.options.twelvehour && (e += this.amOrPm), this.input.prop("value", e), e !== t && (this.input.triggerHandler("change"), this.isInput || this.element.trigger("change")), this.options.autoclose && this.input.trigger("blur"), o(this.options.afterDone)
    }, s.prototype.remove = function() {
        this.element.removeData("clockpicker"), this.input.off("focus.clockpicker click.clockpicker"), this.isShown && this.hide(), this.isAppended && (n.off("resize.clockpicker" + this.id), this.popover.remove())
    }, c.fn.pickatime = function(t) {
        var i = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var e = c(this),
                o = e.data("clockpicker");
            if (o) "function" == typeof o[t] && o[t].apply(o, i);
            else {
                var n = c.extend({}, s.DEFAULTS, e.data(), "object" == typeof t && t);
                e.data("clockpicker", new s(e, n))
            }
        })
    }
}();