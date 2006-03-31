#!/usr/bin/php
<?
/*
 nagiosalert.php 2006 Mikael Fridh <mikael.fridh@ongame.com>
 Telnets to an eggdrop and .say's messages to a channel
 modified and cleaned up by Elan RuusamÃe <glen@pld-linux.org>
*/

error_reporting(E_ALL & ~E_NOTICE);
require "/usr/share/php/t0xirc.php";

$opt = getopt("u:p:h:P:c:m:");

$mybot =& new t0xirc_bot($opt['u'], $opt['p'], $opt['h'], $opt['P']);
$mybot->connect() or die("Unable to connect\n");
$mybot->say($opt['m'], $opt['c']);

printf("Connected to %s default chan %s.\n", $mybot->bot_nick, $mybot->channel['name']);

$mybot->disconnect();

?>
