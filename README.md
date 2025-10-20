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
