# Documentação do Projeto `SelecaoLaravel`

## Versão do Projeto: Laravel 4.2

---

## 0. Visão Geral do Projeto

### 0.1. Propósito e Contexto

O `SelecaoLaravel` é um sistema de gerenciamento de processos seletivos, desenvolvido para a PESC/COPPE/UFRJ. Seu objetivo principal é automatizar e organizar as etapas envolvidas na seleção de candidatos, desde a inscrição e coleta de informações até a avaliação e gestão dos resultados. O sistema visa otimizar o fluxo de trabalho dos responsáveis pelo processo seletivo e fornecer uma plataforma centralizada para candidatos.

### 0.2. Tecnologias Utilizadas

Este projeto foi construído sobre uma base legada, o que implica em considerações importantes sobre as tecnologias empregadas.

*   **Framework:** Laravel 4.2 (versão de 2014, descontinuada e sem suporte oficial. Ver seção 5 para mais detalhes).
*   **Linguagens:**
    *   **Backend:** PHP (versão mínima recomendada: 5.4.0).
    *   **Frontend:** HTML, CSS, JavaScript (provavelmente jQuery para manipulação do DOM).
*   **Banco de Dados:** MySQL (configurável via `.env`).
*   **Gerenciador de Dependências:** Composer.
*   **Servidor Web:** Apache ou Nginx.
*   **Sistema de Template:** Blade (integrado ao Laravel 4.2).

### 0.3. Requisitos de Sistema

Para rodar o `SelecaoLaravel`, os seguintes requisitos de ambiente são necessários:

*   **PHP:** Versão 5.4.0 ou superior (preferencialmente uma versão compatível que ainda receba patches de segurança, embora seja um desafio para 4.2).
    *   Extensões PHP necessárias: `php-mbstring`, `php-pdo_mysql` (ou para seu DB), `php-openssl`, `php-tokenizer`, `php-mcrypt` (se usado no 4.2).
*   **Servidor Web:** Apache (com `mod_rewrite` habilitado) ou Nginx.
*   **Banco de Dados:** MySQL 5.x.
*   **Composer:** Versão compatível com as dependências do Laravel 4.2 (pode ser necessário usar uma versão mais antiga do Composer, como a 1.x).
*   **Git:** Para controle de versão.

---

## 1. Configuração e Ambiente de Desenvolvimento

Esta seção detalha os passos para configurar um ambiente de desenvolvimento local para o projeto.

### 1.1. Pré-requisitos

Certifique-se de ter os seguintes softwares instalados e configurados:

*   **Git:** Para clonar o repositório.
*   **Composer:** Gerenciador de dependências do PHP.
*   **PHP:** Versão 5.4.0+.
*   **Servidor Web:** Apache ou Nginx.
*   **Banco de Dados:** MySQL Server.

### 1.2. Clonando o Repositório

```bash
git clone https://github.com/PESC-COPPE-UFRJ/SelecaoLaravel.git
cd SelecaoLaravel

### 1.3. Instalação de Dependências

Use o Composer para instalar as dependências do PHP. Devido à versão antiga do Laravel, pode ser necessário usar uma versão mais antiga do Composer.
code
Bash
composer install
Se encontrar problemas, tente:
code
Bash
composer self-update --1 # Atualiza para a versão 1.x do Composer
composer install
1.4. Configuração do Ambiente
O Laravel 4.2 usa arquivos de configuração em app/config/ e pode ter um arquivo .env ou diretórios de ambiente para configurações locais.
Crie um arquivo .env na raiz do projeto:
Copie o arquivo de exemplo (se existir) ou crie um novo:
code
Code
cp .env.example .env # Se houver um .env.example
Se não houver, crie um arquivo .env e configure-o manualmente.
Edite o arquivo .env (ou os arquivos em app/config/local/ se essa for a estratégia):
code
Ini
APP_ENV=local
APP_DEBUG=true
APP_KEY=SeuApplicationKeyAqui # Gerar com 'php artisan key:generate' ou copiar de outro lugar

DB_HOST=127.0.0.1
DB_DATABASE=selecao_laravel
DB_USERNAME=root
DB_PASSWORD=
Substitua os valores pelos seus dados.
Gerar APP_KEY: No Laravel 4.2, a chave da aplicação pode ser definida em app/config/app.php ou gerada via comando (se o key:generate estiver disponível). Se não estiver definida, defina uma string aleatória de 32 caracteres.
code
PHP
// Exemplo em app/config/app.php
'key' => env('APP_KEY', 'SomeRandomStringOf32Characters'),
1.5. Configuração do Servidor Web
Configure seu servidor web (Apache ou Nginx) para que o document root (ou web root) aponte para o diretório public/ do projeto.
Exemplo para Apache (httpd-vhosts.conf ou similar):
code
Apache
<VirtualHost *:80>
    DocumentRoot "/caminho/para/seu/projeto/SelecaoLaravel/public"
    ServerName selecao.local # Ou outro domínio local
    ErrorLog "${APACHE_LOG_DIR}/selecao_error.log"
    CustomLog "${APACHE_LOG_DIR}/selecao_access.log" combined

    <Directory "/caminho/para/seu/projeto/SelecaoLaravel/public">
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
Lembre-se de habilitar mod_rewrite e reiniciar o Apache.
Exemplo para Nginx (/etc/nginx/sites-available/selecao.local):
code
Nginx
server {
    listen 80;
    server_name selecao.local; # Ou outro domínio local
    root /caminho/para/seu/projeto/SelecaoLaravel/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php5.6-fpm.sock; # Ajuste para sua versão do PHP-FPM
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
Crie um symlink para sites-enabled e reinicie o Nginx e o PHP-FPM.
1.6. Configuração do Banco de Dados
Crie o banco de dados (ex: selecao_laravel) no seu servidor MySQL.
Execute as migrações para criar as tabelas no banco de dados:
code
Bash
php artisan migrate
Popule o banco de dados com dados iniciais/de teste (se existirem seeders):
code
Bash
php artisan db:seed
1.7. Executando a Aplicação
Após todos os passos, você deve conseguir acessar a aplicação no seu navegador: http://selecao.local (ou o domínio que você configurou).
2. Arquitetura e Estrutura do Código (Laravel 4.2 Específico!)
A arquitetura do Laravel 4.2 difere significativamente das versões mais recentes (Laravel 5+). É crucial entender essas diferenças para navegar e modificar o código.
2.1. Visão Geral da Estrutura de Pastas
app/: Contém a maior parte da lógica da aplicação.
app/commands: Comandos Artisan personalizados.
app/config: Arquivos de configuração da aplicação e de ambientes específicos.
app/controllers: Classes de controladores que lidam com as requisições HTTP.
app/database: Migrações e seeders do banco de dados.
app/lang: Arquivos de tradução.
app/models: Modelos Eloquent para interação com o banco de dados.
app/start: Arquivos de inicialização global e de ambiente.
app/storage: Arquivos de cache, logs, sessões, etc.
app/tests: Testes unitários e funcionais.
app/views: Arquivos de template Blade para a interface do usuário.
app/filters.php: Definição de filtros de rota (equivalente a middlewares no Laravel 5+).
app/routes.php: Definição de todas as rotas da aplicação.
bootstrap/: Arquivos de carregamento do framework.
public/: O diretório público que é acessível via navegador. Contém index.php, CSS, JS, imagens.
vendor/: Dependências PHP instaladas via Composer.
2.2. Fluxo de Requisição (Request Lifecycle)
Uma requisição chega ao servidor web e é direcionada para public/index.php.
index.php carrega o autoload do Composer e o bootstrap do Laravel (bootstrap/start.php).
O Laravel é inicializado, carregando as configurações em app/config/.
Os filtros em app/filters.php são registrados.
As rotas em app/routes.php são carregadas e a URL da requisição é comparada.
Se uma rota for encontrada, os filtros associados são executados.
O controlador e o método correspondente à rota são instanciados e executados.
O controlador interage com modelos (Eloquent ORM), serviços e outros componentes.
Uma view (app/views/) é renderizada, possivelmente com dados passados pelo controlador.
A resposta HTML é enviada de volta ao navegador.
2.3. Rotas (app/routes.php)
No Laravel 4.2, todas as rotas da aplicação são definidas em app/routes.php.
code
PHP
<?php

// Rota para a página inicial
Route::get('/', function()
{
    return View::make('hello'); // Renderiza a view hello.blade.php
});

// Rotas de recurso para gerenciamento de alunos (CRUD)
Route::resource('alunos', 'AlunosController');

// Rota com filtro de autenticação
Route::get('dashboard', array('before' => 'auth', function()
{
    return View::make('dashboard');
}));

// Rota com parâmetros
Route::get('alunos/{id}', 'AlunosController@show');

// Rotas agrupadas (prefixo, namespace, filtros)
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function()
{
    Route::get('/', 'AdminController@index');
    Route::resource('users', 'AdminUsersController');
});

?>
2.4. Controladores (app/controllers/)
Controladores são classes que agrupam a lógica para lidar com as requisições HTTP. Eles geralmente buscam dados, processam-nos e passam para as views.
code
PHP
<?php

class AlunosController extends BaseController {

    // Exibe uma lista de alunos
    public function index()
    {
        $alunos = Aluno::all(); // Busca todos os alunos
        return View::make('alunos.index')->with('alunos', $alunos);
    }

    // Exibe o formulário de criação de um novo aluno
    public function create()
    {
        return View::make('alunos.create');
    }

    // Salva um novo aluno no banco de dados
    public function store()
    {
        $rules = array(
            'nome'      => 'required',
            'matricula' => 'required|unique:alunos'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('alunos/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $aluno = new Aluno;
            $aluno->nome      = Input::get('nome');
            $aluno->matricula = Input::get('matricula');
            $aluno->save();

            Session::flash('message', 'Aluno criado com sucesso!');
            return Redirect::to('alunos');
        }
    }

    // Mostra um aluno específico
    public function show($id)
    {
        $aluno = Aluno::find($id);
        return View::make('alunos.show')->with('aluno', $aluno);
    }

    // ... outros métodos: edit, update, destroy
}
BaseController: Controladores geralmente estendem BaseController para compartilhar funcionalidades.
Filtros: Podem ser aplicados diretamente no construtor do controlador ($this->beforeFilter('auth')).
Input: Os dados de requisição são acessados via Input::get('nome_do_campo').
2.5. Modelos (app/models/)
Modelos representam as tabelas do banco de dados e são usados para interagir com os dados através do Eloquent ORM.
code
PHP
<?php

class Aluno extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alunos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('nome', 'matricula', 'email', 'data_nascimento');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array(); // Ex: 'password'

    /**
     * Desabilita timestamps (created_at, updated_at) se a tabela não os tiver.
     * @var bool
     */
    public $timestamps = true;

    // Exemplo de relacionamento: Um aluno tem muitas formações
    public function formacoes()
    {
        return $this->hasMany('Formacao'); // Onde 'Formacao' é o nome do modelo da formação
    }

    // Exemplo de relacionamento: Um aluno pertence a um processo seletivo
    public function processoSeletivo()
    {
        return $this->belongsTo('ProcessoSeletivo');
    }
}
protected $table: Opcional, se o nome da classe do modelo for o singular do nome da tabela.
protected $fillable / $guarded: Controla quais atributos podem ser atribuídos em massa.
public $timestamps: Define se o Eloquent deve gerenciar as colunas created_at e updated_at.
Relacionamentos: Métodos que definem as relações entre modelos (ex: hasMany, belongsTo, hasOne, belongsToMany).
2.6. Views (app/views/)
As views são os arquivos de template que geram a interface do usuário, utilizando a sintaxe Blade.
code
Blade
{{-- app/views/layouts/master.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Seleção COPPE')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Inclusão de CSS/JS aqui --}}
</head>
<body>
    <header>
        <h1>Sistema de Seleção</h1>
        <nav>
            <ul>
                <li><a href="{{ URL::to('alunos') }}">Alunos</a></li>
                <li><a href="{{ URL::to('processos') }}">Processos Seletivos</a></li>
                @if (Auth::check())
                    <li><a href="{{ URL::to('logout') }}">Logout</a></li>
                @else
                    <li><a href="{{ URL::to('login') }}">Login</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} PESC/COPPE/UFRJ</p>
    </footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
code
Blade
{{-- app/views/alunos/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Lista de Alunos')

@section('content')
    <h2>Lista de Alunos</h2>
    <a href="{{ URL::to('alunos/create') }}" class="btn btn-primary">Adicionar Aluno</a>

    @if ($alunos->isEmpty())
        <p>Nenhum aluno cadastrado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->id }}</td>
                        <td>{{ $aluno->nome }}</td>
                        <td>{{ $aluno->matricula }}</td>
                        <td>{{ $aluno->email }}</td>
                        <td>
                            <a href="{{ URL::to('alunos/' . $aluno->id) }}" class="btn btn-small btn-success">Ver</a>
                            <a href="{{ URL::to('alunos/' . $aluno->id . '/edit') }}" class="btn btn-small btn-info">Editar</a>
                            {{ Form::open(array('url' => 'alunos/' . $aluno->id, 'class' => 'pull-right')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Deletar', array('class' => 'btn btn-warning')) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop
@extends('layout.master'): Define que esta view usa o layout master.
@section('content') / @yield('content'): Define blocos de conteúdo que podem ser preenchidos.
{{ $variavel }}: Exibe o valor de uma variável.
{{ HTML::link(...) }} / {{ URL::to(...) }}: Funções auxiliares para gerar links.
{{ Form::open(...) }} / {{ Form::text(...) }}: Funções auxiliares para construir formulários (requer laravelcollective/html ou similar, ou pode ser HTML puro).
asset('caminho/para/arquivo.css'): Ajuda a gerar URLs para assets públicos.
2.7. Banco de Dados (app/database/)
Este diretório contém os arquivos de migração e seeders para gerenciar o esquema do banco de dados e popular com dados iniciais.
2.7.1. Migrações
As migrações são como um controle de versão para o seu banco de dados.
Criação de uma Migração:
code
Bash
php artisan migrate:make create_tabela_exemplo --table=tabela_exemplo
Isso cria um arquivo como xxxx_xx_xx_xxxxxx_create_tabela_exemplo.php.
Exemplo de Migração:
code
PHP
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nome', 100);
            $table->string('matricula', 20)->unique();
            $table->string('email', 100)->unique()->nullable();
            $table->date('data_nascimento')->nullable();
            $table->timestamps(); // Adiciona created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alunos');
    }

}
Execução:
code
Bash
php artisan migrate           # Executa todas as migrações pendentes
php artisan migrate:rollback  # Reverte a última migração
php artisan migrate:reset     # Reverte todas as migrações
php artisan migrate:refresh   # Reverte e executa todas as migrações
2.7.2. Seeders
Seeders são usados para popular o banco de dados com dados de teste ou iniciais.
Criação de um Seeder:
code
Bash
php artisan make:seeder AlunosTableSeeder
Exemplo de Seeder (app/database/seeds/AlunosTableSeeder.php):
code
PHP
<?php

class AlunosTableSeeder extends Seeder {

    public function run()
    {
        DB::table('alunos')->delete(); // Limpa a tabela antes de inserir

        Aluno::create(array(
            'nome' => 'João da Silva',
            'matricula' => '123456',
            'email' => 'joao@example.com',
            'data_nascimento' => '1990-01-15'
        ));

        Aluno::create(array(
            'nome' => 'Maria Souza',
            'matricula' => '654321',
            'email' => 'maria@example.com',
            'data_nascimento' => '1992-03-20'
        ));
    }

}
Para rodar um seeder, primeiro chame-o no DatabaseSeeder.php:
code
PHP
// app/database/seeds/DatabaseSeeder.php
class DatabaseSeeder extends Seeder {
    public function run()
    {
        Eloquent::unguard();
        $this->call('AlunosTableSeeder');
        // $this->call('OutroTableSeeder');
    }
}
Execução:
code
Bash
php artisan db:seed            # Executa o DatabaseSeeder
php artisan db:seed --class=AlunosTableSeeder # Executa um seeder específico
2.8. Filtros (app/filters.php)
Os filtros são usados para executar código antes ou depois de uma requisição ser processada por uma rota ou controlador. São análogos aos "middlewares" em versões mais recentes do Laravel.
code
PHP
<?php

// Filtro de autenticação
Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::guest('login');
});

// Filtro CSRF
Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

// Aplicação de filtros em rotas (veja app/routes.php)
// Route::get('admin', array('before' => 'auth', 'uses' => 'AdminController@index'));
// Ou em controladores:
// public function __construct() { $this->beforeFilter('auth'); }

?>
3. Principais Módulos/Funcionalidades Existentes
Esta seção descreve as funcionalidades principais do sistema e mapeia-as para os componentes de código relevantes.
3.1. Módulo de Autenticação
Propósito: Gerenciamento de login, logout e talvez registro de usuários.
Componentes Chave:
Controladores: AuthController (ou similar, pode ser parte do UserController).
Rotas (app/routes.php): /login, /logout, /register (se implementado).
Modelos: User (tabela users).
Views (app/views/): login.blade.php, register.blade.php.
Filtros (app/filters.php): auth, auth.basic para proteger rotas.
3.2. Módulo de Gerenciamento de Alunos/Candidatos
Propósito: Inscrição, visualização, edição e exclusão de informações de candidatos/alunos. Gerenciamento de sua formação, documentos, etc.
Componentes Chave:
Controladores: AlunosController, CandidatosController (ou similar).
Modelos: Aluno, Candidato, Formacao, Documento (tabelas alunos, formacoes, documentos).
Rotas (app/routes.php): Route::resource('alunos', 'AlunosController') ou rotas individuais para CRUD.
Views (app/views/): alunos.index.blade.php, alunos.create.blade.php, alunos.edit.blade.php, alunos.show.blade.php.
3.3. Módulo de Processos Seletivos
Propósito: Criação e gerenciamento de diferentes processos de seleção, incluindo suas etapas, prazos e critérios.
Componentes Chave:
Controladores: ProcessosSeletivosController, EtapasController (ou similar).
Modelos: ProcessoSeletivo, Etapa (tabelas processos_seletivos, etapas).
Rotas (app/routes.php): Rotas de recurso ou personalizadas para gestão de processos e etapas.
Views (app/views/): processos.index.blade.php, processos.show.blade.php, etapas.create.blade.php.
4. Guias de Desenvolvimento para Modificações
Esta seção fornece orientações passo a passo para implementar os tipos de modificações desejados, com foco nas particularidades do Laravel 4.2.
4.1. Modificações em Telas e Dados Existentes (Seu Ponto 1)
Objetivo: Alterar campos em formulários, adicionar/remover dados na interface, pequenas mudanças visuais.
Identificar a View:
Encontre a rota associada à tela em app/routes.php.
A rota indicará qual controlador e método são responsáveis.
No controlador, identifique qual View::make('caminho.da.view') está sendo renderizada. O arquivo .blade.php estará em app/views/caminho/da/view.blade.php.
Exemplo: Rota /alunos/create -> AlunosController@create -> View::make('alunos.create') -> app/views/alunos/create.blade.php.
Modificar HTML/CSS:
Abra o arquivo .blade.php identificado.
Modifique o HTML diretamente.
Para CSS, verifique se há arquivos em public/css/ ou se os estilos estão inline. Adicione novas classes e defina-as no arquivo CSS principal ou no próprio HTML.
Alterar Texto/Conteúdo:
Procure por {{ $variavel }} ou texto estático na view e edite-o.
Se o texto vier de uma variável, verifique o controlador para ver como essa variável é passada para a view (ex: ->with('nome', $valor)).
Adicionar/Remover Campos em Formulários:
a. Alterar a View (.blade.php):
Adicione o novo campo HTML (<input>, <select>, <textarea>).
Use Form::label() e Form::text() (se laravelcollective/html for usado) ou HTML puro.
Exemplo de adição de campo 'telefone' em alunos.create.blade.php:
code
Blade
<div class="form-group">
    {{ Form::label('telefone', 'Telefone') }}
    {{ Form::text('telefone', Input::old('telefone'), array('class' => 'form-control')) }}
    {{-- Ou com HTML puro: --}}
    {{-- <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" value="{{ Input::old('telefone') }}" class="form-control"> --}}
</div>
b. Atualizar o Modelo (app/models/SeuModelo.php):
Adicione o nome da nova coluna ao array $fillable para permitir atribuição em massa.
Exemplo no modelo Aluno.php:
code
PHP
protected $fillable = array('nome', 'matricula', 'email', 'data_nascimento', 'telefone'); // Adicionar 'telefone'
c. Atualizar as Migrações (para adicionar a coluna no banco):
Isso é crucial para novos campos. Siga o guia em 4.3. Adicionando Novos Dados na Base.
d. Atualizar a Lógica do Controlador (app/controllers/SeuController.php):
Se houver validação, adicione regras para o novo campo.
A lógica de Input::all() ou Input::get() já deve capturar o novo campo, mas verifique se há lógica específica para salvá-lo.
Exemplo em AlunosController@store:
code
PHP
$rules = array(
    'nome'      => 'required',
    'matricula' => 'required|unique:alunos',
    'telefone'  => 'max:20' // Nova regra de validação
);
// ... (restante do código)
$aluno->telefone = Input::get('telefone'); // Se não usar $fillable e create/update
$aluno->save();
4.2. Criando Novas Telas de Relatório (Seu Ponto 2)
Objetivo: Criar novas telas para exibir resumos de informações, como a formação de cada aluno.
Passo 1: Definir a Rota (app/routes.php):
Adicione uma nova rota que aponte para um método em um controlador (pode ser um controlador existente ou um novo RelatoriosController).
code
PHP
// app/routes.php
Route::get('relatorios/formacao-alunos', 'RelatoriosController@formacaoAlunos');
Passo 2: Criar o Controlador (app/controllers/RelatoriosController.php):
Crie o arquivo e a classe do controlador, estendendo BaseController. Implemente o método que buscará os dados e os passará para a view.
code
PHP
<?php
// app/controllers/RelatoriosController.php

class RelatoriosController extends BaseController {

    public function formacaoAlunos()
    {
        // Exemplo: Buscar todos os alunos com suas formações carregadas (eager loading)
        $alunos = Aluno::with('formacoes')->get();

        // Passar os dados para a view
        return View::make('relatorios.formacao-alunos')->with('alunos', $alunos);
    }
}
Passo 3: Criar a View (app/views/relatorios/formacao-alunos.blade.php):
Crie o arquivo da view no diretório app/views/relatorios/. Use Blade para exibir os dados.
code
Blade
{{-- app/views/relatorios/formacao-alunos.blade.php --}}
@extends('layouts.master')

@section('title', 'Relatório de Formação de Alunos')

@section('content')
    <h2>Relatório de Formação de Alunos</h2>

    @if ($alunos->isEmpty())
        <p>Nenhum aluno encontrado com formação.</p>
    @else
        @foreach ($alunos as $aluno)
            <h3>{{ $aluno->nome }} (Matrícula: {{ $aluno->matricula }})</h3>
            @if ($aluno->formacoes->isEmpty())
                <p>Nenhuma formação registrada para este aluno.</p>
            @else
                <ul>
                    @foreach ($aluno->formacoes as $formacao)
                        <li>
                            **{{ $formacao->curso }}** em {{ $formacao->instituicao }} ({{ $formacao->ano_conclusao }})
                            @if ($formacao->nivel) - Nível: {{ $formacao->nivel }} @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            <hr>
        @endforeach
    @endif
@stop
Exemplos de Queries Eloquent para Relatórios:
Com with() para Eager Loading: Aluno::with('formacoes')->get() (minimiza consultas N+1).
Agregações: Aluno::count(), Aluno::where('data_nascimento', '<', '1990-01-01')->count().
Junções (se necessário SQL puro ou Fluent Query Builder):
code
PHP
$resultados = DB::table('alunos')
                ->join('formacoes', 'alunos.id', '=', 'formacoes.aluno_id')
                ->select('alunos.nome', 'formacoe