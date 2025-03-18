## AI SOLUTIONS

cd /home/wgomez/Documents/GitHub/AISolutions
php artisan serve --host=0.0.0.0

For ubuntu
sudo apt-get install php-curl

https://stackoverflow.com/questions/56219962/composer-require-ext-zip-fails

sudo apt-get install php-zip
https://stackoverflow.com/questions/6384979/how-to-enable-xmlwriter-after-php-having-been-compiled

sudo apt install php-xmlwriter

sudo apt install php-mysql

php artisan migrate:fresh --seed

This is the codebase for AI SOLUTIONS. It is built in Laravel and MySQL for database.


sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update
sudo apt-get install libapache2-mod-php php php-common php-xml php-mysql php-gd php-mbstring php-tokenizer php-json php-bcmath php-curl php-zip unzip -y



sudo cp -r /home/wgomez/Documents/GitHub/AISolutions/public/ /var/www/robin-ai-backend/public/

sudo php artisan config:cache
sudo php artisan route:cache
sudo php artisan view:cache


sudo apt-get update
sudo apt-get install ca-certificates curl gnupg
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg


echo \
  "deb [arch="$(dpkg --print-architecture)" signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  "$(. /etc/os-release && echo "$VERSION_CODENAME")" stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt-get update

sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin


systemctl --user start docker-desktop


sudo curl -L "https://github.com/docker/compose/releases/download/v2.12.2/docker-compose-$(uname -s)-$(uname -m)"  -o /usr/local/bin/docker-compose
sudo mv /usr/local/bin/docker-compose /usr/bin/docker-compose
sudo chmod +x /usr/bin/docker-compose

sudo chown -R www-data:www-data storage/
#to generate again the app docker
sudo docker-compose build app

docker-compose up -d
docker-compose ps

docker-compose exec app ls -l
docker-compose logs nginx

docker-compose exec app composer install

sudo docker-compose build app

sudo docker-compose exec app php artisan key:generate
sudo docker-compose exec app php artisan config:cache
sudo docker-compose exec app php artisan route:cache
sudo docker-compose exec app php artisan view:cache
sudo docker-compose exec app php artisan migrate:fresh --seed

docker-compose down


docker system prune -a

sudo chown wgomez /var/www/public
sudo chown wgomez /var/www/public/tmp



