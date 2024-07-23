<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bonoxs_cadastro";

// Cria conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos estão presentes
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['gender'])) {
        // Coleta os dados do formulário
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha para segurança
        $gender = $_POST['gender'];

        // Prepara a SQL
        $sql = "INSERT INTO participantes (firstname, lastname, email, password, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $gender);

        // Executa a SQL e verifica se foi bem-sucedido
        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta name='description' content='Nossa empresa foi criada no intuito de ajudar os nessecitados.'>
                <meta name='author' content='Vitor Alessandro Barboza da Silva'>
                <title>Bonoxs- Cadastro Completo Boa sorte!</title>
                <link rel='icon' href='JS.png'type='image/x-icon'>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f4f4f4;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        color: #333;
                    }
                    .container {
                        background-color: #fff;
                        padding: 40px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        width: 100%;
                        max-width: 600px;
                        text-align: center;
                    }
                    header {
                        margin-bottom: 20px;
                    }
                    h1 {
                        font-size: 32px;
                        color: #007bff;
                    }
                    p {
                        font-size: 18px;
                        color: #555;
                    }
                    footer {
                        margin-top: 20px;
                        font-size: 14px;
                        color: #777;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <header>
                        <h1>Cadastro Completo</h1>
                        <p>Obrigado por se cadastrar no sorteio!</p>
                    </header>
                    <main>
                        <p>Seu cadastro foi realizado com sucesso. Anunciaremos os 10 ganhadores no dia 23/07/2024. Boa sorte no sorteio!</p>
                    </main>
                    <footer>
                        <p>&copy; 2024 Top Secret. Todos os direitos reservados.</p>
                    </footer>
                </div>
            </body>
            </html>";
        } else {
            echo "Erro: " . $stmt->error;
        }

        // Fecha a conexão
        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
    $conn->close();
}
?>
