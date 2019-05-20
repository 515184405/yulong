
// window.requestAnimFrame 做兼容
(function() {
    var lastTime = 0;
    var vendors = ['webkit', 'moz'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] ||    // Webkit中此取消方法的名字变了
            window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
            var id = window.setTimeout(function() {
                callback(currTime + timeToCall);
            }, timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }
    if (!window.cancelAnimationFrame) {
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }
}());


// 逻辑处理对象
var M = {

    //初始化
    init:function(){
        //执行首屏canvas背景
        M.canvasFun();
        //更改屏幕尺寸事件
        window.onresize = function(){
            M.canvasFun();
        }
        //轮播图调用
        M.swiperFun();
        //首页增加滚动动画
        M.scrollFun();
    },
    //首页增加滚动动画
    scrollFun:function(){
        $(window).scroll(function() {
            $(".animated").each(function(){
                var pos = $(this).offset().top;
                var animatedType = $(this).attr('animate-type');
                var winHeight = $(window).height();
                var winTop = $(window).scrollTop();
                if (pos < winTop + winHeight) {
                    $(this).addClass(animatedType);
                }
            });
        });

        $(window).scroll();
    },
    // 首页banner背景
    canvasFun:function(){
        var canvas = document.getElementById('canvas'),
            ctx = canvas.getContext('2d'),
            w = canvas.width = window.innerWidth,
            height = 200;
            if($(window).width() > 768){
                height=600;
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

        var Star = function() {

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

        Star.prototype.draw = function() {
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
            };

            window.requestAnimationFrame(animation);
        }

        animation();
    },
    //判断是否为ie浏览器
    isIE:function(){
        if (!!window.ActiveXObject || "ActiveXObject" in window)
        { return true; }
        else
        { return false; }
    },
    //轮播图逻辑处理
    swiperFun:function(){
        if(M.isIE()) {
            $("#ie-swiper").show();
            var swiper = new Swiper('#ie-swiper', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                loop:true,
                autoplay:{
                    delay:3000
                },
                speed:500
            });
            return false;
        };
        $("#IE_false").show();
        lock = false;
        bgColor = ["rgb(179, 189, 196)","rgb(180, 183, 166)","rgb(140, 152, 187)"]; //背景色
        var mySwiper = new Swiper('#IE_false',{
            speed: 800,
            parallax : true,  //文字位移视差
            autoplay:{
                delay:5000
            },
            on:{
                transitionStart: function(){
                    lock = true;//锁住按钮
                    slides = this.slides
                    imgBox = slides.eq(this.previousIndex).find('.img-box') //图片包装器
                    imgPrev = slides.eq(this.previousIndex).find('img')  //当前图片
                    imgActive = slides.eq(this.activeIndex).find('img')  //下一张图片
                    derection = this.activeIndex-this.previousIndex
                    //this.$el.css("background-color",bgColor[this.activeIndex]);//背景颜色动画

                    imgBox.transform('matrix(0.6, 0, 0, 0.6, 0, 0)');
                    imgPrev.transition(1000).transform('matrix(1.2, 0, 0, 1.2, 0, 0)');//图片缩放视差
                    this.slides.eq(this.previousIndex).find('h3').transition(1000).css('color','rgba(255,255,255,0)');//文字透明动画
                    this.slides.eq(this.previousIndex).find('h3').transition(1000).css('color','rgba(255,255,255,0)');//文字透明动画

                    imgPrev.transitionEnd(function () {
                        imgActive.transition(300).transform('translate3d(0, 0, 0) matrix(1.2, 0, 0, 1.2, 0, 0)');//图片位移视差
                        imgPrev.transition(300).transform('translate3d('+200*derection+'%, 0, 0)  matrix(1.2, 0, 0, 1.2, 0, 0)');
                    });
                },
                transitionEnd: function(){
                    this.slides.eq(this.activeIndex).find('.img-box').transform(' matrix(1, 0, 0, 1, 0, 0)');
                    imgActive = this.slides.eq(this.activeIndex).find('img')
                    imgActive.transition(1000).transform(' matrix(1, 0, 0, 1, 0, 0)');
                    this.slides.eq(this.activeIndex).find('h3').transition(1000).css('color','rgba(255,255,255,1)');

                    imgActive.transitionEnd(function () {
                        lock = false
                    });
                    //第一个和最后一个，禁止按钮
                    if(this.activeIndex == 0){
                        this.$el.find('.button-prev').addClass('disabled');
                    }else{
                        this.$el.find('.button-prev').removeClass('disabled');
                    }

                    if(this.activeIndex == this.slides.length - 1){
                        this.$el.find('.button-next').addClass('disabled');
                    }else{
                        this.$el.find('.button-next').removeClass('disabled');
                    }
                },
                init:function(){
                    this.emit('transitionEnd');//在初始化时触发一次transitionEnd事件
                },

            }
        });
        //不使用自带的按钮组件，使用lock控制按钮锁定时间
        mySwiper.$el.find('.button-next').on('click',function(){
            if(!lock){
                mySwiper.slideNext();
            }
        })
        mySwiper.$el.find('.button-prev').on('click',function(){
            if(!lock){
                mySwiper.slidePrev();
            }
        })
    },
}

M.init();