pipeline {
    agent any

    environment {
        DISCORD_WEBHOOK_URL = 'https://discord.com/api/webhooks/1319517307277410345/KmUhZyF82LFk6sjZZygvFHSiMfFEv_sowpHv0NtBfKvM8I5hKwI_tx_v9kpbHwPD-UJF'
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    stages {
        stage('Set Build User') {
            steps {
                wrap([$class: 'BuildUser']) {
                    script {
                        env.BUILD_USER = env.BUILD_USER ?: currentBuild.getBuildCauses()[0].userId
    
                        env.GIT_COMMIT = bat(script: '@git rev-parse HEAD', returnStdout: true).trim()
                    }
                }
            }
        }

        stage('Checkout') {
            steps {
                script {
                    checkout([
                        $class: 'GitSCM',
                        branches: [[name: '*/main']],
                        userRemoteConfigs: [[
                            url: 'https://github.com/xXehub/dockerized-furniture-in.git',
                            credentialsId: '43a9241f-7637-4318-8e48-587317cbdd33'
                        ]]
                    ])
                    bat 'echo Kode berhasil diambil dari Git'
                }
            }
        }

        stage('Build') {
            steps {
                bat 'echo Running build...'
            }
        }

        stage('Send Discord Webhook') {
            steps {
                script {
                    def message = [
                        embeds: [
                            [
                                title: "Build Started",
                                description: "Build untuk proyek **Asia Meuble** sedang dimulai.",
                                color: 3066993,
                                fields: [
                                    [name: ":gear: **Job**", value: env.JOB_NAME, inline: true],
                                    [name: ":page_facing_up: **Build**", value: env.BUILD_NUMBER, inline: true]
                                ],
                                footer: [
                                    text: "Jenkins CI/CD Pipeline",
                                    icon_url: "https://www.jenkins.io/images/logos/jenkins/256.png"
                                ]
                            ]
                        ]
                    ]
                    httpRequest(
                        url: DISCORD_WEBHOOK_URL,
                        httpMode: 'POST',
                        contentType: 'APPLICATION_JSON',
                        requestBody: groovy.json.JsonOutput.toJson(message)
                    )
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    def userResponse = input(
                        message: 'Apakah Anda ingin menjalankan tes?',
                        parameters: [
                            [$class: 'ChoiceParameterDefinition', 
                             choices: ['Yes', 'No'], 
                             description: 'Pilih Yes untuk melanjutkan tes.', 
                             name: 'TestResponse']
                        ]
                    )
                    if (userResponse == 'Yes') {
                        bat 'echo Running tests...'
                    } else {
                        echo "Test skipped"
                    }
                }
            }
        }
    }

    post {
        success {
            script {
                def startTime = new Date(currentBuild.startTimeInMillis)
                def formattedStartTime = startTime.format('dd-MM-yyyy HH:mm:ss')
                def executor = env.BUILD_USER ?: currentBuild.getBuildCauses()[0].userId ?: "System"
                def buildUrl = env.BUILD_URL ?: env.JENKINS_URL ?: "https://fairly-notable-skink.ngrok-free.app"
                def commitHash = env.GIT_COMMIT ?: "N/A"

                def embed = [
                    title: "__Build Sukses__",
                    description: "Projek **Asia Meuble** komputasi awan, kelompok 3 kelas **IS-05-03**. Menggunakan php native yang terintegrasi dengan docker, jenkins, github, discord.\n\n",  
                    color: 3066993,
                    fields: [
                        [name: ":bar_chart: **Status**", value: "```🟢 Sukses```", inline: true],
                        [name: ":gear: **Job**", value: env.JOB_NAME, inline: true],
                        [name: ":page_facing_up: **Build**", value: env.BUILD_NUMBER, inline: true],
                        [name: ":clock1: **Waktu Mulai**", value: formattedStartTime, inline: true],
                        [name: ":stopwatch: **Durasi**", value: currentBuild.durationString, inline: true],
                        [name: ":earth_africa: **Branch**", value: env.GIT_BRANCH ?: "N/A", inline: true],
                        [name: ":hash: **Commit**", value: commitHash.substring(0, 7), inline: true],
                        [name: ":computer: **Executor**", value: executor, inline: true],
                        [name: ":link: **Jenkins URL**", value: "[Klik di sini](${buildUrl})", inline: true]
                    ],
                    footer: [
                        text: "Jenkins CI/CD Pipeline",
                        icon_url: "https://www.jenkins.io/images/logos/jenkins/256.png"
                    ]
                ]
                def message = [
                    embeds: [embed]
                ]
                httpRequest(
                    url: DISCORD_WEBHOOK_URL,
                    httpMode: 'POST',
                    contentType: 'APPLICATION_JSON',
                    requestBody: groovy.json.JsonOutput.toJson(message)
                )
            }
        }

        failure {
            script {
                def startTime = new Date(currentBuild.startTimeInMillis)
                def formattedStartTime = startTime.format('dd-MM-yyyy HH:mm:ss')
                def executor = env.BUILD_USER ?: currentBuild.getBuildCauses()[0].userId ?: "System"
                def buildUrl = env.BUILD_URL ?: env.JENKINS_URL ?: "https://fairly-notable-skink.ngrok-free.app"
                def commitHash = env.GIT_COMMIT ?: "N/A"

                def embed = [
                    title: ":x: Build Gagal",
                    description: "Projek **Asia Meuble** komputasi awan, kelompok 3 kelas **IS-05-03**. Menggunakan php native yang terintegrasi dengan docker, jenkins, github, discord.\n\n",  
                    color: 15158332,
                    fields: [
                        [name: ":bar_chart: **Status**", value: "```🔴 Gagal```", inline: true],
                        [name: ":gear: **Job**", value: env.JOB_NAME, inline: true],
                        [name: ":page_facing_up: **Build**", value: env.BUILD_NUMBER, inline: true],
                        [name: ":clock1: **Waktu Mulai**", value: formattedStartTime, inline: true],
                        [name: ":stopwatch: **Durasi**", value: currentBuild.durationString, inline: true],
                        [name: ":earth_africa: **Branch**", value: env.GIT_BRANCH ?: "N/A", inline: true],
                        [name: ":hash: **Commit**", value: commitHash.substring(0, 7), inline: true],
                        [name: ":computer: **Executor**", value: executor, inline: true],
                        [name: ":link: **Jenkins URL**", value: "[Klik di sini](${buildUrl})", inline: true]
                    ],
                    footer: [
                        text: "Jenkins CI/CD Pipeline",
                        icon_url: "https://www.jenkins.io/images/logos/jenkins/256.png"
                    ]
                ]
                def message = [
                    embeds: [embed]
                ]
                httpRequest(
                    url: DISCORD_WEBHOOK_URL,
                    httpMode: 'POST',
                    contentType: 'APPLICATION_JSON',
                    requestBody: groovy.json.JsonOutput.toJson(message)
                )
            }
        }
    }
}
