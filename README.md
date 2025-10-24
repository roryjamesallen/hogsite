# [hogwild.uk](https://hogwild.uk)
## Running hogwild.uk Locally
### Linux / MacOS / Windows with WSL
Summary: Run a local PHP + MySQL server, create the databases/tables the app expects, then serve the project with PHP's built‑in webserver.

1) Install PHP and MySQL/MariaDB
2) Start MySQL and create databases + minimal tables used by the app
   1) sudo mysql < schema.sql
3) Ensure the app uses local DB credentials
4) Start the PHP built‑in webserver from the project root
	```sh
	php -S localhost:8000
	```
5) Open in browser
- Home page: http://localhost:8000/  
- Notoalgorithms: http://localhost:8000/notoalgorithms/  
- NothingEverHappens: http://localhost:8000/nothingeverhappens/

Troubleshooting
- If you get DB connection errors, confirm MySQL is running and credentials/databases exist. You can edit the credential logic in the files linked above.
- To seed more data, insert rows into `artists`, `users`, etc. The app reads/writes these tables via the functions referenced earlier.

### XAMPP (MacOS)
Summary: Install XAMPP, open the `htdocs` folder, clone `hogsite` into the folder, then serve the project with XAMPP running

1) Install [XAMPP](https://www.apachefriends.org/)
2) Run XAMPP and click Explorer (or go to installation folder if on MacOS)
3) Clone `hogsite` here however you normally clone git repositories
4) Navigate to this directory `cd /Applications/XAMPP/xamppfiles/bin`
5) Run `./mysql -u root < /Applications/XAMPP/xamppfiles/htdocs/hogsite/schema.sql` **NOTE:** correct the path to `schema.sql` if not correct
6) The database should now be set up
8) Access the pages using http://localhost/hogsite/ but you will need to add the 'index.php' for each page URL

# Generic library
# JavaScript
By including the following line in your `<script>` block before any other scripting, you can access useful client side functions like `start_image_loop`.
```
import { function1, function2 } from './lib/hoglib.js';
```
Where `function1` and `function2` are the names of the functions you want to import.
# PHP
By including the following line in your PHP code at the top of a page file, you can access the standard functions for database querying as well as useful runtime variables such as `$ip_address`.
```
include '../lib/generic_content.php';
```
## Variables
- `$ip_address` is the IP address of the user accessing the page.
- `$standard_header_content` should be echoed inside `<head>` tags to add the favicon and SEO stuff.
- `$standard_toolbar` is a single button to the home page like the one in Thompson World. Always aligned to the top left of the page over other content.
## Functions
- `apiCall($api_url)` returns JSON from a simple API.
- `openSqlConnection('database', 'relative/path/to/sql_login_database.php')` opens the connection required to query a database. If the database isn't yet live you can enter what you expect the login `php` file to be, but it doesn't actually matter when running locally. See below for more info.
- `sqlQuery('query')` runs and optionally returns the results of an SQL query string e.g. `SELECT * from table`. The connection must be opened using `openSqlConnection` first.
## Accessing a database
### Database setup
**Note: ** This only applies to the final 'live' database setup. For local use just skip to the next section and Rory will set up the login when it's ready to go live.
The database must be set up in phpMyAdmin including creating an `sql_login` file which should contain the following:
```
<?php
$user = [username];
$password = [password];
?>
```
Where `[username]` and `[password]` are the login details for the database user.
### Creating the connection in your PHP file
The database connection can then be initialised by including the generic library and then opening the connection:
```
include '../lib/generic_content.php';
openSqlConnection('wildhog_database', '../sql_login_wildhog_database.php');
```
Where `wildhog_database` is the name of the database and the path is the correct relative path to the login file.
### Querying the database
After setup, any query (SQL query in string format) can be processed using `sqlQuery(query)`, optionally saving the returned data as a variable.
e.g.
```
$result = sqlQuery("SELECT * from users")
```
The result of the query above is iterable or indexable as shown:
```
foreach (sqlQuery($result) as $row){
	echo $row['user_id'];
}

$first_user = $result[0]['user_id'];
```
