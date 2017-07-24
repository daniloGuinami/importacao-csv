# Processamento de arquivo csv
Este projeto tem como objetivo realizar a leitura de arquivos csv, validar, persistir ou atualizar as informações em um banco de dados.

## Premissas
Funcionar em ambiente Windows.

## Instruções para configuração do ambiente

### Instalação do php
Acesse o link abaixo e faça o download da versão PHP 5.6 (5.6.31)
```html
http://windows.php.net/download/
```
Após o download, extrair os arquivos em uma pasta (de preferência na raiz do disco local C) e 
incluir o path dessa pasta nas variáveis de ambiente, para funcionamento do PHP.<br>
Instale as seguintes extensões (alterando o arquivo php.ini):<br>

- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML

### Instalação do composer
Acesse o link abaixo e faça o download da instalação

```html
https://getcomposer.org/download/
```

### Instalação do laravel via composer
Acesse o prompt de comando e digite o comando abaixo

```html
composer global require "laravel/installer"
```

### Instalação do banco de dados mysql para windows
Acesse o link abaixo e faça o download da instalação
```html
https://dev.mysql.com/downloads/file/?id=471661
```

Após a instalação crie um usuário e um banco com os seguintes dados:<br>
Nome do banco: laravel<br>
Nome do usuário: laravel<br>
Senha: root<br>

### Baixando depedências do projeto

Após preparar o ambiente, acesse a pasta do projeto, no prompt de comando
e digite o seguinte comando para baixar as depedências: 
```composer
php composer.phar install
```