#!/usr/bin/perl -w
# new.pl
# This CGI program processes the consumer electronics survey
#  form and updates the file that stores the survey

use CGI ":standard";

sub filter {
	my($val) = @_;
	$val =~ s/</&lt;/g;
	$val =~ s/>/&gt;/g;
	return $val;
}

# Begin main program
# Get the form values
print param("email");

my($age, $gender, $name, $email) = (param("age"), param("gender"),
	param("name"), param("email"));
        
if ($age eq "" || $gender eq "" || $name eq "" || $email eq "") {
	exit(1);
}

# Set names for file locking and unlocking

$LOCK = 2;
$UNLOCK = 8;

# Open and lock the survey data file

open(SURVDAT, ">>survdat.dat") or exit(1);
flock(SURVDAT, $LOCK);

# Write the survey data file, unlock it, and close it
print header();

printf SURVDAT "%s %s %s %s\n", filter($name), filter($age), filter($gender), filter($email);

flock(SURVDAT, $UNLOCK);
close(SURVDAT);
