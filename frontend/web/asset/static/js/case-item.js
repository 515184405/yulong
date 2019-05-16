    var arrTop = [];
    $('.list-container').scroll(function () {
        var scrollTop = $('.list-container').scrollTop();
        var offsetTop = $('.js_case_list')[0].offsetTop;
        if (scrollTop >= offsetTop || (scrollTop + $(window).height()) > $('.list-content')[0].clientHeight) {
            if ($('.js_list_box').attr('data-show') != 1) {
                $.each($('.js_list_box').find('img'), function (key, elem) {
                    $(elem).attr('src', $(elem).attr('data-src'));
                    elem.onload = function () {
                        arrTop.push(elem.offsetTop);
                        arrTop.sort(function (a, b) {
                            return a > b;
                        });
                    }
                })
                $('.sn-count').html($('.js_list_box').find('img').length);
                $('.js_list_box').attr('data-show', 1);
            }
            $('.js_list_box').addClass('add-animated');
            $('.swipper-number').show();
            $('.js_list_box').scrollTop(21);
        } else {
            $('.js_list_box').removeClass('add-animated');
            $('.swipper-number').hide();
        };
    })

    //打开查看图片后的滚动事件 查看当前看到第几张
    $('.js_list_box').scroll(function () {
        var scrollTop = $('.js_list_box').scrollTop();
        var offsetTop = $('.js_case_list')[0].offsetTop;
        if(scrollTop < 20){
            $('.js_list_box').removeClass('add-animated');
            $('.swipper-number').hide();
            $('.list-container').scrollTop(offsetTop-1);
        }
        for (var i = 0, len = arrTop.length; i < len; i++) {
            if ((arrTop[i] <= scrollTop && arrTop[i + 1] > scrollTop) || (scrollTop) >= arrTop[len - 1]) {
                $('.sn-current').html(i + 1);
            }
        }
    })

    //关闭事件
    $('.js_swipper_close').bind('click',function(){
        var offsetTop = $('.js_case_list')[0].offsetTop;
        $('.js_list_box').removeClass('add-animated');
        $('.swipper-number').hide();
        $('.list-container').scrollTop(offsetTop-1);
    })

