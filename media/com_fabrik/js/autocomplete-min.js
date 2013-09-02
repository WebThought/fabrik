var FbAutocomplete=new Class({Implements:[Options,Events],options:{menuclass:"auto-complete-container dropdown",classes:{ul:"dropdown-menu",li:"result"},url:"index.php",max:10,onSelection:Class.empty,autoLoadSingleResult:true,storeMatchedResultsOnly:false},initialize:function(b,a){window.addEvent("domready",function(){this.setOptions(a);b=b.replace("-auto-complete","");this.options.labelelement=typeOf(document.id(b+"-auto-complete"))==="null"?document.getElement(b+"-auto-complete"):document.id(b+"-auto-complete");this.cache={};this.selected=-2;this.searchText="";this.element=typeOf(document.id(b))==="null"?document.getElement(b):document.id(b);this.buildMenu();if(!this.getInputElement()){fconsole("autocomplete didn't find input element");return}this.getInputElement().setProperty("autocomplete","off");this.getInputElement().addEvent("keydown",function(c){this.doWatchKeys(c)}.bind(this));this.getInputElement().addEvent("keyup",function(c){this.search(c)}.bind(this));this.getInputElement().addEvent("blur",function(c){c.stop()}.bind(this))}.bind(this))},search:function(f){var c,d,b;if(this.ajax){this.ajax.cancel()}var a=this.getInputElement().get("value");if(f.key==="tab"||f.key==="enter"){this.searchText=a.toLowerCase();this.menuClose();this.element.fireEvent("change",new Event.Mock(this.element,"change"),500);return}if(a===""){this.menuClose();this.searchText=this.element.value=""}else{if(a.toLowerCase()!==this.searchText){if(this.options.storeMatchedResultsOnly){this.element.value=""}else{this.element.value=a}if(this.cache["$"+a.toLowerCase()+"$"]){this.searchText=a.toLowerCase();this.menuPopulateOpen(this.cache["$"+a.toLowerCase()+"$"])}else{if(this.searchText!==""&&a.indexOf(" ")<0&&a.indexOf(this.searchText)>=0){d=this.cache["$"+this.searchText+"$"];b=a.toLowerCase();for(c=d.length-1;c>=0;c--){if(d[c].text.toLowerCase().indexOf(b)<0){d.splice(c,1)}}this.completeAjax(d,a)}else{this.ajax=new Request({url:this.options.url,data:{value:a},onRequest:function(){Fabrik.loader.start(this.getInputElement())}.bind(this),onCancel:function(){Fabrik.loader.stop(this.getInputElement());this.ajax=null}.bind(this),onComplete:function(){Fabrik.loader.stop(this.getInputElement());this.ajax=null}.bind(this),onFailure:function(e){fconsole("Fabrik autocomplete: Ajax failure: Code "+e.status+": "+e.statusText);elModel=Fabrik.blocks[this.options.formRef].formElements.get(this.element.id);elModel.setErrorMessage(Joomla.JText._("COM_FABRIK_AUTOCOMPLETE_AJAX_ERROR"),"fabrikError",true)}.bind(this),onSuccess:function(e){if(typeOf(e)==="null"){fconsole("Fabrik autocomplete: Ajax response empty");elModel=Fabrik.blocks[this.options.formRef].formElements.get(this.element.id);elModel.setErrorMessage(Joomla.JText._("COM_FABRIK_AUTOCOMPLETE_AJAX_ERROR"),"fabrikError",true);return}e=JSON.decode(e);this.completeAjax(e,a)}.bind(this)}).send()}}}}},completeAjax:function(d,c){this.searchText=u=c.toLowerCase();this.cache["$"+u+"$"]=d;if(d.length===1){var b=d[0].text.toLowerCase();this.searchText=b.substr(0,b.indexOf(u)+u.length);var a=b.substr(b.indexOf(u));while(a.length>u.length){this.cache["$"+b+"$"]=d;b=b.substr(0,b.length-1);this.cache["$"+a+"$"]=d;a=a.substr(0,a.length-1)}}else{d.each(function(e){this.cache["$"+e.text.toLowerCase()+"$"]=new Array(e)}.bind(this))}this.menuPopulateOpen(d)},buildMenu:function(){if(Fabrik.bootstrapped){this.menu=new Element("ul."+this.options.classes.ul,{role:"menu",styles:{"z-index":1056}});this.ul=this.menu}else{this.menu=new Element("div",{"class":this.options.menuclass,styles:{position:"absolute"}}).adopt(new Element("ul."+this.options.classes.ul));this.ul=this.menu.getElement("ul")}this.menu.inject(document.body);this.menu.addEvent("click:relay(a)",function(b,a){this.makeSelection(b,a)}.bind(this));this.menu.addEvent("mouseenter:relay(li)",function(b,a){this.selectLi(b,a)}.bind(this))},getInputElement:function(){return this.options.labelelement?this.options.labelelement:this.element},positionMenu:function(){var a=this.getInputElement().getCoordinates();var b=this.getInputElement().getPosition();this.menu.setStyles({left:a.left,top:(a.top+a.height)-1,width:a.width})},menuPopulateOpen:function(d){d.map(function(i,a){i.text=Encoder.htmlDecode(i.text);return i});this.data=d;var g=this.getListMax();var f=this.ul;f.empty();if(d.length===0){new Element("li").adopt(new Element("div.alert.alert-info").adopt(new Element("i").set("text",Joomla.JText._("COM_FABRIK_NO_RECORDS")))).inject(f)}for(var e=0;e<g;e++){var c=d[e];var h=new Element("a",{href:"#","data-value":c.value,tabindex:"-1"}).set("text",c.text);if(!Fabrik.bootstrapped){k.addClass("unselected "+this.options.classes.li)}var k=new Element("li").adopt(h);k.inject(f)}if(d.length>this.options.max){new Element("li").set("text","....").inject(f)}if(d.length===1&&this.options.autoLoadSingleResult){var j=this.getInputElement().get("value");r=d[0].text;e=r.toLowerCase().indexOf(j.toLowerCase());if(e>=0){var b=this.getInputElement();b.value=r;b.selectRange(e+j.length,r.length);this.element.value=d[0].value;this.menuClose();return}}this.menuOpen()},selectLi:function(b,a){if(typeOf(a)!=="null"){this.menu.getElements("li").each(function(c,d){if(c===a){this.selected=d;this.highlight()}}.bind(this))}},makeSelection:function(b,a){b.stop();this.getInputElement().focus();if(typeOf(a)!=="null"){this.element.value=a.getProperty("data-value");this.getInputElement().value=a.get("text");this.menuClose();Fabrik.fireEvent("fabrik.autocomplete.selected",[this,this.element.value]);this.element.fireEvent("change",new Event.Mock(this.element,"change"),100)}else{Fabrik.fireEvent("fabrik.autocomplete.notselected",[this,this.element.value])}},menuClose:function(){if(this.shown){this.shown=false;if(Fabrik.bootstrapped){this.menu.hide()}else{this.menu.fade("out")}this.selected=-2}},menuOpen:function(){if(!this.shown){this.shown=true;this.positionMenu();if(Fabrik.bootstrapped){this.menu.show()}else{this.menu.setStyle("visibility","visible").fade("in")}if(this.data.length>0){this.selected=-1;this.highlight()}else{this.selected=-2}}},getListMax:function(){if(typeOf(this.data)==="null"){return 0}return this.data.length>this.options.max?this.options.max:this.data.length},doWatchKeys:function(b){var a=this.getListMax();if(!this.shown){if(b.code.toInt()===40&&this.getInputElement().get("value")!==""){this.menuOpen()}}else{switch(b.code){case 40:b.stop();if(this.selected>=-1&&this.selected<a-1){this.selected++;this.highlight()}break;case 38:b.stop();if(this.selected>-1){this.selected--;this.highlight()}break;case 13:b.stop();case 9:if(this.shown){this.makeSelection(new Event.Mock(this.getSelected(),"click"),this.getSelected());this.menuClose()}break;case 27:b.stop();this.menuClose();break}}},getSelected:function(){var b=this.menu.getElements("li").filter(function(a,c){return c===this.selected}.bind(this));return b[0]},highlight:function(){this.menu.getElements("li").each(function(a,b){if(Fabrik.bootstrapped){if(b===this.selected){a.addClass("selected").addClass("active")}else{a.removeClass("selected").removeClass("active")}}else{if(b===this.selected){a.addClass("selected").addClass("active")}else{a.removeClass("selected").removeClass("active")}}}.bind(this))}});var FabCddAutocomplete=new Class({Extends:FbAutocomplete,search:function(f){var d;var b=this.getInputElement().get("value");if(b===""){this.element.value=""}if(b.toLowerCase()!==this.searchText&&b!==""){var a=document.id(this.options.observerid);if(typeOf(a)!=="null"){if(this.options.formRef){a=Fabrik.blocks[this.options.formRef].formElements[this.options.observerid]}d=a.get("value")+"."+b}else{this.parent(f);return}this.searchText=b.toLowerCase();if(this.cache["$"+d+"$"]){this.menuPopulateOpen(this.cache["$"+d+"$"])}else{var c=document.id(this.options.observerid).get("value");if(typeOf(c)==="null"){c=Fabrik.blocks[this.options.formRef].formElements.get(this.options.observerid).get("value")}Fabrik.loader.start(this.getInputElement());if(this.ajax){Fabrik.loader.stop(this.getInputElement());this.menuClose();this.ajax.cancel()}this.ajax=new Request({url:this.options.url,method:this.options.ajaxmethod,data:{value:b,fabrik_cascade_ajax_update:1,v:a.get("value")},onSuccess:function(e){Fabrik.loader.stop(this.getInputElement());e=JSON.decode(e);this.completeAjax(e,b)}.bind(this),onError:function(g,e){fconsole(g,e)},onFailure:function(e){fconsole(e)}}).send()}}}});