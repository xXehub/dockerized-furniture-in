pipeline {
    agent any

    environment {
        DISCORD_WEBHOOK_URL = 'https://discord.com/api/webhooks/1319517307277410345/KmUhZyF82LFk6sjZZygvFHSiMfFEv_sowpHv0NtBfKvM8I5hKwI_tx_v9kpbHwPD-UJF' // Ganti dengan URL webhook yang kamu dapatkan
    }

    stages {
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
                    title: "Build Sukses",
                    description: """
**Branch**: ${env.BRANCH_NAME ?: 'N/A'}
**Executor**: ${env.EXECUTOR_NUMBER ?: 'N/A'}
**Jenkins URL**: [Klik di sini](${env.BUILD_URL})
""".trim(),
                    color: 3066993,
                    // thumbnail: [
                    //     url: "https://media.discordapp.net/attachments/1319516985721229315/1319572293512335411/0d12a119ba7c7899f6bb2224e6b31232.webp?ex=676672f7&is=67652177&hm=1f43f91ef18c018e3de28c7e20197e70bfb391c13198d23861803bdc4833c35c&=&format=webp&width=437&height=437"
                    // ],
                    fields: [
                        [
                            name: ":briefcase: **Job**",
                            value: "${env.JOB_NAME}",
                            inline: true
                        ],
                        [
                            name: ":clipboard: **Build**",
                            value: "${env.BUILD_NUMBER}",
                            inline: true
                        ],
                        [
                            name: ":clock1: **Waktu Mulai**",
                            value: formattedStartTime,
                            inline: true
                        ],
                        [
                            name: ":stopwatch: **Durasi**",
                            value: "${currentBuild.durationString}",
                            inline: true
                        ],
                        [
                            name: ":bookmark_tabs: **Build ID**",
                            value: "${env.BUILD_ID}",
                            inline: true
                        ]
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
                    description: """
**Branch**: ${env.BRANCH_NAME ?: 'N/A'}
**Executor**: ${env.EXECUTOR_NUMBER ?: 'N/A'}
**Jenkins URL**: [Klik di sini](${env.BUILD_URL})
""".trim(),
                    color: 15158332,
                    thumbnail: [
                        url: "https://media.discordapp.net/attachments/1319516985721229315/1319572293512335411/0d12a119ba7c7899f6bb2224e6b31232.webp?ex=676672f7&is=67652177&hm=1f43f91ef18c018e3de28c7e20197e70bfb391c13198d23861803bdc4833c35c&=&format=webp&width=437&height=437"
                    ],
                    fields: [
                        [
                            name: ":briefcase: **Job**",
                            value: "${env.JOB_NAME}",
                            inline: true
                        ],
                        [
                            name: ":clipboard: **Build**",
                            value: "${env.BUILD_NUMBER}",
                            inline: true
                        ],
                        [
                            name: ":clock1: **Waktu Mulai**",
                            value: formattedStartTime,
                            inline: true
                        ],
                        [
                            name: ":stopwatch: **Durasi**",
                            value: "${currentBuild.durationString}",
                            inline: true
                        ],
                        [
                            name: ":bookmark_tabs: **Build ID**",
                            value: "${env.BUILD_ID}",
                            inline: true
                        ]
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
