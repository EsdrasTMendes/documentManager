# Sistema de Gerenciamento de Documentos e Empréstimos

Este projeto é um sistema de gerenciamento de documentos desenvolvido com Laravel, focado no controle de empréstimo de equipamentos. O objetivo é permitir que usuários cadastrem, visualizem e gerenciem documentos de forma segura e organizada, seguindo os requisitos do desafio técnico.

## Requisitos do Projeto

### Requisitos Obrigatórios
- [ ] Cadastro e autenticação de usuário (login/logout).
- [ ] Visualizar, adicionar, editar, baixar e remover documentos.
- [ ] Um usuário pode cadastrar vários documentos, mas não pode visualizar nem realizar o download de documentos de outros usuários.
- [ ] Ao baixar um documento, o sistema deve gerar uma cópia do `Anexo1.docx` preenchida com os dados do empréstimo.

### Requisitos Diferenciais
- [ ] Utilização do Laravel Sail para o projeto.
- [ ] Opção de download dos documentos em formato PDF ou DOCX.
- [ ] Adicionar uma tabela de acessórios e periféricos no `Anexo1.docx`.
- [ ] Criar filtros de pesquisa nos documentos por nome, função e CPF.
- [ ] Fluxo de criação de produtos através do upload de nota fiscal.

## 🚀 To-Do List do Projeto

Use esta lista para acompanhar o andamento das tarefas. Marque-as com `[x]` para indicar que foram concluídas.

### 📝 Etapa 1: Fluxo de Empréstimo de Produtos
- [x] **1.1 - Ajustes e Padronização do Código:**
    - [x] Corrigir a variável `$loans` no `ProductLoanController` para `$productLoans`.
    - [x] Padronizar as views `index.blade.php` e `show.blade.php` com Tailwind CSS.
    - [x] Corrigir as rotas na `index.blade.php` para usarem `product_loans` (com underline).
- [ ] **1.2 - Adição de Itens ao Empréstimo:**
    - [ ] Modificar a view `create.blade.php` para consumir a lista de produtos do banco de dados.
    - [ ] Atualizar o método `store` no `ProductLoanController` para salvar os itens de empréstimo (`ProductLoanItem`).

### 📄 Etapa 2: Geração e Download de Documentos
- [ ] **2.1 - Configuração de Bibliotecas e Template:**
    - [ ] Instalar as bibliotecas `phpword` e `dompdf`.
    - [ ] Criar o template `Anexo1.docx` com os placeholders.
- [ ] **2.2 - Lógica de Geração:**
    - [ ] Implementar a lógica de preenchimento e salvamento dos arquivos `.docx` e `.pdf` no `ProductLoanController@store`.
- [ ] **2.3 - Funcionalidade de Download:**
    - [ ] Implementar o método `download` no `DocumentController` com verificação de permissão.
    - [ ] Adicionar os botões de download na view `show.blade.php` do empréstimo.

### 🔍 Etapa 3: Melhorias e Requisitos Diferenciais
- [ ] **3.1 - Filtros de Pesquisa:**
    - [ ] Implementar a lógica de filtro por nome, função e CPF no `DocumentController`.
    - [ ] Ajustar a view `dashboardapp.blade.php` para exibir os documentos filtrados.
- [ ] **3.2 - Exibição Detalhada dos Itens:**
    - [ ] Garantir que a view `show.blade.php` exiba a lista de itens do empréstimo.
- [ ] **3.3 - Outros Requisitos:**
    - [ ] Considerar a criação de um fluxo de cadastro de categorias, se houver tempo.

### 📦 Etapa 4: Fluxo de Criação de Produtos via Nota Fiscal
- [x] **4.1 - Definição do Formulário e Lógica da View:**
    - [x] Criar o `ProductController`.
    - [x] Criar o formulário `products/create.blade.php` para o cadastro.
- [x] **4.2 - Lógica de Salvamento no `ProductController`:**
    - [x] Criar a model e a migration para `Invoice`.
    - [x] Adicionar o campo `invoice_number` no formulário de criação.
    - [x] Implementar a lógica de validação e salvamento do produto e da nota fiscal no `ProductController@store`.
    - [x] Criar um botão no `dashboardapp.blade.php` para acessar este fluxo.
