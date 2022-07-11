<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:'.$_ENV['DB_HOST'].'=localhost;port=3307;dbname='.$_ENV['DB_NAME'].'',
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
