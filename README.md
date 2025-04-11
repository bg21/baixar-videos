# Baixar Vídeos

Uma interface web simples para download de vídeos de várias plataformas usando a ferramenta yt-dlp.

## 📋 Sobre o Projeto

Este aplicativo fornece uma interface amigável para o [yt-dlp](https://github.com/yt-dlp/yt-dlp), uma poderosa ferramenta de linha de comando para baixar vídeos de plataformas como YouTube, Facebook, Twitter, Instagram, TikTok e muitas outras. A interface web facilita o uso para pessoas que não estão familiarizadas com comandos de terminal.

## ✨ Funcionalidades

- **Download de múltiplas plataformas**: YouTube, Facebook, Instagram, Twitter, TikTok e muitos outros sites
- **Escolha de formato**: MP4, MP3, WebM e outros formatos populares
- **Seleção de qualidade**: Baixa, média, alta ou melhor qualidade disponível
- **Interface simples**: Basta colar a URL e escolher as opções desejadas
- **Sem anúncios ou limitações**: Totalmente gratuito e sem restrições de uso

## 🔧 Requisitos

- PHP 7.4 ou superior
- [yt-dlp](https://github.com/yt-dlp/yt-dlp) instalado no servidor
- FFmpeg (opcional, para conversão de formatos de áudio)

## 🚀 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/bg21/baixar-videos.git
cd baixar-videos
```

2. Certifique-se de ter o yt-dlp instalado no servidor. Se não tiver, instale usando:
```bash
# Para Linux
sudo curl -L https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp -o /usr/local/bin/yt-dlp
sudo chmod a+rx /usr/local/bin/yt-dlp

# Para Windows
# Baixe o executável yt-dlp.exe e coloque-o em uma pasta no PATH
```

3. Configure um servidor web (Apache, Nginx) para servir o diretório ou use o servidor embutido do PHP:
```bash
php -S localhost:8000
```

4. Acesse a aplicação pelo navegador em `http://localhost:8000`

## 💻 Como Usar

1. Abra a aplicação em seu navegador
2. Cole a URL do vídeo que deseja baixar no campo de texto
3. Selecione o formato desejado (MP4, MP3, etc.)
4. Escolha a qualidade do vídeo/áudio
5. Clique em "Baixar"
6. Aguarde o processamento e o download será iniciado automaticamente

## ⚙️ Configuração Avançada

Você pode modificar as opções padrão do yt-dlp editando o arquivo `index.php`:

```php
// Exemplo de configurações adicionais
$options = [
    'format' => 'bestvideo+bestaudio/best', // Formato padrão
    'output' => './downloads/%(title)s.%(ext)s', // Diretório de saída
    'cookies' => './cookies.txt', // Arquivo de cookies para sites que requerem login
    // Adicione mais opções conforme necessário
];
```

Consulte a [documentação oficial do yt-dlp](https://github.com/yt-dlp/yt-dlp#options) para conhecer todas as opções disponíveis.

## ⚠️ Considerações Legais

Este software foi desenvolvido para fins educacionais e para facilitar o download de conteúdo ao qual você já tem direito legal de acesso. Os usuários são responsáveis por garantir que não estão violando os termos de serviço dos sites ou leis de direitos autorais ao baixar conteúdo. O desenvolvedor não se responsabiliza pelo uso indevido desta ferramenta.

## 🔄 Atualizações

Recomenda-se manter o yt-dlp atualizado para garantir compatibilidade com as plataformas de vídeo, já que elas frequentemente atualizam seus sistemas:

```bash
yt-dlp -U
```

## 📄 Licença

Este projeto está licenciado sob a MIT License - veja o arquivo LICENSE para mais detalhes.

---

Desenvolvido por [bg21](https://github.com/bg21)
