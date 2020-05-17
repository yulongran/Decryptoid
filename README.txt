 - All server file compressed in final.zip


 - Application consists	of 4 main pages : registration.php, authentication.php, main.php, 					     history.php

 - DecryptoidTable.sql contains the database schema for this application

 - main.php allows users encrypt and decrypt texts in input based on their selection of cipher and option.
 
 - history.php presents a table which presents the input texts from that user (if logged in), the cipher used and the timestamp at the moment of the creation of the record.

 - registration.php register a user
 
 - authentication.php authenticate a user with session

 - cipher.php contains functions to encrypt and decrypt for all cipher algorithms
 
 - Utility.php contains functions such as authentication and registration, sanitizing 	   functions, input validation, salt generation and password hashing.

 - login.php uses for stores mysql database variable
 
 - logout.php a simple page for redirect user after they logged out 
 
