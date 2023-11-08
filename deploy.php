<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Pneumater');

// Project repository
set('repository', 'git@pneumater.github.com:Notiosoft/Pneumater.git');

// Default Stage
set('default_stage', 'dev');

// Default Branch
set('branch', 'development');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Hosts
host('nc04-deploy')
    ->set('labels', ['stage' => 'dev'])
    ->set('http_user', 'www-data')
    ->set('repository', 'git@pneumater.github.com:Notiosoft/Pneumater.git')
    ->set('deploy_path', '/var/www/com.notiosoft.pneumater')
    ->set('keep_releases', 5);

host('pua-deploy')
    ->set('labels', ['stage' => 'prod'])
    ->set('http_user', 'www-data')
    ->set('repository', 'git@pneumater.github.com:Notiosoft/Pneumater.git')
    ->set('deploy_path', '/var/www/pneumater')
    ->set('keep_releases', 5);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Scaffold the app every time it loads
after('artisan:migrate', 'artisan:db:seed');
