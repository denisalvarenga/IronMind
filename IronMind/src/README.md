# IronMind

**IronMind** é um assistente inteligente de treinos, voltado para otimização de exercícios, controle de hidratação e histórico de treinos personalizados. O projeto permite que usuários criem contas, gerem planos de treino semanais e acompanhem seu progresso ao longo do tempo.

---

## 📝 Funcionalidades

- Cadastro e login de usuários com autenticação segura.
- Dashboard interativo com interface animada e centralizada.
- Geração automática de planos de treino personalizados de acordo com:
  - Peso, altura, idade e sexo.
  - Objetivo (massa, definição ou perda de gordura).
  - Nível de experiência (iniciante, intermediário, avançado).
- Cálculo de ingestão diária de água recomendado.
- Histórico de treinos salvos para acompanhamento.
- Logout seguro com destruição completa da sessão.

---

## 💻 Tecnologias Utilizadas

- **Linguagem:** PHP 8  
- **Banco de Dados:** MySQL (PDO e MySQLi)  
- **Frontend:** HTML5, CSS3, JavaScript  
- **Servidor Local:** XAMPP (Apache + MySQL)

---

## 📂 Estrutura de Pastas

/src
│
├── /auth
│ ├── login.php
│ ├── cadastro.php
│ └── logout.php
│
├── /config
│ └── database.php
│
├── /css
│ └── style.css
│
├── /js
│ └── script.js
│
├── dashboard.php
├── gerador_de_treino.php
├── historico.php
└── index.php


### 📌 Descrição dos arquivos

- `auth/` → páginas de autenticação e gerenciamento de sessão.
- `config/database.php` → conexão com banco de dados (PDO e MySQLi).
- `css/style.css` → todos os estilos centralizados, incluindo dashboard, formulários e histórico.
- `js/script.js` → scripts interativos, como cálculo de água e animações do dashboard.
- `dashboard.php` → interface principal do usuário após login.
- `gerador_de_treino.php` → formulário de geração de treino personalizado e registro no banco.
- `historico.php` → exibição do histórico de treinos do usuário.
- `index.php` → redireciona usuários para login ou dashboard automaticamente.

---

## ⚙️ Instalação e Configuração

1. Clone o repositório:

```bash
git clone https://github.com/seuusuario/IronMind.git
Configure o servidor local (XAMPP, MAMP ou similar):

Copie a pasta IronMind para o diretório htdocs (ou equivalente).

Inicie o Apache e o MySQL.

Crie o banco de dados MySQL:

CREATE DATABASE ironmind;
USE ironmind;

-- Tabela de contas
CREATE TABLE contas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);

-- Tabela de usuários (informações físicas)
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  peso FLOAT,
  altura FLOAT,
  idade INT,
  sexo VARCHAR(20),
  objetivo VARCHAR(50),
  nivel VARCHAR(50),
  imc FLOAT,
  agua FLOAT
);

-- Tabela de treinos
CREATE TABLE treinos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  usuario VARCHAR(100),
  dia_semana ENUM('Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES contas(id)
);
Configure a conexão em src/config/database.php:

$host = "localhost";
$dbname = "ironmind";
$user = "root";
$pass = "";
Abra no navegador:

http://localhost/IronMind/src/index.php
🚀 Uso
Crie uma conta ou faça login com credenciais existentes.

Acesse o Dashboard.

Clique em Gerar Novo Treino e preencha suas informações.

Confira seu plano personalizado e a quantidade diária de água recomendada.

Consulte o Histórico de Treinos para acompanhar seu progresso.

Faça logout quando desejar.

🎨 Frontend
Todo o CSS está centralizado em css/style.css.

As animações do dashboard (elemento symbiote) são feitas com CSS e JS.

Formulários responsivos e botões com hover e efeitos visuais modernos.

🔒 Segurança
Senhas armazenadas com password_hash().

Sessões PHP corretamente destruídas no logout.

Prepared Statements PDO para todas operações com o banco, prevenindo SQL Injection.

✨ Melhorias futuras
Implementar cadastro de exercícios adicionais pelo usuário.

Adicionar gráficos de evolução de IMC e treinos.

Melhorar interface responsiva para dispositivos móveis.

Implementar exportação de treinos em PDF.

📄 Licença
Este projeto é open-source. Sinta-se livre para contribuir ou adaptar para uso pessoal/educacional.