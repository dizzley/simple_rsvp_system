--
-- table = simple_rsvp
--

CREATE TABLE `simple_rsvp` (
 `id` int(11) NOT NULL auto_increment,
 `name` text NOT NULL,
 `email` text NOT NULL,
 `phone` varchar(32) NOT NULL,
 `status` varchar(32) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
