#!/usr/bin/perl -w
# all.pl
# This CGI program read the file that stores the survey and print
# 	all stored data.

use CGI ":standard";

# Begin main program
# Read ids to be deleted
if (param("ids[]")) {
	@ids = param("ids[]");
}else {
	@ids = (param("ids"));
}
# Set names for file locking and unlocking

$LOCK = 2;
$UNLOCK = 8;

# Open and lock the survey data file

open(SURVDAT, "<survdat.dat") or exit(1);
flock(SURVDAT, $LOCK);

@all = <SURVDAT>;
@newall = ();
for ($i = 0, $j = 0; $i < scalar @all; $i++) {
	if ($ids[$j] - 1 != $i) {
		push @newall, $all[$i];
		if ($ids[$j] - 1 < $i && $j < scalar @ids - 1) {
			$j++;
		}
	} elsif ($j < scalar @ids - 1) {
		$j++;
	}
}

# Unlock it, and close it

flock(SURVDAT, $UNLOCK);
close(SURVDAT);

open(SURVDAT, ">survdat.dat") or exit(1);
flock(SURVDAT, $LOCK);
foreach (@newall) {
	print SURVDAT $_;
}
flock(SURVDAT, $UNLOCK);
close(SURVDAT);

print header();