# 📌 Plataforma de Gestão de Programas, Candidatos e Candidaturas  

Este sistema foi desenvolvido para a **gestão de Programas, Candidatos e Candidaturas**, permitindo que candidatos se inscrevam em diferentes programas de acordo com critérios definidos.  

---

## ⚙️ Instalação e Configuração  

### 1️⃣ Clonar o repositório  
```bash
git clone https://github.com/teu-usuario/teu-repositorio.git
cd teu-repositorio
```

### 2️⃣ Instalar dependências do Laravel  
```bash
composer install
```

### 3️⃣ Criar o ficheiro de ambiente  
```bash
cp .env.example .env
```

### 4️⃣ Configurar a base de dados  
Abra o ficheiro `.env` e defina as credenciais:  
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_da_base_de_dados
DB_USERNAME=utilizador
DB_PASSWORD=senha
```

### 5️⃣ Gerar a chave da aplicação  
```bash
php artisan key:generate
```

### 6️⃣ Executar migrações e popular a base de dados  
```bash
php artisan migrate --seed
```

### 7️⃣ Iniciar o servidor local  
```bash
php artisan serve
```

Sistema disponível em:  
👉 `http://127.0.0.1:8000`

---

## ⚖️ Regras de Negócio  

### 🔹 Candidaturas  
- Um candidato pode concorrer a vários programas.  
- Para se candidatar, o candidato deve estar **autenticado (logado)**.  

### 🔹 Programas  
- Um programa só aceita candidaturas se:  
  - **Data de início ≤ hoje ≤ data final**  
  - O **estado** do programa estiver definido como **ativo**  
- Os programas podem ser **pré-cadastrados** no banco de dados.  

---

## 🔄 Fluxo Geral  

1. O administrador cadastra os programas no sistema.  
2. O candidato cria uma conta e realiza login.  
3. O candidato pode visualizar os programas ativos dentro do período válido.  
4. O candidato submete a sua candidatura.  
5. O sistema valida automaticamente as regras de datas e estado do programa antes de aceitar a candidatura.  

---

## 📖 Documentação da API  

A documentação completa dos endpoints encontra-se disponível no Postman:  
👉 [Ver Documentação](https://documenter.getpostman.com/view/48151868/2sB3HjNMqW)  

### 🔗 Endpoints principais  

- **Candidatos:** `http://127.0.0.1:8000/api/v1/candidatos/`  
- **Autenticação:** `http://127.0.0.1:8000/api/v1/autenticação/`  
- **Programas:** `http://127.0.0.1:8000/api/v1/programas/`  
- **Candidaturas:** `http://127.0.0.1:8000/api/v1/candidaturas/`  

---

## 🔑 Guia de Autenticação  

Este sistema utiliza **Laravel Sanctum** para autenticação baseada em token.  

---

## 🛠️ Tecnologias Utilizadas  

- [Laravel 11](https://laravel.com/)  
- [PHP 8.2+](https://www.php.net/)  
- [MySQL](https://www.mysql.com/)  
- [Composer](https://getcomposer.org/)  
