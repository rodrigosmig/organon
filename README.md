## Organon

Simple system for task control and project time control.
Development environment requires Docker and Docker Composer.

* git clone https://github.com/rodrigosmig/organon.git
* cd organon
* docker-compose up -d
* docker-compose exec app composer install
* docker-compose exec app npm install
* docker-compose exec app npm run dev
* cp .env.example .env
* docker-compose exec app php artisan key:generate
* docker-compose exec db bash
* mysql -u root -p [password rootsql]
* GRANT ALL ON organon.* TO 'organon'@'%' IDENTIFIED BY 'organon';
* docker-compose exec app php artisan migrate --seed
* start the app on http://localhost:8000/