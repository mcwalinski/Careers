var careers = {
    colorWidget: function(){
        var wdgt = utility.byId('colorWidget');
        if (wdgt.className.match(/widgetOff/)){
            wdgt.className = "widgetOn";
            utility.showGroup('color');
        } else if (wdgt.className.match(/widgetOn/)){
            wdgt.className = "widgetOff";
            utility.hideGroup('color');
        }
    },
    getBG: function(){
        var careerColor = careers.getColor('careerColor');
        if (careerColor != null && careerColor != ""){
            return careerColor;
        } else {
            careerColor = "blue";
            if ((careerColor != null) && (careerColor != "")){
                careers.setColor('careers', careerColor, 365);
            }
            return careerColor;
        }
    },
    setBG: function(cls){
        document.body.className = cls;
        careers.setColor('careerColor', cls, 365);
    },
    getColor: function(color){
        if (document.cookie.length>0){
            c_start = document.cookie.indexOf(color + "=");
            if (c_start != -1){
                c_start = c_start + color.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1){
                    c_end=document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    },
    setColor: function(color, value, expiredays){
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + expiredays);
        document.cookie = color + "=" + escape(value)+ ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
        document.body.className = value;
    },
    setContactUs: function (contactUsUrl){
        var ts = utility.timestamp();
        new AjaxPostForm({
            url:contactUsUrl + "&" + ts,
            form:"contactus",
            onSuccess:function(object){
                if ((object.errorMessage) || (object.fieldError)){
                    JSONErrors.process(object);
                } else if (object.status == "ok"){
                    window.location = "?category_name=contactusthankyou";
                }
            },
            onFailure:function(object){
                if (typeof(object) != undefined){
                    _E = (["foo#There was en error submitting your request."]);
                    message.process();
                } else {
                    JSONErrors.process(object);
                }
            }
        });
    },
    swapIcons: function(elm, icn){
        var txt = utility.byId('iconText');
        var icnCap = icn.charAt(0);
        icn = icnCap.toUpperCase() + icn.substr(1);
        if (txt.innerHTML == ""){
            txt.innerHTML = icn;
        } else {
            txt.innerHTML = "";
        }
        if (elm.className.search(/_off/) != -1){
            elm.className = elm.className.replace(/_off/, '_on');
        } else if (elm.className.search(/_on/) != -1){
            elm.className = elm.className.replace(/_on/, '_off');
        }
    },
    swapListBG: function(id){
        var itm = utility.byId('listPost' + id);
        var itmBtm = utility.byId('listBottom' + id);
        if (itm.className.search(/listPostOff/) != -1){
            itm.className = itm.className.replace(/listPostOff/, 'listPostOn');
        } else if (itm.className.search(/listPostOn/) != -1){
            itm.className = itm.className.replace(/listPostOn/, 'listPostOff');
        }
        if (itmBtm.className.search(/listBottomOff/) != -1){
            itmBtm.className = itmBtm.className.replace(/listBottomOff/, 'listBottomOn');
        } else if (itmBtm.className.search(/listBottomOn/) != -1){
            itmBtm.className = itmBtm.className.replace(/listBottomOn/, 'listBottomOff');
        }
    }
};
if (typeof(Class) != 'undefined'){
    var AjaxPostForm = new Class({
        initialize: function(options){
            window.addEvent('domready', function() {
                $(options.form).addEvent('submit', function(e){
                    var val = validate.ajaxSubmit($(options.form), e);
                    new Event(e).stop();
                    if (val == true){
                        var myHTMLRequest = new Request.HTML({
                            url:options.url,
                            onComplete:function(responseTree, responseElements, responseHTML, responseJavaScript){
                                handleAjaxResponse(responseHTML, options.onSuccess, options.onFailure);
                            }
                        }).post(this);
                    } else if (val == false){
                        return;
                    }
                });
            });
        }
    });
    function handleAjaxResponse(response, onSuccess, onFailure){
        var r = response;

        // if/else statement added to catch AJAX responses that include a trailing comma
        // IE JS engine cannot process malformed object. FF is lazy enough to drop extra comma
        if (r.match(", }")) {
            r = r.replace(", }", "}");
        } else if (r.match(",}")){
            r = r.replace(",}", "}");
        }

        var obj = JSON.decode(r);
        if(obj){
            if (!obj.errorMessage){
                if(onSuccess){
                    onSuccess(obj);
                } else {
                    // do nothing
                }
            } else if (obj.errorMessage){
                if (onFailure){
                    onFailure(obj);
                } else {
                    //do nothing
                }
            }
        } else {
            // do nothing
        }
    }
    var JSONErrors = {
        process: function(obj){
            var errs = obj;
            if (errs.errorMessage){
                var error = (["foo#" + errs.errorMessage.exception]);
                _E = error;
                message.process();
            } else if (errs.fieldError){
                var error = errs.fieldError;
                _E = error;
                message.process();
            }
        }
    };
}

var utility = {
	isNode: function(x){
		if (x.nodeType == 1){
			return true;
		} else if (x.nodeType != 1){
			return false
		}
	},
    timestamp: function(){
        var ts = Date.parse(new Date());
        return ts;
    },
	byId: function(x){
		var node = utility.isNode(x) ? x : document.getElementById(x);
		return node;
	},
	byClass: function(cl) {
		var retnode = [];
		var myclass = new RegExp('\\b'+cl+'\\b');
		var elem = document.getElementsByTagName('*');
		for (var i = 0; i < elem.length; i++) {
			var classes = elem[i].className;
			if (myclass.test(classes)){
				retnode.push(elem[i]);
			}
		}
		return retnode;
	},
    show: function(id){
        var elm = utility.byId(id);
        if (elm.className.search(/hide/) != -1){
            elm.className = elm.className.replace(/hide/, "show");
        }
    },
    hide: function(id){
        var elm = utility.byId(id);
        if (elm.className.search(/show/) != -1){
            elm.className = elm.className.replace(/show/, "hide");
        } else if (elm.className.search(/inline/) != -1){
            elm.className = elm.className.replace(/inline/, "hide");
        }
    },
    showGroup: function(cls){
        var lst = utility.byClass(cls);
        for (i=0;i<lst.length;i++){
            utility.show(lst[i]);
        }
    },
    hideGroup: function(cls){
        var lst = utility.byClass(cls);
        for (i=0;i<lst.length;i++){
            utility.hide(lst[i]);
        }
    },
    inline: function(id){
        var elm = utility.byId(id);
        if (elm.className.search(/hide/) != -1){
            elm.className = elm.className.replace(/hide/, "inline");
        }
    },
    killChildren: function(node){
        alert(node.childNodes.length);
        if (node.childNodes.length != 0){
            while (node.hadChildNodes()){
                node.removeChild(node.lastChild());
            }
        }
    }
};