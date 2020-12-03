# Databases_2_Lab
You need to put a file in `php` directory called `config.inc.php` and it should follow this template

```php
<?php
$database_host = $HOST;
$database_user = $USERNAME ;
$database_pass = $PASSWORD;
$database_name = $db_name;
$conn = new mysqli($database_host, $database_user, $database_pass, $database_name);
if ($conn->connect_error) {
    echo("connection error");
    die();
}

```
