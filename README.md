# BFG

Fully functional page that can add/retrieve/delete/search phone numbers.
The class should prevent to create duplicates.

Used this link to make an array with the country prefix and name https://en.wikipedia.org/wiki/List_of_country_calling_codes
If can't validate a prefix, then: 07, 02, 03 are Romanian, else german

00 will be converted to +
'-' and space will be replaced with NULL

Insert should return the last insert id, and if duplicate found, it should return the original row id

- copy env.example .env
- docker-compose -d --build
- composer install
- execute in console CREATE TABLE IF NOT EXISTS `all_phone_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(4) NOT NULL COMMENT '+40=ro\r\n+39=de',
  `number` varchar(15) NOT NULL COMMENT 'left trimmed all the leading zeroes',
  `name` varchar(80) NOT NULL COMMENT 'associate or client name',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'last update timestamp',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_phone` (`prefix`,`number`)
  ) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
