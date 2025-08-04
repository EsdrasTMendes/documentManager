# 📋 Gerenciador de Documentos
**Sistema de Gestão de Empréstimos de Equipamentos**

Este projeto é um sistema de gerenciamento de documentos desenvolvido em **Laravel**. O principal objetivo é simplificar e automatizar o controle de empréstimos de equipamentos (como notebooks) dentro de uma organização. A aplicação gerencia todo o fluxo de trabalho, desde a entrada de um produto no inventário por meio de uma nota fiscal XML até a geração automática de um termo de responsabilidade em **PDF** e **DOCX** para o usuário.

A solução foi projetada para ser **robusta, segura e escalável**, atendendo a todos os requisitos do desafio técnico com uma arquitetura coesa e uma experiência de usuário intuitiva.

---

## ✨ Funcionalidades

### 🚦 Fluxo de Negócio
- **Cadastro de Produtos via XML**: Upload de nota fiscal em XML, com extração automática dos dados do produto.
- **Empréstimo e Documentação Automática**: Ao cadastrar um produto, um empréstimo é criado para o usuário logado, gerando automaticamente o documento `Anexo1.docx`.
- **Gestão Completa de Documentos**: Visualização, download, edição e exclusão de documentos.
- **Filtros de Pesquisa**: Dashboard com filtros por **Nome**, **CPF** e **Função** do usuário.

### 🧠 Funcionalidades Técnicas
- **Geração de Documentos**: Utiliza `PHPWord` para .docx e `Dompdf` para PDF.
- **Processamento de XML**: Backend com lógica de leitura, extração e validação de XML.
- **Transações de Banco de Dados**: Uso de `DB::transaction` para garantir atomicidade nas operações.
- **Segurança e Autenticação**: Implementação com `Laravel Breeze` e controle de acesso por `user_id`.
- **UI/UX Moderna**: Interface responsiva com **Tailwind CSS** e modais elegantes com **Alpine.js**.

---

## 🛠️ Tecnologias Utilizadas

- **Framework**: Laravel 12
- **Banco de Dados**: MySQL 8+
- **Ambiente**: Docker (Laravel Sail)
- **Front-end**: Blade Templates, Tailwind CSS, Alpine.js
- **Bibliotecas PHP**: `phpoffice/phpword`, `dompdf/dompdf`

---

## 🚀 Instalação e Execução

### 1. Clonar o Repositório
```bash
git clone [URL_DO_SEU_REPOSITORIO]
cd [pasta_do_projeto]
```

### 2. Configurar o Ambiente
Copie o arquivo de ambiente de exemplo e edite-o conforme suas configurações locais.
```bash
cp .env.example .env
```

### 3. Iniciar o Docker
Inicie os containers do Laravel Sail em background.
```bash
./vendor/bin/sail up -d
```

### 4. Instalar Dependências e Configurar a Aplicação
```bash
sail composer install
sail npm install
sail artisan key:generate
sail artisan migrate:fresh --seed
```

### 5. Compilar Assets e Rodar o Servidor
Compile os assets de front-end.
```bash
sail npm run dev
```

### 6. Acessar a Aplicação
Acesse a aplicação no seu navegador:
[http://localhost](http://localhost)

---

## 💼 Fluxo de Utilização (Para Avaliadores)

1.  **Cadastro de Usuário**: Acesse `http://localhost` e clique em "**Cadastre-se**".
2.  **Login**: Autentique-se com o usuário recém-criado.
3.  **Dashboard**: Na página principal, clique em "**Cadastrar Produto (XML)**".
4.  **Upload de XML**: Selecione o arquivo `invoice_example.xml` (localizado no diretório `/invoices` do projeto) e clique em "**Processar e Criar Empréstimo**".
5.  **Ações**: O novo empréstimo aparecerá na lista. Você poderá baixar os documentos gerados (**PDF/DOCX**), editar o registro com um novo XML ou excluí-lo.

---

## 📝 Observações
Este projeto foi criado como solução para um desafio técnico, com foco em boas práticas, segurança, clareza no fluxo e facilidade de manutenção.

---

## 📌 Licença
Este projeto está licenciado sob os termos da **MIT License**.
