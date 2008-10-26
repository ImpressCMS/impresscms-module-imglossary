# phpMyAdmin SQL Dump
# version 2.5.3
# http://www.phpmyadmin.net
#
# Module: imGlossary

# --------------------------------------------------------

#
# Table structure for table `imglossary_cats`
#

CREATE TABLE `imglossary_cats` (	
	`categoryID` tinyint(4) NOT NULL auto_increment,
	`name` varchar(100) NOT NULL default '',
	`description` text NOT NULL,
	`total` int(11) NOT NULL default '0',
	`weight` int(11) NOT NULL default '1',
	PRIMARY KEY  (`categoryID`),
	UNIQUE KEY columnID (`categoryID`)
) TYPE=MyISAM COMMENT='imGlossary by McDonald';	

#
# Dumping data for table `imglossary_cats`
#

# --------------------------------------------------------

#
# Table structure for table `imglossary_entries`
#

CREATE TABLE `imglossary_entries` (	
	`entryID` int(8) NOT NULL auto_increment,
	`categoryID` tinyint(4) NOT NULL default '0',
	`term` varchar(255) NOT NULL default '0',
	`init` varchar(1) NOT NULL default '0',
	`definition` text NOT NULL,
	`ref` text NOT NULL,
	`url` varchar(255) NOT NULL default '0',
	`uid` int(6) default '1',
	`submit` int(1) NOT NULL default '0',
	`datesub` int(11) NOT NULL default '1033141070',
	`counter` int(8) unsigned NOT NULL default '0',
	`html` int(11) NOT NULL default '0',
	`smiley` int(11) NOT NULL default '0',
	`xcodes` int(11) NOT NULL default '0',
	`breaks` int(11) NOT NULL default '1',
	`block` int(11) NOT NULL default '0',
	`offline` int(11) NOT NULL default '0',
	`notifypub` int(11) NOT NULL default '0',
	`request` int(11) NOT NULL default '0',
	`comments` int(11) unsigned NOT NULL default '0',
	PRIMARY KEY  (`entryID`),
	UNIQUE KEY entryID (`entryID`),
	FULLTEXT KEY definition (`definition`)
) TYPE=MyISAM COMMENT='imGlossary by McDonald';	

#
# Dumping data for table `imglossary_entries`
#