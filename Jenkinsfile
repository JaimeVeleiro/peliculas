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
        VH_PATH = '/var/www/laravel/veleiroruiz'
        SSH_PORT = '2121'
    }

    stages {
        stage('Test') {
            agent any
            steps {
                sh '''
                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "cd && ls"
                '''
            }
        }

        stage('Build') {
            agent {
                docker {
                    image 'ubuntu-rsync'
                }
            }
            steps {
                sh '''
                    mkdir ~/.ssh
                    touch ~/.ssh/id_rsa
                    echo "${SSH_PRIVATE_KEY}" > ~/.ssh/id_rsa
                    chmod 600 ~/.ssh/id_rsa
                    rsync -avz -e "ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} -o StrictHostKeyChecking=no" . ${SSH_USER}@${SSH_HOST}:${VH_PATH}

                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "cd ${VH_PATH} && composer install && npm install && npm run build"
                    
                    
                    
                '''
            } // && docker image rm veleiroruiz_php && ./veleiroruiz-parada.sh 3
        }

        stage('Deploy') {
            agent {
                docker {
                    image 'ubuntu-rsync'
                }
            }
            steps {
                sh '''
                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "chown -R www-data:www-data /var/www/laravel && chmod -R 775 /var/www/laravel"
                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "chown -R www-data:www-data ${VH_PATH} && chmod -R 775 ${VH_PATH}"

                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "cd ${VH_PATH} && chmod +x ./veleiroruiz-arranque.sh && chmod +x ./veleiroruiz-parada.sh"

                    ssh -p $SSH_PORT -i ${SSH_PRIVATE_KEY} ${SSH_USER}@${SSH_HOST} "cd ${VH_PATH} && ./veleiroruiz-parada.sh 3 && docker image rm veleiroruiz_php && docker build -t veleiroruiz_php . && ./veleiroruiz-arranque.sh 3"
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