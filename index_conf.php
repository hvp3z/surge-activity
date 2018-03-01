<?php
	echo '<pre>';	
	//var_dump(shell_exec('export COMPOSER_HOME=/home/root/.composer 2>&1 && php composer.phar update "symfony/swiftmailer-bundle"'));
	//var_dump(shell_exec('php app/console doctrine:schema:update --force 2>&1'));
	var_dump(shell_exec('php app/console doctrine:schema:update --force 2>&1'));
	//var_dump(shell_exec('php app/console router:debug 2>&1'));
	//var_dump(shell_exec('export COMPOSER_HOME=/home/root/.composer 2>&1 && php composer.phar update 2>&1'));
	echo '</pre>';
?>