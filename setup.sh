sudo apt update
sudo apt install php php-mysql mysql-server

sudo systemctl start mysql
sudo systemctl enable mysql
sudo mysql < schema.sql
sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';"

echo "To test MySQL connection:"
echo "mysql -u root -e 'SHOW DATABASES;'"

echo "To start the PHP server:"
echo "php -S localhost:8000"