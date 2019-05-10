                </div>
            </div>
        </div>
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

            })
            //首页增加滚动动画
            var scrollFun = function(){
                $('.list-container').scroll(function() {
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

                $('.list-container').scroll();
            };
            scrollFun();
        </script>
    </body>
</html>