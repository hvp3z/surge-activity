<?php
echo '<pre>';

if(isset($_GET['userName']) && isset($_GET['email']) && isset($_GET['passwd']) && isset($_GET['coName'])){
    // database settings

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

    // request data

    $userName = $_GET['userName'];
    $email = $_GET['email'];
    $passwd = $_GET['passwd'];
    $coName = $_GET['coName'];

    $companyTable = 'company';
    $userTable = 'fos_user';

    try {
        $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);

        // get user with such username and email from database

        $sql = $dbh->query('SELECT * FROM '.$userTable.' WHERE username = "'.$userName.'" and email = "'.$email.'" ');
        $sql->execute();
        $usersArr = $sql->fetchAll();
        $userExists = false;

        if(!empty($usersArr)){
            $userExists = true;
        }

        if(!$userExists){
            var_dump(shell_exec('php app/console fos:user:create '.$userName.' '.$email.' '.$passwd.' --super-admin 2>&1'));
        }

        // create company table if it doesn't exist

        $isTableExist = $dbh->query('SHOW TABLES LIKE "'.$companyTable.'"')->rowCount();
        if(!$isTableExist){
            var_dump(shell_exec('php app/console doctrine:schema:update --force 2>&1'));
        }

        // get company with such companyName from database

        $sql = $dbh->query('SELECT * FROM '.$companyTable.' WHERE name = "'.$coName.'" ');
        $sql->execute();
        $companyArr = $sql->fetchAll();
        $companyExists = false;

        if(!empty($companyArr)){
            $companyExists = true;
        }

        if(!$companyExists){
            $sql = "INSERT INTO $companyTable (name) VALUES (:name)";
            $q = $dbh->prepare($sql);
            $q->execute(array(':name'=>$coName));

            $sql = $dbh->query('SELECT id FROM '.$companyTable.' WHERE name = "'.$coName.'"');
            $sql->execute();
            $company_id_arr = $sql->fetch();
            $company_id = $company_id_arr['id'];

            $sql = $dbh->query('UPDATE '.$userTable.' SET company ='.$company_id.' WHERE username = "'.$userName.'" AND email="'.$email.'" ');

            echo 'New company has been created </br>';
            echo 'Super admin '.$userName.' has been added for that company.';
        }else{
            echo 'Sorry, a company with such name already exists!';
        }

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