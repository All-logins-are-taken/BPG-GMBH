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
