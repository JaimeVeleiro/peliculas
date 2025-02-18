pipeline {
    agent { label 'master' } // Usar label master para el agente Jenkins

    environment {
        MYSQL_ROOT_PASSWORD = credentials('mysql-root-password') // Credencial de Jenkins
        MYSQL_USER = credentials('mysql-user') // Credencial de Jenkins
        MYSQL_PASSWORD = credentials('mysql-password') // Credencial de Jenkins
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
                    image 'edbizarro/gitlab-ci-pipeline-php:latest'
                    // No necesitas especificar el label aquí, ya se definió arriba
                    volumes ['/var/run/docker.sock:/var/run/docker.sock']
                }
            }
            steps {
                sh '''
                    # Install Node dependencies.
                    npm install
                    # Install composer dependencies
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
                    # Run laravel tests
                    php vendor/bin/phpunit --coverage-text --colors=never
                    # Run frontend tests
                    # npm test
                '''
            }
        }

        stage('Deploy') {
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