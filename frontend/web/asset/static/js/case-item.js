    var arrTop = [];
    var keyDirection = 0; //判断是向上滚动还是向下滚动要素
    var keyDirection2 = 0; //判断是向上滚动还是向下滚动要素2
    $('.list-container').scroll(function () {
        var scrollTop = $('.list-container').scrollTop();
        var offsetTop = $('.js_case_list')[0].offsetTop;
        if (scrollTop >= offsetTop || (scrollTop + $(window).height()) > $('.list-content')[0].clientHeight) {
            if ($('.js_list_box').attr('data-show') != 1) {
                $.each($('.js_list_box').find('img'), function (key, elem) {
                    $(elem).attr('src', $(elem).attr('data-src'));
                    elem.onload = function () {
                        arrTop.push(elem.offsetTop);
                        console.log(arrTop);
                        arrTop.sort(function (a, b) {
                            return a > b;
                        });
                    }
                });
                $('.sn-count').html($('.js_list_box').find('img').length);
                $('.js_list_box').attr('data-show', 1);
            }
            $('.js_list_box').addClass('add-animated');
            $('.swipper-number,.scale_box').show();
            $('#picScroll').addClass('active')
            $('.js_list_box').scrollTop(21);
        } else {
            $('.js_list_box').removeClass('add-animated');
            $('.swipper-number,.scale_box').hide();
            $('#picScroll').removeClass('active')
        };
        computerScale();
    })

    //打开查看图片后的滚动事件 查看当前看到第几张
    $('.js_list_box').scroll(function () {
        var scrollTop = $('.js_list_box').scrollTop();
        var offsetTop = $('.js_case_list')[0].offsetTop;
        if(scrollTop < 20){
            $('.js_list_box').removeClass('add-animated');
            $('.swipper-number,.scale_box').hide();
            $('#picScroll').removeClass('active')
            $('.list-container').scrollTop(offsetTop-1);
        }
        for (var i = 0, len = arrTop.length; i < len; i++) {
            if ((arrTop[i] <= scrollTop && arrTop[i + 1] > scrollTop) || (scrollTop) >= arrTop[len - 1]) {
                $('.sn-current').html(i + 1);
                if( $('#picScroll').find('.pic').eq(i).hasClass('active')){
                    return;
                }
                $('#picScroll').find('.pic').removeClass('active');
                $('#picScroll').find('.pic').eq(i).addClass('active');
                if(keyDirection2 > i){
                    var type = 2;
                }else{
                    var type = 1;
                }
                keyDirection2 = i;
                currentImageView(type);
            }
        }
    })

    //关闭事件
    $('.js_swipper_close').bind('click',function(){
        var offsetTop = $('.js_case_list')[0].offsetTop;
        $('.js_list_box').removeClass('add-animated');
        $('.swipper-number,.scale_box').hide();
        $('#picScroll').removeClass('active')
        $('.list-container').scrollTop(offsetTop-1);
    })

    //轮播
    jQuery(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:false,pnLoop:false,vis:3,prevCell:'.picScroll-prev',nextCell:'.picScroll-next'});

    imageOffsetTop();
    //轮播图点击置顶
    function imageOffsetTop(){
        $('.picScroll-left .pic').click(function(){
            var key = $(this).data('key');
            var scrollImgElem = $('.js_list_box').find('img[data-key="'+key+'"]');
            var scrollImgElemScrollTop = scrollImgElem[0].offsetTop;
            $('.js_list_box').scrollTop(scrollImgElemScrollTop);
            if(key > keyDirection){
                var type = 1;
            }else{
                var type = 2;
            }
            keyDirection = key;
            currentImageView(type);
        })
    }

    //距离当前图片是否在可视区域中
    function currentImageView(type){
        var currentImage = $("#picScroll").find('.pic.active');
        var oneImageWidth = currentImage[0].clientWidth;
        if(currentImage[0].offsetLeft > oneImageWidth && currentImage.parent().next().length > 0 && type == 1 ){
            $('.picScroll-next').trigger('click');
        }
        if(currentImage[0].offsetLeft > oneImageWidth && currentImage.parent().prev().length > 0 && type == 2){
            $('.picScroll-prev').trigger('click');
        }
    }

    //计算百分比
    function computerScale(){
        var oneImageElem = $('.js_list_box').find('img');
        var viewImageWidth = parseInt(oneImageElem.css('width'));
        var boxWidth = parseInt($('.case-swipper').css('width')) - 100; //此100为盒子的padding值
        $('.js_scale_number').html(Math.ceil((viewImageWidth/boxWidth)*100));
    }

    //绑定增加比例 +
    $('.js_add_btn').click(function(){
        var scale = parseInt($('.js_scale_number').html());
        if(scale > 95){
            return layer.msg('已经是最大比例了');
        }
        scale += 5;
        $('.js_scale_number').html(scale);
        $.each($('.js_list_box').find('img'),function(key,elem){
            $(elem).css('width',scale+'%');
        })

        //重新计算图片的宽高
        arrTop = [];
        $('.js_list_box').attr('data-show', 0);
        $('.list-container').trigger('scroll');
    })

    //绑定缩放比例 -
    $('.js_sub_btn').click(function(){
        var scale = parseInt($('.js_scale_number').html());
        if(scale < 10){
            return layer.msg('再小就啥也看不见了');
        }
        scale -= 5;
        $('.js_scale_number').html(scale);
        $.each($('.js_list_box').find('img'),function(key,elem){
            $(elem).css('width',scale+'%');
        })

        //重新计算图片的宽高
        arrTop = [];
        $('.js_list_box').attr('data-show', 0);
        $('.list-container').trigger('scroll');
    })