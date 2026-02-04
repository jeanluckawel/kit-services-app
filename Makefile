#APP_NAME=kitservice
#ENV=production
#PHP=php
#COMPOSER=composer
#ARTISAN=php artisan


#
## --------------------
## INSTALLATION INITIALE
## --------------------
#install:
#	$(COMPOSER) update --no-dev --optimize-autoloader || $(COMPOSER) install --no-dev --optimize-autoloader
#	cp .env.$(ENV) .env
#	$(ARTISAN) key:generate
#	$(ARTISAN) migrate --force
#	$(ARTISAN) storage:link
#	make optimize
#
## --------------------
## UPDATE APP
## --------------------
#update:
#	git pull origin main
#	$(COMPOSER) install --no-dev --optimize-autoloader
#	$(ARTISAN) migrate --force
#	make optimize
#
## --------------------
## CACHE / OPTIMIZE
## --------------------
#optimize:
#	$(ARTISAN) config:clear
#	$(ARTISAN) cache:clear
#	$(ARTISAN) route:clear
#	$(ARTISAN) view:clear
#	$(ARTISAN) config:cache
#	$(ARTISAN) route:cache
#	$(ARTISAN) view:cache
#	$(ARTISAN) optimize
#
## --------------------
## PERMISSIONS
## --------------------
#permissions:
#	chmod -R 775 storage bootstrap/cache
#	chown -R www-data:www-data .
#
## --------------------
## QUEUE
## --------------------
#queue:
#	$(ARTISAN) queue:restart
#
## --------------------
## SEED
## --------------------
#seed:
#	$(ARTISAN) db:seed --force
#
## --------------------
## CLEAR ALL
## --------------------
#clear:
#	$(ARTISAN) optimize:clear

