/* qTip2 v2.1.1 tips viewport | qtip2.com | Licensed MIT, GPL | Wed Oct 09 2013 12:22:35 */
!function(a,b,c){!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery","imagesloaded"],a):jQuery&&!jQuery.fn.qtip&&a(jQuery)}(function(d){function e(a,b,c,e){this.id=c,this.target=a,this.tooltip=C,this.elements=elements={target:a},this._id=P+"-"+c,this.timers={img:{}},this.options=b,this.plugins={},this.cache=cache={event:{},target:d(),disabled:B,attr:e,onTooltip:B,lastClass:""},this.rendered=this.destroyed=this.disabled=this.waiting=this.hiddenDuringWait=this.positioning=this.triggering=B}function f(a){return a===C||"object"!==d.type(a)}function g(a){return!(d.isFunction(a)||a&&a.attr||a.length||"object"===d.type(a)&&(a.jquery||a.then))}function h(a){var b,c,e,h;return f(a)?B:(f(a.metadata)&&(a.metadata={type:a.metadata}),"content"in a&&(b=a.content,f(b)||b.jquery||b.done?b=a.content={text:c=g(b)?B:b}:c=b.text,"ajax"in b&&(e=b.ajax,h=e&&e.once!==B,delete b.ajax,b.text=function(a,b){var f=c||d(this).attr(b.options.content.attr)||"Loading...",g=d.ajax(d.extend({},e,{context:b})).then(e.success,C,e.error).then(function(a){return a&&h&&b.set("content.text",a),a},function(a,c,d){b.destroyed||0===a.status||b.set("content.text",c+": "+d)});return h?f:(b.set("content.text",f),g)}),"title"in b&&(f(b.title)||(b.button=b.title.button,b.title=b.title.text),g(b.title||B)&&(b.title=B))),"position"in a&&f(a.position)&&(a.position={my:a.position,at:a.position}),"show"in a&&f(a.show)&&(a.show=a.show.jquery?{target:a.show}:a.show===A?{ready:A}:{event:a.show}),"hide"in a&&f(a.hide)&&(a.hide=a.hide.jquery?{target:a.hide}:{event:a.hide}),"style"in a&&f(a.style)&&(a.style={classes:a.style}),d.each(O,function(){this.sanitize&&this.sanitize(a)}),a)}function i(a,b){for(var c,d=0,e=a,f=b.split(".");e=e[f[d++]];)d<f.length&&(c=e);return[c||a,f.pop()]}function j(a,b){var c,d,e;for(c in this.checks)for(d in this.checks[c])(e=new RegExp(d,"i").exec(a))&&(b.push(e),("builtin"===c||this.plugins[c])&&this.checks[c][d].apply(this.plugins[c]||this,b))}function k(a){return S.concat("").join(a?"-"+a+" ":" ")}function l(a){if(this.tooltip.hasClass(Z))return B;clearTimeout(this.timers.show),clearTimeout(this.timers.hide);var b=d.proxy(function(){this.toggle(A,a)},this);this.options.show.delay>0?this.timers.show=setTimeout(b,this.options.show.delay):b()}function m(a){if(this.tooltip.hasClass(Z))return B;var b=d(a.relatedTarget),c=b.closest(T)[0]===this.tooltip[0],e=b[0]===this.options.show.target[0];if(clearTimeout(this.timers.show),clearTimeout(this.timers.hide),this!==b[0]&&"mouse"===this.options.position.target&&c||this.options.hide.fixed&&/mouse(out|leave|move)/.test(a.type)&&(c||e))try{a.preventDefault(),a.stopImmediatePropagation()}catch(f){}else{var g=d.proxy(function(){this.toggle(B,a)},this);this.options.hide.delay>0?this.timers.hide=setTimeout(g,this.options.hide.delay):g()}}function n(a){return this.tooltip.hasClass(Z)||!this.options.hide.inactive?B:(clearTimeout(this.timers.inactive),this.timers.inactive=setTimeout(d.proxy(function(){this.hide(a)},this),this.options.hide.inactive),void 0)}function o(a){this.rendered&&this.tooltip[0].offsetWidth>0&&this.reposition(a)}function p(a,c,e){d(b.body).delegate(a,(c.split?c:c.join(db+" "))+db,function(){var a=v.api[d.attr(this,R)];a&&!a.disabled&&e.apply(a,arguments)})}function q(a,c,f){var g,i,j,k,l,m=d(b.body),n=a[0]===b?m:a,o=a.metadata?a.metadata(f.metadata):C,p="html5"===f.metadata.type&&o?o[f.metadata.name]:C,q=a.data(f.metadata.name||"qtipopts");try{q="string"==typeof q?d.parseJSON(q):q}catch(r){}if(k=d.extend(A,{},v.defaults,f,"object"==typeof q?h(q):C,h(p||o)),i=k.position,k.id=c,"boolean"==typeof k.content.text){if(j=a.attr(k.content.attr),k.content.attr===B||!j)return B;k.content.text=j}if(i.container.length||(i.container=m),i.target===B&&(i.target=n),k.show.target===B&&(k.show.target=n),k.show.solo===A&&(k.show.solo=i.container.closest("body")),k.hide.target===B&&(k.hide.target=n),k.position.viewport===A&&(k.position.viewport=i.container),i.container=i.container.eq(0),i.at=new x(i.at,A),i.my=new x(i.my),a.data(P))if(k.overwrite)a.qtip("destroy");else if(k.overwrite===B)return B;return a.attr(Q,c),k.suppress&&(l=a.attr("title"))&&a.removeAttr("title").attr(_,l).attr("title",""),g=new e(a,k,c,!!j),a.data(P,g),a.one("remove.qtip-"+c+" removeqtip.qtip-"+c,function(){var a;(a=d(this).data(P))&&a.destroy()}),g}function r(a){return a.charAt(0).toUpperCase()+a.slice(1)}function s(a,b){var d,e,f=b.charAt(0).toUpperCase()+b.slice(1),g=(b+" "+ob.join(f+" ")+f).split(" "),h=0;if(nb[b])return a.css(nb[b]);for(;d=g[h++];)if((e=a.css(d))!==c)return nb[b]=d,e}function t(a,b){return parseInt(s(a,b),10)}function u(a,b){this._ns="tip",this.options=b,this.offset=b.offset,this.size=[b.width,b.height],this.init(this.qtip=a)}var v,w,x,y,z,A=!0,B=!1,C=null,D="x",E="y",F="width",G="height",H="top",I="left",J="bottom",K="right",L="center",M="flipinvert",N="shift",O={},P="qtip",Q="data-hasqtip",R="data-qtip-id",S=["ui-widget","ui-tooltip"],T="."+P,U="click dblclick mousedown mouseup mousemove mouseleave mouseenter".split(" "),V=P+"-fixed",W=P+"-default",X=P+"-focus",Y=P+"-hover",Z=P+"-disabled",$="_replacedByqTip",_="oldtitle";BROWSER={ie:function(){for(var a=3,c=b.createElement("div");(c.innerHTML="<!--[if gt IE "+ ++a+"]><i></i><![endif]-->")&&c.getElementsByTagName("i")[0];);return a>4?a:0/0}(),iOS:parseFloat((""+(/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent)||[0,""])[1]).replace("undefined","3_2").replace("_",".").replace("_",""))||B},w=e.prototype,w.render=function(a){if(this.rendered||this.destroyed)return this;var b=this,c=this.options,e=this.cache,f=this.elements,g=c.content.text,h=c.content.title,i=c.content.button,j=c.position,k="."+this._id+" ",l=[];return d.attr(this.target[0],"aria-describedby",this._id),this.tooltip=f.tooltip=tooltip=d("<div/>",{id:this._id,"class":[P,W,c.style.classes,P+"-pos-"+c.position.my.abbrev()].join(" "),width:c.style.width||"",height:c.style.height||"",tracking:"mouse"===j.target&&j.adjust.mouse,role:"alert","aria-live":"polite","aria-atomic":B,"aria-describedby":this._id+"-content","aria-hidden":A}).toggleClass(Z,this.disabled).attr(R,this.id).data(P,this).appendTo(j.container).append(f.content=d("<div />",{"class":P+"-content",id:this._id+"-content","aria-atomic":A})),this.rendered=-1,this.positioning=A,h&&(this._createTitle(),d.isFunction(h)||l.push(this._updateTitle(h,B))),i&&this._createButton(),d.isFunction(g)||l.push(this._updateContent(g,B)),this.rendered=A,this._setWidget(),d.each(c.events,function(a,b){d.isFunction(b)&&tooltip.bind(("toggle"===a?["tooltipshow","tooltiphide"]:["tooltip"+a]).join(k)+k,b)}),d.each(O,function(a){var c;"render"===this.initialize&&(c=this(b))&&(b.plugins[a]=c)}),this._assignEvents(),d.when.apply(d,l).then(function(){b._trigger("render"),b.positioning=B,b.hiddenDuringWait||!c.show.ready&&!a||b.toggle(A,e.event,B),b.hiddenDuringWait=B}),v.api[this.id]=this,this},w.destroy=function(a){function b(){if(!this.destroyed){this.destroyed=A;var a=this.target,b=a.attr(_);this.rendered&&this.tooltip.stop(1,0).find("*").remove().end().remove(),d.each(this.plugins,function(){this.destroy&&this.destroy()}),clearTimeout(this.timers.show),clearTimeout(this.timers.hide),this._unassignEvents(),a.removeData(P).removeAttr(R).removeAttr("aria-describedby"),this.options.suppress&&b&&a.attr("title",b).removeAttr(_),this._unbind(a),this.options=this.elements=this.cache=this.timers=this.plugins=this.mouse=C,delete v.api[this.id]}}return this.destroyed?this.target:(a!==A&&this.rendered?(tooltip.one("tooltiphidden",d.proxy(b,this)),!this.triggering&&this.hide()):b.call(this),this.target)},y=w.checks={builtin:{"^id$":function(a,b,c,e){var f=c===A?v.nextid:c,g=P+"-"+f;f!==B&&f.length>0&&!d("#"+g).length?(this._id=g,this.rendered&&(this.tooltip[0].id=this._id,this.elements.content[0].id=this._id+"-content",this.elements.title[0].id=this._id+"-title")):a[b]=e},"^prerender":function(a,b,c){c&&!this.rendered&&this.render(this.options.show.ready)},"^content.text$":function(a,b,c){this._updateContent(c)},"^content.attr$":function(a,b,c,d){this.options.content.text===this.target.attr(d)&&this._updateContent(this.target.attr(c))},"^content.title$":function(a,b,c){return c?(c&&!this.elements.title&&this._createTitle(),this._updateTitle(c),void 0):this._removeTitle()},"^content.button$":function(a,b,c){this._updateButton(c)},"^content.title.(text|button)$":function(a,b,c){this.set("content."+b,c)},"^position.(my|at)$":function(a,b,c){"string"==typeof c&&(a[b]=new x(c,"at"===b))},"^position.container$":function(a,b,c){this.tooltip.appendTo(c)},"^show.ready$":function(a,b,c){c&&(!this.rendered&&this.render(A)||this.toggle(A))},"^style.classes$":function(a,b,c,d){this.tooltip.removeClass(d).addClass(c)},"^style.width|height":function(a,b,c){this.tooltip.css(b,c)},"^style.widget|content.title":function(){this._setWidget()},"^style.def":function(a,b,c){this.tooltip.toggleClass(W,!!c)},"^events.(render|show|move|hide|focus|blur)$":function(a,b,c){tooltip[(d.isFunction(c)?"":"un")+"bind"]("tooltip"+b,c)},"^(show|hide|position).(event|target|fixed|inactive|leave|distance|viewport|adjust)":function(){var a=this.options.position;tooltip.attr("tracking","mouse"===a.target&&a.adjust.mouse),this._unassignEvents(),this._assignEvents()}}},w.get=function(a){if(this.destroyed)return this;var b=i(this.options,a.toLowerCase()),c=b[0][b[1]];return c.precedance?c.string():c};var ab=/^position\.(my|at|adjust|target|container|viewport)|style|content|show\.ready/i,bb=/^prerender|show\.ready/i;w.set=function(a,b){if(this.destroyed)return this;var c,e=this.rendered,f=B,g=this.options;return this.checks,"string"==typeof a?(c=a,a={},a[c]=b):a=d.extend({},a),d.each(a,function(b,c){if(!e&&!bb.test(b))return delete a[b],void 0;var h,j=i(g,b.toLowerCase());h=j[0][j[1]],j[0][j[1]]=c&&c.nodeType?d(c):c,f=ab.test(b)||f,a[b]=[j[0],j[1],c,h]}),h(g),this.positioning=A,d.each(a,d.proxy(j,this)),this.positioning=B,this.rendered&&this.tooltip[0].offsetWidth>0&&f&&this.reposition("mouse"===g.position.target?C:this.cache.event),this},w._update=function(a,b){var c=this,e=this.cache;return this.rendered&&a?(d.isFunction(a)&&(a=a.call(this.elements.target,e.event,this)||""),d.isFunction(a.then)?(e.waiting=A,a.then(function(a){return e.waiting=B,c._update(a,b)},C,function(a){return c._update(a,b)})):a===B||!a&&""!==a?B:(a.jquery&&a.length>0?b.children().detach().end().append(a.css({display:"block"})):b.html(a),e.waiting=A,(d.fn.imagesLoaded?b.imagesLoaded():d.Deferred().resolve(d([]))).done(function(a){e.waiting=B,a.length&&c.rendered&&c.tooltip[0].offsetWidth>0&&c.reposition(e.event,!a.length)}).promise())):B},w._updateContent=function(a,b){this._update(a,this.elements.content,b)},w._updateTitle=function(a,b){this._update(a,this.elements.title,b)===B&&this._removeTitle(B)},w._createTitle=function(){var a=this.elements,b=this._id+"-title";a.titlebar&&this._removeTitle(),a.titlebar=d("<div />",{"class":P+"-titlebar "+(this.options.style.widget?k("header"):"")}).append(a.title=d("<div />",{id:b,"class":P+"-title","aria-atomic":A})).insertBefore(a.content).delegate(".qtip-close","mousedown keydown mouseup keyup mouseout",function(a){d(this).toggleClass("ui-state-active ui-state-focus","down"===a.type.substr(-4))}).delegate(".qtip-close","mouseover mouseout",function(a){d(this).toggleClass("ui-state-hover","mouseover"===a.type)}),this.options.content.button&&this._createButton()},w._removeTitle=function(a){var b=this.elements;b.title&&(b.titlebar.remove(),b.titlebar=b.title=b.button=C,a!==B&&this.reposition())},w.reposition=function(c,e){if(!this.rendered||this.positioning||this.destroyed)return this;this.positioning=A;var f,g,h=this.cache,i=this.tooltip,j=this.options.position,k=j.target,l=j.my,m=j.at,n=j.viewport,o=j.container,p=j.adjust,q=p.method.split(" "),r=i.outerWidth(B),s=i.outerHeight(B),t=0,u=0,v=i.css("position"),w={left:0,top:0},x=i[0].offsetWidth>0,y=c&&"scroll"===c.type,z=d(a),C=o[0].ownerDocument,D=this.mouse;if(d.isArray(k)&&2===k.length)m={x:I,y:H},w={left:k[0],top:k[1]};else if("mouse"===k&&(c&&c.pageX||h.event.pageX))m={x:I,y:H},c=!D||!D.pageX||!p.mouse&&c&&c.pageX?(!c||"resize"!==c.type&&"scroll"!==c.type?c&&c.pageX&&"mousemove"===c.type?c:(!p.mouse||this.options.show.distance)&&h.origin&&h.origin.pageX?h.origin:c:h.event)||c||h.event||D||{}:D,"static"!==v&&(w=o.offset()),C.body.offsetWidth!==(a.innerWidth||C.documentElement.clientWidth)&&(g=d(C.body).offset()),w={left:c.pageX-w.left+(g&&g.left||0),top:c.pageY-w.top+(g&&g.top||0)},p.mouse&&y&&(w.left-=D.scrollX-z.scrollLeft(),w.top-=D.scrollY-z.scrollTop());else{if("event"===k&&c&&c.target&&"scroll"!==c.type&&"resize"!==c.type?h.target=d(c.target):"event"!==k&&(h.target=d(k.jquery?k:elements.target)),k=h.target,k=d(k).eq(0),0===k.length)return this;k[0]===b||k[0]===a?(t=BROWSER.iOS?a.innerWidth:k.width(),u=BROWSER.iOS?a.innerHeight:k.height(),k[0]===a&&(w={top:(n||k).scrollTop(),left:(n||k).scrollLeft()})):O.imagemap&&k.is("area")?f=O.imagemap(this,k,m,O.viewport?q:B):O.svg&&k[0].ownerSVGElement?f=O.svg(this,k,m,O.viewport?q:B):(t=k.outerWidth(B),u=k.outerHeight(B),w=k.offset()),f&&(t=f.width,u=f.height,g=f.offset,w=f.position),w=this.reposition.offset(k,w,o),(BROWSER.iOS>3.1&&BROWSER.iOS<4.1||BROWSER.iOS>=4.3&&BROWSER.iOS<4.33||!BROWSER.iOS&&"fixed"===v)&&(w.left-=z.scrollLeft(),w.top-=z.scrollTop()),(!f||f&&f.adjustable!==B)&&(w.left+=m.x===K?t:m.x===L?t/2:0,w.top+=m.y===J?u:m.y===L?u/2:0)}return w.left+=p.x+(l.x===K?-r:l.x===L?-r/2:0),w.top+=p.y+(l.y===J?-s:l.y===L?-s/2:0),O.viewport?(w.adjusted=O.viewport(this,w,j,t,u,r,s),g&&w.adjusted.left&&(w.left+=g.left),g&&w.adjusted.top&&(w.top+=g.top)):w.adjusted={left:0,top:0},this._trigger("move",[w,n.elem||n],c)?(delete w.adjusted,e===B||!x||isNaN(w.left)||isNaN(w.top)||"mouse"===k||!d.isFunction(j.effect)?i.css(w):d.isFunction(j.effect)&&(j.effect.call(i,this,d.extend({},w)),i.queue(function(a){d(this).css({opacity:"",height:""}),BROWSER.ie&&this.style.removeAttribute("filter"),a()})),this.positioning=B,this):this},w.reposition.offset=function(a,c,e){function f(a,b){c.left+=b*a.scrollLeft(),c.top+=b*a.scrollTop()}if(!e[0])return c;var g,h,i,j,k=d(a[0].ownerDocument),l=!!BROWSER.ie&&"CSS1Compat"!==b.compatMode,m=e[0];do"static"!==(h=d.css(m,"position"))&&("fixed"===h?(i=m.getBoundingClientRect(),f(k,-1)):(i=d(m).position(),i.left+=parseFloat(d.css(m,"borderLeftWidth"))||0,i.top+=parseFloat(d.css(m,"borderTopWidth"))||0),c.left-=i.left+(parseFloat(d.css(m,"marginLeft"))||0),c.top-=i.top+(parseFloat(d.css(m,"marginTop"))||0),g||"hidden"===(j=d.css(m,"overflow"))||"visible"===j||(g=d(m)));while(m=m.offsetParent);return g&&(g[0]!==k[0]||l)&&f(g,1),c};var cb=(x=w.reposition.Corner=function(a,b){a=(""+a).replace(/([A-Z])/," $1").replace(/middle/gi,L).toLowerCase(),this.x=(a.match(/left|right/i)||a.match(/center/)||["inherit"])[0].toLowerCase(),this.y=(a.match(/top|bottom|center/i)||["inherit"])[0].toLowerCase(),this.forceY=!!b;var c=a.charAt(0);this.precedance="t"===c||"b"===c?E:D}).prototype;cb.invert=function(a,b){this[a]=this[a]===I?K:this[a]===K?I:b||this[a]},cb.string=function(){var a=this.x,b=this.y;return a===b?a:this.precedance===E||this.forceY&&"center"!==b?b+" "+a:a+" "+b},cb.abbrev=function(){var a=this.string().split(" ");return a[0].charAt(0)+(a[1]&&a[1].charAt(0)||"")},cb.clone=function(){return new x(this.string(),this.forceY)},w.toggle=function(a,c){var e=this.cache,f=this.options,g=this.tooltip;if(c){if(/over|enter/.test(c.type)&&/out|leave/.test(e.event.type)&&f.show.target.add(c.target).length===f.show.target.length&&g.has(c.relatedTarget).length)return this;e.event=d.extend({},c)}if(this.waiting&&!a&&(this.hiddenDuringWait=A),!this.rendered)return a?this.render(1):this;if(this.destroyed||this.disabled)return this;var h,i,j=a?"show":"hide",k=this.options[j],l=(this.options[a?"hide":"show"],this.options.position),m=this.options.content,n=this.tooltip.css("width"),o=this.tooltip[0].offsetWidth>0,p=a||1===k.target.length,q=!c||k.target.length<2||e.target[0]===c.target;return(typeof a).search("boolean|number")&&(a=!o),h=!g.is(":animated")&&o===a&&q,i=h?C:!!this._trigger(j,[90]),i!==B&&a&&this.focus(c),!i||h?this:(d.attr(g[0],"aria-hidden",!a),a?(e.origin=d.extend({},this.mouse),d.isFunction(m.text)&&this._updateContent(m.text,B),d.isFunction(m.title)&&this._updateTitle(m.title,B),!z&&"mouse"===l.target&&l.adjust.mouse&&(d(b).bind("mousemove."+P,this._storeMouse),z=A),n||g.css("width",g.outerWidth(B)),this.reposition(c,arguments[2]),n||g.css("width",""),k.solo&&("string"==typeof k.solo?d(k.solo):d(T,k.solo)).not(g).not(k.target).qtip("hide",d.Event("tooltipsolo"))):(clearTimeout(this.timers.show),delete e.origin,z&&!d(T+'[tracking="true"]:visible',k.solo).not(g).length&&(d(b).unbind("mousemove."+P),z=B),this.blur(c)),after=d.proxy(function(){a?(BROWSER.ie&&g[0].style.removeAttribute("filter"),g.css("overflow",""),"string"==typeof k.autofocus&&d(this.options.show.autofocus,g).focus(),this.options.show.target.trigger("qtip-"+this.id+"-inactive")):g.css({display:"",visibility:"",opacity:"",left:"",top:""}),this._trigger(a?"visible":"hidden")},this),k.effect===B||p===B?(g[j](),after()):d.isFunction(k.effect)?(g.stop(1,1),k.effect.call(g,this),g.queue("fx",function(a){after(),a()})):g.fadeTo(90,a?1:0,after),a&&k.target.trigger("qtip-"+this.id+"-inactive"),this)},w.show=function(a){return this.toggle(A,a)},w.hide=function(a){return this.toggle(B,a)},w.focus=function(a){if(!this.rendered||this.destroyed)return this;var b=d(T),c=this.tooltip,e=parseInt(c[0].style.zIndex,10),f=v.zindex+b.length;return c.hasClass(X)||this._trigger("focus",[f],a)&&(e!==f&&(b.each(function(){this.style.zIndex>e&&(this.style.zIndex=this.style.zIndex-1)}),b.filter("."+X).qtip("blur",a)),c.addClass(X)[0].style.zIndex=f),this},w.blur=function(a){return!this.rendered||this.destroyed?this:(this.tooltip.removeClass(X),this._trigger("blur",[this.tooltip.css("zIndex")],a),this)},w.disable=function(a){return this.destroyed?this:("boolean"!=typeof a&&(a=!(this.tooltip.hasClass(Z)||this.disabled)),this.rendered&&this.tooltip.toggleClass(Z,a).attr("aria-disabled",a),this.disabled=!!a,this)},w.enable=function(){return this.disable(B)},w._createButton=function(){var a=this,b=this.elements,c=b.tooltip,e=this.options.content.button,f="string"==typeof e,g=f?e:"Close tooltip";b.button&&b.button.remove(),b.button=e.jquery?e:d("<a />",{"class":"qtip-close "+(this.options.style.widget?"":P+"-icon"),title:g,"aria-label":g}).prepend(d("<span />",{"class":"ui-icon ui-icon-close",html:"&times;"})),b.button.appendTo(b.titlebar||c).attr("role","button").click(function(b){return c.hasClass(Z)||a.hide(b),B})},w._updateButton=function(a){if(!this.rendered)return B;var b=this.elements.button;a?this._createButton():b.remove()},w._setWidget=function(){var a=this.options.style.widget,b=this.elements,c=b.tooltip,d=c.hasClass(Z);c.removeClass(Z),Z=a?"ui-state-disabled":"qtip-disabled",c.toggleClass(Z,d),c.toggleClass("ui-helper-reset "+k(),a).toggleClass(W,this.options.style.def&&!a),b.content&&b.content.toggleClass(k("content"),a),b.titlebar&&b.titlebar.toggleClass(k("header"),a),b.button&&b.button.toggleClass(P+"-icon",!a)},w._storeMouse=function(c){this.mouse={pageX:c.pageX,pageY:c.pageY,type:"mousemove",scrollX:a.pageXOffset||b.body.scrollLeft||b.documentElement.scrollLeft,scrollY:a.pageYOffset||b.body.scrollTop||b.documentElement.scrollTop}},w._bind=function(a,b,c,e,f){var g="."+this._id+(e?"-"+e:"");b.length&&d(a).bind((b.split?b:b.join(g+" "))+g,d.proxy(c,f||this))},w._unbind=function(a,b){d(a).unbind("."+this._id+(b?"-"+b:""))};var db="."+P;d(function(){p(T,["mouseenter","mouseleave"],function(a){var b="mouseenter"===a.type,c=d(a.currentTarget),e=d(a.relatedTarget||a.target),f=this.options;b?(this.focus(a),c.hasClass(V)&&!c.hasClass(Z)&&clearTimeout(this.timers.hide)):"mouse"===f.position.target&&f.hide.event&&f.show.target&&!e.closest(f.show.target[0]).length&&this.hide(a),c.toggleClass(Y,b)}),p("["+R+"]",U,n)}),w._trigger=function(a,b,c){var e=d.Event("tooltip"+a);return e.originalEvent=c&&d.extend({},c)||this.cache.event||C,this.triggering=A,this.tooltip.trigger(e,[this].concat(b||[])),this.triggering=B,!e.isDefaultPrevented()},w._assignEvents=function(){var c=this.options,e=c.position,f=this.tooltip,g=c.show.target,h=c.hide.target,i=e.container,j=e.viewport,k=d(b),p=(d(b.body),d(a)),q=c.show.event?d.trim(""+c.show.event).split(" "):[],r=c.hide.event?d.trim(""+c.hide.event).split(" "):[],s=[];/mouse(out|leave)/i.test(c.hide.event)&&"window"===c.hide.leave&&this._bind(k,["mouseout","blur"],function(a){/select|option/.test(a.target.nodeName)||a.relatedTarget||this.hide(a)}),c.hide.fixed?h=h.add(f.addClass(V)):/mouse(over|enter)/i.test(c.show.event)&&this._bind(h,"mouseleave",function(){clearTimeout(this.timers.show)}),(""+c.hide.event).indexOf("unfocus")>-1&&this._bind(i.closest("html"),["mousedown","touchstart"],function(a){var b=d(a.target),c=this.rendered&&!this.tooltip.hasClass(Z)&&this.tooltip[0].offsetWidth>0,e=b.parents(T).filter(this.tooltip[0]).length>0;b[0]===this.target[0]||b[0]===this.tooltip[0]||e||this.target.has(b[0]).length||!c||this.hide(a)}),"number"==typeof c.hide.inactive&&(this._bind(g,"qtip-"+this.id+"-inactive",n),this._bind(h.add(f),v.inactiveEvents,n,"-inactive")),r=d.map(r,function(a){var b=d.inArray(a,q);return b>-1&&h.add(g).length===h.length?(s.push(q.splice(b,1)[0]),void 0):a}),this._bind(g,q,l),this._bind(h,r,m),this._bind(g,s,function(a){(this.tooltip[0].offsetWidth>0?m:l).call(this,a)}),this._bind(g.add(f),"mousemove",function(a){if("number"==typeof c.hide.distance){var b=this.cache.origin||{},d=this.options.hide.distance,e=Math.abs;(e(a.pageX-b.pageX)>=d||e(a.pageY-b.pageY)>=d)&&this.hide(a)}this._storeMouse(a)}),"mouse"===e.target&&e.adjust.mouse&&(c.hide.event&&this._bind(g,["mouseenter","mouseleave"],function(a){this.cache.onTarget="mouseenter"===a.type}),this._bind(k,"mousemove",function(a){this.rendered&&this.cache.onTarget&&!this.tooltip.hasClass(Z)&&this.tooltip[0].offsetWidth>0&&this.reposition(a)})),(e.adjust.resize||j.length)&&this._bind(d.event.special.resize?j:p,"resize",o),e.adjust.scroll&&this._bind(p.add(e.container),"scroll",o)},w._unassignEvents=function(){var c=[this.options.show.target[0],this.options.hide.target[0],this.rendered&&this.tooltip[0],this.options.position.container[0],this.options.position.viewport[0],this.options.position.container.closest("html")[0],a,b];this.rendered?this._unbind(d([]).pushStack(d.grep(c,function(a){return"object"==typeof a}))):d(c[0]).unbind("."+this._id+"-create")},v=d.fn.qtip=function(a,b,e){var f=(""+a).toLowerCase(),g=C,i=d.makeArray(arguments).slice(1),j=i[i.length-1],k=this[0]?d.data(this[0],P):C;return!arguments.length&&k||"api"===f?k:"string"==typeof a?(this.each(function(){var a=d.data(this,P);if(!a)return A;if(j&&j.timeStamp&&(a.cache.event=j),!b||"option"!==f&&"options"!==f)a[f]&&a[f].apply(a,i);else{if(e===c&&!d.isPlainObject(b))return g=a.get(b),B;a.set(b,e)}}),g!==C?g:this):"object"!=typeof a&&arguments.length?void 0:(k=h(d.extend(A,{},a)),v.bind.call(this,k,j))},v.bind=function(a,b){return this.each(function(e){function f(a){function b(){k.render("object"==typeof a||g.show.ready),h.show.add(h.hide).unbind(j)}return k.disabled?B:(k.cache.event=d.extend({},a),k.cache.target=a?d(a.target):[c],g.show.delay>0?(clearTimeout(k.timers.show),k.timers.show=setTimeout(b,g.show.delay),i.show!==i.hide&&h.hide.bind(i.hide,function(){clearTimeout(k.timers.show)})):b(),void 0)}var g,h,i,j,k,l;return l=d.isArray(a.id)?a.id[e]:a.id,l=!l||l===B||l.length<1||v.api[l]?v.nextid++:l,j=".qtip-"+l+"-create",k=q(d(this),l,a),k===B?A:(v.api[l]=k,g=k.options,d.each(O,function(){"initialize"===this.initialize&&this(k)}),h={show:g.show.target,hide:g.hide.target},i={show:d.trim(""+g.show.event).replace(/ /g,j+" ")+j,hide:d.trim(""+g.hide.event).replace(/ /g,j+" ")+j},/mouse(over|enter)/i.test(i.show)&&!/mouse(out|leave)/i.test(i.hide)&&(i.hide+=" mouseleave"+j),h.show.bind("mousemove"+j,function(a){k._storeMouse(a),k.cache.onTarget=A}),h.show.bind(i.show,f),(g.show.ready||g.prerender)&&f(b),void 0)})},v.api={},d.each({attr:function(a,b){if(this.length){var c=this[0],e="title",f=d.data(c,"qtip");if(a===e&&f&&"object"==typeof f&&f.options.suppress)return arguments.length<2?d.attr(c,_):(f&&f.options.content.attr===e&&f.cache.attr&&f.set("content.text",b),this.attr(_,b))}return d.fn["attr"+$].apply(this,arguments)},clone:function(a){var b=(d([]),d.fn["clone"+$].apply(this,arguments));return a||b.filter("["+_+"]").attr("title",function(){return d.attr(this,_)}).removeAttr(_),b}},function(a,b){if(!b||d.fn[a+$])return A;var c=d.fn[a+$]=d.fn[a];d.fn[a]=function(){return b.apply(this,arguments)||c.apply(this,arguments)}}),d.ui||(d["cleanData"+$]=d.cleanData,d.cleanData=function(a){for(var b,c=0;(b=d(a[c])).length;c++)if(b.attr(Q))try{b.triggerHandler("removeqtip")}catch(e){}d["cleanData"+$].apply(this,arguments)}),v.version="2.1.1",v.nextid=0,v.inactiveEvents=U,v.zindex=15e3,v.defaults={prerender:B,id:B,overwrite:A,suppress:A,content:{text:A,attr:"title",title:B,button:B},position:{my:"top left",at:"bottom right",target:B,container:B,viewport:B,adjust:{x:0,y:0,mouse:A,scroll:A,resize:A,method:"flipinvert flipinvert"},effect:function(a,b){d(this).animate(b,{duration:200,queue:B})}},show:{target:B,event:"mouseenter",effect:A,delay:90,solo:B,ready:B,autofocus:B},hide:{target:B,event:"mouseleave",effect:A,delay:0,fixed:B,inactive:B,leave:"window",distance:B},style:{classes:"",widget:B,width:B,height:B,def:A},events:{render:C,move:C,show:C,hide:C,toggle:C,visible:C,hidden:C,focus:C,blur:C}};var eb,fb="margin",gb="border",hb="color",ib="background-color",jb="transparent",kb=" !important",lb=!!b.createElement("canvas").getContext,mb=/rgba?\(0, 0, 0(, 0)?\)|transparent|#123456/i,nb={},ob=["Webkit","O","Moz","ms"];lb||(createVML=function(a,b,c){return"<qtipvml:"+a+' xmlns="urn:schemas-microsoft.com:vml" class="qtip-vml" '+(b||"")+' style="behavior: url(#default#VML); '+(c||"")+'" />'}),d.extend(u.prototype,{init:function(a){var b,c;c=this.element=a.elements.tip=d("<div />",{"class":P+"-tip"}).prependTo(a.tooltip),lb?(b=d("<canvas />").appendTo(this.element)[0].getContext("2d"),b.lineJoin="miter",b.miterLimit=100,b.save()):(b=createVML("shape",'coordorigin="0,0"',"position:absolute;"),this.element.html(b+b),a._bind(d("*",c).add(c),["click","mousedown"],function(a){a.stopPropagation()},this._ns)),a._bind(a.tooltip,"tooltipmove",this.reposition,this._ns,this),this.create()},_swapDimensions:function(){this.size[0]=this.options.height,this.size[1]=this.options.width},_resetDimensions:function(){this.size[0]=this.options.width,this.size[1]=this.options.height},_useTitle:function(a){var b=this.qtip.elements.titlebar;return b&&(a.y===H||a.y===L&&this.element.position().top+this.size[1]/2+this.options.offset<b.outerHeight(A))},_parseCorner:function(a){var b=this.qtip.options.position.my;return a===B||b===B?a=B:a===A?a=new x(b.string()):a.string||(a=new x(a),a.fixed=A),a},_parseWidth:function(a,b,c){var d=this.qtip.elements,e=gb+r(b)+"Width";return(c?t(c,e):t(d.content,e)||t(this._useTitle(a)&&d.titlebar||d.content,e)||t(tooltip,e))||0},_parseRadius:function(a){var b=this.qtip.elements,c=gb+r(a.y)+r(a.x)+"Radius";return BROWSER.ie<9?0:t(this._useTitle(a)&&b.titlebar||b.content,c)||t(b.tooltip,c)||0},_invalidColour:function(a,b,c){var d=a.css(b);return!d||c&&d===a.css(c)||mb.test(d)?B:d},_parseColours:function(a){var b=this.qtip.elements,c=this.element.css("cssText",""),e=gb+r(a[a.precedance])+r(hb),f=this._useTitle(a)&&b.titlebar||b.content,g=this._invalidColour,h=[];return h[0]=g(c,ib)||g(f,ib)||g(b.content,ib)||g(tooltip,ib)||c.css(ib),h[1]=g(c,e,hb)||g(f,e,hb)||g(b.content,e,hb)||g(tooltip,e,hb)||tooltip.css(e),d("*",c).add(c).css("cssText",ib+":"+jb+kb+";"+gb+":0"+kb+";"),h},_calculateSize:function(a){var b,c,d,e=a.precedance===E,f=this.options[e?"height":"width"],g=this.options[e?"width":"height"],h="c"===a.abbrev(),i=f*(h?.5:1),j=Math.pow,k=Math.round,l=Math.sqrt(j(i,2)+j(g,2)),m=[this.border/i*l,this.border/g*l];return m[2]=Math.sqrt(j(m[0],2)-j(this.border,2)),m[3]=Math.sqrt(j(m[1],2)-j(this.border,2)),b=l+m[2]+m[3]+(h?0:m[0]),c=b/l,d=[k(c*f),k(c*g)],e?d:d.reverse()},_calculateTip:function(a){var b=this.size[0],c=this.size[1],d=Math.ceil(b/2),e=Math.ceil(c/2),f={br:[0,0,b,c,b,0],bl:[0,0,b,0,0,c],tr:[0,c,b,0,b,c],tl:[0,0,0,c,b,c],tc:[0,c,d,0,b,c],bc:[0,0,b,0,d,c],rc:[0,0,b,e,0,c],lc:[b,0,b,c,0,e]};return f.lt=f.br,f.rt=f.bl,f.lb=f.tr,f.rb=f.tl,f[a.abbrev()]},create:function(){var a=this.corner=(lb||BROWSER.ie)&&this._parseCorner(this.options.corner);return(this.enabled=!!this.corner&&"c"!==this.corner.abbrev())&&(this.qtip.cache.corner=a.clone(),this.update()),this.element.toggle(this.enabled),this.corner},update:function(a,b){if(!this.enabled)return this;var c,e,f,g,h,i,j,k=(this.qtip.elements,this.element),l=k.children(),m=this.options,n=this.size,o=m.mimic,p=Math.round;a||(a=this.qtip.cache.corner||this.corner),o===B?o=a:(o=new x(o),o.precedance=a.precedance,"inherit"===o.x?o.x=a.x:"inherit"===o.y?o.y=a.y:o.x===o.y&&(o[a.precedance]=a[a.precedance])),e=o.precedance,a.precedance===D?this._swapDimensions():this._resetDimensions(),c=this.color=this._parseColours(a),c[1]!==jb?(j=this.border=this._parseWidth(a,a[a.precedance]),m.border&&1>j&&(c[0]=c[1]),this.border=j=m.border!==A?m.border:j):this.border=j=0,g=this._calculateTip(o),i=this.size=this._calculateSize(a),k.css({width:i[0],height:i[1],lineHeight:i[1]+"px"}),h=a.precedance===E?[p(o.x===I?j:o.x===K?i[0]-n[0]-j:(i[0]-n[0])/2),p(o.y===H?i[1]-n[1]:0)]:[p(o.x===I?i[0]-n[0]:0),p(o.y===H?j:o.y===J?i[1]-n[1]-j:(i[1]-n[1])/2)],lb?(l.attr(F,i[0]).attr(G,i[1]),f=l[0].getContext("2d"),f.restore(),f.save(),f.clearRect(0,0,3e3,3e3),f.fillStyle=c[0],f.strokeStyle=c[1],f.lineWidth=2*j,f.translate(h[0],h[1]),f.beginPath(),f.moveTo(g[0],g[1]),f.lineTo(g[2],g[3]),f.lineTo(g[4],g[5]),f.closePath(),j&&("border-box"===tooltip.css("background-clip")&&(f.strokeStyle=c[0],f.stroke()),f.strokeStyle=c[1],f.stroke()),f.fill()):(g="m"+g[0]+","+g[1]+" l"+g[2]+","+g[3]+" "+g[4]+","+g[5]+" xe",h[2]=j&&/^(r|b)/i.test(a.string())?8===BROWSER.ie?2:1:0,l.css({coordsize:n[0]+j+" "+(n[1]+j),antialias:""+(o.string().indexOf(L)>-1),left:h[0]-h[2]*Number(e===D),top:h[1]-h[2]*Number(e===E),width:n[0]+j,height:n[1]+j}).each(function(a){var b=d(this);b[b.prop?"prop":"attr"]({coordsize:n[0]+j+" "+(n[1]+j),path:g,fillcolor:c[0],filled:!!a,stroked:!a}).toggle(!(!j&&!a)),!a&&b.html(createVML("stroke",'weight="'+2*j+'px" color="'+c[1]+'" miterlimit="1000" joinstyle="miter"'))})),b!==B&&this.calculate(a)},calculate:function(a){if(!this.enabled)return B;var b,c,e,f=this,g=this.qtip.elements,h=this.element,i=this.options.offset,j=(this.qtip.tooltip.hasClass("ui-widget"),{});return a=a||this.corner,b=a.precedance,c=this._calculateSize(a),e=[a.x,a.y],b===D&&e.reverse(),d.each(e,function(d,e){var h,k,l;e===L?(h=b===E?I:H,j[h]="50%",j[fb+"-"+h]=-Math.round(c[b===E?0:1]/2)+i):(h=f._parseWidth(a,e,g.tooltip),k=f._parseWidth(a,e,g.content),l=f._parseRadius(a),j[e]=Math.max(-f.border,d?k:i+(l>h?l:-h)))}),j[a[b]]-=c[b===D?0:1],h.css({margin:"",top:"",bottom:"",left:"",right:""}).css(j),j},reposition:function(a,b,d){if(this.enabled){var e,f,g=b.cache,h=this.corner.clone(),i=d.adjusted,j=b.options.position.adjust.method.split(" "),k=j[0],l=j[1]||j[0],m={left:B,top:B,x:0,y:0},n={};this.corner.fixed!==A&&(k===N&&h.precedance===D&&i.left&&h.y!==L?h.precedance=h.precedance===D?E:D:k!==N&&i.left&&(h.x=h.x===L?i.left>0?I:K:h.x===I?K:I),l===N&&h.precedance===E&&i.top&&h.x!==L?h.precedance=h.precedance===E?D:E:l!==N&&i.top&&(h.y=h.y===L?i.top>0?H:J:h.y===H?J:H),h.string()===g.corner.string()||g.cornerTop===i.top&&g.cornerLeft===i.left||this.update(h,B)),e=this.calculate(h,i),e.right!==c&&(e.left=-e.right),e.bottom!==c&&(e.top=-e.bottom),e.user=this.offset,(m.left=k===N&&!!i.left)&&(h.x===L?n[fb+"-left"]=m.x=e[fb+"-left"]-i.left:(f=e.right!==c?[i.left,-e.left]:[-i.left,e.left],(m.x=Math.max(f[0],f[1]))>f[0]&&(d.left-=i.left,m.left=B),n[e.right!==c?K:I]=m.x)),(m.top=l===N&&!!i.top)&&(h.y===L?n[fb+"-top"]=m.y=e[fb+"-top"]-i.top:(f=e.bottom!==c?[i.top,-e.top]:[-i.top,e.top],(m.y=Math.max(f[0],f[1]))>f[0]&&(d.top-=i.top,m.top=B),n[e.bottom!==c?J:H]=m.y)),this.element.css(n).toggle(!(m.x&&m.y||h.x===L&&m.y||h.y===L&&m.x)),d.left-=e.left.charAt?e.user:k!==N||m.top||!m.left&&!m.top?e.left:0,d.top-=e.top.charAt?e.user:l!==N||m.left||!m.left&&!m.top?e.top:0,g.cornerLeft=i.left,g.cornerTop=i.top,g.corner=h.clone()
}},destroy:function(){this.qtip._unbind(this.qtip.tooltip,this._ns),this.qtip.elements.tip&&this.qtip.elements.tip.find("*").remove().end().remove()}}),eb=O.tip=function(a){return new u(a,a.options.style.tip)},eb.initialize="render",eb.sanitize=function(a){a.style&&"tip"in a.style&&(opts=a.style.tip,"object"!=typeof opts&&(opts=a.style.tip={corner:opts}),/string|boolean/i.test(typeof opts.corner)||(opts.corner=A))},y.tip={"^position.my|style.tip.(corner|mimic|border)$":function(){this.create(),this.qtip.reposition()},"^style.tip.(height|width)$":function(a){this.size=size=[a.width,a.height],this.update(),this.qtip.reposition()},"^content.title|style.(classes|widget)$":function(){this.update()}},d.extend(A,v.defaults,{style:{tip:{corner:A,mimic:B,width:6,height:6,border:A,offset:0}}}),O.viewport=function(c,d,e,f,g,h,i){function j(a,b,c,e,f,g,h,i,j){var k=d[f],m=p[a],n=q[a],o=c===N,r=-w.offset[f]+v.offset[f]+v["scroll"+f],s=m===f?j:m===g?-j:-j/2,t=n===f?i:n===g?-i:-i/2,u=y&&y.size?y.size[h]||0:0,x=y&&y.corner&&y.corner.precedance===a&&!o?u:0,z=r-k+x,A=k+j-v[h]-r+x,B=s-(p.precedance===a||m===p[b]?t:0)-(n===L?i/2:0);return o?(x=y&&y.corner&&y.corner.precedance===b?u:0,B=(m===f?1:-1)*s-x,d[f]+=z>0?z:A>0?-A:0,d[f]=Math.max(-w.offset[f]+v.offset[f]+(x&&y.corner[a]===L?y.offset:0),k-B,Math.min(Math.max(-w.offset[f]+v.offset[f]+v[h],k+B),d[f]))):(e*=c===M?2:0,z>0&&(m!==f||A>0)?(d[f]-=B+e,l.invert(a,f)):A>0&&(m!==g||z>0)&&(d[f]-=(m===L?-B:B)+e,l.invert(a,g)),d[f]<r&&-d[f]>A&&(d[f]=k,l=p.clone())),d[f]-k}var k,l,m,n=e.target,o=c.elements.tooltip,p=e.my,q=e.at,r=e.adjust,s=r.method.split(" "),t=s[0],u=s[1]||s[0],v=e.viewport,w=e.container,x=c.cache,y=c.plugins.tip,z={left:0,top:0};return v.jquery&&n[0]!==a&&n[0]!==b.body&&"none"!==r.method?(k="fixed"===o.css("position"),v={elem:v,width:v[0]===a?v.width():v.outerWidth(B),height:v[0]===a?v.height():v.outerHeight(B),scrollleft:k?0:v.scrollLeft(),scrolltop:k?0:v.scrollTop(),offset:v.offset()||{left:0,top:0}},w={elem:w,scrollLeft:w.scrollLeft(),scrollTop:w.scrollTop(),offset:w.offset()||{left:0,top:0}},("shift"!==t||"shift"!==u)&&(l=p.clone()),z={left:"none"!==t?j(D,E,t,r.x,I,K,F,f,h):0,top:"none"!==u?j(E,D,u,r.y,H,J,G,g,i):0},l&&x.lastClass!==(m=P+"-pos-"+l.abbrev())&&o.removeClass(c.cache.lastClass).addClass(c.cache.lastClass=m),z):z}})}(window,document);