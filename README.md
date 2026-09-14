# LibraTrack — Library Management System

Sistema de gerenciamento de biblioteca desenvolvido para consolidar conceitos de
Banco de Dados Relacionais com múltiplas tabelas e relacionamentos, desenvolvimento
web com stack LAMP (Linux, Apache, MariaDB, PHP) e containerização com Docker.

Projeto seguinte ao [SaveWise-CLI](https://github.com/WesF020/SaveWise-CLI), evoluindo
do desenvolvimento desktop Java para desenvolvimento web full-stack.

---

## Tecnologias e Conceitos

- **PHP 8** — lógica de backend e renderização de páginas
- **Apache** — servidor web HTTP
- **MariaDB** — banco de dados relacional com múltiplas tabelas e foreign keys
- **Docker + Docker Compose** — containerização do ambiente completo
- **HTML + CSS** — interface web

---

## Conceitos de Banco de Dados Aplicados

- Relacionamentos entre tabelas com **Foreign Keys**
- Consultas com **JOIN** entre múltiplas tabelas
- **Primary Keys** e integridade referencial
- Uso de **HashMap** e **HashSet** no código para cache e validação
- Queries com filtros, ordenação e agrupamento

---

## Arquitetura

```
Docker Compose
├── web (PHP + Apache)
│   └── src/
│       ├── config/
│       │   └── database.php       ← conexão com MariaDB
│       ├── model/
│       │   ├── Book.php
│       │   ├── Member.php
│       │   └── Loan.php
│       ├── dao/
│       │   ├── BookDAO.php
│       │   ├── MemberDAO.php
│       │   └── LoanDAO.php
│       ├── service/
│       │   ├── BookService.php
│       │   ├── MemberService.php
│       │   └── LoanService.php
│       └── view/
│           ├── books.php
│           ├── members.php
│           └── loans.php
└── db (MariaDB)
    └── init.sql                   ← script de criação do banco
```

---

## Modelo do Banco de Dados

```sql
-- Tabela de livros
CREATE TABLE books (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    author      VARCHAR(100) NOT NULL,
    isbn        VARCHAR(20)  UNIQUE NOT NULL,
    quantity    INT          NOT NULL DEFAULT 1
);

-- Tabela de membros
CREATE TABLE members (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) UNIQUE NOT NULL,
    phone       VARCHAR(20)
);

-- Tabela de empréstimos (relaciona books e members)
CREATE TABLE loans (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    book_id     INT  NOT NULL,
    member_id   INT  NOT NULL,
    loan_date   DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id)   REFERENCES books(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);
```

---

## Como executar localmente

### Pré-requisitos
- Docker
- Docker Compose

### Executando

```bash
git clone https://github.com/WesF020/LibraTrack.git
cd LibraTrack
docker-compose up -d
```

Acesse `http://localhost:8080` no navegador.

### Encerrando

```bash
docker-compose down
```

---

## Configuração

Copie o arquivo de exemplo e ajuste as credenciais:

```bash
cp .env.example .env
```

```env
DB_HOST=db
DB_NAME=libratrack_db
DB_USER=root
DB_PASSWORD=your_password_here
```

---

## Roadmap

Consulte o arquivo [ROADMAP.md](ROADMAP.md) para o planejamento detalhado das fases do projeto.

---

## Autor

[WesF020](https://github.com/WesF020)
