var arrTop = [];
$('.list-container').scroll(function(){
    var scrollTop = $('.list-container').scrollTop();
    var offsetTop = $('.js_case_list')[0].offsetTop;
    if(scrollTop >= offsetTop){
        if($('.js_list_box').attr('data-show') != 1){
            $.each($('.js_list_box').find('img'),function(key,elem){
                $(elem).attr('src',$(elem).attr('data-src'));
                elem.onload = function(){
                    arrTop.push(elem.offsetTop);
                    arrTop.sort(function(a,b){
                        return a>b;
                    });
                }
            })
            $('.sn-count').html($('.js_list_box').find('img').length );
            $('.js_list_box').attr('data-show',1);
        };
        $('.js_list_box').addClass('add-animated').css('top',offsetTop);
        $('.swipper-number').show();
    }else{
        $('.js_list_box').removeClass('add-animated');
        $('.swipper-number').hide();
    };
    setCurrentNumber();
})

$('.js_list_box').scroll(function(){
    setCurrentNumber();
})

function setCurrentNumber(){
    console.log(arrTop);
    var scrollTop = $('.js_list_box').scrollTop();
    var parentScrollTop = $('.list-container').scrollTop();
    for(var i = 0,len = arrTop.length;i < len ;i++){
        if((arrTop[i] <= scrollTop && arrTop[i+1] > scrollTop) || (scrollTop+parentScrollTop) >= arrTop[len-1]){
            $('.sn-current').html(i+1);
        }
    }
}