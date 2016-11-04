#!/usr/bin/perl
use strict;
use warnings;
use TryCatch;

try {
    print true;
}catch ($e) {
	print $e;
}