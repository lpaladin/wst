#!/usr/bin/perl -w
# all.pl
# This CGI program read the file that stores the survey and print
# 	all stored data.

use CGI ":standard";

# Begin main program

# Set names for file locking and unlocking

$LOCK = 2;
$UNLOCK = 8;

# Open and lock the survey data file

open(SURVDAT, "<survdat.dat") or exit(1);
flock(SURVDAT, $LOCK);

@all = <SURVDAT>;

# Unlock it, and close it

flock(SURVDAT, $UNLOCK);
close(SURVDAT);

$i = 0;
print header();
foreach (@all) {
	@curr = split(/ /);
	printf("<tr><td><input type='checkbox' value='%d' name='ids' data-validatefunc='dummy'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n", ++$i, $curr[0], $curr[1], $curr[2], $curr[3]);
}
