<script type="text/javascript">
    window.onload = init;
    var defVal = {
        "name"  			: "Ex: Joe Smith",
        "email" 			: "Ex: email@address.com",
        "departments"		: "choose one",
        "subject"			: "Ex: Subject",
        "message"			: "Ex: Message"
    };
    var _E = "";
    var _M = "";
    function init(){
        message.process();
        validate.defaults();
    }
</script>
<div id="errorsContainer">
	<div id="errors">
		<p class="bold">Please correct the errors below</p>
		<ul id="errList">
		</ul>
	</div>
</div>
<div id="messagesContainer">
	<div id="messages">
		<ul id="msgList">
		</ul>
	</div>
</div>
<h2>If you have any questions about Washington Post Media careers or our application process, please use the following form to contact us. One of our Human Resources professionals will get back to you within 48 hours.</h2>
<p>* All fields below are required.</p>
<form id="contactus" name="contact">
    <label for="name">First and Last Name:</label><br /><input type="text" id="name" class="bigInput required blank" name="name" onblur="validate.blank(this);" onfocus="validate.focus(this);"></input><br />
    <label for="email">Email Address:</label><br /><input type="text" id="email" class="bigInput required email" name="email" onblur="validate.email(this);" onfocus="validate.focus(this);"></input><br />
    <label for="departments">Product:</label><br /><select id="departments" class="bigInput required blank" name="departments" onblur="validate.blank(this);" onfocus="validate.focus(this);">
        <option value="choose one">choose one</option>
        <option value="The Washington Post">The Washington Post</option>
        <option value="Express">Express</option>
        <option value="El Tiempo Latino">El Tiempo Latino</option>
    </select><br />
    <label for="subject">Subject:</label><br /><input type="text" id="subject" class="bigInput required blank" name="subject" onblur="validate.blank(this);" onfocus="validate.focus(this);"></input><br />
    <label for="message">Message:</label><br /><textarea id="message" class="bigInput required blank" name="message" onblur="validate.blank(this);" onfocus="validate.focus(this);"></textarea><br />
    <input type="hidden" id="preferredContact" name="preferredContact" value="email"></input>
    <input type="hidden" id="source" name="source" value="careers"></input>
    <input type="hidden" id="inputtype" name="inputtype"></input>
    <input type="submit" value="" class="sbmtBtn"></input>
</form>
<script type="text/javascript">
    var contactUsUrl = "contactus.nsf/contactService?openagent";
    careers.setContactUs(contactUsUrl);
</script>
