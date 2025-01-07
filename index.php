<?php
// Função para listar formatos e encontrar os melhores IDs
function obterMelhoresFormatos($url) {
    $ytDlpPath = "E:\\yt-dlp\\yt-dlp.exe"; // Ajuste o caminho do yt-dlp conforme necessário

    // Comando para listar os formatos disponíveis
    $comando = "$ytDlpPath --no-playlist --list-formats " . escapeshellarg($url) . " 2>&1";
    $output = shell_exec($comando);

    // Parsear a saída para encontrar os melhores IDs
    $videoId = null;
    $audioId = null;
    foreach (explode("\n", $output) as $linha) {
        if (strpos($linha, "video only") !== false && strpos($linha, "mp4") !== false) {
            $videoId = explode(" ", trim($linha))[0];
        }
        if (strpos($linha, "audio only") !== false && strpos($linha, "m4a") !== false) {
            $audioId = explode(" ", trim($linha))[0];
        }
        if ($videoId && $audioId) break;
    }

    return [$videoId, $audioId];
}

// Função para baixar o vídeo
function baixarVideo($url) {
    $ytDlpPath = "E:\\yt-dlp\\yt-dlp.exe"; // Ajuste o caminho do yt-dlp conforme necessário

    // Obter os melhores IDs
    list($videoId, $audioId) = obterMelhoresFormatos($url);

    if (!$videoId || !$audioId) {
        echo "<p class='text-danger'>Erro: Não foi possível determinar os melhores IDs de vídeo e áudio.</p>";
        return;
    }

    // Comando para baixar e combinar vídeo e áudio
    $comando = "$ytDlpPath --no-playlist -f \"bestvideo[height<=1080]+$audioId\" --merge-output-format mp4 --postprocessor-args \"-strict -2\" --restrict-filenames -o \"%(title)s.%(ext)s\" " . escapeshellarg($url) . " 2>&1";

    // Exibe o comando para depuração
    echo "<pre>Comando executado: $comando</pre>";

    // Executa o comando e captura o log
    $output = shell_exec($comando);

    // Exibe o log completo no navegador para diagnóstico
    echo "<pre>$output</pre>";

    // Verificar se o arquivo foi gerado
    if (preg_match('/Destination: (.+\.mp4)/', $output, $matches)) {
        $arquivo = $matches[1];
        echo "<p class='text-success'>Download concluído com sucesso: <a href='$arquivo' class='btn btn-primary' download><i class='fas fa-download'></i> Clique aqui para baixar o arquivo</a></p>";
    } else {
        echo "<p class='text-danger'>Erro ao gerar o arquivo MP4. Verifique os logs acima.</p>";
    }
}

// Verifica se o formulário foi enviado
if (isset($_POST['url'])) {
    $url = $_POST['url'];
    baixarVideo($url);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baixar Vídeos em MP4</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="h3 text-center"><i class="fas fa-download"></i> Baixar Vídeos em MP4</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="url" class="form-label">URL do vídeo:</label>
                        <input type="text" name="url" id="url" class="form-control" placeholder="Insira a URL do vídeo" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fas fa-arrow-circle-down"></i> Baixar</button>
                </form>
            </div>
        </div>
        <div class="mt-3">
            <?php
            // Exibe as mensagens de erro ou sucesso do PHP
            if (isset($_POST['url'])) {
                echo "<div class='alert alert-info'>Processando...</div>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
