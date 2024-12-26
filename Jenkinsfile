pipeline {
    agent any

    environment {
        DISCORD_WEBHOOK_URL = 'https://discord.com/api/webhooks/1319517307277410345/KmUhZyF82LFk6sjZZygvFHSiMfFEv_sowpHv0NtBfKvM8I5hKwI_tx_v9kpbHwPD-UJF'
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    echo "BUILD_URL: ${env.BUILD_URL}"
                    echo "JENKINS_URL: ${env.JENKINS_URL}"
                    checkout([
                        $class: 'GitSCM',
                        branches: [[name: '*/main']],
                        userRemoteConfigs: [[
                            url: 'https://github.com/xXehub/dockerized-furniture-in.git', 
                            credentialsId: '43a9241f-7637-4318-8e48-587317cbdd33' 
                        ]]
                    ])
                    echo 'Kode berhasil diambil dari Git'
                }
            }
        }
        stage('Build') {
            steps {
                script {
                    echo 'Running build...'
                }
            }
        }
        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                }
            }
        }
    }

    post {
        success {
            script {
                def startTime = new Date(currentBuild.startTimeInMillis)
                def formattedStartTime = startTime.format('dd-MM-yyyy HH:mm:ss')

                def embed = [
                    title: "__Build Sukses__",
                    description: "Projek **Asia Meuble** komputasi awan, kelompok 3 kelas **IS-05-03**",  // Deskripsi proyek ditambahkan di sini
                    color: 3066993,
                    fields: [
                           [name: ":bar_chart: *Status**", value: "```🟢 Sukses```", inline: true]  
                        [name: ":gear: **Job**", value: env.JOB_NAME, inline: true],
                        [name: ":page_facing_up: **Build**", value: env.BUILD_NUMBER, inline: true],
                        [name: ":clock1: **Waktu Mulai**", value: formattedStartTime, inline: true],
                        [name: ":stopwatch: **Durasi**", value: currentBuild.durationString, inline: true],
                        [name: ":earth_africa:  **Branch**", value: env.GIT_BRANCH ?: "N/A", inline: true],
                        [name: ":computer: **Executor**", value: env.BUILD_USER_ID ?: "N/A", inline: true],
                        [name: ":link: **Jenkins URL**", value: "[Klik di sini](${env.BUILD_URL ?: env.JENKINS_URL})", inline: true]
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

                def embed = [
                    title: ":x: Build Gagal",
                    description: "Projek **Asia Meuble** komputasi awan, kelompok 3 kelas **IS-05-03**",  // Deskripsi proyek ditambahkan di sini
                    color: 15158332,
                    fields: [
                           [name: ":bar_chart: *Status**", value: "```🔴 Gagal```", inline: true]  
                        [name: ":gear: **Job**", value: env.JOB_NAME, inline: true],
                        [name: ":page_facing_up: **Build**", value: env.BUILD_NUMBER, inline: true],
                        [name: ":clock1: **Waktu Mulai**", value: formattedStartTime, inline: true],
                        [name: ":stopwatch: **Durasi**", value: currentBuild.durationString, inline: true],
                        [name: ":earth_africa:  **Branch**", value: env.GIT_BRANCH ?: "N/A", inline: true],
                        [name: ":computer: **Executor**", value: env.BUILD_USER_ID ?: "N/A", inline: true],
                        [name: ":link: **Jenkins URL**", value: "[Klik di sini](${env.BUILD_URL ?: env.JENKINS_URL})", inline: true]
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
