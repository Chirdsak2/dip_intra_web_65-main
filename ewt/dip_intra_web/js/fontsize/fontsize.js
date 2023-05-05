

$(window).resize(function() {	
	var width = $(window).width();	  
	if(width < 1200)
	{
		$("body").find("*").css('font-size', '');
		//$('body').removeAttr("style");
		//alert('Your screen is too small');
	}
});
		
(function ($) {
	
    function FontSize(dom, options) {
		
		
        var defaultSettings = {
            step: 2,
            increaseTimes: 2, 
            reduceTimes: 2, 
            increaseBtn: '.zoomin',
            reduceBtn: '.zoomout'		
        };
		 
        this.settings = $.extend({}, defaultSettings, options);
        this.container = dom;
		//console.log(this.container);
        this.noFontTags = ['svg', 'IMG', 'use', 'BR', 'VIDEO', 'AUDIO', 'STYLE', 'SCRIPT'];
        this._init();
        this.$increaseBtn = $(this.settings.increaseBtn);
        this.$reduceBtn = $(this.settings.reduceBtn);

        var that = this;
        this.$increaseBtn.on('click', function () {
            if (that.fontIncrease() === false) {
                that.$increaseBtn.addClass('disable');
            }
            that.$reduceBtn.removeClass('disable');
        });

        this.$reduceBtn.on('click', function () {
            if (that.fontReduce() === false) {
                that.$reduceBtn.addClass('disable');
            }
            that.$increaseBtn.removeClass('disable');
        });

    }

    // font-size
    FontSize.prototype._init = function () {
        this._loopNode(this.container, function () {
            $(this).css('font-size', '');
        });
		
		//screen.width 
        this.zoom = 0;
        this.maxZoom = this.settings.step * this.settings.increaseTimes;
        this.minZoom = -this.settings.step * this.settings.reduceTimes;
    };

    // 
    FontSize.prototype._loopNode = function (node, fn) {
        var type = node.nodeType,
            childNodes,
            noFontTags = this.noFontTags;

        // 
        if (type === 1) {
            childNodes = node.childNodes;
            if (noFontTags.indexOf(node.nodeName) === -1) {
                fn && fn.call(node);
            }

            for (var i = 0, l = childNodes.length; i < l; i++) {
                this._loopNode(childNodes[i], fn);
            }
        }
    };

    //
    FontSize.prototype.fontIncrease = function (step) {
        step = step ? step : this.settings.step;

        if (this.zoom >= this.maxZoom) {
            return false;
        }
        if (this.zoom + step > this.maxZoom) {
            step = this.maxZoom - this.zoom;
        }
        this._loopNode(this.container, function () {
            $(this).css('font-size', $(this).css('font-size').slice(0, -2) - 0 + step + 'px');
        });
        this.zoom += step;
    };

    //
    FontSize.prototype.fontReduce = function (step) {
        step = step ? step : this.settings.step;

        if (this.zoom <= this.minZoom) {
            return false;
        }
        if (this.zoom - step < this.minZoom) {
            step = Math.abs(this.zoom - this.minZoom);
        }
        this._loopNode(this.container, function () {
            $(this).css('font-size', $(this).css('font-size').slice(0, -2) - 0 - step + 'px');
        });
        this.zoom -= step;
    };

    // 
    FontSize.prototype.clearZoom = function () {
        var zoom = this.zoom;
        console.log(this.zoom);
        this._loopNode(this.container, function () {
            $(this).css('font-size', $(this).css('font-size').slice(0, -2) - 0 - zoom + 'px');
        });
        this.zoom = 0;
    };

    $.fn.FontSize = function (options, param) {
        if (typeof options == 'string') {
            var method = $.fn.FontSize.methods[options];
            if (method) {
                return method(this, param);
            }
        }
        return this.each(function () {
            if (!$.data(this, 'FontSize')) {
                $.data(this, 'FontSize', new FontSize(this, options));
            }
        });
    };

    $.fn.FontSize.methods = {
        fontIncrease: function (jq, step) {
            return jq.each(function () {
                $.data(this, 'FontSize').fontIncrease(step);
            });
        },
        fontReduce: function (jq, step) {
            return jq.each(function () {
                $.data(this, 'FontSize').fontReduce(step);
            });
        },
        clearZoom: function (jq) {
            return jq.each(function () {
                $.data(this, 'FontSize').clearZoom();
            });
        }
    };

})(jQuery);
