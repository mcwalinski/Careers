<?php $imgurl = get_bloginfo('template_directory'); ?>
<?php $linkurl = get_bloginfo('url'); ?>
<SCRIPT LANGUAGE=JavaScript1.1>
    <!--
    var MM_contentVersion = 10;
    var plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
    if ( plugin ) {
        var words = navigator.plugins["Shockwave Flash"].description.split(" ");
        for (var i = 0; i < words.length; ++i)
        {
            if (isNaN(parseInt(words[i])))
                continue;
            var MM_PluginVersion = words[i];
        }
        var MM_FlashCanPlay = MM_PluginVersion >= MM_contentVersion;
    }
    else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0
        && (navigator.appVersion.indexOf("Win") != -1)) {
        document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n'); //FS hide this from IE4.5 Mac by splitting the tag
        document.write('on error resume next \n');
        document.write('MM_FlashCanPlay = ( IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash." & MM_contentVersion)))\n');
        document.write('</SCR' + 'IPT\> \n');
    }
    if ( MM_FlashCanPlay ) {
        document.write('<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"');
        //document.write('<OBJECT');
        document.write('  codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ');
        document.write(' ID="script" WIDTH="612" HEIGHT="385" ALIGN="">');
        document.write(' <PARAM NAME=movie VALUE="<?php echo $imgurl ?>/flash/movie02.swf"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF>  ');
        document.write(' <EMBED src="<?php echo $imgurl ?>/flash/movie02.swf" quality=high bgcolor=#FFFFFF  ');
        document.write(' swLiveConnect=FALSE WIDTH="612" HEIGHT="385" NAME="script" ALIGN=""');
        document.write(' TYPE="application/x-shockwave-flash" PLUGINSPAGE="https://www.macromedia.com/go/getflashplayer">');
        document.write(' </EMBED>');
        document.write(' </OBJECT>');
    } else{
        document.write('<img src="<?php echo $imgurl ?>/images/hp_intro_backup.gif" alt="image" width="612" height="385" border="0" usemap="#Map"/>'+
            '<map name="Map" id="Map">'+
            '<area shape="rect" coords="31,172,208,191" href="<?php echo $linkurl ?>/?category_name=contactus" target="_self" />'+
            '<area shape="rect" coords="455,219,547,234" href="https://www.macromedia.com/go/getflashplayer" target="_blank" />'+
            '</map>');
    }
   //-->
</SCRIPT><NOSCRIPT>
    <img src="<?php echo $imgurl ?>/images/hp_intro_backup.gif" alt="image" width="612" height="385" border="0" usemap="#Map" />
    <map name="Map" id="Map">
        <area shape="rect" coords="31,172,208,191" href="<?php echo $linkurl ?>/?category_name=contactus" target="_self" />
        <area shape="rect" coords="455,219,547,234" href="https://www.macromedia.com/go/getflashplayer" target="_blank" />
    </map>
</NOSCRIPT>