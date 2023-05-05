(this || (0, eval)("(this)")).bdor = [];
(function (b) {
    function c(b) {
        b = f.match(b);
        if (null == b || 0 == b.length)return 0;
        b = b[0];
        var c = b.indexOf("/");
        b = b.substring(c + 1, b.length);
        return "" == b ? 0 : parseInt(b)
    }
    
    function d(b) {
        b = f.match(b);
        if (null == b || 0 == b.length)return 0;
        b = b[0].replace("_", ".").match(/\d+\.?\d?/);
        if (null == b || 0 == b.length)return 0;
        b = b[0];
        return "" == b ? 0 : parseFloat(b)
    }
    
    var f = navigator.userAgent.toLowerCase();
    b.browser = {};
    b.browser.webkit = /webkit/.test(f);
    b.browser.mozilla = /firefox/.test(f);
    b.browser.firefox = b.browser.mozilla;
    b.browser.msie = /msie/.test(f) ||
        /trident/.test(f) || /edge/.test(f);
    b.browser.edge = /edge/.test(f);
    b.browser.opera = /opera/.test(f) || /opr/.test(f);
    b.browser.chrome = /chrome/.test(f) && !b.browser.opera && !b.browser.edge;
    b.browser.uc = /ucbrowser/.test(f);
    b.browser.safari = /safari/.test(f) && !b.browser.chrome && !b.browser.uc && !b.browser.opera;
    b.browser.version = 0;
    bdor[1] = "p";
    b.browser.firefox && (b.browser.version = c(/firefox\/\d+/));
    if (b.browser.msie) {
        var g = f.match(/msie\s?\d+\.0/);
        null == g ? (g = f.match(/trident\/\d+\.0/), null != g && 0 < g.length && (g = parseInt(g[0].replace("trident/",
                "")), b.browser.version = g + 4)) : (g = parseInt(g[0].replace("msie", "")), b.browser.version = g)
    }
    b.browser.opera && (b.browser.version = c(/opera\/\d+/) || c(/opr\/\d+/));
    b.browser.chrome && (b.browser.version = c(/chrome\/\d+/));
    b.browser.uc && (b.browser.version = c(/ucbrowser\/\d+/));
    b.browser.safari && (b.browser.version = c(/safari\/\d+/));
    if (void 0 == b.browser.device) {
        b.browser.DEVICE_PC = 0;
        b.browser.DEVICE_PAD = 1;
        b.browser.DEVICE_PHONE = 2;
        var g = /pad/.test(f) || /ipod/.test(f), h = /iphone/.test(f), k = /wpdesktop/.test(f) || /windows phone/.test(f),
            l = /blackberry/.test(f), m = /mobile/.test(f) || /phone/.test(f);
        b.browser.device = b.browser.DEVICE_PC;
        if (g) b.browser.device = b.browser.DEVICE_PAD; else if (h || k || l || m) b.browser.device = b.browser.DEVICE_PHONE
    }
    void 0 == b.browser.prefix && (b.browser.prefix = "", !0 == b.browser.webkit && (b.browser.prefix = "-webkit-"), !0 == b.browser.mozilla && (b.browser.prefix = "-moz-"), !0 == b.browser.opera && (b.browser.prefix = "-webkit-"), !0 == b.browser.uc && (b.browser.prefix = "-webkit-"), !0 == b.browser.msie && (b.browser.prefix = "-ms-"));
    if (void 0 ==
        b.system) {
        b.system = {name: "", version: 0};
        b.system.WINDOWS = "Windows";
        b.system.WP = "WinPhone";
        b.system.WP_DESKTOP = "WinPhoneDesktop";
        b.system.MAC = "Mac OS";
        b.system.IOS = "iPhone OS";
        b.system.LINUX = "Linux";
        b.system.ANDROID = "Android";
        b.system.BLACKBERRY = "BlackBerry";
        /windows/.test(f) && (b.system.name = b.system.WINDOWS, b.system.version = d(/windows nt\s?\d+\.?\d?/));
        /windows phone/.test(f) && (b.system.name = b.system.WP, b.system.version = d(/windows phone\s?\d+\.?\d?/));
        /wpdesktop/.test(f) && (b.system.name = b.system.WP_DESKTOP,
            b.system.version = d(/wpdesktop\s?\d+\.?\d?/));
        if (b.system.name != b.system.WP) {
            if (/iphone/.test(f) || /ipad/.test(f)) b.system.name = b.system.IOS, b.system.version = d(/os\s?\d+_?\d?/);
            /android/.test(f) && (b.system.name = b.system.ANDROID, b.system.version = d(/android\s?\d+\.?\d?/))
        }
    /mac /
    .
        test(f) && b.browser.system != b.browser.IOS && (b.system.name = b.system.MAC, b.system.version = d(/os x\s?\d+\.?\d?/));
        /linux/.test(f) && !/android/.test(f) && (b.system.name = b.system.LINUX);
        /blackberry/.test(f) && (b.system.name = b.system.BLACKBERRY,
            b.system.version = d(/blackberry\s?\d+/))
    }
})(jQuery);
var global = function () {
    return this || (0, eval)("(this)")
}(), virtual_function = function () {
};
function getPackageByName(b) {
    if (void 0 == b || "" == b)return global;
    var c = global;
    b = b.split(".");
    for (var d = 0; d < b.length; d++) {
        var f = b[d];
        c[f] || (c[f] = {IS_PACKAGE_OBJECT: !0});
        c = c[f]
    }
    return c
}
function getClassByFullName(b) {
    if (-1 == b.indexOf("."))return global[b];
    var c = b.split(".");
    b = c.pop();
    c = c.join(".");
    return getPackageByName(c)[b]
}
function classof(b, c) {
    if (!b)return "";
    c || (c = global);
    "string" == typeof c && (c = getPackageByName(c));
    var d = ["webkitStorageInfo", "webkitIndexedDB"], f;
    for (f in c)try {
        if (!(-1 < d.indexOf(f)) && c[f] instanceof Function)try {
            if (b instanceof c[f])return f
        } catch (g) {
        }
    } catch (h) {
    }
    for (f in c)if ("object" == typeof c[f] && c[f].IS_PACKAGE_OBJECT && (d = classof(b, c[f]), "" != d))return f + "." + d;
    return ""
}
function nameof(b, c) {
    if (!b)return "";
    c || (c = global);
    "string" == typeof c && (c = getPackageByName(c));
    var d = ["webkitStorageInfo", "webkitIndexedDB"], f;
    for (f in c)try {
        if (!(-1 < d.indexOf(f)) && c[f] == b)return f
    } catch (g) {
    }
    for (f in c)if ("object" == typeof c[f] && c[f].IS_PACKAGE_OBJECT && (d = nameof(b, c[f]), "" != d))return f + "." + d;
    return ""
}
function Class(b, c) {
    if ("string" === typeof b) {
        var d = c, f = getPackageByName(d.Package);
        f[b] = Class(d);
        return f[b]
    }
    var g = function () {
        if (this.Import) {
            "string" == typeof this.Import && (this.Import = [this.Import]);
            for (var b = 0; b < this.Import.length; b++) {
                var c = this.Import[b], d = getPackageByName(c);
                if (d instanceof Function) this[c.split(".").pop()] = d; else for (var f in d)d[f] instanceof Function && (this[f] = d[f])
            }
        }
        d = getPackageByName(this.Package);
        if (d != global)for (f in d)this.getClassName() != f && d[f] instanceof Function && (this[f] =
            d[f]);
        this.create && this.create instanceof Function && this.create.apply(this, arguments)
    };
    g.prototype = b || {};
    g.prototype.getClassName = function () {
        return nameof(g, this.Package)
    };
    g.prototype.getClass = function () {
        return g
    };
    d = g.prototype.statics;
    if (void 0 != d) {
        for (f in d)void 0 == g[f] && (g[f] = d[f]);
        delete g.prototype.statics
    }
    return g
}
Function.prototype.extend = function (b) {
    if (!b)return this;
    if ("string" == typeof b)if (-1 < b.indexOf(".")) {
        if (b = getClassByFullName(b), !b)return this
    } else {
        var c = this.prototype.Package, d = b, f = b;
        c && "" != c && (f = c + "." + d);
        if (c = getClassByFullName(f)) b = c; else if (c = getClassByFullName(d)) b = c; else return this
    }
    if (b instanceof Function) {
        for (var g in b)void 0 == this[g] && (this[g] = b[g]);
        for (g in b.prototype)void 0 == this.prototype[g] ? b.prototype[g] == virtual_function ? console && console.error && console.error("virtual function [%s] must be override.",
                    g) : this.prototype[g] = b.prototype[g] : (d = /xyz/.test(function () {
                xyz
            }) ? /\b_super\b/ : /.*/, this.prototype[g] instanceof Function && b.prototype[g] instanceof Function && d.test(this.prototype[g]) && (this.prototype[g] = function (c, d) {
                return function () {
                    var f = this._super;
                    this._super = b.prototype[c];
                    var g = d.apply(this, arguments);
                    this._super = f;
                    return g
                }
            }(g, this.prototype[g])));
        if (b.prototype.Import)for (this.prototype.Import || (this.prototype.Import = []), g = b.prototype.Import, d = 0; d < g.length; d++)this.prototype.Import.push(g[d]);
        b.prototype.Package && this.prototype.Package != b.prototype.Package && (this.prototype.Import || (this.prototype.Import = []), this.prototype.Import.push(b.prototype.Package));
        return this
    }
    return "object" !== typeof b ? this : this.extend(Class(b))
};
Function.prototype.expand = function (b, c) {
    if ("object" === typeof b)if (void 0 == c && (c = !1), !0 === c)for (var d in b)this.prototype[d] = b[d]; else this.extend(Class(b))
};
var Instance = {
    copy: function (b) {
        if (!b)return null;
        var c = {};
        b instanceof Array && (c = []);
        for (property in b)c[property] = "object" == typeof b[property] ? Instance.copy(b[property]) : b[property];
        return c
    }, create: function (b, c) {
        c || (c = []);
        var d = b;
        "string" == typeof b && (d = getClassByFullName(d));
        if (!d)return null;
        var f = d.prototype.create;
        d.prototype.create = function () {
        };
        var g = new d;
        d.prototype.create = f;
        g.create && g.create instanceof Function && g.create.apply(g, c);
        return g
    }, JSON: function (b) {
        if (void 0 == b || null == b)return b;
        if (b instanceof Array) {
            var c = [];
            c.push("[");
            for (var d = 0; d < b.length; d++)c.push(Instance.JSON(b[d])), c.push(", ");
            1 < c.length && c.pop();
            c.push("]");
            return c.join("")
        }
        if (b instanceof Function)return b;
        if ("string" === typeof b)return '"' + b.toString() + '"';
        if ("number" === typeof b)return Number(b).toString();
        if ("boolean" === typeof b)return Boolean(b).toString();
        if ("object" === typeof b) {
            c = [];
            c.push("{");
            for (d in b) {
                var f = '"' + d + '":' + Instance.JSON(b[d]);
                c.push(f);
                c.push(", ")
            }
            1 < c.length && c.pop();
            c.push("}");
            return c.join("")
        }
    },
    parse: function (b, c) {
        return b && "undefined" != b && "null" != b && "" != b ? eval("(" + b + ")") : c
    }
};
Object.create = Object.create || function () {
        function b() {
        }
        
        return function (c) {
            if (1 != arguments.length)throw Error("Object.create implementation only accepts one parameter.");
            b.prototype = c;
            return new b
        }
    }();
Object.keys = Object.keys || function (b) {
        if (b !== Object(b))throw new TypeError("Object.keys called on a non-object");
        var c = [], d;
        for (d in b)Object.prototype.hasOwnProperty.call(b, d) && c.push(d);
        return c
    };
(function () {
    for (var b = 0, c = ["webkit", "moz"], d = 0; d < c.length && !window.requestAnimationFrame; ++d)window.requestAnimationFrame = window[c[d] + "RequestAnimationFrame"], window.cancelAnimationFrame = window[c[d] + "CancelAnimationFrame"] || window[c[d] + "CancelRequestAnimationFrame"];
    window.requestAnimationFrame || (window.requestAnimationFrame = function (c) {
        var d = (new Date).getTime(), h = Math.max(0, 16.7 - (d - b)), k = window.setTimeout(function () {
            c(d + h)
        }, h);
        b = d + h;
        return k
    });
    window.cancelAnimationFrame || (window.cancelAnimationFrame =
        function (b) {
            clearTimeout(b)
        })
})();
(function () {
    var b = {
        supportsFullScreen: !1, isFullScreen: function () {
            return !1
        }, requestFullScreen: function () {
        }, cancelFullScreen: function () {
        }, fullScreenEventName: "-", prefix: ""
    }, c = ["webkit", "moz", "o", "ms"];
    if ("undefined" != typeof document.exitFullscreen) b.supportsFullScreen = !0; else if ("undefined" != typeof document.cancelFullScreen) b.supportsFullScreen = !0; else for (var d = 0, f = c.length; d < f; d++)if (b.prefix = c[d], "undefined" != typeof document[b.prefix + "CancelFullScreen"]) {
        b.supportsFullScreen = !0;
        break
    }
    b.supportsFullScreen &&
    (b.fullScreenEventName = b.prefix + "fullscreenchange", b.isFullScreen = function () {
        switch (this.prefix) {
            case "":
                return document.fullScreen;
            case "webkit":
                return document.webkitIsFullScreen;
            default:
                return document[this.prefix + "FullScreen"]
        }
    }, b.requestFullScreen = function (b) {
        b[this.prefix + "RequestFullScreen"]()
    }, b.cancelFullScreen = function (b) {
        return "" === this.prefix ? document.cancelFullScreen() : document[this.prefix + "CancelFullScreen"]()
    });
    window.fullScreenApi = b
})();
var ColorTable = {
    aliceblue: "#f0f8ff",
    antiquewhite: "#faebd7",
    aqua: "#00ffff",
    aquamarine: "#7fffd4",
    azure: "#f0ffff",
    beige: "#f5f5dc",
    bisque: "#ffe4c4",
    black: "#000000",
    blanchedalmond: "#ffebcd",
    blue: "#0000ff",
    blueviolet: "#8a2be2",
    brown: "#a52a2a",
    burlywood: "#deb887",
    cadetblue: "#5f9ea0",
    chartreuse: "#7fff0",
    chocolate: "#d2691e",
    coral: "#ff7f50",
    cornflowerblue: "#6495ed",
    cornsilk: "#fff8dc",
    crimson: "#dc143c",
    cyan: "#00ffff",
    darkblue: "#00008b",
    darkcyan: "#008b8b",
    darkgoldenrod: "#b8860b",
    darkgray: "#a9a9a9",
    darkgreen: "#006400",
    darkgrey: "#a9a9a9",
    darkkhaki: "#bdb76b",
    darkmagenta: "#8b008b",
    darkolivegreen: "#556b2f",
    darkorange: "#ff8c00",
    darkorchid: "#9932cc",
    darkred: "#8b0000",
    darksalmon: "#e9967a",
    darkseagreen: "#8fbc8f",
    darkslateblue: "#483d8b",
    darkslategray: "#2f4f4f",
    darkslategrey: "#2f4f4f",
    darkturquoise: "#00ced1",
    darkviolet: "#9400d3",
    deeppink: "#ff1493",
    deepskyblue: "#00bfff",
    dimgray: "#696969",
    dimgrey: "#696969",
    dodgerblue: "#1e90ff",
    firebrick: "#b22222",
    floralwhite: "#fffaf0",
    forestgreen: "#228b22",
    fuchsia: "#ff00ff",
    gainsboro: "#dcdcdC",
    ghostwhite: "#f8f8ff",
    gold: "#ffd700",
    goldenrod: "#daa520",
    gray: "#808080",
    green: "#008000",
    greenyellow: "#adff2f",
    grey: "#808080",
    honeydew: "#f0fff0",
    hotpink: "#ff69b4",
    indianred: "#cd5c5c",
    indigo: "#4b0082",
    ivory: "#fffff0",
    khaki: "#f0e68c",
    lavender: "#e6e6fa",
    lavenderblush: "#fff0f5",
    lawngreen: "#7cfc00",
    lemonchiffon: "#fffacd",
    lightblue: "#add8e6",
    lightcoral: "#f08080",
    lightcyan: "#e0ffff",
    lightgoldenrodyellow: "#fafad2",
    lightgray: "#d3d3d3",
    lightgreen: "#90ee90",
    lightgrey: "#d3d3d3",
    lightpink: "#ffb6c1",
    lightsalmon: "#ffa07a",
    lightseagreen: "#20b2aa",
    lightskyblue: "#87cefa",
    lightslategray: "#778899",
    lightslategrey: "#778899",
    lightsteelblue: "#b0c4de",
    lightyellow: "#ffffe0",
    lime: "#00ff00",
    limegreen: "#32cd32",
    linen: "#faf0e6",
    magenta: "#ff00ff",
    maroon: "#800000",
    mediumaquamarine: "#66cdaa",
    mediumblue: "#0000cd",
    mediumorchid: "#ba55d3",
    mediumpurple: "#9370db",
    mediumseagreen: "#3cb371",
    mediumslateblue: "#7b68ee",
    mediumspringgreen: "#00fa9a",
    mediumturquoise: "#48d1cc",
    mediumvioletred: "#c71585",
    midnightblue: "#191970",
    mintcream: "#f5fffa",
    mistyrose: "#ffe4e1",
    moccasin: "#ffe4b5",
    navajowhite: "#ffdead",
    navy: "#000080",
    oldlace: "#fdf5e6",
    olive: "#808000",
    olivedrab: "#6b8e23",
    orange: "#ffa500",
    orangered: "#ff4500",
    orchid: "#da70d6",
    palegoldenrod: "#eee8aa",
    palegreen: "#98fb98",
    paleturquoise: "#afeeee",
    palevioletred: "#db7093",
    papayawhip: "#ffefd5",
    peachpuff: "#ffdab9",
    peru: "#cd853f",
    pink: "#ffc0cb",
    plum: "#dda0dd",
    powderblue: "#b0e0e6",
    purple: "#800080",
    red: "#ff0000",
    rosybrown: "#bc8f8f",
    royalblue: "#4169e1",
    saddlebrown: "#8b4513",
    salmon: "#fa8072",
    sandybrown: "#f4a460",
    seagreen: "#2e8b57",
    seashell: "#fff5ee",
    sienna: "#a0522d",
    silver: "#c0c0c0",
    skyblue: "#87ceeb",
    slateblue: "#6a5acd",
    slategray: "#708090",
    slategrey: "#708090",
    snow: "#fffafa",
    springgreen: "#00ff7f",
    steelblue: "#4682b4",
    tan: "#d2b48c",
    teal: "#008080",
    thistle: "#d8bfd8",
    tomato: "#ff6347",
    turquoise: "#40e0d0",
    violet: "#ee82ee",
    wheat: "#f5deb3",
    white: "#ffffff",
    whitesmoke: "#f5f5f5",
    yellow: "#ffff00",
    yellowgreen: "#9acd32",
    value: function (b) {
        if (!b || "string" != typeof b)return b;
        var c = b.toLowerCase();
        return this[c] ? this[c] : b
    }
};
Function.expand({
    bind: function (b) {
        var c = this;
        return function () {
            return c.apply(b, arguments)
        }
    }, delay: function (b, c, d) {
        "object" !== typeof b && (d = c, c = b, b = global);
        c = c || 1;
        d = d || [];
        return setTimeout(function () {
            this.apply(b, d)
        }.bind(this), c)
    }, interval: function (b, c, d) {
        "object" !== typeof b && (d = c, c = b, b = global);
        c = c || 1;
        d = d || [];
        var f = this;
        return {
            intervalId: setInterval(function () {
                this.apply(b, d)
            }.bind(this), c), stop: function () {
                clearInterval(this.intervalId);
                this.intervalId = void 0
            }, isRunning: function () {
                return void 0 !=
                    this.intervalId
            }, start: function () {
                this.intervalId = setInterval(function () {
                    f.apply(b, d)
                }, c)
            }
        }
    }, runInAnimate: function (b, c) {
        "object" !== typeof b && (c = b, b = {});
        var d = {
            stopFlag: !1, stop: function () {
                this.stopFlag = !0
            }
        }, f = this, g = 0, h = Math.ceil(c / 16.7), k = function () {
            !0 !== d.stopFlag && (g++, !1 !== f.apply(b, [g, h]) && (g < h || void 0 == c) && window.requestAnimationFrame(k))
        };
        k();
        return d
    }, executeOnce: function () {
        this.executed || (this.executed = !1);
        this.executed || (this(), this.executed = !0)
    }
});
String.expand({
    trim: function () {
        return this.replace(/(^\s*)|(\s*$)/g, "")
    }, replaceAll: function (b, c, d) {
        void 0 == d && (d = !1);
        if (RegExp && !d)return this.replace(RegExp(b, "g"), c);
        var f = this.indexOf(b);
        d = [];
        for (var g = this; -1 != f;) {
            var f = f + b.length, h = g.substring(0, f), g = g.substring(f), h = h.replace(b, c);
            d.push(h);
            f = g.indexOf(b)
        }
        "" !== g && d.push(g);
        return d.join("")
    }, subBetween: function (b, c) {
        if (void 0 == b || void 0 == c)return "";
        var d = this.length, f = this.indexOf(b);
        if (-1 == f)return "";
        f += b.length;
        d = this.substring(f, d).indexOf(c);
        return -1 == d ? "" : this.substring(f, d + f)
    }, html2Text: function () {
        return this.replaceAll("<[.[^<]]*>", "")
    }, HTMLLabel2Text: function () {
        return this.replaceAll("<", "&lt;").replaceAll(">", "&gt;")
    }, isUrl: function () {
        return "" != this && this.match(/(http\:\/\/)?([\w.]+)(\/[\w-   \.\/\?%&=]*)?/gi) ? !0 : !1
    }, isEmail: function () {
        return "" != this && this.match(/^([A-Za-z0-9])(\w)+@(\w)+(\.)(com|com\.cn|net|cn|net\.cn|org|biz|info|gov|gov\.cn|edu|edu\.cn)/) ? !0 : !1
    }, toArray: function (b) {
        b || (b = "");
        return this.split(b)
    }, reverse: function () {
        var b =
            this.split("");
        b.reverse();
        return b.join("")
    }, equals: function (b) {
        return this.trim() == b.trim()
    }, equalsIgnoreCase: function (b) {
        return this.toLowerCase().trim() == b.toLowerCase().trim()
    }, startWith: function (b) {
        return "" === b ? !1 : this.substr(0, b.length) === b
    }, endWith: function (b) {
        return "" === b ? !1 : this.substr(-b.length, b.length) === b
    }, isEnglish: function () {
        return /[\x00-\xff]/.test(this)
    }, overflow: function (b) {
        if (void 0 == b)return this.toString();
        var c = 2;
        /[^\x00-\xff]/.test(this) && (b = Math.floor(b / 2), c = Math.floor(c /
            2));
        return this.length - b > c ? this.substr(0, b) + "..." : this.toString()
    }, remove: function (b) {
        if ("string" == typeof b && b) {
            var c = this.indexOf(b);
            if (!(0 > c))return b = b.length, this.substring(0, c) + this.substring(c + b, this.length)
        }
    }, removeStartFrom: function (b) {
        if ("string" == typeof b && b && (b = this.indexOf(b), !(0 > b)))return this.substring(0, b)
    }, cycle: function (b) {
        if (!isNaN(b)) {
            for (var c = parseInt(b / this.length), d = this; 0 < c;)d += this, c--;
            return d.substring(0, b)
        }
    }, firstUpperCase: function () {
        return this.substring(0, 1).toUpperCase() +
            this.substring(1)
    }, extract: function () {
        if (0 == this.length || 0 == arguments.length)return [];
        for (var b = [], c = this.toString(), d = 0; d < c.length;) {
            for (var f = !1, g = 0; g < arguments.length; g++) {
                var h = arguments[g];
                if (c.substr(d, h.length) == h) {
                    b.push(h);
                    d += h.length;
                    f = !0;
                    break
                }
            }
            f || d++
        }
        return b
    }, statics: {
        format: function () {
            if (0 == arguments.length)return "";
            if (1 == arguments.length)return arguments[0];
            for (var b = arguments[0], c = b.extract("%s", "%d", "%f", "%b", "%o"), d = 1; d < arguments.length; d++) {
                var f = arguments[d], g = c[d - 1];
                "%s" == g &&
                ("string" == typeof f ? b = b.replace("%s", f) : b = b.replace("%s", ""));
                if ("%d" == g) {
                    isNaN(f) && (f = 0);
                    var h;
                    h = "number" == typeof f ? -1 == Number(f).toString().indexOf(".") : !1;
                    h ? b = b.replace("%d", f + "") : b = b.replace("%d", "")
                }
                "%f" == g && (isNaN(f) && (f = 0), "number" == typeof f ? b = b.replace("%f", f + "") : b = b.replace("%f", ""));
                "%b" == g && (f = !!f, "boolean" == typeof f ? b = b.replace("%b", f + "") : b = b.replace("%b", ""));
                "%o" == g && ("object" == typeof f ? b = b.replace("%o", Instance.JSON(f)) : b = b.replace("%o", ""))
            }
            return b
        }
    }, riseAWord: function (b, c) {
        for (var d =
            null, d = -1 == b.indexOf(" ") ? [b] : b.split(" "), f = this, g = 0; g < d.length; g++)0 > this.indexOf(d[g]) || (f = f.replaceAll(d[g], "<span style='color:" + c + ";'>" + d[g] + "</span></font>"));
        return f
    }
});
Array.expand({
    remove: function (b) {
        return isNaN(b) || b > this.length ? !1 : this.splice(b, 1)[0]
    }, indexOf: function (b) {
        for (var c = 0; c < this.length; c++)if (this[c] === b)return c;
        return -1
    }, removeElement: function (b) {
        b = this.indexOf(b);
        -1 < b && this.remove(b)
    }, lastIndexOf: function (b) {
        for (var c = -1, d = 0; d < this.length; d++)this[d] === b && (c = d);
        return c
    }, statics: {
        isArray: function (b) {
            return "[object Array]" == Object.prototype.toString.call(b)
        }
    }
});
Date.expand({
    format: function (b, c) {
        c = c || !0;
        var d = {
            "y+": this.getYear(),
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "h+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            S: this.getMilliseconds()
        };
        /(y+)/.test(b) && (b = b.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length)));
        for (var f in d)RegExp("(" + f + ")").test(b) && (b = !0 === c ? b.replace(RegExp.$1, d[f]) : b.replace(RegExp.$1, 1 == RegExp.$1.length ? d[f] : ("00" + d[f]).substr(("" + d[f]).length)));
        return b
    },
    statics: {
        now: function () {
            return (new Date).getTime()
        }
    }
});
Number.expand({
    statics: {
        between: function (b, c, d) {
            var f = Math.min(c, d);
            c = Math.max(c, d);
            b < f && (b = f);
            b > c && (b = c);
            return b
        }, fixed: function (b, c) {
            var d = Math.pow(10, c);
            return Math.round(b * d) / d
        }
    }
});
var Color = function (b) {
    b && "object" == typeof b && b.toString && (b = b.toString());
    return {
        value: ColorTable.value(b), toString: function () {
            function b(c, d, h) {
                if (c.length < h && c.length > d)for (; c.length < h;)c = "0" + c;
                return c
            }
            
            var d = this.value;
            d || (d = 0);
            if ("string" == typeof d) {
                if (0 == d.indexOf("#"))return d;
                if (0 == d.indexOf("0x"))return d.replace("0x", "#")
            }
            d = parseInt(d).toString(16);
            8 < d.length && (d = d.substr(0, 8));
            d = b(d, 6, 8);
            d = b(d, 3, 6);
            d = b(d, 0, 3);
            return "#" + d
        }, valueOf: toString, split: function () {
            var b = {r: 0, g: 0, b: 0, a: 255};
            if (!this.value)return b;
            var d = this.toString(), f = "FF", g = "FF", h = "FF", k = "FF";
            switch (d.length) {
                case 9:
                    k = d.substr(1, 2);
                    f = d.substr(3, 2);
                    g = d.substr(5, 2);
                    h = d.substr(7, 2);
                    break;
                case 7:
                    f = d.substr(1, 2);
                    g = d.substr(3, 2);
                    h = d.substr(5, 2);
                    break;
                case 4:
                    f = d.substr(1, 1);
                    g = d.substr(2, 1);
                    h = d.substr(3, 1);
                    f += f;
                    g += g;
                    h += h;
                    break;
                default:
                    return b
            }
            return {r: parseInt(f, 16), g: parseInt(g, 16), b: parseInt(h, 16), a: parseInt(k, 16)}
        }, add: function (b) {
            var d;
            d = "object" == typeof b ? b : {r: b, g: b, b: b, a: 1};
            var f = this.split();
            b = Number.between(f.r + d.r, 0, 255).toString(16).toUpperCase();
            var g = Number.between(f.g + d.g, 0, 255).toString(16).toUpperCase();
            d = Number.between(f.b + d.b, 0, 255).toString(16).toUpperCase();
            f = Number(f.a).toString(16).toUpperCase();
            b = 1 >= b.length ? "0" + b : b;
            g = 1 >= g.length ? "0" + g : g;
            d = 1 >= d.length ? "0" + d : d;
            f = 1 >= f.length ? "0" + f : f;
            return "FF" == f ? "#" + b + g + d : "#" + f + b + g + d
        }, reduce: function (b) {
            return this.add("object" == typeof b ? b : {r: -b, g: -b, b: -b, a: 1})
        }, rgba: function (b) {
            var d = this.split();
            b = void 0 == b || "" === b ? d.a : parseFloat(b);
            1 < b && (b = Number.fixed(b / 255, 2));
            return String.format("rgba(%d,%d,%d,%f)",
                d.r, d.g, d.b, b)
        }, equals: function (b) {
            return this.toString() == Color(b).toString()
        }, difference: function (b) {
            var d = this.split();
            b = Color(b).split();
            return {r: Math.abs(d.r - b.r), g: Math.abs(d.g - b.g), b: Math.abs(d.b - b.b), a: Math.abs(d.a - b.a)}
        }
    }
};
function equals(b, c) {
    return 1E-7 > Math.abs(b - c)
}
var Point = function (b, c) {
    return {
        x: b, y: c, isNearTo: function (b, c) {
            if (!b)return !1;
            void 0 == c && (c = 5);
            return Math.abs(this.x - b.x) < c && Math.abs(this.y - b.y) < c
        }, equals: function (b) {
            return b ? equals(this.x, b.x) && equals(this.y, b.y) : !1
        }, toString: function () {
            return "(" + this.x + "," + this.y + ")"
        }, clone: function () {
            return Point(this.x, this.y)
        }, getX: function () {
            return this.x
        }, getY: function () {
            return this.y
        }, isNaP: function () {
            return isNaN(this.x) || isNaN(this.y)
        }
    }
};
Point.NaP = function () {
    return Point(Number.NaN, Number.NaN)
};
$.browser.mozilla && (HTMLElement.prototype.__defineGetter__("innerText", function () {
    return this.textContent
}), HTMLElement.prototype.__defineSetter__("innerText", function (b) {
    this.textContent = b
}));
bdor[30] = function (b, c) {
    return bdor[b] - c
};
Class("RangeSlider", {
    create: function (b, c) {
        this.slider = b;
        this.min = 0;
        this.max = c.max ? c.max : 1;
        isNaN(this.max) && (this.max = 100);
        this.onChange = c.onChange;
        this.init();
        void 0 == c.range || isNaN(c.range) ? (this.currentRange = 0, this.setRange(0)) : (this.currentRange = c.range, this.setRange(c.range))
    }, init: function () {
        this.slider_total = $('<div class="slider-total"></div>');
        this.slider_range = $('<div class="slider-range"></div>');
        this.slider_hander = $('<div class="slider-handle"></div>');
        this.slider_range.css("pointer-events",
            "none");
        this.slider_hander.css("pointer-events", "none");
        this.slider.append(this.slider_total);
        this.slider.append(this.slider_range);
        this.slider.append(this.slider_hander);
        this.initEvents()
    }, initEvents: function () {
        this.isMouseDown = !1;
        this.slider_total.bind(_event._down, function (b) {
            this.isMouseDown = !0;
            b = isTouch ? b.originalEvent ? b.originalEvent.changedTouches : b.changedTouches : [b];
            this.onChangeRange(b);
            return !1
        }.bind(this));
        this.slider_total.bind(_event._move, function (b) {
            if (this.isMouseDown)return b = isTouch ?
                b.originalEvent ? b.originalEvent.changedTouches : b.changedTouches : [b], this.onChangeRange(b), !1
        }.bind(this));
        this.slider_total.bind(_event._up, function (b) {
            return this.isMouseDown = !1
        }.bind(this));
        this.slider_total.bind(_event._leave, function (b) {
            this.isMouseDown = !1
        }.bind(this));
        this.slider_hander.bind(_event._down, function (b) {
            b = isTouch ? b.originalEvent ? b.originalEvent.changedTouches : b.changedTouches : [b];
            this.onChangeRange(b);
            return !1
        }.bind(this))
    }, setMax: function (b) {
        this.max = b
    }, setRange: function (b) {
        if (void 0 !=
            b) {
            this.range = parseFloat(b);
            this.animation && this.animation.stop();
            var c = this.currentRange, d = this.range;
            this.animation = function (b, g) {
                this.currentRange = $.easing.swing(null, b, c, d - c, g);
                this.moveToRange(this.currentRange);
                this.currentRange == this.range && this.animation && this.animation.stop()
            }.runInAnimate(this, 200)
        }
    }, onChangeRange: virtual_function, moveToRange: virtual_function
});
Class("VerticalSlider", {
    onChangeRange: function (b) {
        b = b[0];
        if (void 0 != b) {
            var c = $(b.target), d = b.offsetY;
            void 0 == d && (d = b.pageY - c.offset().top);
            b = (c.height() - d) / this.slider_total.height() * this.max;
            this.setRange(b);
            if (this.onChange) this.onChange(b)
        }
    }, moveToRange: function (b) {
        this.slider_total.offset();
        this.slider.offset();
        var c = parseInt(this.slider_range.css("bottom").replace("px", "")), d = this.slider_hander.width(), f = this.slider_total.height() - d;
        b = Math.floor(b * f / this.max);
        b = Math.min(b, f);
        d = b + d / 2;
        this.slider_hander.css({
            bottom: b +
            c
        });
        this.slider_range.css({height: d})
    }
}).extend("RangeSlider");
Class("HorizontalSlider", {
    onChangeRange: function (b) {
        b = b[0];
        if (void 0 != b) {
            var c = $(b.target), d = b.offsetX;
            void 0 == d && (d = b.pageX - c.offset().left);
            b = d / this.slider_total.width() * this.max;
            this.setRange(b);
            if (this.onChange) this.onChange(b)
        }
    }, moveToRange: function (b) {
        var c = this.slider_total.offset().left - this.slider.offset().left;
        parseInt(this.slider_range.css("bottom").replace("px", ""));
        var d = this.slider_hander.width(), f = this.slider_total.width() - d;
        b = Math.floor(b * f / this.max);
        b = Math.min(b, f);
        d = b + d / 2;
        this.slider_hander.css({
            left: b +
            c
        });
        this.slider_range.css({width: d})
    }
}).extend("RangeSlider");
(function (b) {
    b.fn.slider = function (b) {
        if (b) {
            this.empty();
            var d = null;
            (d = "horizontal" == b.direction ? new HorizontalSlider(this, b) : new VerticalSlider(this, b)) || (d = new HorizontalSlider(this, b));
            return d
        }
    }
})(jQuery);
(function (b) {
    var c = "object" == typeof exports && exports, d = "object" == typeof module && module && module.exports == c && module, f = "object" == typeof global && global;
    if (f.global === f || f.window === f) b = f;
    var g = function (b) {
        this.message = b
    };
    g.prototype = Error();
    g.prototype.name = "InvalidCharacterError";
    var h = {
        encode: function (b) {
            b = String(b);
            if (/[^\0-\xFF]/.test(b))throw new g("The string to be encoded contains characters outside of the Latin1 range.");
            for (var c = b.length % 3, d = "", f = -1, h, k, r, s = b.length - c; ++f < s;)h = b.charCodeAt(f) <<
                16, k = b.charCodeAt(++f) << 8, r = b.charCodeAt(++f), h = h + k + r, d += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >> 18 & 63) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >> 12 & 63) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >> 6 & 63) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h & 63);
            2 == c ? (h = b.charCodeAt(f) << 8, k = b.charCodeAt(++f), h += k, d += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >>
                        10) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >> 4 & 63) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h << 2 & 63) + "=") : 1 == c && (h = b.charCodeAt(f), d += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h >> 2) + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(h << 4 & 63) + "==");
            return d
        }, decode: function (b) {
            b = String(b);
            for (var c = b.length, d = 0, f, g, h = "", k = -1; ++k < c;)g = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".indexOf(b.charAt(k)),
                f = d % 4 ? 64 * f + g : g, d++ % 4 && (h += String.fromCharCode(255 & f >> (-2 * d & 6)));
            return h
        }, version: "0.1.0"
    };
    if ("function" == typeof define && "object" == typeof define.amd && define.amd) define(function () {
        return h
    }); else if (c && !c.nodeType)if (d) d.exports = h; else for (var k in h)h.hasOwnProperty(k) && (c[k] = h[k]); else b.base64 = h
})(this);
function parsHexToNormalString(b) {
    for (var c = ""; 2 <= b.length;)c += String.fromCharCode(parseInt(b.substring(0, 2), 16)), b = b.substring(2, b.length);
    return c
}
function parseHexString(b) {
    for (var c = []; 2 <= b.length;)c.push(parseInt(b.substring(0, 2), 16)), b = b.substring(2, b.length);
    return c
}
function byteArray2String(b) {
    for (var c = "", d = 0; d < b.length; d++)c += String.fromCharCode(b[d]);
    return c
}
function rc4(b, c) {
    for (var d = [], f = [], g = 0; 256 > g; g++)d[g] = g, f[g] = b.charCodeAt(g % b.length);
    for (var h = 0, g = 0; 256 > g; g++) {
        var h = h + d[g] + f[g] & 255, k = d[g];
        d[g] = d[h];
        d[h] = k
    }
    for (var l = h = f = 0, m, k = "", g = 0; g < c.length; g++)f = f + 1 & 255, h = h + d[f] & 255, l = d[f], d[f] = d[h], d[h] = l, l = d[f] + d[h] & 255, m = c.charCodeAt(g), m ^= d[l], k += String.fromCharCode(m);
    return k
}
String.prototype.MD5 = function (b) {
    function c(b, c) {
        var d, f, g, h, k;
        g = b & 2147483648;
        h = c & 2147483648;
        d = b & 1073741824;
        f = c & 1073741824;
        k = (b & 1073741823) + (c & 1073741823);
        return d & f ? k ^ 2147483648 ^ g ^ h : d | f ? k & 1073741824 ? k ^ 3221225472 ^ g ^ h : k ^ 1073741824 ^ g ^ h : k ^ g ^ h
    }
    
    function d(b, d, f, g, h, k, l) {
        b = c(b, c(c(d & f | ~d & g, h), l));
        return c(b << k | b >>> 32 - k, d)
    }
    
    function f(b, d, f, g, h, k, l) {
        b = c(b, c(c(d & g | f & ~g, h), l));
        return c(b << k | b >>> 32 - k, d)
    }
    
    function g(b, d, f, g, h, k, l) {
        b = c(b, c(c(d ^ f ^ g, h), l));
        return c(b << k | b >>> 32 - k, d)
    }
    
    function h(b, d, f, g, h, k, l) {
        b = c(b,
            c(c(f ^ (d | ~g), h), l));
        return c(b << k | b >>> 32 - k, d)
    }
    
    function k(b) {
        var c = "", d = "", f;
        for (f = 0; 3 >= f; f++)d = b >>> 8 * f & 255, d = "0" + d.toString(16), c += d.substr(d.length - 2, 2);
        return c
    }
    
    var l = [], m, n, p, q, t, r, s, u, v, l = function (b) {
        var c, d = b.length;
        c = d + 8;
        for (var f = 16 * ((c - c % 64) / 64 + 1), g = Array(f - 1), h = 0, k = 0; k < d;)c = (k - k % 4) / 4, h = k % 4 * 8, g[c] |= b.charCodeAt(k) << h, k++;
        c = (k - k % 4) / 4;
        g[c] |= 128 << k % 4 * 8;
        g[f - 2] = d << 3;
        g[f - 1] = d >>> 29;
        return g
    }(this);
    r = 1732584193;
    s = 4023233417;
    u = 2562383102;
    v = 271733878;
    for (m = 0; m < l.length; m += 16)n = r, p = s, q = u, t = v, r = d(r, s,
        u, v, l[m + 0], 7, 3614090360), v = d(v, r, s, u, l[m + 1], 12, 3905402710), u = d(u, v, r, s, l[m + 2], 17, 606105819), s = d(s, u, v, r, l[m + 3], 22, 3250441966), r = d(r, s, u, v, l[m + 4], 7, 4118548399), v = d(v, r, s, u, l[m + 5], 12, 1200080426), u = d(u, v, r, s, l[m + 6], 17, 2821735955), s = d(s, u, v, r, l[m + 7], 22, 4249261313), r = d(r, s, u, v, l[m + 8], 7, 1770035416), v = d(v, r, s, u, l[m + 9], 12, 2336552879), u = d(u, v, r, s, l[m + 10], 17, 4294925233), s = d(s, u, v, r, l[m + 11], 22, 2304563134), r = d(r, s, u, v, l[m + 12], 7, 1804603682), v = d(v, r, s, u, l[m + 13], 12, 4254626195), u = d(u, v, r, s, l[m + 14], 17, 2792965006),
        s = d(s, u, v, r, l[m + 15], 22, 1236535329), r = f(r, s, u, v, l[m + 1], 5, 4129170786), v = f(v, r, s, u, l[m + 6], 9, 3225465664), u = f(u, v, r, s, l[m + 11], 14, 643717713), s = f(s, u, v, r, l[m + 0], 20, 3921069994), r = f(r, s, u, v, l[m + 5], 5, 3593408605), v = f(v, r, s, u, l[m + 10], 9, 38016083), u = f(u, v, r, s, l[m + 15], 14, 3634488961), s = f(s, u, v, r, l[m + 4], 20, 3889429448), r = f(r, s, u, v, l[m + 9], 5, 568446438), v = f(v, r, s, u, l[m + 14], 9, 3275163606), u = f(u, v, r, s, l[m + 3], 14, 4107603335), s = f(s, u, v, r, l[m + 8], 20, 1163531501), r = f(r, s, u, v, l[m + 13], 5, 2850285829), v = f(v, r, s, u, l[m + 2], 9, 4243563512),
        u = f(u, v, r, s, l[m + 7], 14, 1735328473), s = f(s, u, v, r, l[m + 12], 20, 2368359562), r = g(r, s, u, v, l[m + 5], 4, 4294588738), v = g(v, r, s, u, l[m + 8], 11, 2272392833), u = g(u, v, r, s, l[m + 11], 16, 1839030562), s = g(s, u, v, r, l[m + 14], 23, 4259657740), r = g(r, s, u, v, l[m + 1], 4, 2763975236), v = g(v, r, s, u, l[m + 4], 11, 1272893353), u = g(u, v, r, s, l[m + 7], 16, 4139469664), s = g(s, u, v, r, l[m + 10], 23, 3200236656), r = g(r, s, u, v, l[m + 13], 4, 681279174), v = g(v, r, s, u, l[m + 0], 11, 3936430074), u = g(u, v, r, s, l[m + 3], 16, 3572445317), s = g(s, u, v, r, l[m + 6], 23, 76029189), r = g(r, s, u, v, l[m + 9], 4, 3654602809),
        v = g(v, r, s, u, l[m + 12], 11, 3873151461), u = g(u, v, r, s, l[m + 15], 16, 530742520), s = g(s, u, v, r, l[m + 2], 23, 3299628645), r = h(r, s, u, v, l[m + 0], 6, 4096336452), v = h(v, r, s, u, l[m + 7], 10, 1126891415), u = h(u, v, r, s, l[m + 14], 15, 2878612391), s = h(s, u, v, r, l[m + 5], 21, 4237533241), r = h(r, s, u, v, l[m + 12], 6, 1700485571), v = h(v, r, s, u, l[m + 3], 10, 2399980690), u = h(u, v, r, s, l[m + 10], 15, 4293915773), s = h(s, u, v, r, l[m + 1], 21, 2240044497), r = h(r, s, u, v, l[m + 8], 6, 1873313359), v = h(v, r, s, u, l[m + 15], 10, 4264355552), u = h(u, v, r, s, l[m + 6], 15, 2734768916), s = h(s, u, v, r, l[m + 13], 21,
        1309151649), r = h(r, s, u, v, l[m + 4], 6, 4149444226), v = h(v, r, s, u, l[m + 11], 10, 3174756917), u = h(u, v, r, s, l[m + 2], 15, 718787259), s = h(s, u, v, r, l[m + 9], 21, 3951481745), r = c(r, n), s = c(s, p), u = c(u, q), v = c(v, t);
    return 32 == b ? k(r) + k(s) + k(u) + k(v) : k(s) + k(u)
};
function QR8bitByte(b) {
    this.mode = QRMode.MODE_8BIT_BYTE;
    this.data = b
}
QR8bitByte.prototype = {
    getLength: function (b) {
        return this.data.length
    }, write: function (b) {
        for (var c = 0; c < this.data.length; c++)b.put(this.data.charCodeAt(c), 8)
    }
};
function QRCode(b, c) {
    this.typeNumber = b;
    this.errorCorrectLevel = c;
    this.modules = null;
    this.moduleCount = 0;
    this.dataCache = null;
    this.dataList = []
}
QRCode.prototype = {
    addData: function (b) {
        b = new QR8bitByte(b);
        this.dataList.push(b);
        this.dataCache = null
    }, isDark: function (b, c) {
        if (0 > b || this.moduleCount <= b || 0 > c || this.moduleCount <= c)throw Error(b + "," + c);
        return this.modules[b][c]
    }, getModuleCount: function () {
        return this.moduleCount
    }, make: function () {
        if (1 > this.typeNumber) {
            for (var b = 1, b = 1; 40 > b; b++) {
                for (var c = QRRSBlock.getRSBlocks(b, this.errorCorrectLevel), d = new QRBitBuffer, f = 0, g = 0; g < c.length; g++)f += c[g].dataCount;
                for (g = 0; g < this.dataList.length; g++)c = this.dataList[g],
                    d.put(c.mode, 4), d.put(c.getLength(), QRUtil.getLengthInBits(c.mode, b)), c.write(d);
                if (d.getLengthInBits() <= 8 * f)break
            }
            this.typeNumber = b
        }
        this.makeImpl(!1, this.getBestMaskPattern())
    }, makeImpl: function (b, c) {
        this.moduleCount = 4 * this.typeNumber + 17;
        this.modules = Array(this.moduleCount);
        for (var d = 0; d < this.moduleCount; d++) {
            this.modules[d] = Array(this.moduleCount);
            for (var f = 0; f < this.moduleCount; f++)this.modules[d][f] = null
        }
        this.setupPositionProbePattern(0, 0);
        this.setupPositionProbePattern(this.moduleCount - 7, 0);
        this.setupPositionProbePattern(0,
            this.moduleCount - 7);
        this.setupPositionAdjustPattern();
        this.setupTimingPattern();
        this.setupTypeInfo(b, c);
        7 <= this.typeNumber && this.setupTypeNumber(b);
        null == this.dataCache && (this.dataCache = QRCode.createData(this.typeNumber, this.errorCorrectLevel, this.dataList));
        this.mapData(this.dataCache, c)
    }, setupPositionProbePattern: function (b, c) {
        for (var d = -1; 7 >= d; d++)if (!(-1 >= b + d || this.moduleCount <= b + d))for (var f = -1; 7 >= f; f++)-1 >= c + f || this.moduleCount <= c + f || (this.modules[b + d][c + f] = 0 <= d && 6 >= d && (0 == f || 6 == f) || 0 <= f && 6 >=
        f && (0 == d || 6 == d) || 2 <= d && 4 >= d && 2 <= f && 4 >= f ? !0 : !1)
    }, getBestMaskPattern: function () {
        for (var b = 0, c = 0, d = 0; 8 > d; d++) {
            this.makeImpl(!0, d);
            var f = QRUtil.getLostPoint(this);
            if (0 == d || b > f) b = f, c = d
        }
        return c
    }, createMovieClip: function (b, c, d) {
        b = b.createEmptyMovieClip(c, d);
        this.make();
        for (c = 0; c < this.modules.length; c++) {
            d = 1 * c;
            for (var f = 0; f < this.modules[c].length; f++) {
                var g = 1 * f;
                this.modules[c][f] && (b.beginFill(0, 100), b.moveTo(g, d), b.lineTo(g + 1, d), b.lineTo(g + 1, d + 1), b.lineTo(g, d + 1), b.endFill())
            }
        }
        return b
    }, setupTimingPattern: function () {
        for (var b =
            8; b < this.moduleCount - 8; b++)null == this.modules[b][6] && (this.modules[b][6] = 0 == b % 2);
        for (b = 8; b < this.moduleCount - 8; b++)null == this.modules[6][b] && (this.modules[6][b] = 0 == b % 2)
    }, setupPositionAdjustPattern: function () {
        for (var b = QRUtil.getPatternPosition(this.typeNumber), c = 0; c < b.length; c++)for (var d = 0; d < b.length; d++) {
            var f = b[c], g = b[d];
            if (null == this.modules[f][g])for (var h = -2; 2 >= h; h++)for (var k = -2; 2 >= k; k++)this.modules[f + h][g + k] = -2 == h || 2 == h || -2 == k || 2 == k || 0 == h && 0 == k ? !0 : !1
        }
    }, setupTypeNumber: function (b) {
        for (var c =
            QRUtil.getBCHTypeNumber(this.typeNumber), d = 0; 18 > d; d++) {
            var f = !b && 1 == (c >> d & 1);
            this.modules[Math.floor(d / 3)][d % 3 + this.moduleCount - 8 - 3] = f
        }
        for (d = 0; 18 > d; d++)f = !b && 1 == (c >> d & 1), this.modules[d % 3 + this.moduleCount - 8 - 3][Math.floor(d / 3)] = f
    }, setupTypeInfo: function (b, c) {
        for (var d = QRUtil.getBCHTypeInfo(this.errorCorrectLevel << 3 | c), f = 0; 15 > f; f++) {
            var g = !b && 1 == (d >> f & 1);
            6 > f ? this.modules[f][8] = g : 8 > f ? this.modules[f + 1][8] = g : this.modules[this.moduleCount - 15 + f][8] = g
        }
        for (f = 0; 15 > f; f++)g = !b && 1 == (d >> f & 1), 8 > f ? this.modules[8][this.moduleCount -
            f - 1] = g : 9 > f ? this.modules[8][15 - f - 1 + 1] = g : this.modules[8][15 - f - 1] = g;
        this.modules[this.moduleCount - 8][8] = !b
    }, mapData: function (b, c) {
        for (var d = -1, f = this.moduleCount - 1, g = 7, h = 0, k = this.moduleCount - 1; 0 < k; k -= 2)for (6 == k && k--; ;) {
            for (var l = 0; 2 > l; l++)if (null == this.modules[f][k - l]) {
                var m = !1;
                h < b.length && (m = 1 == (b[h] >>> g & 1));
                QRUtil.getMask(c, f, k - l) && (m = !m);
                this.modules[f][k - l] = m;
                g--;
                -1 == g && (h++, g = 7)
            }
            f += d;
            if (0 > f || this.moduleCount <= f) {
                f -= d;
                d = -d;
                break
            }
        }
    }
};
QRCode.PAD0 = 236;
QRCode.PAD1 = 17;
QRCode.createData = function (b, c, d) {
    c = QRRSBlock.getRSBlocks(b, c);
    for (var f = new QRBitBuffer, g = 0; g < d.length; g++) {
        var h = d[g];
        f.put(h.mode, 4);
        f.put(h.getLength(), QRUtil.getLengthInBits(h.mode, b));
        h.write(f)
    }
    for (g = b = 0; g < c.length; g++)b += c[g].dataCount;
    if (f.getLengthInBits() > 8 * b)throw Error("code length overflow. (" + f.getLengthInBits() + ">" + 8 * b + ")");
    for (f.getLengthInBits() + 4 <= 8 * b && f.put(0, 4); 0 != f.getLengthInBits() % 8;)f.putBit(!1);
    for (; !(f.getLengthInBits() >= 8 * b);) {
        f.put(QRCode.PAD0, 8);
        if (f.getLengthInBits() >=
            8 * b)break;
        f.put(QRCode.PAD1, 8)
    }
    return QRCode.createBytes(f, c)
};
QRCode.createBytes = function (b, c) {
    for (var d = 0, f = 0, g = 0, h = Array(c.length), k = Array(c.length), l = 0; l < c.length; l++) {
        var m = c[l].dataCount, n = c[l].totalCount - m, f = Math.max(f, m), g = Math.max(g, n);
        h[l] = Array(m);
        for (var p = 0; p < h[l].length; p++)h[l][p] = 255 & b.buffer[p + d];
        d += m;
        p = QRUtil.getErrorCorrectPolynomial(n);
        m = (new QRPolynomial(h[l], p.getLength() - 1)).mod(p);
        k[l] = Array(p.getLength() - 1);
        for (p = 0; p < k[l].length; p++)n = p + m.getLength() - k[l].length, k[l][p] = 0 <= n ? m.get(n) : 0
    }
    for (p = l = 0; p < c.length; p++)l += c[p].totalCount;
    d = Array(l);
    for (p = m = 0; p < f; p++)for (l = 0; l < c.length; l++)p < h[l].length && (d[m++] = h[l][p]);
    for (p = 0; p < g; p++)for (l = 0; l < c.length; l++)p < k[l].length && (d[m++] = k[l][p]);
    return d
};
for (var QRMode = {MODE_NUMBER: 1, MODE_ALPHA_NUM: 2, MODE_8BIT_BYTE: 4, MODE_KANJI: 8}, QRErrorCorrectLevel = {
    L: 1,
    M: 0,
    Q: 3,
    H: 2
}, QRMaskPattern = {
    PATTERN000: 0,
    PATTERN001: 1,
    PATTERN010: 2,
    PATTERN011: 3,
    PATTERN100: 4,
    PATTERN101: 5,
    PATTERN110: 6,
    PATTERN111: 7
}, QRUtil = {
    PATTERN_POSITION_TABLE: [[], [6, 18], [6, 22], [6, 26], [6, 30], [6, 34], [6, 22, 38], [6, 24, 42], [6, 26, 46], [6, 28, 50], [6, 30, 54], [6, 32, 58], [6, 34, 62], [6, 26, 46, 66], [6, 26, 48, 70], [6, 26, 50, 74], [6, 30, 54, 78], [6, 30, 56, 82], [6, 30, 58, 86], [6, 34, 62, 90], [6, 28, 50, 72, 94], [6, 26, 50, 74, 98], [6,
        30, 54, 78, 102], [6, 28, 54, 80, 106], [6, 32, 58, 84, 110], [6, 30, 58, 86, 114], [6, 34, 62, 90, 118], [6, 26, 50, 74, 98, 122], [6, 30, 54, 78, 102, 126], [6, 26, 52, 78, 104, 130], [6, 30, 56, 82, 108, 134], [6, 34, 60, 86, 112, 138], [6, 30, 58, 86, 114, 142], [6, 34, 62, 90, 118, 146], [6, 30, 54, 78, 102, 126, 150], [6, 24, 50, 76, 102, 128, 154], [6, 28, 54, 80, 106, 132, 158], [6, 32, 58, 84, 110, 136, 162], [6, 26, 54, 82, 110, 138, 166], [6, 30, 58, 86, 114, 142, 170]],
    G15: 1335,
    G18: 7973,
    G15_MASK: 21522,
    getBCHTypeInfo: function (b) {
        for (var c = b << 10; 0 <= QRUtil.getBCHDigit(c) - QRUtil.getBCHDigit(QRUtil.G15);)c ^=
            QRUtil.G15 << QRUtil.getBCHDigit(c) - QRUtil.getBCHDigit(QRUtil.G15);
        return (b << 10 | c) ^ QRUtil.G15_MASK
    },
    getBCHTypeNumber: function (b) {
        for (var c = b << 12; 0 <= QRUtil.getBCHDigit(c) - QRUtil.getBCHDigit(QRUtil.G18);)c ^= QRUtil.G18 << QRUtil.getBCHDigit(c) - QRUtil.getBCHDigit(QRUtil.G18);
        return b << 12 | c
    },
    getBCHDigit: function (b) {
        for (var c = 0; 0 != b;)c++, b >>>= 1;
        return c
    },
    getPatternPosition: function (b) {
        return QRUtil.PATTERN_POSITION_TABLE[b - 1]
    },
    getMask: function (b, c, d) {
        switch (b) {
            case QRMaskPattern.PATTERN000:
                return 0 == (c + d) %
                    2;
            case QRMaskPattern.PATTERN001:
                return 0 == c % 2;
            case QRMaskPattern.PATTERN010:
                return 0 == d % 3;
            case QRMaskPattern.PATTERN011:
                return 0 == (c + d) % 3;
            case QRMaskPattern.PATTERN100:
                return 0 == (Math.floor(c / 2) + Math.floor(d / 3)) % 2;
            case QRMaskPattern.PATTERN101:
                return 0 == c * d % 2 + c * d % 3;
            case QRMaskPattern.PATTERN110:
                return 0 == (c * d % 2 + c * d % 3) % 2;
            case QRMaskPattern.PATTERN111:
                return 0 == (c * d % 3 + (c + d) % 2) % 2;
            default:
                throw Error("bad maskPattern:" + b);
        }
    },
    getErrorCorrectPolynomial: function (b) {
        for (var c = new QRPolynomial([1], 0), d = 0; d <
        b; d++)c = c.multiply(new QRPolynomial([1, QRMath.gexp(d)], 0));
        return c
    },
    getLengthInBits: function (b, c) {
        if (1 <= c && 10 > c)switch (b) {
            case QRMode.MODE_NUMBER:
                return 10;
            case QRMode.MODE_ALPHA_NUM:
                return 9;
            case QRMode.MODE_8BIT_BYTE:
                return 8;
            case QRMode.MODE_KANJI:
                return 8;
            default:
                throw Error("mode:" + b);
        } else if (27 > c)switch (b) {
            case QRMode.MODE_NUMBER:
                return 12;
            case QRMode.MODE_ALPHA_NUM:
                return 11;
            case QRMode.MODE_8BIT_BYTE:
                return 16;
            case QRMode.MODE_KANJI:
                return 10;
            default:
                throw Error("mode:" + b);
        } else if (41 > c)switch (b) {
            case QRMode.MODE_NUMBER:
                return 14;
            case QRMode.MODE_ALPHA_NUM:
                return 13;
            case QRMode.MODE_8BIT_BYTE:
                return 16;
            case QRMode.MODE_KANJI:
                return 12;
            default:
                throw Error("mode:" + b);
        } else throw Error("type:" + c);
    },
    getLostPoint: function (b) {
        for (var c = b.getModuleCount(), d = 0, f = 0; f < c; f++)for (var g = 0; g < c; g++) {
            for (var h = 0, k = b.isDark(f, g), l = -1; 1 >= l; l++)if (!(0 > f + l || c <= f + l))for (var m = -1; 1 >= m; m++)0 > g + m || c <= g + m || 0 == l && 0 == m || k != b.isDark(f + l, g + m) || h++;
            5 < h && (d += 3 + h - 5)
        }
        for (f = 0; f < c - 1; f++)for (g = 0; g < c - 1; g++)if (h = 0, b.isDark(f, g) && h++, b.isDark(f + 1, g) && h++, b.isDark(f,
                g + 1) && h++, b.isDark(f + 1, g + 1) && h++, 0 == h || 4 == h) d += 3;
        for (f = 0; f < c; f++)for (g = 0; g < c - 6; g++)b.isDark(f, g) && !b.isDark(f, g + 1) && b.isDark(f, g + 2) && b.isDark(f, g + 3) && b.isDark(f, g + 4) && !b.isDark(f, g + 5) && b.isDark(f, g + 6) && (d += 40);
        for (g = 0; g < c; g++)for (f = 0; f < c - 6; f++)b.isDark(f, g) && !b.isDark(f + 1, g) && b.isDark(f + 2, g) && b.isDark(f + 3, g) && b.isDark(f + 4, g) && !b.isDark(f + 5, g) && b.isDark(f + 6, g) && (d += 40);
        for (g = h = 0; g < c; g++)for (f = 0; f < c; f++)b.isDark(f, g) && h++;
        b = Math.abs(100 * h / c / c - 50) / 5;
        return d + 10 * b
    }
}, QRMath = {
    glog: function (b) {
        if (1 > b)throw Error("glog(" +
            b + ")");
        return QRMath.LOG_TABLE[b]
    }, gexp: function (b) {
        for (; 0 > b;)b += 255;
        for (; 256 <= b;)b -= 255;
        return QRMath.EXP_TABLE[b]
    }, EXP_TABLE: Array(256), LOG_TABLE: Array(256)
}, i = 0; 8 > i; i++)QRMath.EXP_TABLE[i] = 1 << i;
for (i = 8; 256 > i; i++)QRMath.EXP_TABLE[i] = QRMath.EXP_TABLE[i - 4] ^ QRMath.EXP_TABLE[i - 5] ^ QRMath.EXP_TABLE[i - 6] ^ QRMath.EXP_TABLE[i - 8];
for (i = 0; 255 > i; i++)QRMath.LOG_TABLE[QRMath.EXP_TABLE[i]] = i;
function QRPolynomial(b, c) {
    if (void 0 == b.length)throw Error(b.length + "/" + c);
    for (var d = 0; d < b.length && 0 == b[d];)d++;
    this.num = Array(b.length - d + c);
    for (var f = 0; f < b.length - d; f++)this.num[f] = b[f + d]
}
QRPolynomial.prototype = {
    get: function (b) {
        return this.num[b]
    }, getLength: function () {
        return this.num.length
    }, multiply: function (b) {
        for (var c = Array(this.getLength() + b.getLength() - 1), d = 0; d < this.getLength(); d++)for (var f = 0; f < b.getLength(); f++)c[d + f] ^= QRMath.gexp(QRMath.glog(this.get(d)) + QRMath.glog(b.get(f)));
        return new QRPolynomial(c, 0)
    }, mod: function (b) {
        if (0 > this.getLength() - b.getLength())return this;
        for (var c = QRMath.glog(this.get(0)) - QRMath.glog(b.get(0)), d = Array(this.getLength()), f = 0; f < this.getLength(); f++)d[f] =
            this.get(f);
        for (f = 0; f < b.getLength(); f++)d[f] ^= QRMath.gexp(QRMath.glog(b.get(f)) + c);
        return (new QRPolynomial(d, 0)).mod(b)
    }
};
function QRRSBlock(b, c) {
    this.totalCount = b;
    this.dataCount = c
}
QRRSBlock.RS_BLOCK_TABLE = [[1, 26, 19], [1, 26, 16], [1, 26, 13], [1, 26, 9], [1, 44, 34], [1, 44, 28], [1, 44, 22], [1, 44, 16], [1, 70, 55], [1, 70, 44], [2, 35, 17], [2, 35, 13], [1, 100, 80], [2, 50, 32], [2, 50, 24], [4, 25, 9], [1, 134, 108], [2, 67, 43], [2, 33, 15, 2, 34, 16], [2, 33, 11, 2, 34, 12], [2, 86, 68], [4, 43, 27], [4, 43, 19], [4, 43, 15], [2, 98, 78], [4, 49, 31], [2, 32, 14, 4, 33, 15], [4, 39, 13, 1, 40, 14], [2, 121, 97], [2, 60, 38, 2, 61, 39], [4, 40, 18, 2, 41, 19], [4, 40, 14, 2, 41, 15], [2, 146, 116], [3, 58, 36, 2, 59, 37], [4, 36, 16, 4, 37, 17], [4, 36, 12, 4, 37, 13], [2, 86, 68, 2, 87, 69], [4, 69, 43, 1, 70,
    44], [6, 43, 19, 2, 44, 20], [6, 43, 15, 2, 44, 16], [4, 101, 81], [1, 80, 50, 4, 81, 51], [4, 50, 22, 4, 51, 23], [3, 36, 12, 8, 37, 13], [2, 116, 92, 2, 117, 93], [6, 58, 36, 2, 59, 37], [4, 46, 20, 6, 47, 21], [7, 42, 14, 4, 43, 15], [4, 133, 107], [8, 59, 37, 1, 60, 38], [8, 44, 20, 4, 45, 21], [12, 33, 11, 4, 34, 12], [3, 145, 115, 1, 146, 116], [4, 64, 40, 5, 65, 41], [11, 36, 16, 5, 37, 17], [11, 36, 12, 5, 37, 13], [5, 109, 87, 1, 110, 88], [5, 65, 41, 5, 66, 42], [5, 54, 24, 7, 55, 25], [11, 36, 12], [5, 122, 98, 1, 123, 99], [7, 73, 45, 3, 74, 46], [15, 43, 19, 2, 44, 20], [3, 45, 15, 13, 46, 16], [1, 135, 107, 5, 136, 108], [10, 74, 46, 1,
    75, 47], [1, 50, 22, 15, 51, 23], [2, 42, 14, 17, 43, 15], [5, 150, 120, 1, 151, 121], [9, 69, 43, 4, 70, 44], [17, 50, 22, 1, 51, 23], [2, 42, 14, 19, 43, 15], [3, 141, 113, 4, 142, 114], [3, 70, 44, 11, 71, 45], [17, 47, 21, 4, 48, 22], [9, 39, 13, 16, 40, 14], [3, 135, 107, 5, 136, 108], [3, 67, 41, 13, 68, 42], [15, 54, 24, 5, 55, 25], [15, 43, 15, 10, 44, 16], [4, 144, 116, 4, 145, 117], [17, 68, 42], [17, 50, 22, 6, 51, 23], [19, 46, 16, 6, 47, 17], [2, 139, 111, 7, 140, 112], [17, 74, 46], [7, 54, 24, 16, 55, 25], [34, 37, 13], [4, 151, 121, 5, 152, 122], [4, 75, 47, 14, 76, 48], [11, 54, 24, 14, 55, 25], [16, 45, 15, 14, 46, 16], [6, 147,
    117, 4, 148, 118], [6, 73, 45, 14, 74, 46], [11, 54, 24, 16, 55, 25], [30, 46, 16, 2, 47, 17], [8, 132, 106, 4, 133, 107], [8, 75, 47, 13, 76, 48], [7, 54, 24, 22, 55, 25], [22, 45, 15, 13, 46, 16], [10, 142, 114, 2, 143, 115], [19, 74, 46, 4, 75, 47], [28, 50, 22, 6, 51, 23], [33, 46, 16, 4, 47, 17], [8, 152, 122, 4, 153, 123], [22, 73, 45, 3, 74, 46], [8, 53, 23, 26, 54, 24], [12, 45, 15, 28, 46, 16], [3, 147, 117, 10, 148, 118], [3, 73, 45, 23, 74, 46], [4, 54, 24, 31, 55, 25], [11, 45, 15, 31, 46, 16], [7, 146, 116, 7, 147, 117], [21, 73, 45, 7, 74, 46], [1, 53, 23, 37, 54, 24], [19, 45, 15, 26, 46, 16], [5, 145, 115, 10, 146, 116], [19,
    75, 47, 10, 76, 48], [15, 54, 24, 25, 55, 25], [23, 45, 15, 25, 46, 16], [13, 145, 115, 3, 146, 116], [2, 74, 46, 29, 75, 47], [42, 54, 24, 1, 55, 25], [23, 45, 15, 28, 46, 16], [17, 145, 115], [10, 74, 46, 23, 75, 47], [10, 54, 24, 35, 55, 25], [19, 45, 15, 35, 46, 16], [17, 145, 115, 1, 146, 116], [14, 74, 46, 21, 75, 47], [29, 54, 24, 19, 55, 25], [11, 45, 15, 46, 46, 16], [13, 145, 115, 6, 146, 116], [14, 74, 46, 23, 75, 47], [44, 54, 24, 7, 55, 25], [59, 46, 16, 1, 47, 17], [12, 151, 121, 7, 152, 122], [12, 75, 47, 26, 76, 48], [39, 54, 24, 14, 55, 25], [22, 45, 15, 41, 46, 16], [6, 151, 121, 14, 152, 122], [6, 75, 47, 34, 76, 48], [46,
    54, 24, 10, 55, 25], [2, 45, 15, 64, 46, 16], [17, 152, 122, 4, 153, 123], [29, 74, 46, 14, 75, 47], [49, 54, 24, 10, 55, 25], [24, 45, 15, 46, 46, 16], [4, 152, 122, 18, 153, 123], [13, 74, 46, 32, 75, 47], [48, 54, 24, 14, 55, 25], [42, 45, 15, 32, 46, 16], [20, 147, 117, 4, 148, 118], [40, 75, 47, 7, 76, 48], [43, 54, 24, 22, 55, 25], [10, 45, 15, 67, 46, 16], [19, 148, 118, 6, 149, 119], [18, 75, 47, 31, 76, 48], [34, 54, 24, 34, 55, 25], [20, 45, 15, 61, 46, 16]];
QRRSBlock.getRSBlocks = function (b, c) {
    var d = QRRSBlock.getRsBlockTable(b, c);
    if (void 0 == d)throw Error("bad rs block @ typeNumber:" + b + "/errorCorrectLevel:" + c);
    for (var f = d.length / 3, g = [], h = 0; h < f; h++)for (var k = d[3 * h + 0], l = d[3 * h + 1], m = d[3 * h + 2], n = 0; n < k; n++)g.push(new QRRSBlock(l, m));
    return g
};
QRRSBlock.getRsBlockTable = function (b, c) {
    switch (c) {
        case QRErrorCorrectLevel.L:
            return QRRSBlock.RS_BLOCK_TABLE[4 * (b - 1) + 0];
        case QRErrorCorrectLevel.M:
            return QRRSBlock.RS_BLOCK_TABLE[4 * (b - 1) + 1];
        case QRErrorCorrectLevel.Q:
            return QRRSBlock.RS_BLOCK_TABLE[4 * (b - 1) + 2];
        case QRErrorCorrectLevel.H:
            return QRRSBlock.RS_BLOCK_TABLE[4 * (b - 1) + 3]
    }
};
function QRBitBuffer() {
    this.buffer = [];
    this.length = 0
}
QRBitBuffer.prototype = {
    get: function (b) {
        return 1 == (this.buffer[Math.floor(b / 8)] >>> 7 - b % 8 & 1)
    }, put: function (b, c) {
        for (var d = 0; d < c; d++)this.putBit(1 == (b >>> c - d - 1 & 1))
    }, getLengthInBits: function () {
        return this.length
    }, putBit: function (b) {
        var c = Math.floor(this.length / 8);
        this.buffer.length <= c && this.buffer.push(0);
        b && (this.buffer[c] |= 128 >>> this.length % 8);
        this.length++
    }
};
(function (b) {
    b.fn.qrcode = function (c) {
        "string" === typeof c && (c = {text: c});
        c = b.extend({}, {
            render: "canvas",
            width: 256,
            height: 256,
            typeNumber: -1,
            correctLevel: QRErrorCorrectLevel.H,
            background: "#ffffff",
            foreground: "#000000"
        }, c);
        return this.each(function () {
            var d;
            if ("canvas" == c.render) {
                d = new QRCode(c.typeNumber, c.correctLevel);
                d.addData(c.text);
                d.make();
                var f = document.createElement("canvas");
                f.width = c.width;
                f.height = c.height;
                for (var g = f.getContext("2d"), h = c.width / d.getModuleCount(), k = c.height / d.getModuleCount(),
                         l = 0; l < d.getModuleCount(); l++)for (var m = 0; m < d.getModuleCount(); m++) {
                    g.fillStyle = d.isDark(l, m) ? c.foreground : c.background;
                    var n = Math.ceil((m + 1) * h) - Math.floor(m * h), p = Math.ceil((l + 1) * h) - Math.floor(l * h);
                    g.fillRect(Math.round(m * h), Math.round(l * k), n, p)
                }
            } else for (d = new QRCode(c.typeNumber, c.correctLevel), d.addData(c.text), d.make(), f = b("<table></table>").css("width", c.width + "px").css("height", c.height + "px").css("border", "0px").css("border-collapse", "collapse").css("background-color", c.background), g = c.width /
                d.getModuleCount(), h = c.height / d.getModuleCount(), k = 0; k < d.getModuleCount(); k++)for (l = b("<tr></tr>").css("height", h + "px").appendTo(f), m = 0; m < d.getModuleCount(); m++)b("<td></td>").css("width", g + "px").css("background-color", d.isDark(k, m) ? c.foreground : c.background).appendTo(l);
            d = f;
            jQuery(d).appendTo(this)
        })
    }
})(jQuery);
!function (b, c, d, f) {
    function g(b, c, d) {
        return Array.isArray(b) ? (h(b, d[c], d), !0) : !1
    }
    
    function h(b, c, d) {
        var g;
        if (b)if (b.forEach) b.forEach(c, d); else if (b.length !== f)for (g = 0; g < b.length;)c.call(d, b[g], g, b), g++; else for (g in b)b.hasOwnProperty(g) && c.call(d, b[g], g, b)
    }
    
    function k(c, d, f) {
        var g = "DEPRECATED METHOD: " + d + "\n" + f + " AT \n";
        return function () {
            var d = Error("get-stack-trace"), d = d && d.stack ? d.stack.replace(/^[^\(]+?[\n$]/gm, "").replace(/^\s+at\s+/gm, "").replace(/^Object.<anonymous>\s*\(/gm, "{anonymous}()@") :
                "Unknown Stack Trace", f = b.console && (b.console.warn || b.console.log);
            return f && f.call(b.console, g, d), c.apply(this, arguments)
        }
    }
    
    function l(b, c, d) {
        var f = c.prototype;
        c = b.prototype = Object.create(f);
        c.constructor = b;
        c._super = f;
        d && S(c, d)
    }
    
    function m(b, c) {
        return function () {
            return b.apply(c, arguments)
        }
    }
    
    function n(b, c) {
        return typeof b == Ma ? b.apply(c ? c[0] || f : f, c) : b
    }
    
    function p(b, c, d) {
        h(r(c), function (c) {
            "undefined" != typeof window.addEventListener ? b.addEventListener(c, d, !1) : b.attachEvent(c, d)
        })
    }
    
    function q(b, c, d) {
        h(r(c),
            function (c) {
                "undefined" != typeof window.removeEventListener ? b.removeEventListener(c, d, !1) : b.detachEvent(c, d)
            })
    }
    
    function t(b, c) {
        for (; b;) {
            if (b == c)return !0;
            b = b.parentNode
        }
        return !1
    }
    
    function r(b) {
        return b.trim().split(/\s+/g)
    }
    
    function s(b, c, d) {
        if (b.indexOf && !d)return b.indexOf(c);
        for (var f = 0; f < b.length;) {
            if (d && b[f][d] == c || !d && b[f] === c)return f;
            f++
        }
        return -1
    }
    
    function u(b) {
        return Array.prototype.slice.call(b, 0)
    }
    
    function v(b, c, d) {
        for (var f = [], g = [], h = 0; h < b.length;) {
            var k = c ? b[h][c] : b[h];
            0 > s(g, k) && f.push(b[h]);
            g[h] = k;
            h++
        }
        return d && (f = c ? f.sort(function (b, d) {
                return b[c] > d[c]
            }) : f.sort()), f
    }
    
    function w(b, c) {
        if (c && c[0]) {
            for (var d, g, h = c[0].toUpperCase() + c.slice(1), k = 0; k < za.length;) {
                if (d = za[k], g = d ? d + h : c, g in b)return g;
                k++
            }
            return f
        }
    }
    
    function y(c) {
        c = c.ownerDocument || c;
        return c.defaultView || c.parentWindow || b
    }
    
    function x(b, c) {
        var d = this;
        this.manager = b;
        this.callback = c;
        this.element = b.element;
        this.target = b.options.inputTarget;
        this.domHandler = function (c) {
            n(b.options.enable, [b]) && d.handler(c)
        };
        this.init()
    }
    
    function A(b) {
        var c =
            b.options.inputClass;
        return new (c ? c : Na ? I : Oa ? G : Aa ? J : D)(b, E)
    }
    
    function E(b, c, d) {
        var g = d.pointers.length, h = d.changedPointers.length, k = c & N && 0 === g - h, g = c & (L | O) && 0 === g - h;
        d.isFirst = !!k;
        d.isFinal = !!g;
        k && (b.session = {});
        d.eventType = c;
        c = b.session;
        k = d.pointers;
        g = k.length;
        c.firstInput || (c.firstInput = F(d));
        1 < g && !c.firstMultiple ? c.firstMultiple = F(d) : 1 === g && (c.firstMultiple = !1);
        var h = c.firstInput, l = (g = c.firstMultiple) ? g.center : h.center, m = d.center = z(k);
        d.timeStamp = sa();
        d.deltaTime = d.timeStamp - h.timeStamp;
        d.angle = K(l,
            m);
        d.distance = B(l, m);
        var h = d.center, l = c.offsetDelta || {}, m = c.prevDelta || {}, n = c.prevInput || {};
        d.eventType !== N && n.eventType !== L || (m = c.prevDelta = {
            x: n.deltaX || 0,
            y: n.deltaY || 0
        }, l = c.offsetDelta = {x: h.x, y: h.y});
        d.deltaX = m.x + (h.x - l.x);
        d.deltaY = m.y + (h.y - l.y);
        d.offsetDirection = C(d.deltaX, d.deltaY);
        h = d.deltaX / d.deltaTime || 0;
        l = d.deltaY / d.deltaTime || 0;
        d.overallVelocityX = h;
        d.overallVelocityY = l;
        d.overallVelocity = Y(h) > Y(l) ? h : l;
        d.scale = g ? B(k[0], k[1], ka) / B(g.pointers[0], g.pointers[1], ka) : 1;
        d.rotation = g ? K(k[1], k[0], ka) +
            K(g.pointers[1], g.pointers[0], ka) : 0;
        d.maxPointers = c.prevInput ? d.pointers.length > c.prevInput.maxPointers ? d.pointers.length : c.prevInput.maxPointers : d.pointers.length;
        l = c.lastInterval || d;
        k = d.timeStamp - l.timeStamp;
        d.eventType != O && (k > Pa || l.velocity === f) ? (h = d.deltaX - l.deltaX, l = d.deltaY - l.deltaY, m = h / k || 0, n = l / k || 0, k = m, g = n, m = Y(m) > Y(n) ? m : n, h = C(h, l), c.lastInterval = d) : (m = l.velocity, k = l.velocityX, g = l.velocityY, h = l.direction);
        d.velocity = m;
        d.velocityX = k;
        d.velocityY = g;
        d.direction = h;
        c = b.element;
        t(d.srcEvent.target,
            c) && (c = d.srcEvent.target);
        d.target = c;
        b.emit("hammer.input", d);
        b.recognize(d);
        b.session.prevInput = d
    }
    
    function F(b) {
        for (var c = [], d = 0; d < b.pointers.length;)c[d] = {
            clientX: ba(b.pointers[d].clientX),
            clientY: ba(b.pointers[d].clientY)
        }, d++;
        return {timeStamp: sa(), pointers: c, center: z(c), deltaX: b.deltaX, deltaY: b.deltaY}
    }
    
    function z(b) {
        var c = b.length;
        if (1 === c)return {x: ba(b[0].clientX), y: ba(b[0].clientY)};
        for (var d = 0, f = 0, g = 0; c > g;)d += b[g].clientX, f += b[g].clientY, g++;
        return {x: ba(d / c), y: ba(f / c)}
    }
    
    function C(b, c) {
        return b ===
        c ? la : Y(b) >= Y(c) ? 0 > b ? ea : fa : 0 > c ? ga : ha
    }
    
    function B(b, c, d) {
        d || (d = Ba);
        var f = c[d[0]] - b[d[0]];
        b = c[d[1]] - b[d[1]];
        return Math.sqrt(f * f + b * b)
    }
    
    function K(b, c, d) {
        d || (d = Ba);
        return 180 * Math.atan2(c[d[1]] - b[d[1]], c[d[0]] - b[d[0]]) / Math.PI
    }
    
    function D() {
        this.evEl = Qa;
        this.evWin = Ra;
        this.pressed = !1;
        x.apply(this, arguments)
    }
    
    function I() {
        this.evEl = Ca;
        this.evWin = Da;
        x.apply(this, arguments);
        this.store = this.manager.session.pointerEvents = []
    }
    
    function H() {
        this.evTarget = Sa;
        this.evWin = Ta;
        this.started = !1;
        x.apply(this, arguments)
    }
    
    function G() {
        this.evTarget =
            Ua;
        this.targetIds = {};
        x.apply(this, arguments)
    }
    
    function M(b, c) {
        var d = u(b.touches), f = this.targetIds;
        if (c & (N | Z) && 1 === d.length)return f[d[0].identifier] = !0, [d, d];
        var g, h = u(b.changedTouches), k = [], l = this.target;
        if (g = d.filter(function (b) {
                return t(b.target, l)
            }), c === N)for (d = 0; d < g.length;)f[g[d].identifier] = !0, d++;
        for (d = 0; d < h.length;)f[h[d].identifier] && k.push(h[d]), c & (L | O) && delete f[h[d].identifier], d++;
        return k.length ? [v(g.concat(k), "identifier", !0), k] : void 0
    }
    
    function J() {
        x.apply(this, arguments);
        var b = m(this.handler,
            this);
        this.touch = new G(this.manager, b);
        this.mouse = new D(this.manager, b);
        this.primaryTouch = null;
        this.lastTouches = []
    }
    
    function ia(b) {
        b = b.changedPointers[0];
        if (b.identifier === this.primaryTouch) {
            var c = {x: b.clientX, y: b.clientY};
            this.lastTouches.push(c);
            var d = this.lastTouches;
            setTimeout(function () {
                var b = d.indexOf(c);
                -1 < b && d.splice(b, 1)
            }, Va)
        }
    }
    
    function W(b, c) {
        this.manager = b;
        this.set(c)
    }
    
    function Wa(b) {
        if (-1 < b.indexOf(ca))return ca;
        var c = -1 < b.indexOf(ma), d = -1 < b.indexOf(na);
        return c && d ? ca : c || d ? c ? ma : na : -1 < b.indexOf(ta) ?
                    ta : Ea
    }
    
    function T(b) {
        this.options = S({}, this.defaults, b || {});
        this.id = Xa++;
        this.manager = null;
        this.options.enable = this.options.enable === f ? !0 : this.options.enable;
        this.state = oa;
        this.simultaneous = {};
        this.requireFail = []
    }
    
    function Fa(b) {
        return b & ja ? "cancel" : b & X ? "end" : b & da ? "move" : b & P ? "start" : ""
    }
    
    function Ga(b) {
        return b == ha ? "down" : b == ga ? "up" : b == ea ? "left" : b == fa ? "right" : ""
    }
    
    function pa(b, c) {
        var d = c.manager;
        return d ? d.get(b) : b
    }
    
    function Q() {
        T.apply(this, arguments)
    }
    
    function qa() {
        Q.apply(this, arguments);
        this.pY = this.pX =
            null
    }
    
    function ua() {
        Q.apply(this, arguments)
    }
    
    function va() {
        T.apply(this, arguments);
        this._input = this._timer = null
    }
    
    function wa() {
        Q.apply(this, arguments)
    }
    
    function xa() {
        Q.apply(this, arguments)
    }
    
    function ra() {
        T.apply(this, arguments);
        this.pCenter = this.pTime = !1;
        this._input = this._timer = null;
        this.count = 0
    }
    
    function U(b, c) {
        return c = c || {}, c.recognizers = c.recognizers === f ? U.defaults.preset : c.recognizers, new ya(b, c)
    }
    
    function ya(b, c) {
        this.options = S({}, U.defaults, c || {});
        this.options.inputTarget = this.options.inputTarget ||
            b;
        this.handlers = {};
        this.session = {};
        this.recognizers = [];
        this.element = b;
        this.input = A(this);
        this.touchAction = new W(this, this.options.touchAction);
        Ha(this, !0);
        h(this.options.recognizers, function (b) {
            var c = this.add(new b[0](b[1]));
            b[2] && c.recognizeWith(b[2]);
            b[3] && c.requireFailure(b[3])
        }, this)
    }
    
    function Ha(b, c) {
        var d = b.element;
        d.style && h(b.options.cssProps, function (b, f) {
            d.style[w(d.style, f)] = c ? b : ""
        })
    }
    
    function Ya(b, d) {
        var f = c.createEvent("Event");
        f.initEvent(b, !0, !0);
        f.gesture = d;
        d.target.dispatchEvent(f)
    }
    
    var S, za = " webkit Moz MS ms o".split(" "), Za = c.createElement("div"), Ma = "function", ba = Math.round, Y = Math.abs, sa = Date.now;
    S = "function" != typeof Object.assign ? function (b) {
            if (b === f || null === b)throw new TypeError("Cannot convert undefined or null to object");
            for (var c = Object(b), d = 1; d < arguments.length; d++) {
                var g = arguments[d];
                if (g !== f && null !== g)for (var h in g)g.hasOwnProperty(h) && (c[h] = g[h])
            }
            return c
        } : Object.assign;
    var Ia = k(function (b, c, d) {
        for (var g = Object.keys(c), h = 0; h < g.length;)(!d || d && b[g[h]] === f) && (b[g[h]] =
            c[g[h]]), h++;
        return b
    }, "extend", "Use `assign`."), $a = k(function (b, c) {
        return Ia(b, c, !0)
    }, "merge", "Use `assign`."), Xa = 1, ab = /mobile|tablet|ip(ad|hone|od)|android/i, Aa = "ontouchstart" in b, Na = w(b, "PointerEvent") !== f, Oa = Aa && ab.test(navigator.userAgent), Pa = 25, N = 1, Z = 2, L = 4, O = 8, la = 1, ea = 2, fa = 4, ga = 8, ha = 16, R = ea | fa, aa = ga | ha, Ja = R | aa, Ba = ["x", "y"], ka = ["clientX", "clientY"];
    x.prototype = {
        handler: function () {
        }, init: function () {
            this.evEl && p(this.element, this.evEl, this.domHandler);
            this.evTarget && p(this.target, this.evTarget,
                this.domHandler);
            this.evWin && p(y(this.element), this.evWin, this.domHandler)
        }, destroy: function () {
            this.evEl && q(this.element, this.evEl, this.domHandler);
            this.evTarget && q(this.target, this.evTarget, this.domHandler);
            this.evWin && q(y(this.element), this.evWin, this.domHandler)
        }
    };
    var bb = {mousedown: N, mousemove: Z, mouseup: L}, Qa = "mousedown", Ra = "mousemove mouseup";
    l(D, x, {
        handler: function (b) {
            var c = bb[b.type];
            c & N && 0 === b.button && (this.pressed = !0);
            c & Z && 1 !== b.which && (c = L);
            this.pressed && (c & L && (this.pressed = !1), this.callback(this.manager,
                c, {pointers: [b], changedPointers: [b], pointerType: "mouse", srcEvent: b}))
        }
    });
    var cb = {pointerdown: N, pointermove: Z, pointerup: L, pointercancel: O, pointerout: O}, db = {
        2: "touch",
        3: "pen",
        4: "mouse",
        5: "kinect"
    }, Ca = "pointerdown", Da = "pointermove pointerup pointercancel";
    b.MSPointerEvent && !b.PointerEvent && (Ca = "MSPointerDown", Da = "MSPointerMove MSPointerUp MSPointerCancel");
    l(I, x, {
        handler: function (b) {
            var c = this.store, d = !1, f = b.type.toLowerCase().replace("ms", ""), f = cb[f], g = db[b.pointerType] || b.pointerType, h = "touch" == g,
                k = s(c, b.pointerId, "pointerId");
            f & N && (0 === b.button || h) ? 0 > k && (c.push(b), k = c.length - 1) : f & (L | O) && (d = !0);
            0 > k || (c[k] = b, this.callback(this.manager, f, {
                pointers: c,
                changedPointers: [b],
                pointerType: g,
                srcEvent: b
            }), d && c.splice(k, 1))
        }
    });
    var eb = {
        touchstart: N,
        touchmove: Z,
        touchend: L,
        touchcancel: O
    }, Sa = "touchstart", Ta = "touchstart touchmove touchend touchcancel";
    l(H, x, {
        handler: function (b) {
            var c = eb[b.type];
            if (c === N && (this.started = !0), this.started) {
                var d, f = u(b.touches);
                d = u(b.changedTouches);
                d = (c & (L | O) && (f = v(f.concat(d),
                    "identifier", !0)), [f, d]);
                c & (L | O) && 0 === d[0].length - d[1].length && (this.started = !1);
                this.callback(this.manager, c, {
                    pointers: d[0],
                    changedPointers: d[1],
                    pointerType: "touch",
                    srcEvent: b
                })
            }
        }
    });
    var fb = {
        touchstart: N,
        touchmove: Z,
        touchend: L,
        touchcancel: O
    }, Ua = "touchstart touchmove touchend touchcancel";
    l(G, x, {
        handler: function (b) {
            var c = fb[b.type], d = M.call(this, b, c);
            d && this.callback(this.manager, c, {
                pointers: d[0],
                changedPointers: d[1],
                pointerType: "touch",
                srcEvent: b
            })
        }
    });
    var Va = 2500;
    l(J, x, {
        handler: function (b, c, d) {
            var f =
                "touch" == d.pointerType, g = "mouse" == d.pointerType;
            if (!(g && d.sourceCapabilities && d.sourceCapabilities.firesTouchEvents)) {
                if (f) c & N ? (this.primaryTouch = d.changedPointers[0].identifier, ia.call(this, d)) : c & (L | O) && ia.call(this, d); else {
                    if (f = g)a:{
                        for (var f = d.srcEvent.clientX, g = d.srcEvent.clientY, h = 0; h < this.lastTouches.length; h++) {
                            var k = this.lastTouches[h], l = Math.abs(f - k.x), k = Math.abs(g - k.y);
                            if (25 >= l && 25 >= k) {
                                f = !0;
                                break a
                            }
                        }
                        f = !1
                    }
                    if (f)return
                }
                this.callback(b, c, d)
            }
        }, destroy: function () {
            this.touch.destroy();
            this.mouse.destroy()
        }
    });
    var Ka = w(Za.style, "touchAction"), La = Ka !== f, Ea = "auto", ta = "manipulation", ca = "none", ma = "pan-x", na = "pan-y";
    W.prototype = {
        set: function (b) {
            "compute" == b && (b = this.compute());
            La && this.manager.element.style && (this.manager.element.style[Ka] = b);
            this.actions = b.toLowerCase().trim()
        }, update: function () {
            this.set(this.manager.options.touchAction)
        }, compute: function () {
            var b = [];
            return h(this.manager.recognizers, function (c) {
                n(c.options.enable, [c]) && (b = b.concat(c.getTouchAction()))
            }), Wa(b.join(" "))
        }, preventDefaults: function (b) {
            if (!La) {
                var c =
                    b.src