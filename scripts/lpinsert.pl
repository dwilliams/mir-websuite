#!/usr/bin/perl
#
# lpinsert.pl - MIR Websuite
# Daniel Patrick Williams - dwilliams@port8080.net
# Mines Internet Radio - http://radio.mines.edu
# 2008.12.14
#
# Script to insert the last played track into a Postgres database.
# Written initially to be called from Liquidsoap
#  (http://savonet.sourceforge.net).
#
# USAGE: lpinsert.pl <artist> <album> <title>

use DBI;
use strict;

### Database Setting ###

my $dbhost = ""; # hostname of database
my $dbname = ""; # name of database
my $dbuser = ""; # user to access database as
my $dbpass = ""; # password for dbuser
my $dbtable =""; # table to insert the information into

### Functional Variables ###

my $dbh;
my $sth;

### Main Program ###

# check to see if there were too many or too few arguments
if ($#ARGV > 2) {
  die("Too many arguments");
}
if ($#ARGV < 2) {
  die("Too few arguments");
}

# Parse command-line arguments
my $artist = $ARGV[0];
my $album = $ARGV[1];
my $title = $ARGV[2];

# Connect to DB
$dbh = DBI->connect("dbi:Pg:database=$dbname;host=$dbhost", $dbuser, $dbpass);

# If connected successfully
if ($dbh) {

  # Prepare insert query for DB
  $sth = $dbh->prepare("INSERT INTO $dbtable (artist, album, title) VALUES ('$artist', '$album', '$title');");
  if (!defined($sth)) {
    die("Cannot prepare $DBI::errstr\n");
  }

  # Execute query
  if (!$sth->execute) {
    die("Cannot execute $DBI::errstr\n");
  }

  # Close DB
  $sth->finish;
  $dbh->disconnect();
}
else {
  die("Cannot connect to Postgres server: $DBI::errstr\n");
}
