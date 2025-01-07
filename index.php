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
        echo "<p>Erro: Não foi possível determinar os melhores IDs de vídeo e áudio.</p>";
        return;
    }

    // Comando para baixar e combinar vídeo e áudio
    $comando = "$ytDlpPath --no-playlist -f \"$videoId+$audioId\" --merge-output-format mp4 --postprocessor-args \"-strict -2\" --restrict-filenames -o \"%(title)s.%(ext)s\" " . escapeshellarg($url) . " 2>&1";

    // Exibe o comando para depuração
    echo "<pre>Comando executado: $comando</pre>";

    // Executa o comando e captura o log
    $output = shell_exec($comando);

    // Exibe o log completo no navegador para diagnóstico
    echo "<pre>$output</pre>";

    // Verificar se o arquivo foi gerado
    if (preg_match('/Destination: (.+\.mp4)/', $output, $matches)) {
        $arquivo = $matches[1];
        echo "Download concluído com sucesso: <a href='$arquivo' download>Clique aqui para baixar o arquivo</a>";
    } else {
        echo "Erro ao gerar o arquivo MP4. Verifique os logs acima.";
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
</head>
<body>
    <h1>Baixar Vídeos em MP4</h1>
    <form method="POST" action="">
        <label for="url">URL do vídeo:</label>
        <input type="text" name="url" id="url" required>
        <button type="submit">Baixar</button>
    </form>
</body>
</html>
