
PhoneBook
---------------

PhoneBook is a simple CRUD application to store contacts list with their phone numbers.
User is able to view, add, edit and delete contacts and their three types of phone numbers: cell, home and business.
Frontend is viewable in Polish.

Getting Started

In order to start using that app, please create a Configuration.php file in src/ folder.
User should include four variables: $dbName, $dbHost, $dbUsername and $dbUserPassword.
In the desired database, user should create `person` table with five columns: id, name, surname, cell_number, 
home_number and business_number.