@servers(['web'=>['centuriosadm@190.57.133.38']])

@task('actualizar',['on'=>'web'])
    cd /home/centuriosadm/
    cd CRM
    git pull 
    composer dump-autoload
    php artisan migrate --force
    php artisan horizon:terminate
    php artisan config:clear
    php artisan route:cache
    php artisan view:cache

@endtask