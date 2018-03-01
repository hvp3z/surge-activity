<?php
echo '<pre>';

if(isset($_GET['schemaUpdate'])){
    var_dump(shell_exec('php app/console doctrine:schema:update --force 2>&1'));
}
if(isset($_GET['composerUpdate'])){
    //var_dump(shell_exec('export COMPOSER_HOME=/home/root/.composer 2>&1 && php composer.phar update "symfony/swiftmailer-bundle"'));
    var_dump(shell_exec('export COMPOSER_HOME=/home/root/.composer 2>&1 && php composer.phar update 2>&1'));
}
if(isset($_GET['assetsInstall'])){
    var_dump(shell_exec('php app/console assets:install 2>&1'));
}
if(isset($_GET['userName']) && isset($_GET['email']) && isset($_GET['passwd']) && isset($_GET['coName'])){
    $userName = $_GET['userName'];
    $email = $_GET['email'];
    $passwd = $_GET['passwd'];
    $coName = $_GET['coName'];

    var_dump(shell_exec('php app/console fos:user:create '.$userName.' '.$email.' '.$passwd.' --super-admin 2>&1'));

    $filePath = 'app/config/parameters.yml';
    $fileContent = file_get_contents($filePath);
    $fileParts = explode('parameters:', $fileContent);
    $moreParts = explode("\n", $fileParts[1]);
    $parameters = array();

    foreach($moreParts as $element){
        if(strlen($element) > 0){
            $keyVal = explode(':', $element);
            $parameters[trim($keyVal[0])] = trim($keyVal[1]);
        }
    }
    $dbHost = $parameters['database_host'];
    $dbName = $parameters['database_name'];
    $dbUser = $parameters['database_user'];
    $dbPass = $parameters['database_password'];
    $companyTable = 'company';
    $userTable = 'fos_user';

    $dataArray = array('declined', 'accepted', 'notSpecified');

    try {
        $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);

        $isTableExist = $dbh->query('SHOW TABLES LIKE "'.$tableName.'"')->rowCount();
        if(!$isTableExist){
            var_dump(shell_exec('php app/console doctrine:schema:update --force 2>&1'));
        }

        // add new row to company

        $sql = "INSERT INTO $companyTable (name) VALUES (:name)";
        $q = $dbh->prepare($sql);
        $q->execute(array(':name'=>$coName));

        $company_id_arr = $dbh->query('SELECT id FROM '.$companyTable.' WHERE name = "'.$coName.'"');
        $company_id = null;

        if($company_id_arr){
            $company_id = $company_id_arr[0]['id'];
        }

        $sql = "INSERT INTO $userTable (company) VALUES (:company) WHERE username = :username AND email=:email ";
        $q = $dbh->prepare($sql);
        $q->execute(array(':company'=>$company_id, ':username'=>$userName, ':email'=>$email,));

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}else{
    echo 'Sorry, some parameters are missing! Please, try again.';
}

if(!$_GET){
    echo 'Please, choose what action do you want to execute:<br />';
    echo ' execute addNewScript.php file where<br />';
    echo ' - "userName" - user\'s name <br />';
    echo ' - "email" - user\'s email <br />';
    echo ' - "passwd" - user\'s password <br />';
    echo ' - "coName" - user\'s company name <br />';
    echo 'Add all necessary GET parameters. For example /addNewScript.php?userName=...&email=...&passwd=...&coName=...';
}
echo '</pre>';
?>