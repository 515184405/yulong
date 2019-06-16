                </div>
            </div>
        </div>
        <?=$this->render('./public-footer'); ?>
        <script>
            function IElt10(){
                var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
                var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器
                if(isIE) {
                    var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
                    reIE.test(userAgent);
                    var fIEVersion = parseFloat(RegExp["$1"]);
                    if(fIEVersion < 10) {
                        return true;
                    }
                    return false;
                }
                return false;
            }
            $(".list-header,.list-content,.list-aslide").addClass('list-layout-animated');
            //左侧导航关闭
            $('.aslide-switch').bind('click',function(){
                //if($(window).width() <= 1004) return;
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $('.list-aslide,.list-container').removeClass('active');
                }else{
                    $(this).addClass('active');
                    $('.list-aslide,.list-container').addClass('active');
                }

                //案例列表动画改编
                setTimeout(function(){
                    typeof(addAnimateDelay) !== 'undefined' && typeof(addAnimateDelay) == 'function' && addAnimateDelay();
                    $('.list-container').scroll();
                },300)
            });

        $(window).resize(function(){
            var winW = $(window).width();
            if($(window).width() < 1100){
                if(!$('.aslide-switch').hasClass('active')){
                    $('.aslide-switch').trigger('click');
                }
            }else{
                if($('.aslide-switch').hasClass('active')){
                    $('.aslide-switch').trigger('click');
                }
            };
        });
        $(window).resize();


            //增加滚动动画
            function addScrollAnimate(){
                $(".animated").each(function(){
                    var pos = $(this).offset().top;
                    var animatedType = $(this).attr('animate-type');
                    var winHeight = $(window).height();
                    var winTop = $(window).scrollTop();
                    if (pos < winTop + winHeight) {
                        $(this).addClass(animatedType);
                        //兼容ie10及以下
                        if(IElt10()){
                            $(this).css('opacity',1);
                        }
                    }
                });
            };

            var scrollFun = function(){
                $('.list-container').scroll(function() {
                    addScrollAnimate();
                });
                $('.list-container').scroll();
            };
            scrollFun();
        </script>
    </body>
</html>