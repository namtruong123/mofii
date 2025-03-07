'use strict';(function($){var $storage=true;var added_ids=[];var key=Cookies.get('woosw_key');try{$storage=('sessionStorage'in window&&window.sessionStorage!==null);window.sessionStorage.setItem('woosw','test');window.sessionStorage.removeItem('woosw');}catch(err){$storage=false;}
$(function(){if(key===null||key===undefined||key===''){key=woosw_get_key();Cookies.set('woosw_key',key,{expires:7});}
woosw_load_data();if($('.woosw-custom-menu-item').length||woosw_vars.reload_count==='yes'){woosw_load_count();}
if(woosw_vars.button_action==='message'){$.notiny.addTheme('woosw',{notification_class:'notiny-theme-woosw',});}});$(document).on('change','.woosw-switcher-dropdown',function(){window.location=$(this).val();});$(document).on('woosw_refresh_data',function(){woosw_get_data();});$(document).on('woosw_refresh_count',function(){woosw_load_count();});$(document).on('woovr_selected',function(e,selected,variations){var id=selected.attr('data-id');var pid=selected.attr('data-pid');if(id>0){$('.woosw-btn-'+pid).attr('data-id',id).removeClass('woosw-btn-added woosw-added');woosw_refresh_button_id(id);}else{$('.woosw-btn-'+pid).attr('data-id',pid).removeClass('woosw-btn-added woosw-added');woosw_refresh_button_id(pid);}});$(document).on('found_variation',function(e,t){var product_id=$(e['target']).attr('data-product_id');$('.woosw-btn-'+product_id).attr('data-id',t.variation_id).removeClass('woosw-btn-added woosw-added');woosw_refresh_button_id(t.variation_id);});$(document).on('reset_data',function(e){var product_id=$(e['target']).attr('data-product_id');$('.woosw-btn-'+product_id).attr('data-id',product_id).removeClass('woosw-btn-added woosw-added');woosw_refresh_button_id(product_id);});$(document).on('click touch','#woosw_wishlist .woosq-link, #woosw_wishlist .woosq-btn',function(e){woosw_wishlist_hide();e.preventDefault();});$(document).on('click touch','.woosw-btn',function(e){var $this=$(this);var id=$this.attr('data-id');var pid=$this.attr('data-pid');var product_id=$this.attr('data-product_id');var product_name=$this.attr('data-product_name');var product_image=$this.attr('data-product_image');if(typeof pid!==typeof undefined&&pid!==false){id=pid;}
if(typeof product_id!==typeof undefined&&product_id!==false){id=product_id;}
var data={action:'wishlist_add',product_id:id,nonce:woosw_vars.nonce,};if($this.hasClass('woosw-added')){if(woosw_vars.button_action_added==='page'){window.location.href=woosw_vars.wishlist_url;}else{if($('#woosw_wishlist').hasClass('woosw-loaded')){woosw_wishlist_show();}else{woosw_wishlist_load();}}}else{$this.addClass('woosw-adding').find('.woosw-btn-icon').removeClass(woosw_vars.button_normal_icon+' '+
woosw_vars.button_added_icon).addClass(woosw_vars.button_loading_icon);$.post(woosw_vars.ajax_url,data,function(response){$this.removeClass('woosw-adding').find('.woosw-btn-icon').removeClass(woosw_vars.button_loading_icon);if(woosw_vars.button_action==='list'){if(response.content!=null){$('#woosw_wishlist').html(response.content).addClass('woosw-loaded');}
if(response.notice!=null){woosw_notice(response.notice.replace('{name}','<strong>'+product_name+'</strong>'));}
woosw_perfect_scrollbar();woosw_wishlist_show();}
if(woosw_vars.button_action==='message'){$('#woosw_wishlist').removeClass('woosw-loaded');$.notiny({theme:'woosw',position:woosw_vars.message_position,image:product_image,text:response.notice.replace('{name}','<strong>'+product_name+'</strong>'),});}
if(woosw_vars.button_action==='no'){$('#woosw_wishlist').removeClass('woosw-loaded');}
if(response.count!=null){woosw_change_count(response.count);}
if(response.status===1){woosw_refresh_button_id(id);}
if($storage&&response.data){sessionStorage.setItem('woosw_data_'+response.data.key,JSON.stringify(response.data));}
if(response.data.fragments){woosw_refresh_fragments(response.data.fragments);}
if(response.data.ids){woosw_refresh_buttons(response.data.ids);woosw_refresh_ids(response.data.ids);}
$(document.body).trigger('woosw_add',[id]);});}
e.preventDefault();});$(document).on('click touch','.woosw-item--add span',function(e){var $this=$(this);var key=$this.closest('.woosw-items').data('key');var $this_item=$this.closest('.woosw-item');var product_id=$this_item.attr('data-id');var product_name=$this_item.attr('data-product_name');var data={action:'wishlist_add',product_id:product_id,key:key,nonce:woosw_vars.nonce,};$this.addClass('woosw-item--adding');$.post(woosw_vars.ajax_url,data,function(response){$this.addClass('woosw-item--adding');if(response.content!=null){$('#woosw_wishlist').html(response.content).addClass('woosw-loaded');}
if(response.notice!=null){woosw_notice(response.notice.replace('{name}','<strong>'+product_name+'</strong>'));}
if(response.count!=null){woosw_change_count(response.count);}
if($storage&&response.data){sessionStorage.setItem('woosw_data_'+response.data.key,JSON.stringify(response.data));}
if(response.data.fragments){woosw_refresh_fragments(response.data.fragments);}
if(response.data.ids){woosw_refresh_buttons(response.data.ids);woosw_refresh_ids(response.data.ids);}
$(document.body).trigger('woosw_add',[product_id]);if($this.closest('.woosw-list').length){location.reload();}});e.preventDefault();});$(document).on('click touch','.woosw-item--remove span',function(e){var $this=$(this);var key=$this.closest('.woosw-items').data('key');var $this_item=$this.closest('.woosw-item');var product_id=$this_item.attr('data-id');var data={action:'wishlist_remove',product_id:product_id,key:key,nonce:woosw_vars.nonce,};$this.addClass('woosw-item--removing');$.post(woosw_vars.ajax_url,data,function(response){$this.removeClass('woosw-item--removing');$this_item.remove();if(response.content!=null){$('#woosw_wishlist').html(response.content).addClass('woosw-loaded');}
if(response.notice!=null){woosw_notice(response.notice);}
if(response.count!=null){woosw_change_count(response.count);}
if($storage&&response.data){sessionStorage.setItem('woosw_data_'+response.data.key,JSON.stringify(response.data));}
if(response.data.fragments){woosw_refresh_fragments(response.data.fragments);}
if(response.data.ids){woosw_refresh_buttons(response.data.ids);woosw_refresh_ids(response.data.ids);}
$(document.body).trigger('woosw_remove',[product_id]);});e.preventDefault();});$(document).on('click touch','.woosw-empty',function(e){var $this=$(this);if(confirm(woosw_vars.empty_confirm)){woosw_popup_loading();var key=$this.data('key');var data={action:'wishlist_empty',key:key,nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){if(response.content!=null){$('#woosw_wishlist').html(response.content).addClass('woosw-loaded');}
if(response.notice!=null){woosw_notice(response.notice);}
if(response.count!=null){woosw_change_count(response.count);}
if($storage&&response.data){sessionStorage.setItem('woosw_data_'+response.data.key,JSON.stringify(response.data));}
if(response.data.fragments){woosw_refresh_fragments(response.data.fragments);}
if(response.data.ids){woosw_refresh_buttons(response.data.ids);woosw_refresh_ids(response.data.ids);}
woosw_popup_loaded();$(document.body).trigger('woosw_empty',[key]);});}
e.preventDefault();});$(document).on('click touch','.woosw-popup',function(e){var woosw_content=$('.woosw-popup-content');if($(e.target).closest(woosw_content).length==0){woosw_wishlist_hide();woosw_manage_hide();}});$(document).on('click touch','.woosw-continue',function(e){var url=$(this).attr('data-url');woosw_wishlist_hide();if(url!==''){window.location.href=url;}
e.preventDefault();});$(document).on('click touch','#woosw_wishlist .woosw-popup-close',function(e){woosw_wishlist_hide();e.preventDefault();});$(document).on('click touch','#woosw_manage .woosw-popup-close',function(e){woosw_manage_hide();e.preventDefault();});$(document).on('click touch','.woosw-manage',function(e){e.preventDefault();woosw_popup_loading();var data={action:'manage_wishlists',nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){woosw_wishlist_hide();$('#woosw_manage').html(response);woosw_manage_show();woosw_popup_loaded();});});$(document).on('click touch','#woosw_add_wishlist',function(e){e.preventDefault();woosw_popup_loading();var name=$('#woosw_wishlist_name').val();var data={action:'add_wishlist',name:name,nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){$('#woosw_manage').html(response);$('#woosw_wishlist').removeClass('woosw-loaded');woosw_popup_loaded();});});$(document).on('click touch','.woosw-set-default',function(e){e.preventDefault();woosw_popup_loading();var key=$(this).data('key');var data={action:'set_default',key:key,nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){if(response.count!=null){woosw_change_count(response.count);}
if((response.products!=null)&&response.products.length){response.products.forEach((product_id)=>{woosw_refresh_button_id(product_id);});}
$('#woosw_manage').html(response.content);if($storage&&response.data){sessionStorage.setItem('woosw_data_'+response.data.key,JSON.stringify(response.data));}
if(response.data.fragments){woosw_refresh_fragments(response.data.fragments);}
if(response.data.ids){woosw_refresh_buttons(response.data.ids);woosw_refresh_ids(response.data.ids);}
$('#woosw_wishlist').removeClass('woosw-loaded');woosw_popup_loaded();});});$(document).on('click touch','.woosw-delete-wishlist',function(e){e.preventDefault();if(confirm(woosw_vars.delete_confirm)){woosw_popup_loading();var key=$(this).data('key');var data={action:'delete_wishlist',key:key,nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){$('#woosw_manage').html(response);$('#woosw_wishlist').removeClass('woosw-loaded');woosw_popup_loaded();});}});$(document).on('click touch','.woosw-view-wishlist',function(e){e.preventDefault();woosw_popup_loading();var key=$(this).data('key');var data={action:'view_wishlist',key:key,nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){woosw_manage_hide();$('#woosw_wishlist').removeClass('woosw-loaded').html(response);woosw_wishlist_show();woosw_popup_loaded();});});$(document).on('click touch','.woosw-menu-item a, .woosw-menu a',function(e){if(woosw_vars.menu_action==='open_popup'){e.preventDefault();if($('#woosw_wishlist').hasClass('woosw-loaded')){woosw_wishlist_show();}else{woosw_wishlist_load();}}});$(document).on('click touch','#woosw_copy_url, #woosw_copy_btn',function(e){e.preventDefault();let $link=$('#woosw_copy_url');let link=$link.val();navigator.clipboard.writeText(link).then(function(){alert(woosw_vars.copied_text+' '+link);},function(){alert('Failure to copy!');});$link.select();});$(document).on('click touch','.woosw-item--note',function(){if($(this).closest('.woosw-item').find('.woosw-item--note-add').length){$(this).closest('.woosw-item').find('.woosw-item--note-add').show();$(this).hide();}});$(document).on('click touch','.woosw_add_note',function(e){e.preventDefault();woosw_popup_loading();var $this=$(this);var key=$this.closest('.woosw-items').data('key');var product_id=$this.closest('.woosw-item').attr('data-id');var note=$this.closest('.woosw-item').find('input[type="text"]').val();var data={action:'add_note',key:key,product_id:product_id,note:woosw_html_entities(note),nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){$this.closest('.woosw-item').find('.woosw-item--note').html(response).show();$this.closest('.woosw-item').find('.woosw-item--note-add').hide();woosw_popup_loaded();});});$(window).on('resize',function(){woosw_fix_height();});function woosw_wishlist_load(){var data={action:'wishlist_load',nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){if(response.content!=null){$('#woosw_wishlist').html(response.content);}
if(response.count!=null){if($('#woosw_wishlist .woosw-items .woosw-item').length&&($('#woosw_wishlist .woosw-items .woosw-item').length!=response.count)){woosw_change_count($('#woosw_wishlist .woosw-items .woosw-item').length);}else{woosw_change_count(response.count);}}
if(response.notice!=null){woosw_notice(response.notice);}
$('#woosw_wishlist').addClass('woosw-loaded');woosw_perfect_scrollbar();woosw_wishlist_show();});}
function woosw_load_count(){var data={action:'wishlist_load_count',nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){if(response.count!=null){var count=response.count;woosw_change_count(count);$(document.body).trigger('woosw_load_count',[count]);}});}
function woosw_wishlist_show(){$('#woosw_wishlist').addClass('woosw-show');woosw_fix_height();$(document.body).trigger('woosw_wishlist_show');}
function woosw_wishlist_hide(){$('#woosw_wishlist').removeClass('woosw-show');$(document.body).trigger('woosw_wishlist_hide');}
function woosw_manage_show(){$('#woosw_manage').addClass('woosw-show');$(document.body).trigger('woosw_manage_show');}
function woosw_manage_hide(){$('#woosw_manage').removeClass('woosw-show');$(document.body).trigger('woosw_manage_hide');}
function woosw_popup_loading(){$('.woosw-popup').addClass('woosw-loading');}
function woosw_popup_loaded(){$('.woosw-popup').removeClass('woosw-loading');}
function woosw_change_count(count){$('#woosw_wishlist .woosw-count').html(count);if(parseInt(count)>0){$('.woosw-empty').show();}else{$('.woosw-empty').hide();}
if($('.woosw-menu-item .woosw-menu-item-inner').length){$('.woosw-menu-item .woosw-menu-item-inner').attr('data-count',count);}else{$('.woosw-menu-item a').html('<span class="woosw-menu-item-inner" data-count="'+count+'"><i class="woosw-icon"></i><span>'+woosw_vars.menu_text+'</span></span>');}
$(document.body).trigger('woosw_change_count',[count]);}
function woosw_notice(notice){$('.woosw-notice').html(notice);woosw_notice_show();setTimeout(function(){woosw_notice_hide();},3000);}
function woosw_notice_show(){$('#woosw_wishlist .woosw-notice').addClass('woosw-notice-show');}
function woosw_notice_hide(){$('#woosw_wishlist .woosw-notice').removeClass('woosw-notice-show');}
function woosw_perfect_scrollbar(){if(woosw_vars.perfect_scrollbar==='yes'){jQuery('#woosw_wishlist .woosw-popup-content-mid').perfectScrollbar({theme:'wpc'});}}
function woosw_html_entities(str){return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}
function woosw_get_key(){var result=[];var characters='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';var charactersLength=characters.length;for(var i=0;i<6;i++){result.push(characters.charAt(Math.floor(Math.random()*charactersLength)));}
return result.join('');}
function woosw_fix_height(){jQuery('.woosw-popup-center .woosw-popup-content').height(2*Math.floor(jQuery('.woosw-popup-center .woosw-popup-content').height()/2)+
2);}
function woosw_load_data(){if($storage){try{var data=JSON.parse(sessionStorage.getItem('woosw_data_'+key));if(data.fragments){woosw_refresh_fragments(data.fragments);}
if(data.ids){woosw_refresh_buttons(data.ids);woosw_refresh_ids(data.ids);}
if(data.key&&(key===null||key===undefined||key==='')){Cookies.set('woosw_key',data.key,{expires:7});}}catch(err){woosw_get_data();}}else{woosw_get_data();}}
function woosw_get_data(){var data={action:'woosw_get_data',nonce:woosw_vars.nonce,};$.post(woosw_vars.ajax_url,data,function(response){if(response){if($storage){sessionStorage.setItem('woosw_data_'+response.key,JSON.stringify(response));}
if(response.fragments){woosw_refresh_fragments(response.fragments);}
if(response.ids){woosw_refresh_buttons(response.ids);woosw_refresh_ids(response.ids);}
if(response.key&&(key===null||key===undefined||key===''||key!==response.key)){Cookies.set('woosw_key',response.key,{expires:7});}
$(document.body).trigger('woosw_data_refreshed',[response]);}});}
function woosw_refresh_fragments(fragments){$.each(fragments,function(key,value){$(key).replaceWith(value);});$(document.body).trigger('woosw_fragments_refreshed',[fragments]);}
function woosw_refresh_ids(ids){added_ids=ids;}
function woosw_refresh_buttons(ids){$('.woosw-btn').removeClass('woosw-btn-added woosw-added');$('.woosw-btn:not(.woosw-btn-has-icon)').html(woosw_vars.button_text);$('.woosw-btn.woosw-btn-has-icon').find('.woosw-btn-icon').removeClass(woosw_vars.button_added_icon).addClass(woosw_vars.button_normal_icon);$('.woosw-btn.woosw-btn-has-icon').find('.woosw-btn-text').html(woosw_vars.button_text);$.each(ids,function(key,value){$('.woosw-btn-'+key).addClass('woosw-btn-added woosw-added');$('.woosw-btn-'+key+':not(.woosw-btn-has-icon)').html(woosw_vars.button_text_added);$('.woosw-btn-has-icon.woosw-btn-'+key).find('.woosw-btn-icon').removeClass(woosw_vars.button_normal_icon).addClass(woosw_vars.button_added_icon);$('.woosw-btn-has-icon.woosw-btn-'+key).find('.woosw-btn-text').html(woosw_vars.button_text_added);if(value.parent!==undefined){$('.woosw-btn-'+value.parent).addClass('woosw-btn-added woosw-added');$('.woosw-btn-'+value.parent+':not(.woosw-btn-has-icon)').html(woosw_vars.button_text_added);$('.woosw-btn-has-icon.woosw-btn-'+value.parent).find('.woosw-btn-icon').removeClass(woosw_vars.button_normal_icon).addClass(woosw_vars.button_added_icon);$('.woosw-btn-has-icon.woosw-btn-'+value.parent).find('.woosw-btn-text').html(woosw_vars.button_text_added);}});$(document.body).trigger('woosw_buttons_refreshed',[ids]);}
function woosw_refresh_button_id(id){$('.woosw-btn[data-id="'+id+'"]').removeClass('woosw-btn-added woosw-added');$('.woosw-btn[data-id="'+id+'"]:not(.woosw-btn-has-icon)').html(woosw_vars.button_text);$('.woosw-btn-has-icon.woosw-btn[data-id="'+id+'"]').find('.woosw-btn-icon').removeClass(woosw_vars.button_added_icon).addClass(woosw_vars.button_normal_icon);$('.woosw-btn-has-icon.woosw-btn[data-id="'+id+'"]').find('.woosw-btn-text').html(woosw_vars.button_text);$.each(added_ids,function(key){if(parseInt(key)===parseInt(id)){$('.woosw-btn[data-id="'+id+'"]').addClass('woosw-btn-added woosw-added');$('.woosw-btn[data-id="'+id+'"]:not(.woosw-btn-has-icon)').html(woosw_vars.button_text_added);$('.woosw-btn-has-icon.woosw-btn[data-id="'+id+'"]').find('.woosw-btn-icon').removeClass(woosw_vars.button_normal_icon).addClass(woosw_vars.button_added_icon);$('.woosw-btn-has-icon.woosw-btn[data-id="'+id+'"]').find('.woosw-btn-text').html(woosw_vars.button_text_added);}});$(document.body).trigger('woosw_refresh_button_id',[id,added_ids]);}})(jQuery);;
/*!
 *  GMAP3 Plugin for jQuery
 *  Version   : 6.0.0
 *  Date      : 2014-04-25
 *  Author    : DEMONTE Jean-Baptiste
 *  Contact   : jbdemonte@gmail.com
 *  Web site  : http://gmap3.net
 *  Licence   : GPL v3 : http://www.gnu.org/licenses/gpl.html
 *  
 *  Copyright (c) 2010-2014 Jean-Baptiste DEMONTE
 *  All rights reserved.
 */
;(function($,undef){var defaults,gm,gId=0,isFunction=$.isFunction,isArray=$.isArray;function isObject(m){return typeof m==="object";}
function isString(m){return typeof m==="string";}
function isNumber(m){return typeof m==="number";}
function isUndefined(m){return m===undef;}
function initDefaults(){gm=google.maps;if(!defaults){defaults={verbose:false,queryLimit:{attempt:5,delay:250,random:250},classes:(function(){var r={};$.each("Map Marker InfoWindow Circle Rectangle OverlayView StreetViewPanorama KmlLayer TrafficLayer BicyclingLayer GroundOverlay StyledMapType ImageMapType".split(" "),function(_,k){r[k]=gm[k];});return r;}()),map:{mapTypeId:gm.MapTypeId.ROADMAP,center:[46.578498,2.457275],zoom:2},overlay:{pane:"floatPane",content:"",offset:{x:0,y:0}},geoloc:{getCurrentPosition:{maximumAge:60000,timeout:5000}}}}}
function globalId(id,simulate){return isUndefined(id)?"gmap3_"+(simulate?gId+1:++gId):id;}
function googleVersionMin(version){var i,gmVersion=gm.version.split(".");version=version.split(".");for(i=0;i<gmVersion.length;i++){gmVersion[i]=parseInt(gmVersion[i],10);}
for(i=0;i<version.length;i++){version[i]=parseInt(version[i],10);if(gmVersion.hasOwnProperty(i)){if(gmVersion[i]<version[i]){return false;}}else{return false;}}
return true;}
function attachEvents($container,args,sender,id,senders){var td=args.td||{},context={id:id,data:td.data,tag:td.tag};function bind(items,handler){if(items){$.each(items,function(name,f){var self=$container,fn=f;if(isArray(f)){self=f[0];fn=f[1];}
handler(sender,name,function(event){fn.apply(self,[senders||sender,event,context]);});});}}
bind(td.events,gm.event.addListener);bind(td.onces,gm.event.addListenerOnce);}
function getKeys(obj){var k,keys=[];for(k in obj){if(obj.hasOwnProperty(k)){keys.push(k);}}
return keys;}
function copyKey(target,key){var i,args=arguments;for(i=2;i<args.length;i++){if(key in args[i]){if(args[i].hasOwnProperty(key)){target[key]=args[i][key];return;}}}}
function tuple(args,value){var k,i,keys=["data","tag","id","events","onces"],td={};if(args.td){for(k in args.td){if(args.td.hasOwnProperty(k)){if((k!=="options")&&(k!=="values")){td[k]=args.td[k];}}}}
for(i=0;i<keys.length;i++){copyKey(td,keys[i],value,args.td);}
td.options=$.extend({},args.opts||{},value.options||{});return td;}
function error(){if(defaults.verbose){var i,err=[];if(window.console&&(isFunction(console.error))){for(i=0;i<arguments.length;i++){err.push(arguments[i]);}
console.error.apply(console,err);}else{err="";for(i=0;i<arguments.length;i++){err+=arguments[i].toString()+" ";}
alert(err);}}}
function numeric(mixed){return(isNumber(mixed)||isString(mixed))&&mixed!==""&&!isNaN(mixed);}
function array(mixed){var k,a=[];if(!isUndefined(mixed)){if(isObject(mixed)){if(isNumber(mixed.length)){a=mixed;}else{for(k in mixed){a.push(mixed[k]);}}}else{a.push(mixed);}}
return a;}
function ftag(tag){if(tag){if(isFunction(tag)){return tag;}
tag=array(tag);return function(val){var i;if(isUndefined(val)){return false;}
if(isObject(val)){for(i=0;i<val.length;i++){if($.inArray(val[i],tag)>=0){return true;}}
return false;}
return $.inArray(val,tag)>=0;};}}
function toLatLng(mixed,emptyReturnMixed,noFlat){var empty=emptyReturnMixed?mixed:null;if(!mixed||(isString(mixed))){return empty;}
if(mixed.latLng){return toLatLng(mixed.latLng);}
if(mixed instanceof gm.LatLng){return mixed;}
if(numeric(mixed.lat)){return new gm.LatLng(mixed.lat,mixed.lng);}
if(!noFlat&&isArray(mixed)){if(!numeric(mixed[0])||!numeric(mixed[1])){return empty;}
return new gm.LatLng(mixed[0],mixed[1]);}
return empty;}
function toLatLngBounds(mixed){var ne,sw;if(!mixed||mixed instanceof gm.LatLngBounds){return mixed||null;}
if(isArray(mixed)){if(mixed.length===2){ne=toLatLng(mixed[0]);sw=toLatLng(mixed[1]);}else if(mixed.length===4){ne=toLatLng([mixed[0],mixed[1]]);sw=toLatLng([mixed[2],mixed[3]]);}}else{if(("ne"in mixed)&&("sw"in mixed)){ne=toLatLng(mixed.ne);sw=toLatLng(mixed.sw);}else if(("n"in mixed)&&("e"in mixed)&&("s"in mixed)&&("w"in mixed)){ne=toLatLng([mixed.n,mixed.e]);sw=toLatLng([mixed.s,mixed.w]);}}
if(ne&&sw){return new gm.LatLngBounds(sw,ne);}
return null;}
function resolveLatLng(ctx,method,runLatLng,args,attempt){var latLng=runLatLng?toLatLng(args.td,false,true):false,conf=latLng?{latLng:latLng}:(args.td.address?(isString(args.td.address)?{address:args.td.address}:args.td.address):false),cache=conf?geocoderCache.get(conf):false,self=this;if(conf){attempt=attempt||0;if(cache){args.latLng=cache.results[0].geometry.location;args.results=cache.results;args.status=cache.status;method.apply(ctx,[args]);}else{if(conf.location){conf.location=toLatLng(conf.location);}
if(conf.bounds){conf.bounds=toLatLngBounds(conf.bounds);}
geocoder().geocode(conf,function(results,status){if(status===gm.GeocoderStatus.OK){geocoderCache.store(conf,{results:results,status:status});args.latLng=results[0].geometry.location;args.results=results;args.status=status;method.apply(ctx,[args]);}else if((status===gm.GeocoderStatus.OVER_QUERY_LIMIT)&&(attempt<defaults.queryLimit.attempt)){setTimeout(function(){resolveLatLng.apply(self,[ctx,method,runLatLng,args,attempt+1]);},defaults.queryLimit.delay+Math.floor(Math.random()*defaults.queryLimit.random));}else{error("geocode failed",status,conf);args.latLng=args.results=false;args.status=status;method.apply(ctx,[args]);}});}}else{args.latLng=toLatLng(args.td,false,true);method.apply(ctx,[args]);}}
function resolveAllLatLng(list,ctx,method,args){var self=this,i=-1;function resolve(){do{i++;}while((i<list.length)&&!("address"in list[i]));if(i>=list.length){method.apply(ctx,[args]);return;}
resolveLatLng(self,function(args){delete args.td;$.extend(list[i],args);resolve.apply(self,[]);},true,{td:list[i]});}
resolve();}
function geoloc(ctx,method,args){var is_echo=false;if(navigator&&navigator.geolocation){navigator.geolocation.getCurrentPosition(function(pos){if(!is_echo){is_echo=true;args.latLng=new gm.LatLng(pos.coords.latitude,pos.coords.longitude);method.apply(ctx,[args]);}},function(){if(!is_echo){is_echo=true;args.latLng=false;method.apply(ctx,[args]);}},args.opts.getCurrentPosition);}else{args.latLng=false;method.apply(ctx,[args]);}}
function isDirectGet(obj){var k,result=false;if(isObject(obj)&&obj.hasOwnProperty("get")){for(k in obj){if(k!=="get"){return false;}}
result=!obj.get.hasOwnProperty("callback");}
return result;}
var services={},geocoderCache=new GeocoderCache();function geocoder(){if(!services.geocoder){services.geocoder=new gm.Geocoder();}
return services.geocoder;}
function GeocoderCache(){var cache=[];this.get=function(request){if(cache.length){var i,j,k,item,eq,keys=getKeys(request);for(i=0;i<cache.length;i++){item=cache[i];eq=keys.length===item.keys.length;for(j=0;(j<keys.length)&&eq;j++){k=keys[j];eq=k in item.request;if(eq){if(isObject(request[k])&&("equals"in request[k])&&isFunction(request[k])){eq=request[k].equals(item.request[k]);}else{eq=request[k]===item.request[k];}}}
if(eq){return item.results;}}}};this.store=function(request,results){cache.push({request:request,keys:getKeys(request),results:results});};}
function Stack(){var st=[],self=this;self.empty=function(){return!st.length;};self.add=function(v){st.push(v);};self.get=function(){return st.length?st[0]:false;};self.ack=function(){st.shift();};}
function Store(){var store={},objects={},self=this;function normalize(res){return{id:res.id,name:res.name,object:res.obj,tag:res.tag,data:res.data};}
self.add=function(args,name,obj,sub){var td=args.td||{},id=globalId(td.id);if(!store[name]){store[name]=[];}
if(id in objects){self.clearById(id);}
objects[id]={obj:obj,sub:sub,name:name,id:id,tag:td.tag,data:td.data};store[name].push(id);return id;};self.getById=function(id,sub,full){var result=false;if(id in objects){if(sub){result=objects[id].sub;}else if(full){result=normalize(objects[id]);}else{result=objects[id].obj;}}
return result;};self.get=function(name,last,tag,full){var n,id,check=ftag(tag);if(!store[name]||!store[name].length){return null;}
n=store[name].length;while(n){n--;id=store[name][last?n:store[name].length-n-1];if(id&&objects[id]){if(check&&!check(objects[id].tag)){continue;}
return full?normalize(objects[id]):objects[id].obj;}}
return null;};self.all=function(name,tag,full){var result=[],check=ftag(tag),find=function(n){var i,id;for(i=0;i<store[n].length;i++){id=store[n][i];if(id&&objects[id]){if(check&&!check(objects[id].tag)){continue;}
result.push(full?normalize(objects[id]):objects[id].obj);}}};if(name in store){find(name);}else if(isUndefined(name)){for(name in store){find(name);}}
return result;};function rm(obj){if(isFunction(obj.setMap)){obj.setMap(null);}
if(isFunction(obj.remove)){obj.remove();}
if(isFunction(obj.free)){obj.free();}
obj=null;}
self.rm=function(name,check,pop){var idx,id;if(!store[name]){return false;}
if(check){if(pop){for(idx=store[name].length-1;idx>=0;idx--){id=store[name][idx];if(check(objects[id].tag)){break;}}}else{for(idx=0;idx<store[name].length;idx++){id=store[name][idx];if(check(objects[id].tag)){break;}}}}else{idx=pop?store[name].length-1:0;}
if(!(idx in store[name])){return false;}
return self.clearById(store[name][idx],idx);};self.clearById=function(id,idx){if(id in objects){var i,name=objects[id].name;for(i=0;isUndefined(idx)&&i<store[name].length;i++){if(id===store[name][i]){idx=i;}}
rm(objects[id].obj);if(objects[id].sub){rm(objects[id].sub);}
delete objects[id];store[name].splice(idx,1);return true;}
return false;};self.objGetById=function(id){var result,idx;if(store.clusterer){for(idx in store.clusterer){if((result=objects[store.clusterer[idx]].obj.getById(id))!==false){return result;}}}
return false;};self.objClearById=function(id){var idx;if(store.clusterer){for(idx in store.clusterer){if(objects[store.clusterer[idx]].obj.clearById(id)){return true;}}}
return null;};self.clear=function(list,last,first,tag){var k,i,name,check=ftag(tag);if(!list||!list.length){list=[];for(k in store){list.push(k);}}else{list=array(list);}
for(i=0;i<list.length;i++){name=list[i];if(last){self.rm(name,check,true);}else if(first){self.rm(name,check,false);}else{while(self.rm(name,check,false)){}}}};self.objClear=function(list,last,first,tag){var idx;if(store.clusterer&&($.inArray("marker",list)>=0||!list.length)){for(idx in store.clusterer){objects[store.clusterer[idx]].obj.clear(last,first,tag);}}};}
function Task(ctx,onEnd,td){var session={},self=this,current,resolve={latLng:{map:false,marker:false,infowindow:false,circle:false,overlay:false,getlatlng:false,getmaxzoom:false,getelevation:false,streetviewpanorama:false,getaddress:true},geoloc:{getgeoloc:true}};function unify(td){var result={};result[td]={};return result;}
if(isString(td)){td=unify(td);}
function next(){var k;for(k in td){if(td.hasOwnProperty(k)&&!session.hasOwnProperty(k)){return k;}}}
self.run=function(){var k,opts;while(k=next()){if(isFunction(ctx[k])){current=k;opts=$.extend(true,{},defaults[k]||{},td[k].options||{});if(k in resolve.latLng){if(td[k].values){resolveAllLatLng(td[k].values,ctx,ctx[k],{td:td[k],opts:opts,session:session});}else{resolveLatLng(ctx,ctx[k],resolve.latLng[k],{td:td[k],opts:opts,session:session});}}else if(k in resolve.geoloc){geoloc(ctx,ctx[k],{td:td[k],opts:opts,session:session});}else{ctx[k].apply(ctx,[{td:td[k],opts:opts,session:session}]);}
return;}else{session[k]=null;}}
onEnd.apply(ctx,[td,session]);};self.ack=function(result){session[current]=result;self.run.apply(self,[]);};}
function directionsService(){if(!services.ds){services.ds=new gm.DirectionsService();}
return services.ds;}
function distanceMatrixService(){if(!services.dms){services.dms=new gm.DistanceMatrixService();}
return services.dms;}
function maxZoomService(){if(!services.mzs){services.mzs=new gm.MaxZoomService();}
return services.mzs;}
function elevationService(){if(!services.es){services.es=new gm.ElevationService();}
return services.es;}
function newEmptyOverlay(map,radius){function Overlay(){var self=this;self.onAdd=function(){};self.onRemove=function(){};self.draw=function(){};return defaults.classes.OverlayView.apply(self,[]);}
Overlay.prototype=defaults.classes.OverlayView.prototype;var obj=new Overlay();obj.setMap(map);return obj;}
function InternalClusterer($container,map,raw){var timer,projection,ffilter,fdisplay,ferror,updating=false,updated=false,redrawing=false,ready=false,enabled=true,self=this,events=[],store={},ids={},idxs={},markers=[],tds=[],values=[],overlay=newEmptyOverlay(map,raw.radius);main();function prepareMarker(index){if(!markers[index]){delete tds[index].options.map;markers[index]=new defaults.classes.Marker(tds[index].options);attachEvents($container,{td:tds[index]},markers[index],tds[index].id);}}
self.getById=function(id){if(id in ids){prepareMarker(ids[id]);return markers[ids[id]];}
return false;};self.rm=function(id){var index=ids[id];if(markers[index]){markers[index].setMap(null);}
delete markers[index];markers[index]=false;delete tds[index];tds[index]=false;delete values[index];values[index]=false;delete ids[id];delete idxs[index];updated=true;};self.clearById=function(id){if(id in ids){self.rm(id);return true;}};self.clear=function(last,first,tag){var start,stop,step,index,i,list=[],check=ftag(tag);if(last){start=tds.length-1;stop=-1;step=-1;}else{start=0;stop=tds.length;step=1;}
for(index=start;index!==stop;index+=step){if(tds[index]){if(!check||check(tds[index].tag)){list.push(idxs[index]);if(first||last){break;}}}}
for(i=0;i<list.length;i++){self.rm(list[i]);}};self.add=function(td,value){td.id=globalId(td.id);self.clearById(td.id);ids[td.id]=markers.length;idxs[markers.length]=td.id;markers.push(null);tds.push(td);values.push(value);updated=true;};self.addMarker=function(marker,td){td=td||{};td.id=globalId(td.id);self.clearById(td.id);if(!td.options){td.options={};}
td.options.position=marker.getPosition();attachEvents($container,{td:td},marker,td.id);ids[td.id]=markers.length;idxs[markers.length]=td.id;markers.push(marker);tds.push(td);values.push(td.data||{});updated=true;};self.td=function(index){return tds[index];};self.value=function(index){return values[index];};self.marker=function(index){if(index in markers){prepareMarker(index);return markers[index];}
return false;};self.markerIsSet=function(index){return Boolean(markers[index]);};self.setMarker=function(index,marker){markers[index]=marker;};self.store=function(cluster,obj,shadow){store[cluster.ref]={obj:obj,shadow:shadow};};self.free=function(){var i;for(i=0;i<events.length;i++){gm.event.removeListener(events[i]);}
events=[];$.each(store,function(key){flush(key);});store={};$.each(tds,function(i){tds[i]=null;});tds=[];$.each(markers,function(i){if(markers[i]){markers[i].setMap(null);delete markers[i];}});markers=[];$.each(values,function(i){delete values[i];});values=[];ids={};idxs={};};self.filter=function(f){ffilter=f;redraw();};self.enable=function(value){if(enabled!==value){enabled=value;redraw();}};self.display=function(f){fdisplay=f;};self.error=function(f){ferror=f;};self.beginUpdate=function(){updating=true;};self.endUpdate=function(){updating=false;if(updated){redraw();}};self.autofit=function(bounds){var i;for(i=0;i<tds.length;i++){if(tds[i]){bounds.extend(tds[i].options.position);}}};function main(){projection=overlay.getProjection();if(!projection){setTimeout(function(){main.apply(self,[]);},25);return;}
ready=true;events.push(gm.event.addListener(map,"zoom_changed",delayRedraw));events.push(gm.event.addListener(map,"bounds_changed",delayRedraw));redraw();}
function flush(key){if(isObject(store[key])){if(isFunction(store[key].obj.setMap)){store[key].obj.setMap(null);}
if(isFunction(store[key].obj.remove)){store[key].obj.remove();}
if(isFunction(store[key].shadow.remove)){store[key].obj.remove();}
if(isFunction(store[key].shadow.setMap)){store[key].shadow.setMap(null);}
delete store[key].obj;delete store[key].shadow;}else if(markers[key]){markers[key].setMap(null);}
delete store[key];}
function distanceInMeter(){var lat1,lat2,lng1,lng2,e,f,g,h,cos=Math.cos,sin=Math.sin,args=arguments;if(args[0]instanceof gm.LatLng){lat1=args[0].lat();lng1=args[0].lng();if(args[1]instanceof gm.LatLng){lat2=args[1].lat();lng2=args[1].lng();}else{lat2=args[1];lng2=args[2];}}else{lat1=args[0];lng1=args[1];if(args[2]instanceof gm.LatLng){lat2=args[2].lat();lng2=args[2].lng();}else{lat2=args[2];lng2=args[3];}}
e=Math.PI*lat1/180;f=Math.PI*lng1/180;g=Math.PI*lat2/180;h=Math.PI*lng2/180;return 1000*6371*Math.acos(Math.min(cos(e)*cos(g)*cos(f)*cos(h)+cos(e)*sin(f)*cos(g)*sin(h)+sin(e)*sin(g),1));}
function extendsMapBounds(){var radius=distanceInMeter(map.getCenter(),map.getBounds().getNorthEast()),circle=new gm.Circle({center:map.getCenter(),radius:1.25*radius});return circle.getBounds();}
function getStoreKeys(){var k,keys={};for(k in store){keys[k]=true;}
return keys;}
function delayRedraw(){clearTimeout(timer);timer=setTimeout(redraw,25);}
function extendsBounds(latLng){var p=projection.fromLatLngToDivPixel(latLng),ne=projection.fromDivPixelToLatLng(new gm.Point(p.x+raw.radius,p.y-raw.radius)),sw=projection.fromDivPixelToLatLng(new gm.Point(p.x-raw.radius,p.y+raw.radius));return new gm.LatLngBounds(sw,ne);}
function redraw(){if(updating||redrawing||!ready){return;}
var i,j,k,indexes,check=false,bounds,cluster,position,previous,lat,lng,loop,keys=[],used={},zoom=map.getZoom(),forceDisabled=("maxZoom"in raw)&&(zoom>raw.maxZoom),previousKeys=getStoreKeys();updated=false;if(zoom>3){bounds=extendsMapBounds();check=bounds.getSouthWest().lng()<bounds.getNorthEast().lng();}
for(i=0;i<tds.length;i++){if(tds[i]&&(!check||bounds.contains(tds[i].options.position))&&(!ffilter||ffilter(values[i]))){keys.push(i);}}
while(1){i=0;while(used[i]&&(i<keys.length)){i++;}
if(i===keys.length){break;}
indexes=[];if(enabled&&!forceDisabled){loop=10;do{previous=indexes;indexes=[];loop--;if(previous.length){position=bounds.getCenter();}else{position=tds[keys[i]].options.position;}
bounds=extendsBounds(position);for(j=i;j<keys.length;j++){if(used[j]){continue;}
if(bounds.contains(tds[keys[j]].options.position)){indexes.push(j);}}}while((previous.length<indexes.length)&&(indexes.length>1)&&loop);}else{for(j=i;j<keys.length;j++){if(!used[j]){indexes.push(j);break;}}}
cluster={indexes:[],ref:[]};lat=lng=0;for(k=0;k<indexes.length;k++){used[indexes[k]]=true;cluster.indexes.push(keys[indexes[k]]);cluster.ref.push(keys[indexes[k]]);lat+=tds[keys[indexes[k]]].options.position.lat();lng+=tds[keys[indexes[k]]].options.position.lng();}
lat/=indexes.length;lng/=indexes.length;cluster.latLng=new gm.LatLng(lat,lng);cluster.ref=cluster.ref.join("-");if(cluster.ref in previousKeys){delete previousKeys[cluster.ref];}else{if(indexes.length===1){store[cluster.ref]=true;}
fdisplay(cluster);}}
$.each(previousKeys,function(key){flush(key);});redrawing=false;}}
function Clusterer(id,internalClusterer){var self=this;self.id=function(){return id;};self.filter=function(f){internalClusterer.filter(f);};self.enable=function(){internalClusterer.enable(true);};self.disable=function(){internalClusterer.enable(false);};self.add=function(marker,td,lock){if(!lock){internalClusterer.beginUpdate();}
internalClusterer.addMarker(marker,td);if(!lock){internalClusterer.endUpdate();}};self.getById=function(id){return internalClusterer.getById(id);};self.clearById=function(id,lock){var result;if(!lock){internalClusterer.beginUpdate();}
result=internalClusterer.clearById(id);if(!lock){internalClusterer.endUpdate();}
return result;};self.clear=function(last,first,tag,lock){if(!lock){internalClusterer.beginUpdate();}
internalClusterer.clear(last,first,tag);if(!lock){internalClusterer.endUpdate();}};}
function OverlayView(map,opts,latLng,$div){var self=this,listeners=[];defaults.classes.OverlayView.call(self);self.setMap(map);self.onAdd=function(){var panes=self.getPanes();if(opts.pane in panes){$(panes[opts.pane]).append($div);}
$.each("dblclick click mouseover mousemove mouseout mouseup mousedown".split(" "),function(i,name){listeners.push(gm.event.addDomListener($div[0],name,function(e){$.Event(e).stopPropagation();gm.event.trigger(self,name,[e]);self.draw();}));});listeners.push(gm.event.addDomListener($div[0],"contextmenu",function(e){$.Event(e).stopPropagation();gm.event.trigger(self,"rightclick",[e]);self.draw();}));};self.getPosition=function(){return latLng;};self.setPosition=function(newLatLng){latLng=newLatLng;self.draw();};self.draw=function(){var ps=self.getProjection().fromLatLngToDivPixel(latLng);$div.css("left",(ps.x+opts.offset.x)+"px").css("top",(ps.y+opts.offset.y)+"px");};self.onRemove=function(){var i;for(i=0;i<listeners.length;i++){gm.event.removeListener(listeners[i]);}
$div.remove();};self.hide=function(){$div.hide();};self.show=function(){$div.show();};self.toggle=function(){if($div){if($div.is(":visible")){self.show();}else{self.hide();}}};self.toggleDOM=function(){self.setMap(self.getMap()?null:map);};self.getDOMElement=function(){return $div[0];};}
function Gmap3($this){var self=this,stack=new Stack(),store=new Store(),map=null,task;function run(){if(!task&&(task=stack.get())){task.run();}}
function end(){task=null;stack.ack();run.call(self);}
function callback(args){var params,cb=args.td.callback;if(cb){params=Array.prototype.slice.call(arguments,1);if(isFunction(cb)){cb.apply($this,params);}else if(isArray(cb)){if(isFunction(cb[1])){cb[1].apply(cb[0],params);}}}}
function manageEnd(args,obj,id){if(id){attachEvents($this,args,obj,id);}
callback(args,obj);task.ack(obj);}
function newMap(latLng,args){args=args||{};var opts=args.td&&args.td.options?args.td.options:0;if(map){if(opts){if(opts.center){opts.center=toLatLng(opts.center);}
map.setOptions(opts);}}else{opts=args.opts||$.extend(true,{},defaults.map,opts||{});opts.center=latLng||toLatLng(opts.center);map=new defaults.classes.Map($this.get(0),opts);}}
self._plan=function(list){var k;for(k=0;k<list.length;k++){stack.add(new Task(self,end,list[k]));}
run();};self.map=function(args){newMap(args.latLng,args);attachEvents($this,args,map);manageEnd(args,map);};self.destroy=function(args){store.clear();$this.empty();if(map){map=null;}
manageEnd(args,true);};self.overlay=function(args,internal){var objs=[],multiple="values"in args.td;if(!multiple){args.td.values=[{latLng:args.latLng,options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
if(!OverlayView.__initialised){OverlayView.prototype=new defaults.classes.OverlayView();OverlayView.__initialised=true;}
$.each(args.td.values,function(i,value){var id,obj,td=tuple(args,value),$div=$(document.createElement("div")).css({border:"none",borderWidth:0,position:"absolute"});$div.append(td.options.content);obj=new OverlayView(map,td.options,toLatLng(td)||toLatLng(value),$div);objs.push(obj);$div=null;if(!internal){id=store.add(args,"overlay",obj);attachEvents($this,{td:td},obj,id);}});if(internal){return objs[0];}
manageEnd(args,multiple?objs:objs[0]);};function createClusterer(raw){var internalClusterer=new InternalClusterer($this,map,raw),td={},styles={},thresholds=[],isInt=/^[0-9]+$/,calculator,k;for(k in raw){if(isInt.test(k)){thresholds.push(1*k);styles[k]=raw[k];styles[k].width=styles[k].width||0;styles[k].height=styles[k].height||0;}else{td[k]=raw[k];}}
thresholds.sort(function(a,b){return a>b;});if(td.calculator){calculator=function(indexes){var data=[];$.each(indexes,function(i,index){data.push(internalClusterer.value(index));});return td.calculator.apply($this,[data]);};}else{calculator=function(indexes){return indexes.length;};}
internalClusterer.error(function(){error.apply(self,arguments);});internalClusterer.display(function(cluster){var i,style,atd,obj,offset,shadow,cnt=calculator(cluster.indexes);if(raw.force||cnt>1){for(i=0;i<thresholds.length;i++){if(thresholds[i]<=cnt){style=styles[thresholds[i]];}}}
if(style){offset=style.offset||[-style.width/2,-style.height/2];atd=$.extend({},td);atd.options=$.extend({pane:"overlayLayer",content:style.content?style.content.replace("CLUSTER_COUNT",cnt):"",offset:{x:("x"in offset?offset.x:offset[0])||0,y:("y"in offset?offset.y:offset[1])||0}},td.options||{});obj=self.overlay({td:atd,opts:atd.options,latLng:toLatLng(cluster)},true);atd.options.pane="floatShadow";atd.options.content=$(document.createElement("div")).width(style.width+"px").height(style.height+"px").css({cursor:"pointer"});shadow=self.overlay({td:atd,opts:atd.options,latLng:toLatLng(cluster)},true);td.data={latLng:toLatLng(cluster),markers:[]};$.each(cluster.indexes,function(i,index){td.data.markers.push(internalClusterer.value(index));if(internalClusterer.markerIsSet(index)){internalClusterer.marker(index).setMap(null);}});attachEvents($this,{td:td},shadow,undef,{main:obj,shadow:shadow});internalClusterer.store(cluster,obj,shadow);}else{$.each(cluster.indexes,function(i,index){internalClusterer.marker(index).setMap(map);});}});return internalClusterer;}
self.marker=function(args){var objs,clusterer,internalClusterer,multiple="values"in args.td,init=!map;if(!multiple){args.opts.position=args.latLng||toLatLng(args.opts.position);args.td.values=[{options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
if(init){newMap();}
if(args.td.cluster&&!map.getBounds()){gm.event.addListenerOnce(map,"bounds_changed",function(){self.marker.apply(self,[args]);});return;}
if(args.td.cluster){if(args.td.cluster instanceof Clusterer){clusterer=args.td.cluster;internalClusterer=store.getById(clusterer.id(),true);}else{internalClusterer=createClusterer(args.td.cluster);clusterer=new Clusterer(globalId(args.td.id,true),internalClusterer);store.add(args,"clusterer",clusterer,internalClusterer);}
internalClusterer.beginUpdate();$.each(args.td.values,function(i,value){var td=tuple(args,value);td.options.position=td.options.position?toLatLng(td.options.position):toLatLng(value);if(td.options.position){td.options.map=map;if(init){map.setCenter(td.options.position);init=false;}
internalClusterer.add(td,value);}});internalClusterer.endUpdate();manageEnd(args,clusterer);}else{objs=[];$.each(args.td.values,function(i,value){var id,obj,td=tuple(args,value);td.options.position=td.options.position?toLatLng(td.options.position):toLatLng(value);if(td.options.position){td.options.map=map;if(init){map.setCenter(td.options.position);init=false;}
obj=new defaults.classes.Marker(td.options);objs.push(obj);id=store.add({td:td},"marker",obj);attachEvents($this,{td:td},obj,id);}});manageEnd(args,multiple?objs:objs[0]);}};self.getroute=function(args){args.opts.origin=toLatLng(args.opts.origin,true);args.opts.destination=toLatLng(args.opts.destination,true);directionsService().route(args.opts,function(results,status){callback(args,status===gm.DirectionsStatus.OK?results:false,status);task.ack();});};self.getdistance=function(args){var i;args.opts.origins=array(args.opts.origins);for(i=0;i<args.opts.origins.length;i++){args.opts.origins[i]=toLatLng(args.opts.origins[i],true);}
args.opts.destinations=array(args.opts.destinations);for(i=0;i<args.opts.destinations.length;i++){args.opts.destinations[i]=toLatLng(args.opts.destinations[i],true);}
distanceMatrixService().getDistanceMatrix(args.opts,function(results,status){callback(args,status===gm.DistanceMatrixStatus.OK?results:false,status);task.ack();});};self.infowindow=function(args){var objs=[],multiple="values"in args.td;if(!multiple){if(args.latLng){args.opts.position=args.latLng;}
args.td.values=[{options:args.opts}];}
$.each(args.td.values,function(i,value){var id,obj,td=tuple(args,value);td.options.position=td.options.position?toLatLng(td.options.position):toLatLng(value.latLng);if(!map){newMap(td.options.position);}
obj=new defaults.classes.InfoWindow(td.options);if(obj&&(isUndefined(td.open)||td.open)){if(multiple){obj.open(map,td.anchor||undef);}else{obj.open(map,td.anchor||(args.latLng?undef:(args.session.marker?args.session.marker:undef)));}}
objs.push(obj);id=store.add({td:td},"infowindow",obj);attachEvents($this,{td:td},obj,id);});manageEnd(args,multiple?objs:objs[0]);};self.circle=function(args){var objs=[],multiple="values"in args.td;if(!multiple){args.opts.center=args.latLng||toLatLng(args.opts.center);args.td.values=[{options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
$.each(args.td.values,function(i,value){var id,obj,td=tuple(args,value);td.options.center=td.options.center?toLatLng(td.options.center):toLatLng(value);if(!map){newMap(td.options.center);}
td.options.map=map;obj=new defaults.classes.Circle(td.options);objs.push(obj);id=store.add({td:td},"circle",obj);attachEvents($this,{td:td},obj,id);});manageEnd(args,multiple?objs:objs[0]);};self.getaddress=function(args){callback(args,args.results,args.status);task.ack();};self.getlatlng=function(args){callback(args,args.results,args.status);task.ack();};self.getmaxzoom=function(args){maxZoomService().getMaxZoomAtLatLng(args.latLng,function(result){callback(args,result.status===gm.MaxZoomStatus.OK?result.zoom:false,status);task.ack();});};self.getelevation=function(args){var i,locations=[],f=function(results,status){callback(args,status===gm.ElevationStatus.OK?results:false,status);task.ack();};if(args.latLng){locations.push(args.latLng);}else{locations=array(args.td.locations||[]);for(i=0;i<locations.length;i++){locations[i]=toLatLng(locations[i]);}}
if(locations.length){elevationService().getElevationForLocations({locations:locations},f);}else{if(args.td.path&&args.td.path.length){for(i=0;i<args.td.path.length;i++){locations.push(toLatLng(args.td.path[i]));}}
if(locations.length){elevationService().getElevationAlongPath({path:locations,samples:args.td.samples},f);}else{task.ack();}}};self.defaults=function(args){$.each(args.td,function(name,value){if(isObject(defaults[name])){defaults[name]=$.extend({},defaults[name],value);}else{defaults[name]=value;}});task.ack(true);};self.rectangle=function(args){var objs=[],multiple="values"in args.td;if(!multiple){args.td.values=[{options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
$.each(args.td.values,function(i,value){var id,obj,td=tuple(args,value);td.options.bounds=td.options.bounds?toLatLngBounds(td.options.bounds):toLatLngBounds(value);if(!map){newMap(td.options.bounds.getCenter());}
td.options.map=map;obj=new defaults.classes.Rectangle(td.options);objs.push(obj);id=store.add({td:td},"rectangle",obj);attachEvents($this,{td:td},obj,id);});manageEnd(args,multiple?objs:objs[0]);};function poly(args,poly,path){var objs=[],multiple="values"in args.td;if(!multiple){args.td.values=[{options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
newMap();$.each(args.td.values,function(_,value){var id,i,j,obj,td=tuple(args,value);if(td.options[path]){if(td.options[path][0][0]&&isArray(td.options[path][0][0])){for(i=0;i<td.options[path].length;i++){for(j=0;j<td.options[path][i].length;j++){td.options[path][i][j]=toLatLng(td.options[path][i][j]);}}}else{for(i=0;i<td.options[path].length;i++){td.options[path][i]=toLatLng(td.options[path][i]);}}}
td.options.map=map;obj=new gm[poly](td.options);objs.push(obj);id=store.add({td:td},poly.toLowerCase(),obj);attachEvents($this,{td:td},obj,id);});manageEnd(args,multiple?objs:objs[0]);}
self.polyline=function(args){poly(args,"Polyline","path");};self.polygon=function(args){poly(args,"Polygon","paths");};self.trafficlayer=function(args){newMap();var obj=store.get("trafficlayer");if(!obj){obj=new defaults.classes.TrafficLayer();obj.setMap(map);store.add(args,"trafficlayer",obj);}
manageEnd(args,obj);};self.bicyclinglayer=function(args){newMap();var obj=store.get("bicyclinglayer");if(!obj){obj=new defaults.classes.BicyclingLayer();obj.setMap(map);store.add(args,"bicyclinglayer",obj);}
manageEnd(args,obj);};self.groundoverlay=function(args){args.opts.bounds=toLatLngBounds(args.opts.bounds);if(args.opts.bounds){newMap(args.opts.bounds.getCenter());}
var id,obj=new defaults.classes.GroundOverlay(args.opts.url,args.opts.bounds,args.opts.opts);obj.setMap(map);id=store.add(args,"groundoverlay",obj);manageEnd(args,obj,id);};self.streetviewpanorama=function(args){if(!args.opts.opts){args.opts.opts={};}
if(args.latLng){args.opts.opts.position=args.latLng;}else if(args.opts.opts.position){args.opts.opts.position=toLatLng(args.opts.opts.position);}
if(args.td.divId){args.opts.container=document.getElementById(args.td.divId);}else if(args.opts.container){args.opts.container=$(args.opts.container).get(0);}
var id,obj=new defaults.classes.StreetViewPanorama(args.opts.container,args.opts.opts);if(obj){map.setStreetView(obj);}
id=store.add(args,"streetviewpanorama",obj);manageEnd(args,obj,id);};self.kmllayer=function(args){var objs=[],multiple="values"in args.td;if(!multiple){args.td.values=[{options:args.opts}];}
if(!args.td.values.length){manageEnd(args,false);return;}
$.each(args.td.values,function(i,value){var id,obj,options,td=tuple(args,value);if(!map){newMap();}
options=td.options;if(td.options.opts){options=td.options.opts;if(td.options.url){options.url=td.options.url;}}
options.map=map;if(googleVersionMin("3.10")){obj=new defaults.classes.KmlLayer(options);}else{obj=new defaults.classes.KmlLayer(options.url,options);}
objs.push(obj);id=store.add({td:td},"kmllayer",obj);attachEvents($this,{td:td},obj,id);});manageEnd(args,multiple?objs:objs[0]);};self.panel=function(args){newMap();var id,$content,x=0,y=0,$div=$(document.createElement("div"));$div.css({position:"absolute",zIndex:1000,visibility:"hidden"});if(args.opts.content){$content=$(args.opts.content);$div.append($content);$this.first().prepend($div);if(!isUndefined(args.opts.left)){x=args.opts.left;}else if(!isUndefined(args.opts.right)){x=$this.width()-$content.width()-args.opts.right;}else if(args.opts.center){x=($this.width()-$content.width())/2;}
if(!isUndefined(args.opts.top)){y=args.opts.top;}else if(!isUndefined(args.opts.bottom)){y=$this.height()-$content.height()-args.opts.bottom;}else if(args.opts.middle){y=($this.height()-$content.height())/2}
$div.css({top:y,left:x,visibility:"visible"});}
id=store.add(args,"panel",$div);manageEnd(args,$div,id);$div=null;};self.directionsrenderer=function(args){args.opts.map=map;var id,obj=new gm.DirectionsRenderer(args.opts);if(args.td.divId){obj.setPanel(document.getElementById(args.td.divId));}else if(args.td.container){obj.setPanel($(args.td.container).get(0));}
id=store.add(args,"directionsrenderer",obj);manageEnd(args,obj,id);};self.getgeoloc=function(args){manageEnd(args,args.latLng);};self.styledmaptype=function(args){newMap();var obj=new defaults.classes.StyledMapType(args.td.styles,args.opts);map.mapTypes.set(args.td.id,obj);manageEnd(args,obj);};self.imagemaptype=function(args){newMap();var obj=new defaults.classes.ImageMapType(args.opts);map.mapTypes.set(args.td.id,obj);manageEnd(args,obj);};self.autofit=function(args){var bounds=new gm.LatLngBounds();$.each(store.all(),function(i,obj){if(obj.getPosition){bounds.extend(obj.getPosition());}else if(obj.getBounds){bounds.extend(obj.getBounds().getNorthEast());bounds.extend(obj.getBounds().getSouthWest());}else if(obj.getPaths){obj.getPaths().forEach(function(path){path.forEach(function(latLng){bounds.extend(latLng);});});}else if(obj.getPath){obj.getPath().forEach(function(latLng){bounds.extend(latLng);});}else if(obj.getCenter){bounds.extend(obj.getCenter());}else if(typeof Clusterer==="function"&&obj instanceof Clusterer){obj=store.getById(obj.id(),true);if(obj){obj.autofit(bounds);}}});if(!bounds.isEmpty()&&(!map.getBounds()||!map.getBounds().equals(bounds))){if("maxZoom"in args.td){gm.event.addListenerOnce(map,"bounds_changed",function(){if(this.getZoom()>args.td.maxZoom){this.setZoom(args.td.maxZoom);}});}
map.fitBounds(bounds);}
manageEnd(args,true);};self.clear=function(args){if(isString(args.td)){if(store.clearById(args.td)||store.objClearById(args.td)){manageEnd(args,true);return;}
args.td={name:args.td};}
if(args.td.id){$.each(array(args.td.id),function(i,id){store.clearById(id)||store.objClearById(id);});}else{store.clear(array(args.td.name),args.td.last,args.td.first,args.td.tag);store.objClear(array(args.td.name),args.td.last,args.td.first,args.td.tag);}
manageEnd(args,true);};self.get=function(args,direct,full){var name,res,td=direct?args:args.td;if(!direct){full=td.full;}
if(isString(td)){res=store.getById(td,false,full)||store.objGetById(td);if(res===false){name=td;td={};}}else{name=td.name;}
if(name==="map"){res=map;}
if(!res){res=[];if(td.id){$.each(array(td.id),function(i,id){res.push(store.getById(id,false,full)||store.objGetById(id));});if(!isArray(td.id)){res=res[0];}}else{$.each(name?array(name):[undef],function(i,aName){var result;if(td.first){result=store.get(aName,false,td.tag,full);if(result){res.push(result);}}else if(td.all){$.each(store.all(aName,td.tag,full),function(i,result){res.push(result);});}else{result=store.get(aName,true,td.tag,full);if(result){res.push(result);}}});if(!td.all&&!isArray(name)){res=res[0];}}}
res=isArray(res)||!td.all?res:[res];if(direct){return res;}else{manageEnd(args,res);}};self.exec=function(args){$.each(array(args.td.func),function(i,func){$.each(self.get(args.td,true,args.td.hasOwnProperty("full")?args.td.full:true),function(j,res){func.call($this,res);});});manageEnd(args,true);};self.trigger=function(args){if(isString(args.td)){gm.event.trigger(map,args.td);}else{var options=[map,args.td.eventName];if(args.td.var_args){$.each(args.td.var_args,function(i,v){options.push(v);});}
gm.event.trigger.apply(gm.event,options);}
callback(args);task.ack();};}
$.fn.gmap3=function(){var i,list=[],empty=true,results=[];initDefaults();for(i=0;i<arguments.length;i++){if(arguments[i]){list.push(arguments[i]);}}
if(!list.length){list.push("map");}
$.each(this,function(){var $this=$(this),gmap3=$this.data("gmap3");empty=false;if(!gmap3){gmap3=new Gmap3($this);$this.data("gmap3",gmap3);}
if(list.length===1&&(list[0]==="get"||isDirectGet(list[0]))){if(list[0]==="get"){results.push(gmap3.get("map",true));}else{results.push(gmap3.get(list[0].get,true,list[0].get.full));}}else{gmap3._plan(list);}});if(results.length){if(results.length===1){return results[0];}
return results;}
return this;};})(jQuery);