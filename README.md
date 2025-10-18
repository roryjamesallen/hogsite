Itay-Kirsh: How do I run this project locally?

Copilot (summarised):

Summary — run a local PHP + MySQL server, create the databases/tables the app expects, then serve the project with PHP's built‑in webserver.

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