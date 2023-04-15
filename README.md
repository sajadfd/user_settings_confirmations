 ## Run project
1.Clone your project <br />
2.Go to the folder application using cd command on your cmd or terminal<br />
3.Run composer install on your cmd or terminal<br />
4.Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu<br />
5.Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.<br />
6.Run php artisan key:generate<br />
7.Run php artisan migrate<br />
8.Run php artisan serve<br />
9.Go to http://localhost:8000/
