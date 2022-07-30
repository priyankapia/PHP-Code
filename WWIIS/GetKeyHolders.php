<?php

$database_user = "test";
/**
 * 
 * In single quotes nothing is auto parsed. But, in double quotes, if we use $ within a string.
 *  It considers as a variable and it looks for variable value. When you use \ it escapes $ character 
 * 
 */

$database_password = "testP\$ssw0rd";

//$pdo = new PDO('mysql:host=localhost;dbname=test', $database_user, $database_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM, PDO::ATTR_AUTOCOMMIT => 1, PDO::ATTR_STRINGIFY_FETCHES => 1));

/** 
 * 
 * PDO is generic and supports multiple database vendors.
 * So you need to tell PDO which db we are connecting. EX: mysql or mysqli etc. 
 * and I have also added exception for database connection
 * 
 */

try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", $database_user, $database_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM, PDO::ATTR_AUTOCOMMIT => 1, PDO::ATTR_STRINGIFY_FETCHES => 1));
    echo "Connected to test at localhost successfully."."<br>"."<br>";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

try {

   /**
    * 
    * If an identifier contains is a reserved word, we must quote it with `(backtick)
    * HERE key and order are reverved words
    * mysql should pass data as field in the index.
    * PDO::FETCH_ASSOC is passed fetch the data with field name as index
    *
    */ 

    $query = $pdo->query("SELECT name, `key` FROM key_holders WHERE active = 1 ORDER BY `order`");
    $contacts = $query->fetchAll(PDO::FETCH_ASSOC);

    
    foreach($contacts as $contact) {
        $telephone = $pdo->prepare("SELECT telephone FROM contact_details WHERE name = ?");
        $telephone->execute(array($contact['name']));
        $telephone = $telephone->fetchColumn();
        // need to set telephone data in contact array 
        $contact['telephone'] = $telephone;

        /**
         * 
         * printf() outputs a formatted string whereas print() outputs one or more strings.
         * and also f0r telephone value  we need to fetch it as string %s
         * if fetched as integer %d the 0 in the beggining of telephone number will be escaped
         */
        
        printf("%s  %s  %s\n", $contact['name'], $contact['telephone'], $contact['key']);
        echo "<br>";
    }

} catch(Exception $exception) {
    echo "An exception occurred!";
}

