
deploy:
	ssh kit-services 'cd ~/app.kit-services.org && git pull && make install'


deploy-refresh:
	ssh kit-services 'cd ~/app.kit-services.org && git pull && make install && make refresh'


refresh:
	php artisan migrate:fresh --seed --step


install: .env vendor/autoload.php public/storage
	php artisan migrate --step
	php artisan cache:clear


.env:
	cp .env.example .env
	php artisan key:generate


vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php

# Création du lien symbolique pour storage
public/storage:
	php artisan storage:link
