(window.webpackJsonp=window.webpackJsonp||[]).push([["case"],{"0116":function(t,e,a){t.exports=a.p+"img/logo-text.3d80368c.png"},"47a9":function(t,e,a){},"657d":function(t,e,a){"use strict";var s=a("47a9");a.n(s).a},"73f5":function(t,e,a){"use strict";a.r(e);var s=[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"logo-box flex x-center y-center"},[e("img",{attrs:{src:a("0116"),alt:"logo"}})])}],i={name:"new-details",data:function(){return{newDetails:{},prev:null,next:null,phtoList:[],recommendList:[]}},watch:{$route:function(t,e){t.params.news_id!=e.params.news_id&&null!=t.params.news_id&&this.getNewsDetails()}},methods:{getNewsDetails:function(){var t=this;this.$req.getNewsDetails({id:this.$route.params.news_id}).then((function(e){1e5==e.code?(t.newDetails=e.data.list,t.prev=e.data.prev,t.next=e.data.next,t.phtoList=e.data.phtoList,t.recommendList=e.data.recommend):(t.$Message.error(e.message),t.$router.go(-1))})).catch((function(e){console.log(e),t.$Message.error("系统异常")}))}},created:function(){this.getNewsDetails()}},n=(a("7ac4"),a("e90a")),r=Object(n.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"news"},[a("div",{staticClass:"banner"}),a("div",{staticClass:"sub-content container"},[a("div",{staticClass:"bread"},[a("Breadcrumb",[a("BreadcrumbItem",{attrs:{to:"/"}},[t._v("首页")]),a("BreadcrumbItem",{attrs:{to:{name:"News"}}},[t._v("文章列表")]),a("BreadcrumbItem",[t._v(t._s(t.newDetails.title))])],1)],1),a("div",{staticClass:"sub-content-content x-between flex"},[a("div",{staticClass:"sub-content-left"},[a("h2",{staticClass:"content-title"},[t._v(t._s(t.newDetails.title))]),a("div",{staticClass:"content-info"},[a("span",[t._v("发布日期： "+t._s(t.commonApi.formatDate(t.newDetails.create_time)))]),a("span",[t._v("浏览次数："+t._s(t.newDetails.look))])]),a("div",{staticClass:"content-text",domProps:{innerHTML:t._s(t.newDetails.content)}}),a("div",{staticClass:"content-footer t-l"},[t.prev?a("a",[a("router-link",{attrs:{to:{name:"NewsDetails",params:{news_id:t.prev.id}}}},[t._v("上一篇："+t._s(t.prev.title))])],1):t._e(),t.next?a("a",[a("router-link",{attrs:{to:{name:"NewsDetails",params:{news_id:t.next.id}}}},[t._v("下一篇："+t._s(t.next.title))])],1):t._e()])]),a("div",{staticClass:"sub-content-right"},[a("div",{staticClass:"scr-item"},[t._m(0),a("p",{staticClass:"logo-text"},[t._v("记录精彩一刻")]),a("p",{staticClass:"p-item"},[t._v(" 摄影派，一个专注于照片存储的提供商，让客户更便捷的分享精彩一刻。客户可以从摄影师手里拿到一个精美的相册，相册的配置项会让客户更愉悦呦... ")]),a("p",{staticClass:"p-item"},[a("Button",{attrs:{type:"primary",size:"large",long:""}},[t._v("联系我们")])],1)]),a("div",{staticClass:"scr-item"},[a("div",{staticClass:"scr-title"},[t._v("热门新闻")]),t._l(t.recommendList,(function(e,s){return a("router-link",{staticClass:"news-item",attrs:{to:{name:"NewsDetails",params:{news_id:e.id}}}},[a("h2",{staticClass:"overflow-text2"},[t._v(t._s(e.title))]),a("p",{staticClass:"about-time"},[t._v(t._s(t.commonApi.formatDate(e.create_time)))])])}))],2),a("div",{staticClass:"scr-item"},[a("div",{staticClass:"scr-title"},[t._v("最新相册")]),t._l(t.phtoList,(function(e,s){return a("router-link",{staticClass:"news-item",attrs:{to:{name:"CaseDetails",params:{case_id:e.id}}}},[a("h2",{staticClass:"overflow-text2"},[t._v(t._s(e.name))]),a("p",{staticClass:"about-time"},[t._v(t._s(e.starttime))])])}))],2)])])])])}),s,!1,null,"e602fa78",null);e.default=r.exports},7871:function(t,e,a){"use strict";a.r(e);var s={name:"photoPreview",data:function(){return{}}},i=(a("88f6"),a("e90a")),n=Object(i.a)(s,(function(){var t=this.$createElement;return(this._self._c||t)("div",{staticClass:"photoPreview"},[this._v(" 相册预览 ")])}),[],!1,null,null,null);e.default=n.exports},"7ac4":function(t,e,a){"use strict";var s=a("deeb");a.n(s).a},"88f6":function(t,e,a){"use strict";var s=a("ef06");a.n(s).a},"9fe4":function(t,e,a){"use strict";a.r(e);a("dbb3");var s=a("b4a8"),i=null,n={name:"Case",data:function(){return{filterData:{type:"",address:[],name:"",dateRange:[]},photoType:[],cityJson:[],caseList:[],totalCount:0,page:{page:1,limit:30},scrollHeight:"auto"}},watch:{filterData:{handler:function(t){var e=this;i&&(clearTimeout(i),i=null),i=setTimeout((function(){e.formatFilterData(t)}),100)},deep:!0}},methods:{formatFilterData:function(t){var e={};for(var a in t)"address"==a?(e.province_id=t.address[0],e.city_id=t.address[1],e.area_id=t.address[2]):e[a]=t[a];this.getCaseList(e)},changePage:function(t){this.page.page=t,this.formatFilterData(this.filterData)},clearFilterFun:function(){for(var t in this.filterData)Array.isArray(this.filterData[t])?this.filterData[t]=[]:this.filterData[t]=""},setTimeEvent:function(t){this.filterData.starttime=t[0],this.filterData.endtime=t[1]},windowScroll:function(t){window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop;var e=this.$refs.filter_box.clientHeight+25,a=t.clientHeight,s=window.innerHeight+e;s>a&&t.scrollTop+a>=s&&(this.scrollHeight=window.innerHeight-e)},getCaseList:function(t){var e=this,a=Object.assign(t,this.page);this.$req.caseList(a).then((function(t){1e5==t.code?(e.$req.getCitys().then((function(a){e.cityJson=a,t.data.filter((function(t){var e=a.findItem({value:t.province_id}),s=e.children.findItem({value:t.city_id}),i=s.children.findItem({value:t.area_id});t.province=e.label,t.city=s.label,t.area=i.label}))})),e.totalCount=parseInt(t.count),e.caseList=t.data):e.$Message.error(t.message)})).catch((function(t){console.log(t),e.$Message.error("系统异常")}))},getPhotoType:function(){var t=this;this.$req.photoliveType({}).then((function(e){1e5==e.code?(e.data.unshift({id:0,name:"全部"}),t.photoType=e.data):t.$Message.error(e.message)})).catch((function(e){console.log(e),t.$Message.error("系统异常")}))}},components:{caseItem:s.a},created:function(){},mounted:function(){this.filterData.type=this.$route.params.type_id,this.getPhotoType()}},r=(a("e350"),a("e90a")),c=Object(r.a)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"case"},[a("div",{staticClass:"banner"}),a("div",{staticClass:"sub-content"},[a("div",{ref:"filter_box",staticClass:"bread flex x-between container"},[a("div",{staticClass:"filter-select flex y-center"},[a("span",[t._v("筛选：")]),a("Select",{staticStyle:{"margin-right":"15px",width:"150px"},attrs:{placeholder:"活动类型筛选"},model:{value:t.filterData.type,callback:function(e){t.$set(t.filterData,"type",e)},expression:"filterData.type"}},t._l(t.photoType,(function(e){return a("Option",{key:e.id,attrs:{value:e.id}},[t._v(t._s(e.name))])})),1),t.cityJson.length?a("Cascader",{staticStyle:{width:"200px","margin-right":"15px"},attrs:{transfer:!0,data:t.cityJson,placeholder:"地点筛选"},model:{value:t.filterData.address,callback:function(e){t.$set(t.filterData,"address",e)},expression:"filterData.address"}}):t._e(),a("DatePicker",{staticStyle:{width:"200px"},attrs:{format:"yyyy-MM-dd",type:"daterange",placeholder:"活动日期筛选"},on:{"on-change":t.setTimeEvent},model:{value:t.filterData.dateRange,callback:function(e){t.$set(t.filterData,"dateRange",e)},expression:"filterData.dateRange"}}),a("Button",{staticStyle:{"margin-left":"10px"},on:{click:t.clearFilterFun}},[t._v("清除")])],1),a("Input",{staticStyle:{width:"200px"},attrs:{search:"",placeholder:"请输入直播案例标题搜索"},model:{value:t.filterData.name,callback:function(e){t.$set(t.filterData,"name",e)},expression:"filterData.name"}})],1),a("div",{staticClass:"container sub-content-content"},[a("div",{staticClass:"case-list flex wrap container"},t._l(t.caseList,(function(t,e){return a("case-item",{key:e,attrs:{caseObj:t}})})),1),t.totalCount>t.page.limit?a("div",{staticStyle:{margin:"10px",overflow:"hidden"}},[a("div",{staticClass:"t-c"},[a("Page",{attrs:{total:t.totalCount,"page-size":t.page.limit,current:t.page.page},on:{"on-change":t.changePage}})],1)]):t._e()])])])}),[],!1,null,null,null);e.default=c.exports},a2f9:function(t,e,a){"use strict";a.r(e);a("e35a"),a("9cf3");var s=a("c451"),i=a("f8c2"),n=null,r={name:"News",data:function(){return{newsList:[],search:"",totalCount:0,page:{page:1,limit:30}}},components:{newsItem:i.a},watch:{search:function(t,e){var a=this;n&&(clearTimeout(n),n=null),n=setTimeout((function(){a.getNewsList()}),500)}},methods:{changePage:function(t){this.page.page=t,this.getNewsList()},getNewsList:function(){var t=this;this.$req.getNewsList(Object(s.a)({title:this.search},this.page)).then((function(e){1e5==e.code?(t.newsList=e.data,t.totalCount=parseInt(e.count)):t.$Message.error(e.message)})).catch((function(e){console.log(e),t.$Message.error("系统异常")}))}},created:function(){this.getNewsList()}},c=(a("657d"),a("e90a")),o=Object(c.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"news"},[a("div",{staticClass:"banner"}),a("div",{staticClass:"sub-content container"},[a("div",{staticClass:"bread flex x-between y-center"},[a("Breadcrumb",[a("BreadcrumbItem",{attrs:{to:"/"}},[t._v("首页")]),a("BreadcrumbItem",[t._v("文章列表")])],1),a("Input",{staticStyle:{width:"200px"},attrs:{search:"",placeholder:"请输入新闻标题搜索"},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),a("div",{staticClass:"sub-content-content"},[t._l(t.newsList,(function(t,e){return a("news-item",{key:e,attrs:{newItem:t}})})),t.totalCount>t.page.limit?a("div",{staticStyle:{margin:"10px",overflow:"hidden"}},[a("div",{staticClass:"t-c"},[a("Page",{attrs:{total:t.totalCount,"page-size":t.page.limit,current:t.page.page},on:{"on-change":t.changePage}})],1)]):t._e()],2)])])}),[],!1,null,null,null);e.default=o.exports},c451:function(t,e,a){"use strict";a.d(e,"a",(function(){return n}));a("f3dd"),a("dbb3"),a("fe59"),a("b73f"),a("bf84"),a("fe8a"),a("08ba");var s=a("b081");function i(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function n(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?i(Object(a),!0).forEach((function(e){Object(s.a)(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):i(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}},dca1:function(t,e,a){},deeb:function(t,e,a){},e350:function(t,e,a){"use strict";var s=a("dca1");a.n(s).a},ef06:function(t,e,a){}}]);