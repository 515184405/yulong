(window.webpackJsonp=window.webpackJsonp||[]).push([["photoGroup"],{"204b":function(t,e,o){"use strict";o.r(e);o("dbb3"),o("fe59"),o("ea69"),o("08ba"),o("053b");var n={name:"photoGroupItem",props:{groupList:{type:Array,default:[]}},data:function(){return{currentText:""}},methods:{swapArray:function(t,e,o){console.log(t[e].name,t[e].sort),console.log(t[o].name,t[o].sort);var n=t[e].sort,s=t[o].sort;return t[e].sort=s,t[o].sort=n,console.log(t[e].name,t[e].sort),console.log(t[o].name,t[o].sort),t[e]=t.splice(o,1,t[e])[0],console.log(t),t},zIndexDown:function(t,e){e+1!=t.length?this.swapArray(t,e,e+1):this.$Message.warning("已经处于置底，无法下移")},zIndexUp:function(t,e){0!=e?this.swapArray(t,e,e-1):this.$Message.warning("已经处于置顶，无法上移")},sortFun:function(){},btnClickEvent:function(t,e,o){var n=this.groupList[o];switch(t){case"edit":console.log("修改"),this.currentText=n.name,this.$emit("setAttrValueEvent",n,"status",!0);break;case"yes":console.log("确定修改"),this.$emit("setAttrValueEvent",n,"status",!1,"update");break;case"no":console.log("取消修改"),n.name=this.currentText,this.$emit("setAttrValueEvent",n,"status",o,"canel");break;case"down":console.log("下"),this.zIndexDown(this.groupList,o),this.$emit("setAttrValueEvent",n,"status",!1,"sort",(function(){}));break;case"remove":console.log("删除"),this.$emit("setAttrValueEvent",n,"status",!1,"remove");break;case"up":console.log("上"),this.zIndexUp(this.groupList,o),this.$emit("setAttrValueEvent",n,"status",!1,"sort",(function(){}));break;default:console.log("无效事件")}}},created:function(){console.log(this.$route.params)}},s=(o("ce6d"),o("e90a")),r={name:"setPhotoGroup",data:function(){return{groupList:[]}},components:{groupItem:Object(s.a)(n,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",t._l(t.groupList,(function(e,n){return o("div",{key:e.id,staticClass:"photoGroupItem flex"},[o("Input",{staticClass:"flex-item group-input",attrs:{autofocus:e.status,readonly:!e.status,placeholder:"请输入分组名称"},model:{value:e.name,callback:function(o){t.$set(e,"name",o)},expression:"item.name"}}),e.status?o("ButtonGroup",[o("Button",{attrs:{icon:"md-checkmark"},on:{click:function(o){return t.btnClickEvent("yes",e.id,n)}}}),o("Button",{attrs:{icon:"md-close"},on:{click:function(o){return t.btnClickEvent("no",e.id,n)}}})],1):o("ButtonGroup",[o("Button",{on:{click:function(o){return t.btnClickEvent("edit",e.id,n)}}},[t._v("编辑")]),o("Button",{on:{click:function(o){return t.btnClickEvent("remove",e.id,n)}}},[t._v("删除")]),o("Button",{attrs:{icon:"md-arrow-round-up"},on:{click:function(o){return t.btnClickEvent("up",e.id,n)}}}),o("Button",{attrs:{icon:"md-arrow-round-down"},on:{click:function(o){return t.btnClickEvent("down",e.id,n)}}})],1)],1)})),0)}),[],!1,null,null,null).exports},methods:{addGroupEvent:function(){this.groupList.push(Object.assign({status:!0},this.$route.params))},setAttrValueEvent:function(t,e,o,n,s){"update"==n?this.photoLiveGroupInsert(t,e,o):"remove"==n?this.photoLiveGroupRemove(t,e,o):"canel"==n?t.id?this.$set(t,e,!1):(console.log(o),this.groupList.splice(o,1)):"sort"==n?this.photoliveGroupSort(t,e,o,s):this.$set(t,e,o)},photoliveGroupSort:function(t,e,o,n){var s=this;this.$req.photoliveGroupSort(this.groupList).then((function(r){1e5==r.code?s.$set(t,e,o):(s.$Message.error(r.message),"function"==typeof n&&n())})).catch((function(t){console.log(t),"function"==typeof n&&n(),s.$Message.error("服务器内部错误")}))},photoLiveGroupRemove:function(t,e,o){var n=this;this.$req.photoliveGroupRemove(t).then((function(s){1e5==s.code?(n.$set(t,e,o),n.groupList=n.groupList.filter((function(e){return e.id!=t.id}))):n.$Message.error(s.message)})).catch((function(t){console.log(t),n.$Message.error("服务器内部错误")}))},photoLiveGroupInsert:function(t,e,o){var n=this;this.$req.photoliveGroupCreateUpdate(t).then((function(s){1e5==s.code?(1==n.groupList.length&&window.location.reload(),n.$set(t,e,o)):n.$Message.error(s.message),n.photoliveGroupList()})).catch((function(t){console.log(t),n.$Message.error("服务器内部错误")}))},photoliveGroupList:function(){var t=this;this.$req.photoliveGroupList(this.$route.params).then((function(e){1e5==e.code?(e.data.forEach((function(t,e){t.status=!1})),t.groupList=e.data):t.$Message.error(e.message)})).catch((function(){t.$Message.error("服务器内部错误")}))}},created:function(){this.photoliveGroupList()}},i=(o("2c46"),Object(s.a)(r,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"setPhotoGroup",staticStyle:{"margin-top":"25px"}},[e("Card",{attrs:{"dis-hover":"",bordered:!1}},[e("p",{staticStyle:{"line-height":"33px",height:"30px"},attrs:{slot:"title"},slot:"title"},[e("Icon",{staticStyle:{"font-size":"20px"},attrs:{type:"ios-browsers"}}),this._v(" 设置照片分组 ")],1),e("Button",{attrs:{slot:"extra",name:"btn",type:"primary"},on:{click:this.addGroupEvent},slot:"extra"},[this._v("新建分组")]),e("group-item",{attrs:{groupList:this.groupList},on:{setAttrValueEvent:this.setAttrValueEvent}})],1)],1)}),[],!1,null,null,null));e.default=i.exports},"2c46":function(t,e,o){"use strict";var n=o("7d4b");o.n(n).a},"7d4b":function(t,e,o){},ce6d:function(t,e,o){"use strict";var n=o("e6ec");o.n(n).a},e6ec:function(t,e,o){}}]);