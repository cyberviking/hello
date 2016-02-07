<?php
include("include/myFunctions.php");
include("include/kick_or_open_mysql_if_connected.php"); //CREATE CONNECTION ON MYSQL DATABASE + CREATE $INFOUSER FROM "liste_users" DATABASE
?>
<script>
//SYNC WITH SERVER DATES
var TIMEPAGE = new Date().getTime();
var today_serv=<?php echo round(time()/86400)-$INFOUSER['my_first_day']; ?>;
var my_last_sync=<?php echo $INFOUSER['my_last_sync'] ?>;
if(today_serv!=my_last_sync){window.location="http://localhost/jquery_wikiface/sTaTs/syncWithServ.php";}
scroll=0;
</script>
<!DOCTYPE html>
<html>
<head>
	<?php
	$xml_score=simplexml_load_file("TRAD/score.xml");
	include("include/all_var_js.php"); //Toutes mes variables en javascript, mes_langues, mes_suejts...
	include("gen_js/gen_var_LISTE.html");
	include("gen_js/gen_size_js.html");
	include("gen_js/gen_folders_files.html");
	include("include/user_online.php"); //A CHAQUE FOIS ???
	?>
	<title>WikiFace</title>
	<meta charset="UTF-8" />
	<!-- CSS AND PERSONAL FONT -->
	<link href="Css.css" rel="stylesheet">
	<style>html{font-family:<?php echo $INFOUSER['currentFont']; ?>;};</style>
	<!-- JQUERY -->
	<script type="text/javascript" src="themes/GENERAL/external/jquery/jquery.js"></script>
	<script type="text/javascript" src="themes/GENERAL/jquery-ui.js"></script>
	<!-- JQUERY UI -->
	<link href="themes/<?php echo "{$INFOUSER['currentTemplate']}"; ?>/theme.css" rel="stylesheet">
	<link href="themes/<?php echo "{$INFOUSER['currentTemplate']}"; ?>/jquery-ui.css" rel="stylesheet">
	<!-- NOTIFICATIONS -->
	<script type="text/javascript" language="javascript" src="addons/jquery.notify.js"></script>
	<link href="addons/ui-notify.css" rel="stylesheet">
	<!-- DATATABLE ADDON -->
	<link rel="stylesheet" type="text/css" href="addons/dataTables.jqueryui.css">
	<script type="text/javascript" language="javascript" src="addons/DataTables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="addons/DataTables/media/js/dataTables.jqueryui.js"></script>
	<!-- JQUERY MULTITABLE -->
	<script type="text/javascript" language="javascript" src="addons/jquery.ui.multiprogressbar.js"></script>
	<!-- PLOT CHARTS -->
	<script type="text/javascript" src="addons/flot.js"></script>
	<style>
		.plot_chart{margin:0px;padding:0px;width:1100px;height:150px;text-align:center;}
		#chart_wikiface{width:770px;}
	</style>
	<?php if($INFOUSER['chart']==0) echo '<style>.plot_chart{display:none;}</style>';?>
	<script>
	//alert($(document).scrollTop());
	function getClassProperty(clazz,prop,type){
		type = (type || false) ? type : "div";
		var dummy = $("<"+type+" style='display=none;'></"+type+">").addClass(clazz).appendTo("body");
		var value = dummy.css(prop);
		dummy.remove();
		if(value.indexOf("rgb") != -1){
			var digits = /(.*?)rgba?\((\d+),\s?(\d+),\s?(\d+)[\),]/.exec(value);
			return "#" + (parseInt(digits[4])|(parseInt(digits[3])<<8)|(parseInt(digits[2])<<16)).toString(16);
		}else{
			return value;
		}
	}
	(function($) {
	$.fn.outerHTML = function(s) {
		return (s) 
			? this.before(s).remove() 
			: $('<p>').append(this.eq(0).clone()).html();
	}
	})(jQuery);
	</script>
</head>
<body id="my_body">

<div style="display:none;" id="nottop">
	
<!-- START : NOTIFICATIONS -->	
<div id="container" style="display:none;z-index:999;">
	<div id="default">
		<h1>#{title}</h1>
		<p>#{text}</p>
	</div>
</div>
<script>$("#container").notify();</script>
<!--<form><input type="button" onclick='$("#container").notify("create", {title: "Test Notification",text: "This is an example of the default config, and will fade out after five seconds."});' /></form>
<!-- END : NOTIFICATIONS -->	

<!-- PERSONAL : jquery ui colors in canvas -->
<div id="bottom_right" class="ui-state-focus"></div>
<div id="bottom_left" class="ui-state-focus"></div>

<script>
//alert($(document).scrollTop());
function getClassProperty(clazz,prop,type){
	type = (type || false) ? type : "div";
	var dummy = $("<"+type+" style='display=none;'></"+type+">").addClass(clazz).appendTo("body");
	var value = dummy.css(prop);
	dummy.remove();
	if(value.indexOf("rgb") != -1){
		var digits = /(.*?)rgba?\((\d+),\s?(\d+),\s?(\d+)[\),]/.exec(value);
		return "#" + (parseInt(digits[4])|(parseInt(digits[3])<<8)|(parseInt(digits[2])<<16)).toString(16);
	}else{
		return value;
	}
}
//var ui_back_color = getClassProperty("ui-state-default","background-color");
var ui_color = getClassProperty("ui-state-default","color");
var ui_color_progress_bar = getClassProperty("ui-widget-header","background");
var wi = $(window).width();
var hi = $(window).height();
</script>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1" class="t_score">
			<img src="img/ico/score.png" />
		</a></li>
		<li><a href="#tabs-2" class="t_options">
			<img src="img/ico/options.png" />
		</a></li>
		<li><a href="include_tabs/discussions.php" class="t_discussions">
			<img src="img/ico/discussions.png" />
		</a></li>
		<li><a href="include_tabs/mes_discussions.php" class="t_mes_discussions">
			<img src="img/ico/mesdiscussions.png" />
		</a></li>
		<li><a href="include_tabs/messages.php">
			<img src="img/ico/messages.png" />
			<span class="t_messages"></span>
			<span id="nb_new_messages"></span>
		</a></li> <!-- DYNAMIC MESSAGES -->
		<li><a href="include_tabs/utilisateurs.php" class="t_utilisateurs">
			<img src="img/ico/users.png" />
		</a></li>
	</ul>
	<div id="tabs-1"><?php include("include_tabs/score.php"); ?></div>
	<div id="tabs-2"><?php include("include_tabs/options.php"); ?></div>
</div>
<!--	<div id="tabs-2"><php include("include_tabs/options.php"); ?></div>
	<div id="tabs-3"><php include("include_tabs/cours.php"); ?></div> -->

</div><!-- END nottop -->

</body>
<script>
//index : MAIN TAB
$("#tabs").tabs({show: { effect: "fade", duration: 500 },hide: { effect: "fade", duration: 500 }});
//score : MAIN ACCORDION
$("#accordion_mes_scores").accordion({ collapsible: true, heightStyle: "content", active:false }); //active:false permet de ne pas dérouler par défaut le premier accordéon (maybe bug with hide)
//score : DISABLE ONCLICK ACCORDION IF EMPTY DIV AFTER H3
$(".another_accordion").accordion({ collapsible: true, heightStyle: "content", active:false }).sortable({axis: "y",handle: "h3"});
//score : PUT IT ALL UP FOR BETTER VISIBILITY
for(I=0;I!=listeSummary.length;I++){$("#go-up-"+listeSummary[I]).prependTo("#acc-"+listeSummary[I]);}
$("#go-up-wikiface").prependTo("#accordion_mes_scores");
//score : remove the arrow icon for db file
$(".no-icon .ui-accordion-header-icon").hide();
//obsolete ???
//$("#accordion_messages").accordion({ collapsible: true, heightStyle: "content" });
//obsolete ???
//$(".no-icon").addClass("ui-state-content");//change header style :0

//dialogs_assoc obsolete because no "modify ny interests" button anymore ???
/*
function prepare_dialogs_assoc(NaMe){
	document.write("<div class=\"dialog_assoc_"+NaMe+"\">"+NaMe+"");
	if(typeof link_dossiers_enfants[NaMe] === 'undefined'){alert(link_dossiers_enfants[NaMe])}
	else{
		//alert(NaMe);
		//TOUS LES ENFANTS DU SUJET
		for (var k = 0; k < link_dossiers_enfants[NaMe].length; k++){
			document.write("<div id=\"divassoc_"+link_dossiers_enfants[NaMe][k]+"\"><div><input type=\"checkbox\" id=\"bassoc_"+link_dossiers_enfants[NaMe][k]+"\" /><label style=\"width:170px;\" for=\"bassoc_"+link_dossiers_enfants[NaMe][k]+"\">"+link_dossiers_enfants[NaMe][k].replace(/.*__/,"")+"</label></div></div>");
			liste_assoc_button.push(link_dossiers_enfants[NaMe][k]);
		}
	}
	document.write("</div>");//close dialog assoc
	$(".dialog_assoc_"+NaMe).dialog({
		close: function(ev, ui) {//ex NaMe : language__en__words
			sub_str=NaMe.split('__');
			var chainSujets=sub_str[0];//language
			for(i=1;sub_str.hasOwnProperty(i);i++){//3 times (before + new)
				tmp=sub_str[i-1]+"__"+sub_str[i];
				chainSujets=chainSujets+"#"+tmp;
			}
			scroll=$(document).scrollTop();
			window.location.hash="#score#"+chainSujets+"#"+scroll;window.location.reload(true); },
		show: {effect: "fade",duration: 500},
		hide: {effect: "fade",duration: 500},
		autoOpen: false,
		modal: true,
		width: 205
	});
	//Button "Modify my interests"
	//$(".dialoglink_assoc_"+NaMe).button({icons: {primary: "ui-icon-suitcase"}}).click(function( event ) {$(".dialog_assoc_"+NaMe).dialog( "open" );event.preventDefault();});
}
//close: function(ev, ui) { window.location.hash="#assoc";location.reload(); },
//FOREACH computer, language, geography
liste_assoc_button=[];
for(i=0;i!=liste_assoc_dialog.length;i++){
	NaMe=liste_assoc_dialog[i];
	//CREATE DIALOG WITH LIST
	prepare_dialogs_assoc(NaMe)
}
for(l=0;l!=liste_assoc_button.length;l++){
	prepare_button_assoc_dossier(liste_assoc_button[l]);
}
*/

//score : show mes sujets dans l'accordeon
for(j=0;j!=mes_dossiers.length;j++){
	$(".sAssoc_"+mes_dossiers[j]).show();
	//obsolete because of no "modify my interest" button
	//$("#bassoc_"+mes_dossiers[j]).prop("checked","checked").button("refresh");
}
//ALWAYS SHOW SUB SUJET LVL 3 4 :p
$(".s3").show();
$(".s4").show();

<!-- LAUNCH WHEN PAGE IS FULLY LOADED -->
$(document).ready(function() {

//in options already
//options : ENABLE IF IN MES_DOSSIERS (green/red icon)
/*
$(".elemsub").each(function() {
	var TX=$(this).attr('alt');
	if(mes_dossiers.indexOf(TX)>-1){
		$(this).attr('src',"img/ico/green.png");
		PARENT=$(this).attr('name');
		//IF EVERYTHING IS GREEN TURN GREEN
		ALL=1;
		$(".sub_"+PARENT).each(function() {
			if($(this).attr('src')==="img/ico/red.png") ALL=0;
		});
		if(ALL==1) $("#"+PARENT).attr('src',"img/ico/green.png");
		else $("#"+PARENT).attr('src',"img/ico/blue.png");
	}
});
*/
//RANDOM STUFF
//$(".t_mes_themes").append(" \""+mon_theme+"\""); //AJOUTE A H3 LE NOM DU THEME APRES LES : DU TITRE
//$("#animations").switchButton({sujet:"animation",checked: animation,labels_placement: "right",width: 35,height: 13,button_width: 15});
//SWITCH BUTTONS IN OPTIONS MES OPTIONS
//$("#chart").switchButton({sujet:"chart",checked: chart,labels_placement: "right",width: 35,height: 13,button_width: 15});
//ADAPT THEME TO SWITCH
//$(".switch-button-background").addClass("ui-state-focus");$(".switch-button-button").addClass("ui-widget-header");
//$("#slider_messagerie").slider({min:1,max:3,range:"min"}).change(function() {alert("sss");});
//$("#slider_animation").slider({min:1,max:2,range:"min"});

//MOVE THIS UP ??? why here ? :p
var animation=<?php if($INFOUSER['animation']==1) echo "true"; else echo "false"; ?>;
var chart=<?php if($INFOUSER['chart']==1) echo "true"; else echo "false"; ?>;
//DISABLE ANIMATIONS FOR WEAK COMPUTER (OPTION ???)
<?php if(!$INFOUSER['animation']) echo "$.fx.off = !$.fx.off;";?>

//DISABLE BUG DRAG

//score : GO TO SCORE AND SPECIFIC PLACE IF NEEDED
if(window.location.hash){
	//SI ANCRE #options go tab 2
	if(window.location.hash=="#options"){
		$("#tabs").tabs({ active: 1 });
	}
	else{
		//SI ANCRE #messages go tab 5
		if(window.location.hash=="#messages"){
			$("#tabs").tabs({ active: 4 });
		}
		else{
			//#score move on the correct recorded spot
			HASH=window.location.hash.replace(/#score/,""); //"#sujet1#sujet2#sujet3#570"
			sujet1=HASH.replace(/^#/,"").replace(/#.*/,""); //sujet1
			sujet2=HASH.replace(/#[^#]*#/,"").replace(/#.*/,""); //sujet2
			sujet3=HASH.replace(/#[^#]*#[^#]*#/,"").replace(/#.*/,""); //sujet3 ???
			scroll=HASH.replace(/.*#/,""); //570
			//$("#tabs").tabs({ active: 0 });
			$("#progress_bar_s1_"+sujet1).click();
			$("#progress_bar_s2_"+sujet2).click();
			$("#progress_bar_s3_"+sujet3).click();
			//alert(scroll);
		}
	}
}

$("#nottop").show();//can't avoid blinking ? :'(
//alert(scroll);
$("html").css("background","none");

var elapsed = new Date().getTime() - TIMEPAGE;
document.getElementById("top").innerHTML=elapsed+"ms";

cMp=0;
handle=setInterval(function() {
	$(document).scrollTop(scroll);
	if($(document).scrollTop()==scroll) clearInterval(handle);
	cMp++;if(cMp == 100) clearInterval(handle); //STOP after 100 tries
},0);
//alert(scroll);

//WRITE PROFILE ON FILE
//alert($('#accordion_mes_scores').html());
//$.ajax({type: "POST",data: {"content":$('#accordion_mes_scores').html()},url: "sQl/ajax:write_profile_on_file.php",success: function(data){console.log("Success");alert("SucceSS");},error: function(data){console.log("Fail");}});

//}); //END OF DOCUMENT READY

//$(function() { //launched many times !!! :s
var language = "<?php echo $INFOUSER['currentLanguage']; ?>";
//APPEND
$.ajax({
    type: "GET",
	url: 'traduction_append.xml',
    dataType: "xml",
	success: function(xml) {
		$(xml).find('translation').each(function(){
			var id = $(this).attr('id');
			var text = $(this).find(language).text();
			$("." + id).append(text);
			//JUST ADD HERE SCROLL
		});
	}
});
//PREPEND
$.ajax({
    type: "GET",
	url: 'traduction_prepend.xml',
    dataType: "xml",
	success: function(xml) {
		$(xml).find('translation').each(function(){
			var id = $(this).attr('id');
			var text = $(this).find(language).text();
			$("." + id).prepend(text);
			//JUST ADD HERE SCROLL
		});
	}
});

});//END OF DOCUMENT READY
</script>

<?php
//capture number of unread messages
$req1=log_mysql_query("select * from pm_topics where (topic_for_id={$INFOUSER['id']} and user2read='no') OR (topic_by_id={$INFOUSER['id']} and user1read='no');");
$NBNEWMESSAGES=intval(mysql_num_rows($req1));
//if have unread messages, change the content of the menu
if($NBNEWMESSAGES){echo "<script>$('#nb_new_messages').html(' ({$NBNEWMESSAGES})');</script>";}
?>

<script>
//CHECKNEW MESSAGES EVERY MINUTE
$.extend({
	xResponse: function(url, data) {
		// local var
		var theResponse = null;
		// jQuery ajax
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			dataType: "html",
			//async: false,
			success: function(respText) {
				theResponse = respText;
			}
		});
		// Return the response text
		return theResponse;
	}
});
//What does that do ???
//$('body').bind('beforeunload',function(){$('#nottop').hide();});
//What does that do ???
//change reload message by location.reload() with #messages
function reloadMessages(){$("#tabs").tabs( "option", "active", 1 );$("#tabs").tabs( "option", "active", 4 );}
nb_messages=<?php echo $NBNEWMESSAGES; ?>;
//clearTimeout(handle);
handle2=setInterval(function() {
	var xData = $.xResponse('sQl/sjax:check_new_message.php', {issession: 1,selector: true});
	if(xData!=0) if(!!xData) $("#nb_new_messages").html(" ("+xData+")");
	if(xData!=nb_messages){ //NOUVEAU MESSAGE !!!
		if($("#tabs").tabs("option","active")==4) reloadMessages();//SI FENETRE MESSAGE ACTIVE, REFRESH ;)
	}
	nb_messages=xData;
//}, 1000 * 60 * 1); //CHECK NEW MESSAGES EVERY 1 MINUTE
}, 30000); //CHECK NEW MESSAGES EVERY 1 MINUTE
</script>
</html>
