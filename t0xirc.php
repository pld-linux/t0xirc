#!/usr/bin/php
<?
/*
 nagiosalert.php 2006 Mikael Fridh <mikael.fridh@ongame.com>
 Telnets to an eggdrop and .say's messages to a channel.
 Modified and cleaned up by Elan Ruusamäe <glen@pld-linux.org>
*/

error_reporting(E_ALL & ~E_NOTICE);
require "/usr/share/php/t0xirc.php";

$opt = getopt("u:p:h:P:c:m:");

$mybot =& new t0xirc_bot($opt['u'], $opt['p'], $opt['h'], $opt['P']);
$mybot->connect() or die("Unable to connect\n");

printf("Connected to %s default chan %s.\n", $mybot->bot_nick, $mybot->channel['name']);

if ($opt['m']) {
	$mybot->say($opt['m'], $opt['c']);
} else {
	// read from stdin
	$fp = STDIN;
	while (!feof($fp)) {
		$line = fgets($fp, 4096);
		if (!$line) {
			break;
		}
		$mybot->say($line, $opt['c']);
	}
}

$mybot->disconnect();

?>
