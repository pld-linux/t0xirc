#!/usr/bin/php
<?
/*
 nagiosalert.php 2006 Mikael Fridh <mikael.fridh@ongame.com>
 Telnets to an eggdrop and .say's messages to a channel.
 Modified and cleaned up by Elan Ruusamäe <glen@pld-linux.org>
*/

error_reporting(E_ALL & ~E_NOTICE);
define('PROGRAM', basename($argv[0]));

function usage() {
	$PROGRAM = PROGRAM;
	fwrite(STDERR, "Usage:
    {$PROGRAM} -u USER -p PASSWORD -h HOSTNAME -P PORT [-c CHANNEL] [-m MESSAGE]

Connects to an eggdrop and .say's messages to a channel.
If CHANNEL is omited bot's default channel is used.
if Message is omited, message is read from STDIN.

");
}

require_once '/usr/share/php/t0xirc.php';

$opt = getopt("u:p:h:P:c:m:v");
if (empty($opt['u']) || empty($opt['p']) || empty($opt['h']) || empty($opt['P'])) {
	usage();
	exit(1);
}

$verbose = isset($opt['v']);

$bot =& new t0xirc_bot($opt['u'], $opt['p'], $opt['h'], $opt['P']);
if ($verbose) {
	echo "Connecting to {$opt['h']}:{$opt['P']}\n";
}
if (!$bot->connect()) {
	fwrite(STDERR, "Unable to connect to {$opt['h']}:{$opt['P']}!\n");
	exit(1);
}
if ($verbose) {
	echo "Connected!\n";
}

if (empty($opt['c'])) {
	$opt['c'] = $bot->channel['name'];
	if ($verbose) {
		printf("Connected to %s default channel %s.\n", $bot->bot_nick, $bot->channel['name']);
	}
} else {
	if ($verbose) {
		printf("Connected to %s, channel: %s.\n", $bot->bot_nick, $bot->channel['name']);
	}
}

if ($opt['m']) {
	$bot->say($opt['m'], $opt['c']);
} else {
	// read from stdin
	$fp = STDIN;
	while (!feof($fp)) {
		$line = fgets($fp, 4096);
		if (!$line) {
			break;
		}
		$bot->say($line, $opt['c']);
	}
}

$bot->disconnect();
