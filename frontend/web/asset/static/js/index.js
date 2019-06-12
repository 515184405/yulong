// window.requestAnimFrame 做兼容
(function () {
    var lastTime = 0;
    var vendors = ['webkit', 'moz'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] ||    // Webkit中此取消方法的名字变了
            window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function (callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
            var id = window.setTimeout(function () {
                callback(currTime + timeToCall);
            }, timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }
    if (!window.cancelAnimationFrame) {
        window.cancelAnimationFrame = function (id) {
            clearTimeout(id);
        };
    }
}());


// 逻辑处理对象
var M = {

    //初始化
    init: function () {
        //执行首屏canvas背景
        M.canvasFun();
        //更改屏幕尺寸事件
        window.onresize = function () {
            M.canvasFun();
        }
        //轮播图调用
        M.swiperFun();
        //首页增加滚动动画
        M.scrollFun();
    },
    //首页增加滚动动画
    scrollFun: function () {
        $(window).scroll(function () {
            $(".animated").each(function () {
                var pos = $(this).offset().top;
                var animatedType = $(this).attr('animate-type');
                var winHeight = $(window).height();
                var winTop = $(window).scrollTop();
                if (pos < winTop + winHeight) {
                    $(this).addClass(animatedType);
                    if (M.isIE()) {
                        $(this).css('opacity', 1);
                    }
                }
            });
        });

        $(window).scroll();
    },
    // 首页banner背景
    canvasFun: function () {
        var canvas = document.getElementById('canvas'),
            ctx = canvas.getContext('2d'),
            w = canvas.width = window.innerWidth,
            height = 200;
        if ($(window).width() > 768) {
            height = 600;
        }
        var h = canvas.height = height;

        hue = 217,
            stars = [],
            count = 0,
            maxStars = 1200;

        var canvas2 = document.createElement('canvas'),
            ctx2 = canvas2.getContext('2d');
        canvas2.width = 100;
        canvas2.height = 100;
        var half = canvas2.width / 2,
            gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
        gradient2.addColorStop(0.025, '#fff');
        gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
        gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
        gradient2.addColorStop(1, 'transparent');

        ctx2.fillStyle = gradient2;
        ctx2.beginPath();
        ctx2.arc(half, half, half, 0, Math.PI * 2);
        ctx2.fill();

        // End cache
        function random(min, max) {
            if (arguments.length < 2) {
                max = min;
                min = 0;
            }

            if (min > max) {
                var hold = max;
                max = min;
                min = hold;
            }

            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function maxOrbit(x, y) {
            var max = Math.max(x, y),
                diameter = Math.round(Math.sqrt(max * max + max * max));
            return diameter / 2;
        }

        var Star = function () {

            this.orbitRadius = random(maxOrbit(w, h));
            this.radius = random(60, this.orbitRadius) / 12;
            this.orbitX = w / 2;
            this.orbitY = h / 2;
            this.timePassed = random(0, maxStars);
            this.speed = random(this.orbitRadius) / 900000;
            this.alpha = random(2, 10) / 10;

            count++;
            stars[count] = this;
        }

        Star.prototype.draw = function () {
            var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
                y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
                twinkle = random(10);

            if (twinkle === 1 && this.alpha > 0) {
                this.alpha -= 0.05;
            } else if (twinkle === 2 && this.alpha < 1) {
                this.alpha += 0.05;
            }

            ctx.globalAlpha = this.alpha;
            ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
            this.timePassed += this.speed;
        }

        for (var i = 0; i < maxStars; i++) {
            new Star();
        }

        function animation() {
            ctx.globalCompositeOperation = 'source-over';
            ctx.globalAlpha = 0.8;
            ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 1)';
            ctx.fillRect(0, 0, w, h)

            ctx.globalCompositeOperation = 'lighter';
            for (var i = 1, l = stars.length; i < l; i++) {
                stars[i].draw();
            }
            ;

            window.requestAnimationFrame(animation);
        }

        animation();
    },
    //判断是否为ie浏览器
    isIE: function () {
        if (!!window.ActiveXObject || "ActiveXObject" in window) {
            return true;
        }
        else {
            return false;
        }
    },
    //轮播图逻辑处理
    swiperFun: function () {
        var oPlay = document.getElementById('play');
        var aLi = oPlay.getElementsByTagName('li');
        var oButton = document.getElementById('button');
        var aDiv = oButton.getElementsByTagName('div');
        var oPrev = document.getElementById('prev');
        var oNext = document.getElementById('next');
        var oFlash = document.getElementById('ie-swiper');
        var now = 0;
        var timer2 = null;
        for (var i = 0; i < aDiv.length; i++) {
            aDiv[i].index = i;
            aDiv[i].onmouseover = function () {
                if (now == this.index) return;
                now = this.index;
                tab();
            }
        }
        oPrev.onclick = function () {
            now--;
            if (now == -1) {
                now = aDiv.length - 1;
            }
            tab();
        }
        oNext.onclick = function () {
            now++;
            if (now == aDiv.length) {
                now = 0;
            }
            tab();
        }
        oFlash.onmouseover = function () {
            clearInterval(timer2);
        }
        oFlash.onmouseout = function () {
            timer2 = setInterval(oNext.onclick, 4000);
        }
        timer2 = setInterval(oNext.onclick, 5000);

        function tab() {
            for (var i = 0; i < aLi.length; i++) {
                aLi[i].style.display = 'none';
            }
            for (var i = 0; i < aDiv.length; i++) {
                aDiv[i].style.background = "#DDDDDD";
            }
            aDiv[now].style.background = '#A10000';
            aLi[now].style.display = 'block';
            aLi[now].style.opacity = 0;
            aLi[now].style.filter = "alpha(opacity=0)";
            jianbian(aLi[now]);
        }

        function jianbian(obj) {
            var alpha = 0;
            clearInterval(timer);
            var timer = setInterval(function () {
                alpha++;
                obj.style.opacity = alpha / 100;
                obj.style.filter = "alpha(opacity=" + alpha + ")";
                if (alpha == 100) {
                    clearInterval(timer);
                }
            }, 10);
        };
    },
}

M.init();