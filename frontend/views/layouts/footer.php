<!--尾部-->
<footer class="footer">
    <div class="fy-container">
        <p class="footer-link">
            <a href="#">关于我们</a> |
            <a href="#">服务项目</a> |
            <a href="#">网站案例</a> |
            <a href="#">建站常识</a> |
            <a href="#">常见问题</a> |
            <a href="#">联系方式</a>
        </p>
        <p class="footer-msg">
            <span>Copyright 2008-2019 西安凡高网络科技有限公司 ALL Rights Reserved. 陕西·西安高新区唐延路25号银河产业园3单元24层</span>
            <span class="margin-left:30px;">工信部备案号：陕ICP备14002553号</span>
        </p>
    </div>
</footer>
<!--尾部-->

</div>
<script>
    //导航固定动画
    var navAnimate = function(){
        $(window).scroll(function(e){
            var scrollTop = $(window).scrollTop();
            if(scrollTop >= 600){
                $('#header').addClass('active fadeInDown');
            }else{
                $('#header').removeClass('active fadeInDown');
            }
        })
    };
    navAnimate();
</script>
</body>
</html>