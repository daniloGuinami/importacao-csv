# Processamento de arquivo csv
Este projeto tem como objetivo realizar a leitura de arquivos csv, validar, persistir ou atualizar as informações em um banco de dados.

## Premissas
Funcionar em ambiente Windows.

## Instruções para configuração do ambiente

### 1. Instalação do php
Acesse o link abaixo e faça o download da versão PHP 5.6 (5.6.31)

http://windows.php.net/download/

Após o download, extraia os arquivos em uma pasta (de preferência na raiz do disco local C) e 
inclua o path dessa pasta nas variáveis de ambiente, para funcionamento do PHP.<br>
Instale as seguintes extensões (alterando o arquivo php.ini):<br>

- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML

####2. Instalação do composer
Acesse o link abaixo e faça o download da instalação

https://getcomposer.org/download/

####3. Instalação do laravel via composer
Acesse o prompt de comando e digite o comando abaixo

```html
composer global require "laravel/installer"
```

####4. Instalação do banco de dados mysql para windows
Acesse o link abaixo e faça o download da instalação

https://dev.mysql.com/downloads/file/?id=471661

Após a instalação crie um usuário e um banco com os seguintes dados:<br>
Nome do banco: laravel<br>
Nome do usuário: laravel<br>
Senha: root<br>

####5. Baixando dependências do projeto

Após preparar o ambiente, acesse a pasta do projeto no prompt de comando
e digite o seguinte comando para baixar as dependências: 
```composer
composer install
```

####6. Alterando o arquivo de configuração do bando de dados
Na raiz do projeto, renomeie o arquivo ".env.example" para ".env", e altere as 
informações relacionadas ao banco de dados, com as mesmas informações 
definidas no tópico 4 (Instalação do banco de dados mysql para windows)

####7. Criando tabelas com migration
Acesse o prompt de comando e digite o comando abaixo para gerar as tabelas do banco de dados

```html
php artisan migrate
```

####8. Criando pastas para armazenamento de arquivos
Na pasta do projeto, acesse a pasta "storage/app" e crie as seguintes pastas:<br>
- arquivos-a-processar
- arquivos-processados

-----
## Instruções para uso do sistema
- Copie e cole seu(s) arquivo(s) .csv na pasta "storage/app/arquivos-a-processar"
- Acesse a pasta do projeto no prompt de comando
  e digite o seguinte comando para realizar o processamento do arquivo:

```html
php artisan csv:import nomeArquivo.csv
```

- Após o processamento do(s) arquivo(s), o mesmo foi movido para a pasta "storage/app/processados"