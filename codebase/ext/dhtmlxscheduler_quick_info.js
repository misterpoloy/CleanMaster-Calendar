/*
@license
dhtmlxScheduler v.4.3.35 Professional Evaluation

This software is covered by DHTMLX Evaluation License. Contact sales@dhtmlx.com to get Commercial or Enterprise license. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
Scheduler.plugin(function(e){e.config.icons_select=["icon_details","icon_delete"],e.config.details_on_create=!0,e.config.show_quick_info=!0,e.xy.menu_width=0,e.attachEvent("onClick",function(t){return e.showQuickInfo(t),!0}),function(){for(var t=["onEmptyClick","onViewChange","onLightbox","onBeforeEventDelete","onBeforeDrag"],a=function(){return e._hideQuickInfo(),!0},n=0;n<t.length;n++)e.attachEvent(t[n],a)}(),e.templates.quick_info_title=function(e,t,a){return a.text.substr(0,50)},e.templates.quick_info_content=function(e,t,a){
return a.details||a.text},e.templates.quick_info_date=function(t,a,n){return e.isOneDayEvent(n)?e.templates.day_date(t,a,n)+" "+e.templates.event_header(t,a,n):e.templates.week_date(t,a,n)},e.showQuickInfo=function(e){if(e!=this._quick_info_box_id&&this.config.show_quick_info){this.hideQuickInfo(!0);var t=this._get_event_counter_part(e);t&&(this._quick_info_box=this._init_quick_info(t),this._fill_quick_data(e),this._show_quick_info(t))}},e._hideQuickInfo=function(){e.hideQuickInfo()},e.hideQuickInfo=function(t){
var a=this._quick_info_box;if(this._quick_info_box_id=0,a&&a.parentNode){var n=a._offsetWidth;if(e.config.quick_info_detached)return a.parentNode.removeChild(a);"auto"==a.style.right?a.style.left=-n+"px":a.style.right=-n+"px",t&&a.parentNode.removeChild(a)}},dhtmlxEvent(window,"keydown",function(t){27==t.keyCode&&e.hideQuickInfo()}),e._show_quick_info=function(t){var a=e._quick_info_box;e._obj.appendChild(a);var n=a.offsetWidth,i=a.offsetHeight;e.config.quick_info_detached?(a.style.left=t.left-t.dx*(n-t.width)+"px",
a.style.top=t.top-(t.dy?i:-t.height)+"px"):(a.style.top=this.xy.scale_height+this.xy.nav_height+20+"px",1==t.dx?(a.style.right="auto",a.style.left=-n+"px",setTimeout(function(){a.style.left="-10px"},1)):(a.style.left="auto",a.style.right=-n+"px",setTimeout(function(){a.style.right="-10px"},1)),a.className=a.className.replace("dhx_qi_left","").replace("dhx_qi_right","")+" dhx_qi_"+(1==t?"left":"right"))},e.attachEvent("onTemplatesReady",function(){if(e.hideQuickInfo(),this._quick_info_box){var t=this._quick_info_box;
t.parentNode&&t.parentNode.removeChild(t),this._quick_info_box=null}}),e._quick_info_onscroll_handler=function(t){e.hideQuickInfo()},e._init_quick_info=function(){if(!this._quick_info_box){var t=e.xy,a=this._quick_info_box=document.createElement("div");a.className="dhx_cal_quick_info",e.$testmode&&(a.className+=" dhx_no_animate");var n='<div class="dhx_cal_qi_title" style="height:'+t.quick_info_title+'px"><div class="dhx_cal_qi_tcontent"></div><div  class="dhx_cal_qi_tdate"></div></div><div class="dhx_cal_qi_content"></div>';
n+='<div class="dhx_cal_qi_controls" style="height:'+t.quick_info_buttons+'px">';for(var i=e.config.icons_select,r=0;r<i.length;r++)n+='<div class="dhx_qi_big_icon '+i[r]+'" title="'+e.locale.labels[i[r]]+"\"><div class='dhx_menu_icon "+i[r]+"'></div><div>"+e.locale.labels[i[r]]+"</div></div>";n+="</div>",a.innerHTML=n,dhtmlxEvent(a,"click",function(t){t=t||event,e._qi_button_click(t.target||t.srcElement)}),e.config.quick_info_detached&&(e._detachDomEvent(e._els.dhx_cal_data[0],"scroll",e._quick_info_onscroll_handler),
dhtmlxEvent(e._els.dhx_cal_data[0],"scroll",e._quick_info_onscroll_handler))}return this._quick_info_box},e._qi_button_click=function(t){var a=e._quick_info_box;if(t&&t!=a){var n=e._getClassName(t);if(-1!=n.indexOf("_icon")){var i=e._quick_info_box_id;e._click.buttons[n.split(" ")[1].replace("icon_","")](i)}else e._qi_button_click(t.parentNode)}},e._get_event_counter_part=function(t){for(var a=e.getRenderedEvent(t),n=0,i=0,r=a;r&&r!=e._obj;)n+=r.offsetLeft,i+=r.offsetTop-r.scrollTop,r=r.offsetParent;
if(r){var s=n+a.offsetWidth/2>e._x/2?1:0,d=i+a.offsetHeight/2>e._y/2?1:0;return{left:n,top:i,dx:s,dy:d,width:a.offsetWidth,height:a.offsetHeight}}return 0},e._fill_quick_data=function(t){var a=e.getEvent(t),n=e._quick_info_box;e._quick_info_box_id=t;var i=n.firstChild.firstChild;i.innerHTML=e.templates.quick_info_title(a.start_date,a.end_date,a);var r=i.nextSibling;r.innerHTML=e.templates.quick_info_date(a.start_date,a.end_date,a);var s=n.firstChild.nextSibling;s.innerHTML=e.templates.quick_info_content(a.start_date,a.end_date,a);
}});