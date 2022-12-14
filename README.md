How to run
- Docker is required as project set up done with command: curl -s "https://laravel.build/cs-orders-voucher?with=mysql&devcontainer" | bash
- cd cs-orders-voucher  
- ./vendor/bin/sail up
- php artisan migrate:fresh
- php artisan db:seed
- post collection is shared
