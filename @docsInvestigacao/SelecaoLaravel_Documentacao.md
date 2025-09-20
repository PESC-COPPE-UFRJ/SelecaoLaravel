# Documentação do Projeto `SelecaoLaravel`

## Versão do Projeto: Laravel 4.2

---

## 0. Visão Geral do Projeto

### 0.1. Propósito e Contexto

O `SelecaoLaravel` é um sistema de gerenciamento de processos seletivos, desenvolvido para a PESC/COPPE/UFRJ. Seu objetivo principal é automatizar e organizar as etapas envolvidas na seleção de candidatos, desde a inscrição e coleta de informações até a avaliação e gestão dos resultados. O sistema visa otimizar o fluxo de trabalho dos responsáveis pelo processo seletivo e fornecer uma plataforma centralizada para candidatos.

### 0.2. Tecnologias Utilizadas

- **Framework:** Laravel 4.2 (versão de 2014, descontinuada e sem suporte oficial. Ver seção 5 para mais detalhes).
- **Linguagens:**
  - **Backend:** PHP (versão mínima recomendada: 5.4.0).
  - **Frontend:** HTML, CSS, JavaScript (provavelmente jQuery para manipulação do DOM).
- **Banco de Dados:** MySQL (configurável via `.env`).
- **Gerenciador de Dependências:** Composer.
- **Servidor Web:** Apache ou Nginx.
- **Sistema de Template:** Blade (integrado ao Laravel 4.2).

### 0.3. Requisitos de Sistema

- **PHP:** Versão 5.4.0 ou superior  
  - Extensões PHP necessárias: `php-mbstring`, `php-pdo_mysql`, `php-openssl`, `php-tokenizer`, `php-mcrypt`.
- **Servidor Web:** Apache (com `mod_rewrite`) ou Nginx.
- **Banco de Dados:** MySQL 5.x.
- **Composer:** Compatível (1.x recomendado).
- **Git:** Para versionamento.

---

## 1. Configuração e Ambiente de Desenvolvimento

### 1.1. Pré-requisitos

- **Git**
- **Composer**
- **PHP** (5.4+)
- **Servidor Web** (Apache ou Nginx)
- **MySQL**

### 1.2. Clonando o Repositório

```bash
git clone https://github.com/PESC-COPPE-UFRJ/SelecaoLaravel.git
cd SelecaoLaravel
```

### 1.3. Instalação de Dependências

```bash
composer install
```

Se necessário:

```bash
composer self-update --1
composer install
```

### 1.4. Configuração do Ambiente

```bash
cp .env.example .env
```

```ini
APP_ENV=local
APP_DEBUG=true
APP_KEY=SeuApplicationKeyAqui

DB_HOST=127.0.0.1
DB_DATABASE=selecao_laravel
DB_USERNAME=root
DB_PASSWORD=
```

No `app/config/app.php`:

```php
'key' => env('APP_KEY', 'SomeRandomStringOf32Characters'),
```

### 1.5. Configuração do Servidor Web

**Apache**:

```apache
<VirtualHost *:80>
    DocumentRoot "/caminho/SelecaoLaravel/public"
    ServerName selecao.local

    <Directory "/caminho/SelecaoLaravel/public">
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

**Nginx**:

```nginx
server {
    listen 80;
    server_name selecao.local;
    root /caminho/SelecaoLaravel/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php5.6-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 1.6. Banco de Dados

```bash
php artisan migrate
php artisan db:seed
```

### 1.7. Executando

```
http://selecao.local
```

---

## 2. Arquitetura e Estrutura (Laravel 4.2)

### 2.1. Estrutura de Pastas

- `app/commands`: Artisan
- `app/config`: Configurações
- `app/controllers`: Controladores
- `app/database`: Migrações e seeders
- `app/lang`: Traduções
- `app/models`: Modelos
- `app/routes.php`: Rotas
- `app/views`: Views Blade
- `bootstrap/`: Inicialização
- `public/`: Arquivos públicos
- `vendor/`: Dependências

### 2.2. Fluxo de Requisição

1. Requisição chega em `public/index.php`.
2. Bootstrap inicializa.
3. Configurações em `app/config/`.
4. Rotas em `app/routes.php`.
5. Controller é chamado → Model → View.
6. Resposta enviada ao navegador.

---

## 2.3. Rotas (Exemplo)

```php
<?php
Route::get('/', function() {
    return View::make('hello');
});

Route::resource('alunos', 'AlunosController');

Route::get('dashboard', array('before' => 'auth', function() {
    return View::make('dashboard');
}));
?>
```

---

## 2.4. Controladores (Exemplo)

```php
<?php
class AlunosController extends BaseController {
    public function index() {
        $alunos = Aluno::all();
        return View::make('alunos.index')->with('alunos', $alunos);
    }
}
?>
```

---

## 2.5. Modelos (Exemplo)

```php
<?php
class Aluno extends Eloquent {
    protected $table = 'alunos';
    protected $fillable = array('nome','matricula','email','data_nascimento');
    public $timestamps = true;
}
?>
```

---

## 2.6. Views (Blade)

```blade
@extends('layouts.master')

@section('title', 'Lista de Alunos')

@section('content')
    <h2>Lista de Alunos</h2>
@stop
```

---

## 2.7. Migrações

```php
<?php
class CreateAlunosTable extends Migration {
    public function up() {
        Schema::create('alunos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 100);
            $table->string('matricula', 20)->unique();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::drop('alunos');
    }
}
?>
```

---

## 2.8. Filtros

```php
<?php
Route::filter('auth', function() {
    if (Auth::guest()) return Redirect::guest('login');
});
?>
```

---

## 3. Módulos Principais

- **Autenticação**
- **Gerenciamento de Alunos**
- **Gerenciamento de Processos Seletivos**

---

## 4. Guias de Desenvolvimento

- Alteração de campos
- Criação de relatórios
- Modificações em views
- Novos controladores e models

---

## 5. Observações sobre Laravel 4.2

- Sem suporte oficial.
- Dependências antigas.
- Considerar atualização ou reescrita.

---

**Fim da documentação.**
