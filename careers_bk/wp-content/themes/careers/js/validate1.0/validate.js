//************************************************************************************************//
// To use this validation module:
//
// * Include validate.js in the head of the html file
// * Include validate.css in the head of the html file
// * To allow for in-field labeling, include an array called defVal in the head of the html file
//   in the following format:
//
//		var defVal = {
//			"phone"		: "Phone Number",
//			"text"		: "First Name",
//			"alphanum"	: "Alpha Numeric",
//			"zip"		: "Zip Code",
//			"date"		: "Birthday",
//			"blank"		: "Address",
//			"ccNum"		: "Credit Card Number",
//			"ccCode"	: "CIV"
//		};
//
//	 and all input's default values are set by including in the same script block:
//
//   	window.onload = validate.defaults;
//
// * Each input to validate requires an onblur event and an onfocus event handler with the element
//   passed in
// * The validation type is set by class name ('phone' in the example below)
// * If a field is required, this is set as a class name ('required' in the example below)
// * <input type="text" id="phone" class="phone required" onblur="validate.phone(this);"
//	 	onfocus="validate.focus(this);" value="Phone Number"></input>
//
// * All fields require an ID
// * Currenty validation types include:
//
//		* phone
//		* text (alpha characters only)
//		* alphanum
//		* zip
//		* date (validates dates from 1900-2099 in mm-dd-yyyy format)
//		* blank (accepts letters, numbers, spaces, punctuation, and special characters)
//		* email
//
// * creditcard object included with this validation module validates:
//
//		* luhn (validates credit card number against credit card type)
//		* securityCode (validates code against card type)
//		* expires (validates month and year of credit card- note: current month and year pass)
//
// **NOTE** In order for the credit card validation to work correctly, the IDs of the form fields
//			have to be as follows:
//		* credit card type = ccType
//		* credit card number = ccNum
//		* credit card security code = ccCode
//		* expiration month = expMonth
//		* expiration year = expYear
//
// **NOTE** If an address scrub is performed on submit, the class name 'scrub' needs to be included for
//   all the fields scrubbed to highlight when scrub error is returned
//
// * Page-level validation is performed onsumbit by inluding an event handler in the form tag with
//   the form passes in along with the event (see example below)
//
// * <form name="validation" id="validation" action="http://google.com" method="post"
//		onsubmit="validate.submit(this, event);">
//
// * Page messages are displayed on page load in an included div with the id=messagesContainer
// * Page errors are displayed on submit in an included div with the id=errorsContainer
//
//************************************************************************************************//


// FORM FIELD VALIDATION
var validate = {

    // SETS INPUT'S DEFAULT VALUES
    defaults: function (){
        for (i=0;i<document.forms.length;i++){
            var f = document.forms[i];
            for (j=0;j<f.length;j++){
                if (f[j].id != ""){
                    var inpId = f[j].id;
                    var inp = document.getElementById(inpId);
                    if ((defVal[inpId] != undefined) && (inp.value == "")){
                    //if ((defVal[inpId] != undefined) && ((inp.value == "") || (inp.value == "null"))){
                        inp.value = defVal[inpId];
                    }
                }
            }
        }
    },

    // PHONE NUMBER
    phone: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (val.match(/[a-z~`!@#$%^&*_+={}\[\]\|\\:;<>,?]/gi)){
            validate.message(inp, 'Please enter a ten-digit phone number in XXX-XXX-XXXX format.');
            error = true;
        } else {
            while (val.search(/\D/) != -1){
                val = val.replace(/\D/, "");
            }
            if ((val != "") && (val.length != 10)){
                validate.message(inp, 'Please enter a ten-digit phone number in XXX-XXX-XXXX format.');
                error = true;
            } else if ((val == "") && (errLoc != "page")){
                inp.value = def;
                validate.clearError(inp);
                validate.clearMessage();
                error = false;
            } else {
                if (val.match(/1[0-9]{9}/)){
                    validate.message(inp, 'Phone number can not start with 1');
                    error = true;
                } else if (val.match(/[2-9][0-9]{2}1[0-9]{6}/)){
                    validate.message(inp, 'Seven digit phone number can not start with 1');
                    error = true;
                } else if (val.match(/0[0-9]{9}/)){
                    validate.message(inp, 'Phone number can not start with 0');
                    error = true;
                } else if (val.match(/[2-9][0-9]{2}0[0-9]{6}/)){
                    validate.message(inp, 'Seven digit phone number can not start with 0');
                    error = true;
                } else if (val.match(/911[2-9][0-9]{2}[0-9]{4}/)){
                    validate.message(inp, "Phone number can not begin with '911'.");
                    error = true;
                } else if (val.match(/[2-9][0-9]{2}911[0-9]{4}/)){
                    validate.message(inp, "Seven digit phone number can not being with '911'.");
                    error = true;
                }
                if (val != ""){
                    var ph = [];
                    ph[0] = val.slice(0,3);
                    ph[1] = val.slice(3,6);
                    ph[2] = val.slice(6,10);
                    val = ph[0] + "-" + ph[1] + "-" + ph[2];
                }
                var elm = document.getElementById(inp.id);
                elm.value = val;
            }
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    // ALPHA
    text: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (val.search(/[^a-z]/gi) != -1){
            validate.message(inp, "Please enter only text characters.");
            error = true;
        }
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    // ALPHA NUMERIC
    alphanum: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (val.search(/\W/) != -1){
            validate.message(inp, "Please enter only text characters and numbers.");
            error = true;
        }
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    //  ZIP CODE
    zip: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (((!val.match(/\d{5}/)) && (val != "")) || ((val.match(/\d{5}/)) && (val.length > 5))){
            if ((val.length == 10) && (val.charAt(5) == "-")){
                error = false;
            } else {
                validate.message(inp, val + " is an invalid zip code. Please enter a 5-digit zip code.");
                error = true;
            }
        }
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    //  YEAR - validate years 1900 through this year
    year: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;

        var today = new Date();
        var thisYr = today.getFullYear();

        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (((!val.match(/\d{4}/)) && (val != "")) || ((val.match(/\d{4}/)) && (val.length > 4))){
            validate.message(inp, val + " is an invalid year. Please enter a year in YYYY format.");
            error = true;
        }
        if ((val.match(/\d{4}/)) && (val.length == 4)){
            if ((thisYr < val) || (val < 1900)){
                validate.message(inp, val + " is an invalid year. Please enter a year between 1900 and " + thisYr + ".");
                error = true;
            }
        }
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    // DATE SELECT
    realDate: function (mo, dt, yr){
        var m = mo.value, d = dt.value, y = yr.value;
        var mDef = defVal[mo.id], dDef = defVal[dt.id], yDef = defVal[yr.id];
        var badDt = false;
        if ((m != "") && (d != "") && (y != yDef)){
            if ((m.match(/02|04|06|09|11/)) && (d.match(/31/))){
                badDt = true;
            }
            if (m.match(/02/)){
                if (d == 29){
                    var ly = validate.leapYear(y);
                    if (ly == false){
                        badDt = true;
                    }
                } else if (d == 30){
                    badDt = true;
                }
            }
        }
        if (badDt == false){
            validate.clearError(mo);
            validate.clearError(dt);
            validate.clearError(yr);
            validate.clearMessage();
            if (y != defVal[yr.id]){
                validate.year(yr);
            }
            return;
        } else if (badDt == true){
            var dateVal = m + "/" + d + "/" + y;
            validate.showError(mo);
            validate.showError(dt);
            validate.showError(yr);
            validate.message(dt, dateVal + " is an invalid date.");
        }
    },

    // LEAP YEAR TEST
    leapYear: function (yr){
        y = parseInt(yr);
        if(y%4 == 0){
            if(y%100 != 0){
                return true;
            } else {
                if(y%400 == 0){
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    },

    //  DATE - validate dates 1900 through 2099
    date: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (val.match(/[a-z~`!@#$%^&*()_+={}\[\]\|\\:;<>,.?]/gi)){
            validate.message(inp, 'Please enter a date in MM/DD/YYYY format.');
            error = true;
        } else {
            while (val.search(/\D/) != -1){
                val = val.replace(/\D/, "");
            }
            if ((val != "") && (val.length != 8)){
                validate.message(inp, 'Please enter a date in MM/DD/YYYY format.');
                error = true;
            } else if (val == ""){
                if (errLoc != "page"){
                    inp.value = def;
                }
                validate.clearError(inp);
                validate.clearMessage();
                error = false;
            } else {
                var mo = val.substring(0,2);
                var dt = val.substring(2,4);
                var yr = val.substring(4,8);

                if (mo.match(/[0-1][0-9]/)){
                    if (mo.charAt(0) == 1){
                        if(!mo.match(/1[0-2]/)){
                            validate.message(inp, mo + ' is not a valid month.');
                            error = true;
                        }
                    } else if (mo.charAt(0) == 0){
                        if(!mo.match(/0[1-9]/)){
                            validate.message(inp, mo + ' is not a valid month.');
                            error = true;
                        }
                    }
                } else if (!mo.match(/[0-1][0-9]/)){
                    validate.message(inp, mo + ' is not a valid month.');
                    error = true;
                }
                if (dt.match(/[0-3][0-9]/)){
                    var dt1 = dt.charAt(0);
                    if(dt.match(/00/)){
                        validate.message(inp, dt + ' is not a valid date.');
                        error = true;
                    }
                    if (dt1 == 3){
                        if(!dt.match(/3[01]/)){
                            validate.message(inp, dt + ' is not a valid date.');
                            error = true;
                        }
                    }
                } else if (!dt.match(/[0-3][0-9]/)){
                    validate.message(inp, dt + ' is not a valid date.');
                    error = true;
                }
                if (!yr.match(/20[0-9]{2}|19[0-9]{2}/)){
                    validate.message(inp, yr + ' is not a valid year.');
                    error = true;
                }
                if (mo.match(/02/)){
                    if (dt == 29){
                        var ly = validate.leapYear(yr);
                        if (ly == false){
                            validate.message(inp, yr + ' is not a leap year.');
                            error = true;
                        }
                    } else if ((dt == 30) || (dt == 31)){
                        validate.message(inp, dt + ' is not a valid date.');
                        error = true;
                    }
                }

                if (val != ""){
                    var d = [];
                    d[0] = val.slice(0,2);
                    d[1] = val.slice(2,4);
                    d[2] = val.slice(4,8);
                    val = d[0] + "/" + d[1] + "/" + d[2];
                }
                var elm = document.getElementById(inp.id);
                elm.value = val;
            }
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },
    // EMAIL ADDRESS
    email: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if (inp.className.search(/required/) != -1){
            req = true;
        }
        if (val.match(/[~`!#$%^&*()+=\/\{\}\[\]\|\\:;<>,?]/gi)){ // verify address doesn't contain any non-email characters
            //validate.message(inp, "Please enter only text characters, numbers, and the special characters '. @ _ -'");
            error = true;
        } else if ((val.match(/[.@_\-]$/)) || (val.match(/^[.@_\-]/))){ // verify email address does not start or end with email-allowed special characters
            //validate.message(inp, "Email addresses cannot start or end with '. @ _ or -'.");
            error = true;
        } else if ((!val.match(/@/g)) && (val != def)){ // verify email address contains a @
            //validate.message(inp, "Email addresses must contain a '@'.");
            error = true;
        } else {
            var adLn = val.split("@"); // check for multiple @
            if (adLn.length > 2){
                //validate.message(inp, "Email addresses must not contain more than one '@'.");
                error = true;
            }
            var dom = val.slice(val.lastIndexOf("@") + 1);
            var domNm = dom.substring(0, dom.indexOf("."));
            var suf = dom.slice(dom.indexOf(".") + 1);
            if (domNm.length <= 1){ // verify domain name is more than 1 character
                //validate.message(inp, "Email domains must be at least 2 characters in length.");
                error = true;
            } else if ((domNm.match(/[-.]$/)) || (domNm.match(/^[-.]/))){ // verify domain name doesn't start or end with -
                //validate.message(inp, "Email domains cannot start or end with hyphens or periods.");
                error = true;
            } else if (domNm.match(/_/)){ // verify domain name doesn't contain underscores
                //validate.message(inp, "Email domains cannot contain underscores.");
                error = true;
            } else if ((suf.match(/[.]$/)) || (suf.match(/^[.]/))){ // verify domain name suffix doesn't start or end with .
                //validate.message(inp, "Email domain suffixes cannot start or end with periods.");
                error = true;
            } else if (suf.match(/[_\-]/)){ // verify domain name suffix doesn't contain underscores or hyphens
                //validate.message(inp, "Email domains suffixes cannot contain special characters.");
                error = true;
            } else if (suf.match(/[0-9]/)){ // verify domain name suffix doesn't contain numbers
                //validate.message(inp, "Email domains suffixes cannot contain numbers.");
                error = true;
            } else if (suf.length <= 1){ // verify domain name suffix is more than 1 character
                //validate.message(inp, "Email domains suffixes must be at least 2 characters in length.");
                error = true;
            } else if (suf.match(/./)){ // verify domain name suffix doesn't contain more than one period
                var sufLn = suf.split(".");
                if (sufLn.length > 2){
                    //validate.message(inp, "Email domains suffixes must not contain more than one period.");
                    error = true;
                }
            }
        }
        if (error == true){
            validate.message(inp, "You entered an invalid email address. Please enter an address in example@domain.com format.");
        }
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    // GENERIC BLANK
    blank: function (inp, err){
        var errLoc = err;
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        var req = false;
        if ((val == "") && (errLoc != "page")){
            inp.value = def;
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            validate.clearMessage();
        }
    },

    // DISPLAY ERROR MESSAGE
    message: function (inp, msg){
        validate.showError(inp);
        if (document.getElementById("error") != null){
            document.body.removeChild(document.getElementById("error"));
        }
        if (document.getElementById("arrow") != null){
            document.body.removeChild(document.getElementById("arrow"));
        }
        var d = document.createElement("div");
        d.id = "error";
        d.className = "error";
        d.id = "error";

        var errorContainer = document.createElement("span");
        errorContainer.innerHTML = msg;
        d.appendChild(errorContainer);

        var arrow = document.createElement("div");
        arrow.id = "arrow";

        d.style.left = "-1000px";

        document.body.appendChild(d);
        d.appendChild(arrow);

        var inpL = inpT = 0;
        if (inp.offsetParent) {
            do {
                inpL += inp.offsetLeft;
                inpT += inp.offsetTop;
            } while (inp = inp.offsetParent);
        }

        if (((inpT - errorContainer.offsetHeight) - 30) < 0){
            d.style.top = (inpT + 30) + "px";
            arrow.className = "upArrow";
        } else {
            d.style.top = ((inpT - errorContainer.offsetHeight) - 30) + "px";
            d.style.paddingBottom = "0px";
            arrow.className = "downArrow";
        }
        d.style.left = (inpL + 30) + "px";
    },

    // DISPLAY ERROR MESSAGE ON FOCUS
    focus: function (inp){
        var elm = inp;
        var def = defVal[elm.id];
        if (elm.value == def){
            inp.value = "";
        }
        if (elm.className.search("fieldError") != -1){
            validate.clearMessage();
            validate.clearError(elm);
            if (elm.className.search("zip") != -1){
                validate.zip(inp, "page");
            } else if (elm.className.search("phone") != -1){
                validate.phone(inp, "page");
            } else if (elm.className.search("text") != -1){
                validate.text(inp, "page");
            } else if (elm.className.search("alphanumeric") != -1){
                validate.alphanum(inp, "page");
            } else if (elm.className.search("date") != -1){
                validate.date(inp, "page");
            } else if (elm.className.search("year") != -1){
                validate.year(inp, "page");
            } else if (elm.className.search("email") != -1){
                validate.email(inp, "page");
            } else if (elm.className.search("blank") != -1){
                validate.blank(inp, "page");
            } else if (elm.className.search("ccType") != -1){
                creditcard.luhn(inp, document.getElementById('ccNum'));
            } else if (elm.className.search("ccNum") != -1){
                creditcard.luhn(document.getElementById('ccType'), inp, "page");
            }
        }
    },

    // CLEAR ERROR MESSAGE
    clearMessage: function (){
        if (document.getElementById("error") != null){
            document.body.removeChild(document.getElementById("error"));
        }
        if (document.getElementById("arrow") != null){
            document.body.removeChild(document.getElementById("arrow"));
        }
    },

    // CLEAR PAGE ERRORS
    clearPageErrors: function (){
        _E = "";
        var err = document.getElementsByClassName('fieldError');
        for (i=0;i<err.length;i++){
            err[i].className = err[i].className.replace("fieldError", "");
        }
    },

    // SHOW ERROR STYLING
    showError: function(inp){
        var elm = inp;
        if (elm != null && !elm.className.match(/fieldError/)){
            elm.className = elm.className += " fieldError";
        }
    },

    // SHOW SCRUB ERROR
    showScrubError: function(){
        var scrub = document.getElementsByClassName('scrub');
        for (i=0;i<scrub.length;i++){
            validate.showError(scrub[i]);
        }
    },

    // CLEAR ERROR STYLING
    clearError: function(inp){
        var elm = inp;
        if (elm.className.match(/fieldError/)){
            elm.className = elm.className.replace("fieldError", "");
        }
    },

    // PAGE SUBMIT
    ajaxSubmit: function(frm, evt){
        var e = evt;

        validate.clearMessage();
        validate.clearPageErrors();

        var noErrors = validate.page(frm);
        if (noErrors == false){
            message.errors("page");
            var msgs = document.getElementById("messagesContainer");
            msgs.style.display = "none";
            return false;
        } else if (noErrors == true){
            for (i=0;i<frm.elements.length;i++){
                var elmID = frm.elements[i].id;
                if (defVal[elmID] == frm.elements[i].value){
                    frm.elements[i].value = null;
                }
//////// CODE INSERTED FOR CONTACT US SUBJECT LINE ////////////////////////////
                if ((frm.elements[i].id == "subject") && (frm.id == "contactus")){
                    frm.elements[i].value = "Washington Post Media: Careers: " + frm.elements[i].value;
                }
//////// CODE INSERTED FOR CONTACT US SUBJECT LINE ////////////////////////////
            }
            return true;
        }
    },
	submit: function(frm, evt){
		var e = evt;
		var noErrors = validate.page(frm);

		validate.clearMessage();

		if (noErrors == false){
			message.errors("page");
			var msgs = document.getElementById("messagesContainer");
			msgs.style.display = "none";
			if (e && e.stopPropagation && e.preventDefault) {
				e.stopPropagation();
				e.preventDefault();
			}
			if (window.event) {
				window.event.cancelBubble = true;
				window.event.returnValue = false;
				return false;
			}
		} else if (noErrors == true){
			return;
		}
    },

    // FORM VALIDATION
    page: function(frm){
        var f = frm;
        var noErrors = true;

        for (i=0;i<f.length;i++){
            if (f[i].className.match(/required/)){
                if ((f[i].value == defVal[f[i].id]) || (f[i].value == "")){
                    // If rating widget is included in page, this will check hidden field.
                    if (f[i].className.match(/rating/)){
                        validate.showError(document.getElementById(f[i].id + "Stars"));
                    }
                    validate.showError(f[i]);
                    noErrors = false;
                } else if ((f[i].className.match(/fieldError/)) && (!f[i].className.match(/scrub/))){
                    noErrors = false;
                }
            }
        }
        return noErrors;
    },

    // HIDE PAGE ERRORS
    hidePageErrors: function(){
        var pE = document.getElementById("errorsContainer");
        pE.style.display = "none";
    },

    // DISPLAY PAGE ERRORS
    showPageErrors: function(){
        var pE = document.getElementById("errorsContainer");
        pE.style.display = "block";
    }

};

// CREDIT CARD VALIDATION
var creditcard = {

    // LUHN
    luhn: function (typ, num, err){
        var error = false;
        var def = defVal[num.id];
        var errLoc = err;

        var ccNum = num.value;
        var ccType = typ.value;

        if (ccNum.match(/\D/) && (ccNum != def)){
            validate.message(num, 'Please enter only numbers.');
            error = true;
        }
        if ((ccNum != "") && (ccType != "") && (ccNum != def)){
            switch (ccType){
                case "mc" :
                    if (!ccNum.match(/5[1-5][0-9]{14}/) || (ccNum.length != 16)){
                        validate.message(num, 'This is a not valid MasterCard card.');
                        error = true;
                    }
                    break;
                case "vi" :
                    if ((!ccNum.match(/4([0-9]{12}|[0-9]{15})/)) || ((ccNum.length == 14) || (ccNum.length == 15) || (ccNum.length > 16))){
                        validate.message(num, 'This is a not valid Visa card.');
                        error = true;
                    }
                    break;
                case "ax" :
                    if (!ccNum.match(/3[47][0-9]{13}/) || (ccNum.length != 15)){
                        validate.message(num, 'This is a not valid American Express card.');
                        error = true;
                    }
                    break;
                case "dv" :
                    if (!ccNum.match(/6011[0-9]{12}/) || (ccNum.length != 16)){
                        validate.message(num, 'This is a not valid Discover card.');
                        error = true;
                    }
                    break;
                default:
                    validate.message(num, 'You entered invalid credit information.');
                    error = true;
            }
            if (error == true){
                return;
            } else if (error == false){
                validate.clearError(num);
                validate.clearMessage();
            }
        }
        if (((ccNum == def) || (ccNum == "")) && (errLoc != "page")) {
            num.value = def;
            if (!num.className.match(/fieldError/)){
                validate.clearError(num);
            }
            validate.clearMessage();
            error = false;
        }
        if (error == true){
            return;
        } else if (error == false){
            if (!num.className.match(/fieldError/)){
                validate.clearError(num);
            }
            validate.clearMessage();
        }
    },

    // SECURITY CODE
    securityCode: function (inp, ccType) {
        var error = false;
        var def = defVal[inp.id];
        var val = inp.value;
        if ((ccType != "") && (val == def)){
            inp.value = "";
            validate.clearError(inp);
        } else if (val == ""){
            inp.value = def;
        }
        if (((val != def) || (val != "")) && (ccType == "")){
            validate.message(inp, 'Please enter a credit card type first.');
            inp.value = def;
            error = true;
        } else if ((ccType != "") && (val == def)){
            validate.clearError(inp);
            return;
        }
        if ((ccType != "") && (val != def)){
            switch (ccType) {
                case "mc":
                case "ec":
                case "vi":
                case "dv":
                    if (((!val.match(/\d{3}/)) && (val != "")) || ((val.match(/\d{3}/)) && (val.length > 3))){
                        validate.message(inp, 'This is a not valid security code for the card type you entered.');
                        error = true;
                    }
                    break;
                case "ax":
                    if (((!val.match(/\d{4}/)) && (val != "")) || ((val.match(/\d{4}/)) && (val.length > 4))){
                        validate.message(inp, 'This is a not valid security code for the card type you entered.');
                        error = true;
                    }
                    break;
                default:
                    return false;
            }
        }
        if (error == true){
            return;
        } else if (error == false){
            validate.clearError(inp);
            return;
        }
    },

    // EXPIRATION DATE
    expires: function (mo, yr){
        var m = mo.value, y = yr.value;
        if ((m != "") && (y != "")){
            var today = new Date();
            var thisMo = (today.getMonth()) + 1;
            var thisYr = today.getFullYear();
            if (y < thisYr){
                validate.message(yr, "This card has expired. Please choose a different credit card.");
            } else if (y == thisYr){
                if (m < thisMo){
                    validate.message(mo, "This card has expired. Please choose a different credit card.");
                }
            }
            if (((y == thisYr) && (m >= thisMo)) || (y > thisYr)){
                validate.clearError(mo);
                validate.clearError(yr);
                validate.clearMessage();
            }
        } else if ((m != "") && (y == "")){
            validate.clearError(mo);
            validate.clearMessage();
        } else if ((m == "") && (y != "")){
            validate.clearError(yr);
            validate.clearMessage();
        }
    }

};

// PAGE MESSAGING AND ERRORS
var message = {
    process: function(){
        if (_M != null){
            message.messages();
        }
        if (_E != null){
            message.errors();
        }
    },
    errors: function(err){
        try {
            validate.defaults();
        } catch (e){
            // do nothing
        }

        var errs = document.getElementById('errorsContainer');
        var ulLs = document.getElementById('errList');
        var errLoc = err;
        var _e = _E;
        if ((_e.length > 0) || (errLoc == "page")){
            errs.style.display = 'block';
        } else {
            errs.style.display = 'none';
        }
        ulLs.innerHTML = "";
        for (i=0;i<_e.length;i++){
            if (typeof(_e[i]) != "undefined"){
                var li = document.createElement('li');
                var errList = _e[i].split('#', 2);
                var inpID = document.getElementsByClassName(errList[0]);
                if (inpID.length > 1){
                    for (j=0;j<inpID.length;j++){
                        if (typeof(inpID[j]) != "undefined"){
                            validate.showError(inpID[j]);
                        }
                    }
                    li.appendChild(document.createTextNode(errList[1]));
                    ulLs.appendChild(li);
                } else if (inpID.length == 1){
                    validate.showError(inpID[0]);
                    li.appendChild(document.createTextNode(errList[1]));
                    ulLs.appendChild(li);
                } else if (inpID.length == 0){
                    li.appendChild(document.createTextNode(errList[1]));
                    ulLs.appendChild(li);
                }
            }
        }
        window.scrollTo(0,0);
    },
    messages: function(){
        var ms = document.getElementById('messagesContainer');
        var _m = _M;
        if (_m.length > 0){
            ms.style.display = 'block';
        } else {
            ms.style.display = 'none';
        }
        var ulLs = document.getElementById('msgList');
        for (i=0;i<_m.length;i++){
            if (typeof(_m[i]) != "undefined"){
                var li = document.createElement('li');
                var m = _m[i];
                li.appendChild(document.createTextNode(m));
                ulLs.appendChild(li);
            }
        }
        window.scrollTo(0,0);
    }
};

// UTILITY TO GET ALL ELEMENTS BY CLASSNAME
document.getElementsByClassName = function(cl) {
    var retnode = [];
    var myclass = new RegExp('\\b'+cl+'\\b');
    var elem = this.getElementsByTagName('*');
    for (var i = 0; i < elem.length; i++) {
        var classes = elem[i].className;
        if (myclass.test(classes)){
            retnode.push(elem[i]);
        }
    }
    return retnode;
};

/* RATINGS METHODS */
var ratings = {
    // THIS SECTION IS FOR INPUTTING A RATING IN A FORM

    setLeft: function(elm, num){
        var s = elm;
        ratings.unsetStars();
        if (s.className.search(/leftEmpty/) != -1){
            s.className = s.className.replace(/leftEmpty/, 'leftFull');
        }
        ratings.fillStar(num);
    },

    setRight: function(elm, num){
        var s = elm;
        ratings.unsetStars();
        if (s.className.search(/rightEmpty/) != -1){
            s.className = s.className.replace(/rightEmpty/, 'rightFull');
        }
        ratings.fillStar(num);
    },

    // clears stars to allow for rollovers
    unsetStars: function(){
        for (i=0;i<10;i++){
            var ss = document.getElementById(('star_' + (i + 1)));
            if (ss.className.search(/leftFull/) != -1){
                ss.className = ss.className.replace(/leftFull/, 'leftEmpty');
            }
            if (ss.className.search(/rightFull/) != -1){
                ss.className = ss.className.replace(/rightFull/, 'rightEmpty');
            }
        }
    },

    // sets stars from 'rating' value
    setStars: function(){
        var inp = document.getElementById('rating');
        var num = (inp.value * 2); // since ratings are in 1/2 stars
        ratings.unsetStars();
        ratings.fillStar(num);
    },

    fillStar: function(num) {
        for (i=0;i<num;i++){
            var ss = document.getElementById(('star_' + (i + 1)));
            if (ss.className.search(/leftEmpty/) != -1){
                ss.className = ss.className.replace(/leftEmpty/, 'leftFull');
            }
            if (ss.className.search(/rightEmpty/) != -1){
                ss.className = ss.className.replace(/rightEmpty/, 'rightFull');
            }
        }
    },

    setRating: function(num){
        var rt = document.getElementById('rating');
        rt.value = num;
        ratings.clearError();
    },

    setAverage: function(rate){
        var rt = document.getElementById('rating');
        if ((0 <= rate) && (rate <= .25)){
            rt.value = "0.0";
        } else if ((.26 <= rate) && (rate <= .75)){
            rt.value = "0.5";
        } else if ((.75 <= rate) && (rate <= 1.25)){
            rt.value = "1.0";
        } else if ((1.26 <= rate) && (rate <= 1.75)){
            rt.value = "1.5";
        } else if ((1.76 <= rate) && (rate <= 2.25)){
            rt.value = "2.0";
        } else if ((2.26 <= rate) && (rate <= 2.75)){
            rt.value = "2.5";
        } else if ((2.76 <= rate) && (rate <= 3.25)){
            rt.value = "3.0";
        } else if ((3.26 <= rate) && (rate <= 3.75)){
            rt.value = "3.5";
        } else if ((3.76 <= rate) && (rate <= 4.25)){
            rt.value = "4.0";
        } else if ((4.26 <= rate) && (rate <= 4.75)){
            rt.value = "4.5";
        } else if (rate >= 4.75){
            rt.value = "5.0";
        }
        ratings.setStars();
        ratings.clearError();
    },

    clearError: function(){ // need to add element being passed in since we can have more than one rating per page
        var rt = document.getElementById('ratingStars');
        var rtInp = document.getElementById('rating');
        if (rt.className.search(/fieldError/) != -1){
            rt.className = rt.className.replace(/fieldError/, "");
        }
        if (rtInp.className.search(/fieldError/) != -1){
            rtInp.className = rtInp.className.replace(/fieldError/, "");
        }
    },

    // THIS SECTION IS FOR RATING START DISPLAY

    // to populate rating stars from any rating, print it out in a <div class="starRating"></div> and call ratings.displayStars(); on page load
    // this function will replace all numeric values from 0.0 to 5.0 and fail gracefully if the content of the div is not a number
    displayStars: function(){
        var elms = document.getElementsByClassName('starRating');
        for (i=0;i<elms.length;i++){
            var elmRt = elms[i].innerHTML;
            if (isNaN(elmRt) == false){
                elms[i].innerHTML = "&nbsp;";
                var cls = ratings.getClass(elmRt);
                elms[i].className = elms[i].className += " " + cls;
            }
        }
    },

    getClass: function(rate){
        var rt = "";
        if (rate == 0){
            rt = "star_unrated";
        } else if ((0 < rate) && (rate <= .75)){
            rt = "star_half";
        } else if ((.75 <= rate) && (rate <= 1.25)){
            rt = "star_one";
        } else if ((1.26 <= rate) && (rate <= 1.75)){
            rt = "star_oneHalf";
        } else if ((1.76 <= rate) && (rate <= 2.25)){
            rt = "star_two";
        } else if ((2.26 <= rate) && (rate <= 2.75)){
            rt = "star_twoHalf";
        } else if ((2.76 <= rate) && (rate <= 3.25)){
            rt = "star_three";
        } else if ((3.26 <= rate) && (rate <= 3.75)){
            rt = "star_threeHalf";
        } else if ((3.76 <= rate) && (rate <= 4.25)){
            rt = "star_four";
        } else if ((4.26 <= rate) && (rate <= 4.75)){
            rt ="star_fourHalf";
        } else if (rate >= 4.75){
            rt = "star_five";
        }
        return rt;
    }

};

