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
        VH_PATH = '/var/www/laravel'
    }

    stages {
        stage('Test') {
            agent {
                docker {
                    image 'ubuntu:latest'
                    label 'master' 
                    // args '-v /var/run/docker.sock:/var/run/docker.sock'
                    // image 'cimg/base:stable'
                    // label 'master' 
                    // args '-v /var/run/docker.sock:/var/run/docker.sock'
                    // volumes ['/var/run/docker.sock:/var/run/docker.sock']
                    // volumes(['/var/run/docker.sock:/var/run/docker.sock'])dsad
                }
            }
            steps {
                sh '''
                    echo "$SSH_PRIVATE_KEY" > my_key
                    chmod 600 my_key
                    rsync -avz -e "ssh -p $SSH_PORT -i my_key -o StrictHostKeyChecking=no" . ${SSH_USER}@${SSH_HOST}:${VH_PATH}
                    
                    
                '''
            }
        }

        stage('Deploy') {
            agent any
            steps {
                sh '''

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