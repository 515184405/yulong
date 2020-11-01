import PhotoSwipe from './photoswipe.js';
import PhotoSwipeUI_Default from './photoswipe-ui-default.min.js';

const openPhotoSwipe = function(items,params) {
    var pswpElement = document.querySelectorAll('.pswp')[0];

    // build items array
    /* items = [
        {
			msrc: 'path/to/small-image.jpg', // small image placeholder,
            src: 'https://farm2.staticflickr.com/1043/5186867718_06b2e9e551_b.jpg',
			title: 'Image Caption',  // used by Default PhotoSwipe UI
            w: 964,
            h: 1024
        },
    
    ]; */
    
    // define options (if needed)
    var options = {
             // history & focus options are disabled on CodePen        
        history: false,
        focus: false,
        showAnimationDuration: 0,
        hideAnimationDuration: 0,
		/* 是否添加点击显示隐藏头尾状态条 */
		tapToToggleControls : false,
	    history:false,
	    shareEl:false,
	    fullscreenEl : false,
	    loop:false,
	    maxSpreadZoom:0.7,
		createElem:function(obj){
		
			var videoType = obj.src.substr(-3).toLowerCase();
			if(/^(mp4|avi|3gp|rmvb|flv)$/.test(videoType)){
				var videoElem = '<div class="pswp__img pswp__video"><video class="preview__video" poster="'+obj.msrc+'" controls="controls" webkit-playsinline="true" playsinline="true" width="100%" height="100%" preload="auto" src="'+obj.src+'"></video></div>';
				obj.container.innerHTML = videoElem;

			   return true;
			}
		}
    };
	
	options = Object.assign(options,params)
    
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
	return gallery
};

// openPhotoSwipe();

module.exports = openPhotoSwipe