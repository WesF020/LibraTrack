[ROADMAP.md](https://github.com/user-attachments/files/32183222/ROADMAP.md)
# LibraTrack — Roadmap

Planejamento técnico das fases do projeto, desde a configuração do ambiente
Docker até o sistema web completo com PHP e MariaDB.

---

## Fase 1 — Ambiente Docker

Configurar o ambiente de desenvolvimento containerizado antes de escrever qualquer código.

- [ ] Criar `docker-compose.yml` com serviços `web` (PHP+Apache) e `db` (MariaDB)
- [ ] Criar `Dockerfile` para o serviço web
- [ ] Criar `.env` e `.env.example` para credenciais
- [ ] Adicionar `.env` no `.gitignore`
- [ ] Validar que `docker-compose up` sobe o ambiente corretamente
- [ ] Confirmar acesso ao MariaDB pelo container web

```yaml
# docker-compose.yml esperado
services:
  web:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html
    depends_on:
      - db

  db:
    image: mariadb:10.11
    environment:
      MARIADB_ROOT_PASSWORD: ${DB_PASSWORD}
      MARIADB_DATABASE: ${DB_NAME}
    volumes:
      - ./db/init.sql:/docker-entrypoint-initdb.d/init.sql
```

**Commits:**
```
chore(docker): add docker-compose with PHP/Apache and MariaDB services
chore(docker): add Dockerfile for web service
chore(git): add .env.example and protect .env via .gitignore
```

---

## Fase 2 — Banco de Dados

Criar o schema com relacionamentos e foreign keys.

- [ ] Criar `db/init.sql` com as tabelas `books`, `members` e `loans`
- [ ] Definir `FOREIGN KEY` em `loans` referenciando `books` e `members`
- [ ] Validar integridade referencial — tentar deletar um livro com empréstimo ativo
- [ ] Popular o banco com dados de teste via `INSERT`

**Conceitos praticados:**
- Primary Key e Auto Increment
- Foreign Key e integridade referencial
- Relacionamento N:N entre books e members via tabela loans
- Queries com JOIN entre as três tabelas

**Commits:**
```
feat(db): add init.sql with books, members and loans schema
feat(db): add foreign key constraints between loans, books and members
feat(db): add seed data for local testing
```

---

## Fase 3 — Backend PHP (DAO Pattern)

Implementar a camada de acesso a dados em PHP, seguindo o mesmo padrão DAO do SaveWise.

- [ ] Criar `config/database.php` com conexão PDO ao MariaDB
- [ ] Criar `model/Book.php`, `model/Member.php`, `model/Loan.php`
- [ ] Criar `dao/BookDAO.php` com métodos `save`, `findAll`, `findById`, `delete`
- [ ] Criar `dao/MemberDAO.php` com os mesmos métodos
- [ ] Criar `dao/LoanDAO.php` com método `findAllWithDetails` usando JOIN
- [ ] Criar `service/BookService.php`, `service/MemberService.php`, `service/LoanService.php`

**Conceitos praticados:**
- PDO (PHP Data Objects) — equivalente ao JDBC do Java
- Prepared Statements para evitar SQL Injection
- JOIN entre books, members e loans
- HashMap para cache de livros por ID

**Commits:**
```
feat(config): add PDO database connection
feat(model): add Book, Member and Loan models
feat(dao): add BookDAO, MemberDAO and LoanDAO with PDO
feat(service): add service layer with business rules
```

---

## Fase 4 — Interface Web (PHP + HTML + CSS)

Criar as páginas web servidas pelo Apache.

- [ ] Criar `view/books.php` — listagem e cadastro de livros
- [ ] Criar `view/members.php` — listagem e cadastro de membros
- [ ] Criar `view/loans.php` — listagem de empréstimos com JOIN (título + nome do membro)
- [ ] Criar `view/new-loan.php` — formulário de novo empréstimo com select de livros e membros
- [ ] Estilizar as páginas com CSS

**Commits:**
```
feat(view): add books listing and registration page
feat(view): add members listing and registration page
feat(view): add loans listing with book and member details
feat(view): add new loan form with book and member selects
feat(view): add CSS styling for all pages
```

---

## Fase 5 — Melhorias Futuras

- [ ] Validação de disponibilidade — impedir empréstimo de livro sem estoque
- [ ] Filtro de empréstimos em aberto (sem `return_date`)
- [ ] Paginação na listagem de livros
- [ ] Busca por título ou autor
