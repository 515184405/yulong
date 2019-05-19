                </div>
            </div>
        </div>
        <div class="wap-list-nav none">
            <a href="/"><i class="iconfont">&#xe603;</i>首页</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'case')!==false ? 'active' : ''?>" href="/case"><i class="iconfont">&#xe64a;</i>案例</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'unit')!==false ? 'active' : ''?>" href="/unit"><i class="iconfont">&#xe617;</i>组件</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'news')!==false ? 'active' : ''?>" href="/news"><i class="iconfont">&#xe681;</i>文章</a>
        </div>
        <?=$this->render('./public-footer'); ?>
        <script>
            $(".list-header,.list-content,.list-aslide").addClass('list-layout-animated');
            //左侧导航关闭
            $('.aslide-switch').bind('click',function(){
                if($(window).width() <= 1004) return;
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $('.list-aslide,.list-container').removeClass('active');
                }else{
                    $(this).addClass('active');
                    $('.list-aslide,.list-container').addClass('active');
                }

                //案例列表动画改编
                setTimeout(function(){
                    !!addAnimateDelay && typeof(addAnimateDelay) == 'function' && addAnimateDelay();
                    $('.list-container').scroll();
                },300)
            })


            //首页增加滚动动画
            function addScrollAnimate(){
                $(".animated").each(function(){
                    var pos = $(this).offset().top;
                    var animatedType = $(this).attr('animate-type');
                    var winHeight = $(window).height();
                    var winTop = $(window).scrollTop();
                    if (pos < winTop + winHeight) {
                        $(this).addClass(animatedType);
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