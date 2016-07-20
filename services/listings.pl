#!/usr/bin/perl
use strict;
use warnings;

use lib 'C:\Users\dhope\Documents\Projects\lister\packages';

use CGI;
use DBI qw(:sql_types);
use DbConnect ('getConnection');
use JSON;
use Listing;


eval{

	my $svc = CGI->new;

	if ($ENV{'REQUEST_METHOD'} eq 'GET'){
		if ($svc->param('m') eq 'GET') {
				my $id = $svc->param('id');
				getById($id);
		} else {
				listall();
		}
	}elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		print 'no post methods implemented';
	}else{
		print 'error';
	}


	my $JSON = JSON->new->utf8;
	$JSON->convert_blessed(1);

	sub listall{
		my $value = 1491170;
		my @listings;
		my @data;
		my $db = getConnection();
		my $sth = $db->prepare("SELECT mls,address,price,status FROM listings where mls = ?");
		$sth->bind_param(1, $value, SQL_INTEGER);
		$sth->execute();

		my $listing;

		while (@data = $sth->fetchrow_array()) {
			$listing = new Listing($data[0],$data[1],$data[2],$data[3]);
			$listing->setMls($data[0] . "-2");
			#push @listings, $JSON->encode($listing);
			#push @listings, $listing;
		}

		$sth->finish;
		$db->disconnect;

		#$JSON->{"listings"} = $JSON->encode(\@listings);
		#my $json_text = to_json($json);

		print $svc->header('application/json');
		#print $json_text;
		#print $JSON->{"listings"};
		print $JSON->encode($listing);
	}

	sub getById{

		my $value = 1491170;
		my @data;
		my $db = getConnection();
		my $sth = $db->prepare("SELECT mls,address,price,status FROM listings where mls = ?");
		$sth->bind_param(1, $value, SQL_INTEGER);
		$sth->execute();

		my $listing;

		while (@data = $sth->fetchrow_array()) {
			$listing = new Listing($data[0],$data[1],$data[2],$data[3]);
			$listing->setMls($data[0] . "-2");
		}

		$sth->finish;
		$db->disconnect;

		print $svc->header('application/json');
		print $JSON->encode($listing);
	}

};

if ($@) {
    # $sth->err and $DBI::err will be true if error was from DBI
    warn $@; # print the error
    ... # do whatever you need to deal with the error

}
