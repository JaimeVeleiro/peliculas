pipeline {
    agent any

    environment {
        MYSQL_ROOT_PASSWORD = '2121'
        MYSQL_USER = 'ubuntu'
        MYSQL_PASSWORD = '2121'
        MYSQL_DATABASE = 'films_jenkins'
        DB_HOST = 'mysql'
        SSH_PRIVATE_KEY = credentials('ssh-private-key')
        SSH_USER = 'root'
        SSH_HOST = '51.255.168.80'
    }

    stages {
        stage('Test') {
            agent {
                docker {
                    image 'cimg/base:stable'
                    label 'master' 
                    // volumes ['/var/run/docker.sock:/var/run/docker.sock']
                    // volumes(['/var/run/docker.sock:/var/run/docker.sock'])dsad
                    args '-v /var/run/docker.sock:/var/run/docker.sock'
                }
            }
            steps {
                sh '''
                    sudo apt install nodejs
                    # Install Node dependencies.
                    npm install
                    # install composer dependencies
                    composer install --prefer-dist --no-ansi --no-interaction --no-progress
                    # Copy over example configuration.
                    cp .env.example .env
                    # Generate an application key. Re-cache.
                    php artisan key:generate
                    php artisan config:cache
                    # Run database migrations.
                    php artisan migrate:refresh --seed
                    # Run database seed
                    php artisan db:seed
                    # run laravel tests
                    php vendor/bin/phpunit --coverage-text --colors=never
                    # run frontend tests
                    # if you have any task for testing frontend
                    # set it in your package.json script
                    # comment this out if you don't have a frontend test
                    # npm test
                '''
            }
        }

        stage('Deploy') {
            agent any
            steps {
                sh '''
                    # Add SSH key
                    echo "$SSH_PRIVATE_KEY" | tr -d '\r' > ~/.ssh/id_rsa
                    chmod 600 ~/.ssh/id_rsa
                    ssh-keyscan -H "$SSH_HOST" >> ~/.ssh/known_hosts

                    # Deploy
                    rsync -avz --delete -e "ssh -o StrictHostKeyChecking=no" . ${SSH_USER}@${SSH_HOST}:/var/www/laravel-app

                    # Remote commands
                    ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SSH_HOST} "cd /var/www/laravel-app && docker compose down && docker compose up -d --build"
                    ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SSH_HOST} "cd /var/www/laravel-app && cp .env.example .env"
                    ssh -o StrictHostKeyChecking=no ${SSH_USER}@${SSH_HOST} "cd /var/www/laravel-app && php artisan key:generate"

                '''
            }
        }
    }
}
// pipeline {
//     agent any

//     stages {
//         stage('Hello') {
//             steps {
//                 echo 'Hello World'
//             }
//         }
//     }
// }
//