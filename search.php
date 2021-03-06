<?php
// English Configuration
$my_server = "http://".getenv("SERVER_NAME").":".getenv("SERVER_PORT"); // Your Server (generally no changes needed)
$my_root = getenv("DOCUMENT_ROOT"); // Your document root (generally no changes needed)
$s_dirs = array("/search/dir1","/search/dir2"); // Which directories should be searched ("/dir1","/dir2","/dir1/subdir2","/Verzeichniss2/Unterverzeichniss2")? --> $s_dirs = array(""); searches the entire server
$s_skip = array("..",".","subdir2"); // Which files/dirs do you like to skip?
$s_files = "html|htm|HTM|HTML|php3|php4|php|txt"; // Which files types should be searched? Example: "html$|htm$|php4$"
$min_chars = "3"; // Min. chars that must be entered to perform the search
$max_chars = "30"; // Max. chars that can be submited to perform the search
$default_val = "Searchphrase"; // Default value in searchfield
$limit_hits = array("5","10","25","50","100"); // How many hits should be displayed, to suppress the select-menu simply use one value in the array --> array("100")
$message_1 = "Invalid Searchterm!"; // Invalid searchterm
$message_2 = "Please enter at least '$min_chars', highest '$max_chars' characters."; // Invalid searchterm long ($min_chars/$max_chars)
$message_3= "Your searchresult for:"; // Headline searchresults
$message_4 = "Sorry, no hits."; // No hits
$message_5 = "results"; // Hits
$message_6 = "Match case"; // Match case
$no_title = "Untiteled"; // This should be displayed if no title or empty title is found in file
$limit_extracts_extracts = ""; // How many extratcts per file do you like to display. Default: "" --> every extract, alternative: 'integer' e.g. "3"
$byte_size = "51200"; // How many bytes per file should be searched? Reduce to increase speed

/*
// Deutsche Konfiguration
$my_server = "http://".getenv("SERVER_NAME").":".getenv("SERVER_PORT"); // Zu durchsuchender Server
$my_root = getenv("DOCUMENT_ROOT"); // Wurzelverzeichnis fuer die Suche
$s_dirs = array("/search/dir1","/search/dir2"); // Welche Verzeichnisse ("/Verzeichniss1","/Verzeichniss2","/Verzeichniss2/Unterverzeichniss1","/Verzeichniss2/Unterverzeichniss2") im Wurzelverzeichnis sollen durchsucht werden? --> $s_dirs = array(""); durchsucht den ganzen Server
$s_skip = array("..",".","subdir2"); // Welche Ordner oder Dateien sollen ausgelassen werden?
$s_files = "html|htm|HTM|HTML|php3|php4|php|txt"; // Welche Dateien (Endung) sollen durchsucht werden? Beispiel fuer mehrere Endungen: "html$|htm$|php4$"
$min_chars = "3"; // Wieviel Zeichen muessen mind. bei der Suche eingegeben werden?
$max_chars = "30"; // Wieviel Zeichen duerfen max. bei der Suche eingegeben werden?
$default_val = "Begriff"; // Default Wert im Suchfeld
$limit_hits = array("5","10","25","50","100"); // Max. Treffer anzeigen, um das select-menue zu unterdruecken und beispielsweise max. 100 Treffer anzuzeigen --> array("100")
$message_1 = "Ung&uuml;ltiger Suchbegriff!"; // Zuwenig/zuviel Zeichen in der Suche
$message_2 = "Bitte geben Sie mindestens '$min_chars', maximal '$max_chars' Zeichen ein, zusammenh&auml;ngende Begriffe durch ein Leerzeichen getrennt."; // Ungueltige Suchanfrage ($min_chars/$max_chars)
$message_3= "Suchergebnisse f&uuml;r:"; // Ueberschrift Suchergebnisse
$message_4 = "Die Suche ergab leider keinen Treffer."; // Keinen Treffer
$message_5 = "Treffer"; // Treffer
$message_6 = "Gro�-/Kleinschreibung beachten"; // Gro�-/Kleinschreibung beachten
$no_title = "Ohne Titel"; // Kein Titel in Datei
$limit_extracts = ""; // Wieviele Treffer (Auszuege) sollen _pro Dokument_ ausgegeben. Default: "" also alle, Alternativ: 'Zahl' z.B. "2"
$byte_size = "51200"; // Wieviel byte sollen pro zu durchsuchender html-Datei durchsucht werden (Je kleiner, desto schneller die Suche, desto geringer die Chance auf einen Treffer --> html-Dateien sollten eigentlich nicht groesser als 10 KB, also 10240 byte sein) Default: '51200', weil grosse Dateien vorhanden?
*/

//ini_set("error_reporting", "2047"); // Debugger

// search_form(): Gibt das Suchformular aus
function search_form($HTTP_GET_VARS, $limit_hits, $default_val, $message_5, $message_6, $PHP_SELF) {
	@$keyword=$HTTP_GET_VARS['keyword'];
	@$case=$HTTP_GET_VARS['case'];
	@$limit=$HTTP_GET_VARS['limit'];
	echo
	"<form action=\"$PHP_SELF\" method=\"GET\">\n",
	"<input type=\"hidden\" value=\"SEARCH\" name=\"action\">\n",
	"<input type=\"text\" name=\"keyword\" class=\"text\" size=\"10\"  maxlength=\"30\" value=\"";
	if(!$keyword)
		echo "$default_val";
	else
		echo str_replace("&amp;","&",htmlentities($keyword));
	echo "\" ";
	echo "onFocus=\" if (value == '";
	if(!$keyword)
		echo "$default_val"; 
	else
		echo str_replace("&amp;","&",htmlentities($keyword));
	echo "') {value=''}\" onBlur=\"if (value == '') {value='";
	if(!$keyword)
		echo "$default_val"; 
	else
		echo str_replace("&amp;","&",htmlentities($keyword));
	echo "'}\"> ";
	$j=count($limit_hits);
	if($j==1)
		echo "<input type=\"hidden\" value=\"".$limit_hits[0]."\" name=\"limit\">";
	elseif($j>1) {
		echo
		"<select name=\"limit\" class=\"select\">\n";
		for($i=0;$i<$j;$i++) {
			echo "<option value=\"".$limit_hits[$i]."\"";
			if($limit==$limit_hits[$i])
				echo "SELECTED";
			echo ">".$limit_hits[$i]." $message_5</option>\n";
			}
		echo "</select> ";
		}
	echo
	"<input type=\"submit\" value=\"OK\" class=\"button\">\n",
	"<br>\n",
	"<span class=\"checkbox\">$message_6</span> <input type=\"checkbox\" name=\"case\" value=\"true\" class=\"checkbox\"";
	if($case)
		echo " CHECKED";
	echo
	">\n",
	"<br>\n",
	"<a href=\"http://www.terraserver.de/\" class=\"ts\" target=\"_blank\">Powered by terraserver.de/search</a>",
	"</form>\n";
	}

// search_headline(): Ueberschrift Suchergebnisse
function search_headline($HTTP_GET_VARS, $message_3) {
	@$keyword=$HTTP_GET_VARS['keyword'];
	@$action=$HTTP_GET_VARS['action'];
	if($action == "SEARCH") // Volltextsuche
		echo "<h1 class=\"result\">$message_3 '<i>".htmlentities(stripslashes($keyword))."</i>'</h1>";
	}

// search_error(): Auf Fehler testen und Suchfehler anzeigen
function search_error($HTTP_GET_VARS, $min_chars, $max_chars, $message_1, $message_2, $limit_hits) {
	global $HTTP_GET_VARS;
	@$keyword=$HTTP_GET_VARS['keyword'];
	@$action=$HTTP_GET_VARS['action'];
	@$limit=$HTTP_GET_VARS['limit'];
	if($action == "SEARCH") { // Volltextsuche
		if(strlen($keyword)<$min_chars||strlen($keyword)>$max_chars||!in_array ($limit, $limit_hits)) { // Ist die Anfrage in Ordnung (min. '$min_chars' Zeichen, max. '$max_chars' Zeichen)?
			echo "<p class=\"result\"><b>$message_1</b><br>$message_2</p>";
			$HTTP_GET_VARS['action'] = "ERROR"; // Suche abbrechen
			}
		}
	}


// search_dir(): Volltextsuche in Verzeichnissen
function search_dir($my_server, $my_root, $s_dirs, $s_files, $s_skip, $message_1, $message_2, $no_title, $limit_extracts, $byte_size, $HTTP_GET_VARS) {
	global $count_hits;
	@$keyword=$HTTP_GET_VARS['keyword'];
	@$action=$HTTP_GET_VARS['action'];
	@$limit=$HTTP_GET_VARS['limit'];
	@$case=$HTTP_GET_VARS['case'];
	if($action == "SEARCH") { // Volltextsuche
		foreach($s_dirs as $dir) { // Alle Verzeichnisse in $s_dirs durchsuchen
			$handle = @opendir($my_root.$dir);
			while($file = @readdir($handle)) {
				if(in_array($file, $s_skip)) { // Alles in $skip auslassen
					continue;
					}
				elseif($count_hits>=$limit) {
					break; // Maximale Trefferzahl erreicht
					}
				elseif(is_dir($my_root.$dir."/".$file)) { // Unterverzeichnisse durchsuchen
					$s_dirs = array("$dir/$file");
					search_dir($my_server, $my_root, $s_dirs, $s_files, $s_skip, $message_1, $message_2, $no_title, $limit_extracts, $byte_size, $HTTP_GET_VARS); // search_dir() rekursiv auf alle Unterverzeichnisse aufrufen
					}
				elseif(preg_match("/($s_files)$/i", $file)) { // Alle Dateien gemaess Endungen $s_files
					$fd=fopen($my_root.$dir."/".$file,"r");
					$text=fread($fd, $byte_size); // 50 KB
					$keyword_html = htmlentities($keyword);
					if($case) { // Gross-/Kleinschreibung beruecksichtigen?
						$do=strstr($text, $keyword)||strstr($text, $keyword_html);
						}
					else {
						$do=stristr($text, $keyword)||stristr($text, $keyword_html);
						}
					if($do)	{
						$count_hits++; // Treffer zaehlen
						if(preg_match_all("=<title[^>]*>(.*)</title>=siU", $text, $titel)) { // Generierung des Link-Textets aus <title>...</title>
							if(!$titel[1][0]) // <title></title> ist leer...
								$link_title=$no_title; // ...also $no_title
							else
								$link_title=$titel[1][0];  // <title>...</title> vorhanden...
							}
						else {
							$link_title=$no_title; // ...ansonsten $no_title
							}
						echo "<a href=\"$my_server$dir/$file\" target=\"_self\" class=\"result\">$count_hits.  $link_title</a><br>"; // Ausgabe des Links
						$auszug = strip_tags($text);
						$keyword = preg_quote($keyword); // unescapen
						$keyword = str_replace("/","\/","$keyword");
						$keyword_html = preg_quote($keyword_html); // unescapen
						$keyword_html = str_replace("/","\/","$keyword_html");
						echo "<span class=\"extract\">";
						if(preg_match_all("/((\s\S*){0,3})($keyword|$keyword_html)((\s?\S*){0,3})/i", $auszug, $match, PREG_SET_ORDER)); {
							if(!$limit_extracts)
								$number=count($match);
							else
								$number=$limit_extracts;
							for ($h=0;$h<$number;$h++) { // Kein Limit angegeben also alle Vorkommen ausgeben
								if (!empty($match[$h][3]))
									printf("<i><b>..</b> %s<b>%s</b>%s <b>..</b></i>", $match[$h][1], $match[$h][3], $match[$h][4]);
								}
							}
						echo "</span><br><br>";
						flush();
						}
					fclose($fd);
					}
				}
	  		@closedir($handle);
			}
		}
	}


// search_no_hits(): Ausgabe 'keine Treffer' bei der Suche
function search_no_hits($HTTP_GET_VARS, $count_hits, $message_4) {
	@$action=$HTTP_GET_VARS['action'];
	if($action == "SEARCH" && $count_hits<1) // Volltextsuche, kein Treffer
		echo "<p class=\"result\">$message_4</p>";
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<style type="text/css">
<!--
input.text  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 12px;
	text-decoration : none;
	width : 120px;
}

input.button  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 12px;
	text-decoration : none;
}

input.checkbox  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 12px;
	text-decoration : none;
}

span.checkbox  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 11px;
	text-decoration : none;
}

select.select  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 12px;
	text-decoration : none;
}

h1.result  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : bold;
	font-size : 14px;
	text-decoration : none;
}

p.result  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 12px;
	text-decoration : none;
}

a.result:link  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #03629C;
	font-weight : bold;
	font-size : 12px;
	text-decoration : none;
}

a.result:visited  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #03629C;
	font-weight : bold;
	font-size : 12px;
	text-decoration : none;
}

a.result:active  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #9D9D9D;
	font-weight : bold;
	font-size : 12px;
	text-decoration : underline;
}

a.result:hover  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #9D9D9D;
	font-weight : bold;
	font-size : 12px;
	text-decoration : underline;
}

span.extract  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #000000;
	font-weight : normal;
	font-size : 11px;
	text-decoration : none;
}

a.ts:link  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #03629C;
	font-weight : normal;
	font-size : 9px;
	text-decoration : none;
}

a.ts:visited  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #03629C;
	font-weight : normal;
	font-size : 9px;
	text-decoration : none;
}

a.ts:active  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #9D9D9D;
	font-weight : normal;
	font-size : 9px;
	text-decoration : underline;
}

a.ts:hover  {
	font-family : verdana, arial,helvetica,sans-serif;
	color : #9D9D9D;
	font-weight : normal;
	font-size : 9px;
	text-decoration : underline;
}
//-->
</style>
	<title>terraserver.de/search</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#03629C" vlink="#03629C" alink="#9D9D9D">
<table border="0" cellspacing="1" cellpadding="0" bgcolor="#03629C">
  <tr align="left" valign="top">
	<td>
	  <table border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF">
		<tr align="left" valign="top">
		  <td>
<?php
// search_form(): Gibt das Suchformular aus
search_form($HTTP_GET_VARS, $limit_hits, $default_val, $message_5, $message_6, $PHP_SELF);
?>
		  </td>
		</tr>
	  </table>	
	</td>
  </tr>
</table>
<?php
// search_headline(): Ueberschrift Suchergebnisse
search_headline($HTTP_GET_VARS, $message_3);
// search_error(): Auf Fehler testen und Suchfehler anzeigen
search_error($HTTP_GET_VARS, $min_chars, $max_chars, $message_1, $message_2, $limit_hits);
// search_dir(): Volltextsuche in Verzeichnissen (siehe config.php4)
search_dir($my_server, $my_root, $s_dirs, $s_files, $s_skip, $message_1, $message_2, $no_title, $limit_extracts, $byte_size, $HTTP_GET_VARS);
// search_no_hits(): Ausgabe 'keine Treffer' bei der Suche
search_no_hits($HTTP_GET_VARS, $count_hits, $message_4);
?>
</body>
</html>
