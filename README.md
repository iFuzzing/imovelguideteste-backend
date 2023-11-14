# Projeto Backend PHP - Teste Técnico 🚀

Teste técnico e de logíca da Imóvel Guide

## Tecnologias Utilizadas 🛠️

- PHP Orientado a Objetos
- PDO para manipulação do banco de dados MySQL
- Padrões de Arquitetura MVC

## Estrutura do Projeto 🏗️
```
───index.php
───App
    ├───assets
    │   ├───css
    │   │       main.css
    │   │
    │   └───js
    │           main.js
    │
    ├───Controllers
    │       Corretor.php
    │
    └───Models
            Corretor.php
            PDODB.php
```


Explicação rápida da estrutura:

- **app**: Contém os controladores, modelos e as classes de conexão ao banco de dados. Seguindo a arquitetura MVC.
- **app/assets**: Arquivos Javascript e CSS.
- **index.php**: Arquivo principal contendo o frontend e execução da aplicação, bem como o teste de lógica.


## Banco de Dados 💾

Certifique-se de configurar o arquivo `App/Models/PDODB.php` com as informações corretas do banco de dados antes de executar o projeto.

## Para o Teste de Lógica

Para a resolução foi utilizada uma API da Back4app, certifique-se de ter um APP ID e uma chave de API válido dentro do arquivo `App/assets/js/main.js`

## Executando o Projeto ▶️

1. Clone o repositório: `git clone https://github.com/iFuzzing/imovelguideteste-backend.git`
2. Crie uma tabela no seu banco de dados MySQL: `corretores`
3. Com 4 colunas: `id | name | cpf | creci`
4. Configure corretamente a conexão com o banco de dados
5. Inicialize o servidor e acesse a página principal: `index.php`

