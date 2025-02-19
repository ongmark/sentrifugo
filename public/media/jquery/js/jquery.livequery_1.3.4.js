/*! Copyright 
 *  (c) 2010, Brandon Aaron (https://brandonaaron.net)
 *  (c) 2012 - 2013, Alexander Zaytsev (https://hazzik.ru/en)
 * Dual licensed under the MIT (MIT_LICENSE.txt)
 * and GPL Version 2 (GPL_LICENSE.txt) licenses.
 *
 * Version: 1.3.4
 * Requires jQuery 1.3+
 * Docs: https://docs.jquery.com/Plugins/livequery
 * 
 * Downloaded on 07-aug-2013 by k.rama krishna
 */
(function(b,d){function c(g,h,f,e){return g.selector==h.selector&&g.context==h.context&&(!f||f.$lqguid==h.fn.$lqguid)&&(!e||e.$lqguid==h.fn2.$lqguid)}b.extend(b.fn,{livequery:function(f,e){var g=this,h;b.each(a.queries,function(j,k){if(c(g,k,f,e)){return(h=k)&&false}});h=h||new a(g.selector,g.context,f,e);h.stopped=false;h.run();return g},expire:function(f,e){var g=this;b.each(a.queries,function(h,j){if(c(g,j,f,e)&&!g.stopped){a.stop(j.id)}});return g}});var a=b.livequery=function(e,g,h,f){var i=this;i.selector=e;i.context=g;i.fn=h;i.fn2=f;i.elements=b([]);i.stopped=false;i.id=a.queries.push(i)-1;h.$lqguid=h.$lqguid||a.guid++;if(f){f.$lqguid=f.$lqguid||a.guid++}return i};a.prototype={stop:function(){var e=this;if(e.stopped){return}if(e.fn2){e.elements.each(e.fn2)}e.elements=b([]);e.stopped=true},run:function(){var f=this;if(f.stopped){return}var h=f.elements,e=b(f.selector,f.context),i=e.not(h),g=h.not(e);f.elements=e;i.each(f.fn);if(f.fn2){g.each(f.fn2)}}};b.extend(a,{guid:0,queries:[],queue:[],running:false,timeout:null,registered:[],checkQueue:function(){if(a.running&&a.queue.length){var e=a.queue.length;while(e--){a.queries[a.queue.shift()].run()}}},pause:function(){a.running=false},play:function(){a.running=true;a.run()},registerPlugin:function(){b.each(arguments,function(f,g){if(!b.fn[g]||a.registered.indexOf(g)>0){return}var e=b.fn[g];b.fn[g]=function(){var h=e.apply(this,arguments);a.run();return h};a.registered.push(g)})},run:function(e){if(e!=d){if(b.inArray(e,a.queue)<0){a.queue.push(e)}}else{b.each(a.queries,function(f){if(b.inArray(f,a.queue)<0){a.queue.push(f)}})}if(a.timeout){clearTimeout(a.timeout)}a.timeout=setTimeout(a.checkQueue,20)},stop:function(e){if(e!=d){a.queries[e].stop()}else{b.each(a.queries,a.prototype.stop)}}});a.registerPlugin("append","prepend","after","before","wrap","attr","removeAttr","addClass","removeClass","toggleClass","empty","remove","html","prop","removeProp");b(function(){a.play()})})(jQuery);