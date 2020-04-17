## Project Title
--> Ongeza Online Test


## Requirements (Prerequisites)
requirements required to successfully install & run this project.
* Internet Connection
  To load (css and js files)

* Web Server (Apache & Mysql) & web browser


## Installation | Deployment
1: Download or clone the project file.
2: Move or Copy the Project folder into Server folder 

	For Xampp 
	--> Move the project folder into htdocs folder

	For Wampp
	--> Move the project folder into www folder

3: Create Database named 'ongeza_test'

4: Import the database dump-file into ongeza_test database
   -->DB dump file - ongeza_test.sql


## Usage | Testing
1: The home-page(index.php) shows a table of registered customers with respectively action buttons( UPDATE & DELETE ).
   --> Home page - http://localhost/ongeza_test/index.php  

2: Also You can register new customers by clicking the (register customers) Button in the home page.
  --> Register Customer Page - http://localhost/ongeza_test/customer_create.php

3: Updating Customer records can be done in home page by clicking the (UPDATE BUTTON). 

4: Deleting customer records can also be done in home page by clicking the (DELETE BUTTON).
  --> Hint: By deleting customer is_deleted field in customer table will be set to 1 & Customer won't apper in the registered list

5: Database Configuration file --> db_conn.php
	DB_HOST --> 'localhost'
	DB_NAME --> 'ongeza_test'
	DB_USER --> 'root'
	DB_PASS --> ''


## Tech Stack / Built With
1: PHP 7
2: MySQL
3: HTML | CSS | Javascript
4: Bootstrap - The front-end framework


## Author 
Peter Malunguja  – p.22charles@gmail.com
 
You can find me here at:
[Github](https://github.com/pmalunguja)




