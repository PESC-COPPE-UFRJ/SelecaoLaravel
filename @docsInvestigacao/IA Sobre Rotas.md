# Visão Geral do Arquivo de Rotas

* **O que é este arquivo:** Arquivo de definição de rotas de uma aplicação **Laravel legada**. Ele mapeia **métodos HTTP + URIs** para **ações** (closures ou métodos de controllers), além de **grupos** com filtros (“before”) que condicionam o acesso.
* **Quando é chamado no ciclo de requisição:** Durante o **bootstrap** do framework: `public/index.php` → `bootstrap/app.php` → `Http/Kernel` → `RouteServiceProvider` (no Laravel 4, via *Application* + *Router* registrado no *Service Provider*) → **carregamento das rotas**.
* **O que ele faz na aplicação:** Declara rotas públicas e protegidas por filtros **`auth`**, **`admin`** e **`periodo_ativo`**, organiza módulos por prefixos (ex.: `adm/`, `candidato/`, `professor/`), utiliza **controllers “implícitos”** (`Route::controller`) e **recursos REST** (`Route::resource`).

---

# Conceitos Essenciais de Laravel (no contexto deste arquivo)

> Comparações úteis para quem vem de **Python/Flask/Django**.

* **Roteamento (Routing):** O roteador casa **método HTTP + caminho** e delega para um **handler** (closure ou `Controller@method`). Analogia: **Flask** `@app.route("/...")` / **Django** `urls.py`.
* **Filtros “before” (Laravel 4):** Antecessores dos *middlewares* modernos; executam **antes** da ação (ex.: `auth`, `admin`, `periodo_ativo`). Analogia: **Flask** `before_request` ou *decorators* que checam sessão/permissão.
* **Controllers e Actions:** Classes com métodos que tratam requisições. Sintaxe legado `Controller@method`. Analogia: *class-based views* do **Django**.
* **Grupos de Rotas:** Encapsulam atributos herdados (aqui, `array('before' => '...')`). Tudo dentro do grupo “herda” o filtro. Analogia: **Flask Blueprints** com *before\_request*.
* **Named Routes:** Não há nomes explícitos neste arquivo; quando usados, servem para *reverse routing* (gerar URLs a partir do nome).
* **Route Model Binding:** Não há *bindings* explícitos; parâmetros aparecem apenas como *placeholders* `{id}` na URI (binding real depende de controllers).
* **Resource / apiResource:** `Route::resource('adm/periodo','PeriodoController')` cria rotas REST (index/show/store/update/destroy). Analogia: **Django REST Framework** *ViewSets/routers*.
* **Fallback/Redirect:** Não há `Route::fallback` nem *redirects* explícitos neste arquivo.
* **Cache de rotas:** Laravel suporta `php artisan route:cache` em versões mais novas; **não inferível** no arquivo.

---

# Mapa Top-Down das Rotas

## Domínios/Prefixes principais (panorama)

* **/** (raiz): 1 rota (closure).
* **/adm**: maior bloco funcional (gestão de período, perfil, usuário, parâmetros, provas, mensagens). Fortemente protegido por `auth`; algumas entradas aparecem sob `admin`.
* **/candidato**: inscrição e “meus dados” (controllers específicos).
* **/professor**: inscrição e operações ligadas ao corpo docente.
* **/mensagem** (e `mensagem/log`): registro e histórico de mensagens.
* **Outros**: `faqs`, `nota`, `documentos`, `imagem`, `id`, `password`, `panel`, utilitários como `pesquisar`/`classificar`.

> **Papel dos filtros/grupos**
>
> * **`auth`**: exige usuário autenticado.
> * **`admin`**: exige perfil administrativo (subconjunto sob `auth`).
> * **`periodo_ativo`**: exige que o período do processo esteja ativo (subconjunto específico).

## Grupos e Filtros (herança efetiva)

* **Grupo 1** — `before=auth` (linhas \~16–484)
  **Efeito:** Todas as rotas aninhadas exigem **autenticação**.
* **Grupo 2** — `before=admin` (linhas \~434–439), *dentro do grupo `auth`*
  **Efeito:** Subconjunto “admin” (usuário logado **e** administrador).
* **Grupo 3** — `before=periodo_ativo` (linhas \~477–482), *dentro do grupo `auth`*
  **Efeito:** Subconjunto que requer período vigente **além de** autenticação.

> A **herança** funciona assim: tudo que está **dentro** do bloco `Route::group(array('before' => 'X'), function () { ... });` recebe o filtro **X**. Se um grupo está **dentro** de outro, os filtros **se acumulam** (ex.: `auth` + `admin`).

---

# Tabela Canônica de Rotas

> **Observação:** “Middlewares/Filters efetivos” mostra os **filtros herdados** via grupos `before`. “Parâmetros na URI” indica placeholders `{...}`; *bindings* propriamente ditos dependem de controllers (**não inferível** aqui).

| #  | Método(s)  | URI efetiva                        | Nome | Destino                                                                  | Middlewares/Filters efetivos | Parâmetros        | Restrições | Grupo(s)                           | Observações                       |
| -- | ---------- | ---------------------------------- | ---- | ------------------------------------------------------------------------ | ---------------------------- | ----------------- | ---------- | ---------------------------------- | --------------------------------- |
| 1  | GET        | panel                              | —    | Closure                                                                  | auth                         | —                 | —          | before=auth                        | —                                 |
| 2  | GET        | pesquisar                          | —    | CandidatoDadosPessoaisController\@pesquisar                              | auth                         | —                 | —          | before=auth                        | —                                 |
| 3  | GET        | classificar                        | —    | CandidatoDadosPessoaisController\@classificar                            | auth                         | —                 | —          | before=auth                        | —                                 |
| 4  | CONTROLLER | candidato/meusdados                | —    | MeusDadosController                                                      | auth                         | —                 | —          | before=auth                        | —                                 |
| 5  | CONTROLLER | adm/inscricao                      | —    | AdminInscricaoController                                                 | auth                         | —                 | —          | before=auth                        | —                                 |
| 6  | CONTROLLER | faqs                               | —    | FaqController                                                            | auth                         | —                 | —          | before=auth                        | —                                 |
| 7  | CONTROLLER | professor/inscricao                | —    | ProfessorInscricaoController                                             | auth                         | —                 | —          | before=auth                        | —                                 |
| 8  | CONTROLLER | mensagem/log                       | —    | MensagemHistoricoController                                              | auth, admin                  | —                 | —          | before=auth, before=admin          | —                                 |
| 9  | CONTROLLER | mensagem                           | —    | MensagemController                                                       | auth, admin                  | —                 | —          | before=auth, before=admin          | —                                 |
| 10 | CONTROLLER | mensagem-requerimento              | —    | MensagemRequerimentoController                                           | auth                         | —                 | —          | before=auth                        | —                                 |
| 11 | CONTROLLER | nota                               | —    | NotaController                                                           | auth                         | —                 | —          | before=auth                        | —                                 |
| 12 | GET        | /adm/periodo/clonar/{id}           | —    | PeriodoController\@clonar                                                | auth                         | Parâmetros na URI | —          | before=auth                        | —                                 |
| 13 | RESOURCE   | adm/periodo                        | —    | PeriodoController                                                        | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 14 | RESOURCE   | adm/perfil                         | —    | PerfilController                                                         | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 15 | RESOURCE   | adm/usuario                        | —    | UsuarioController                                                        | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 16 | CONTROLLER | adm/parametro                      | —    | ParametrosController                                                     | auth                         | —                 | —          | before=auth                        | —                                 |
| 17 | RESOURCE   | adm/mensagem\_padrao               | —    | MensagemPadraoController                                                 | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 18 | RESOURCE   | adm/scripts                        | —    | ScriptsController                                                        | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 19 | GET        | adm/inscricao/dados-inscricao/{id} | —    | AdminInscricaoController\@getDadosInscricao                              | auth                         | Parâmetros na URI | —          | before=auth                        | —                                 |
| 20 | POST       | adm/inscricao/dados-inscricao/     | —    | AdminInscricaoController\@postDadosInscricao                             | auth                         | —                 | —          | before=auth                        | —                                 |
| 21 | GET        | adm/inscricao/dados-pessoais/{id}  | —    | AdminInscricaoController\@getDadosPessoais                               | auth                         | Parâmetros na URI | —          | before=auth                        | —                                 |
| 22 | POST       | adm/inscricao/dados-pessoais/      | —    | AdminInscricaoController\@postDadosPessoais                              | auth                         | —                 | —          | before=auth                        | —                                 |
| 23 | GET        | adm/meusdados/dados-pessoais/{id}  | —    | MeusDadosController\@getDadosPessoais                                    | auth                         | Parâmetros na URI | —          | before=auth                        | —                                 |
| 24 | POST       | adm/meusdados/dados-pessoais/      | —    | MeusDadosController\@postDadosPessoais                                   | auth                         | —                 | —          | before=auth                        | —                                 |
| 25 | GET        | adm/meusdados/docencia/{id}        | —    | MeusDadosController\@getDocencia                                         | auth                         | Parâmetros na URI | —          | before=auth                        | —                                 |
| 26 | GET        | adm/meusdados/docencia/            | —    | MeusDadosController\@postDocencia                                        | auth                         | —                 | —          | before=auth                        | —                                 |
| 27 | POST       | adm/prova/deletar                  | —    | ProvasController\@destroyMany                                            | auth                         | —                 | —          | before=auth                        | —                                 |
| 28 | GET        | adm/prova/destroyajax              | —    | ProvasController\@destroyajax                                            | auth                         | —                 | —          | before=auth                        | —                                 |
| 29 | RESOURCE   | adm/provatipos                     | —    | ProvaTiposController                                                     | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 30 | RESOURCE   | adm/prova                          | —    | ProvasController                                                         | auth                         | —                 | —          | before=auth                        | REST (7 ações padrão)             |
| 31 | CONTROLLER | documentos                         | —    | DocumentoController                                                      | auth                         | —                 | —          | before=auth                        | —                                 |
| 32 | CONTROLLER | professor                          | —    | ProfessorController                                                      | auth                         | —                 | —          | before=auth                        | —                                 |
| 33 | GROUP      | candidato/inscricao                | —    | CandidatoInscricaoController (via Route::controller sob `periodo_ativo`) | auth, periodo\_ativo         | —                 | —          | before=auth, before=periodo\_ativo | Controla fluxo de inscrição       |
| 34 | CONTROLLER | imagem                             | —    | ImagemController                                                         | auth                         | —                 | —          | before=auth                        | —                                 |
| 35 | CONTROLLER | id                                 | —    | IdController                                                             | auth                         | —                 | —          | before=auth                        | —                                 |
| 36 | CONTROLLER | password                           | —    | RemindersController                                                      | auth                         | —                 | —          | before=auth                        | Rotas de “lembrar senha” (legado) |
| 37 | GET        | /                                  | —    | Closure                                                                  | —                            | —                 | —          | raiz                               | Página inicial (closure)          |

> **Notas**
>
> * Entradas `RESOURCE` correspondem ao *bundle* REST (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
> * Entradas `CONTROLLER` com `Route::controller` ativam **roteamento implícito**: métodos `getX`, `postY` no controller viram URLs automaticamente sob o prefixo. As URIs exatas **não são inferíveis** apenas deste arquivo.
> * O item **#33** representa o efeito do **grupo `periodo_ativo`** sobre o controller `candidato/inscricao` (linha \~479): as ações desse controller são acessíveis **somente quando** há período ativo **e** o usuário está autenticado.

---

# Detalhamento por Conjunto Funcional

## Público

* **GET /** → *Closure* (página inicial). **Middlewares:** —
  **O que faz:** Retorna a página inicial. **Parâmetros/Restrições:** — (**Não inferível** conteúdo do closure).

## Autenticado (grupo `auth`)

* **Painel e utilitários**

  * **GET /panel** → *Closure*. **Middlewares:** `auth`.
  * **GET /pesquisar** → `CandidatoDadosPessoaisController@pesquisar`.
  * **GET /classificar** → `CandidatoDadosPessoaisController@classificar`.

* **Candidato**

  * **Route::controller 'candidato/meusdados'** → `MeusDadosController`. **Middlewares:** `auth`.
    Ações implícitas (ex.: `getIndex`, `postAtualizar` etc.). **URIs exatas:** **não inferíveis** aqui.

* **Professor**

  * **Route::controller 'professor/inscricao'** → `ProfessorInscricaoController`.
  * **Route::controller 'professor'** → `ProfessorController`.

* **Administração (subgrupo `admin` dentro de `auth`)**

  * **mensagem/log** → `MensagemHistoricoController`.
  * **mensagem** → `MensagemController`.
    *Ambas com filtros efetivos:* `auth` + `admin`.

* **Administração (demais rotas sob `auth`)**

  * **/adm/periodo** (`resource`) → `PeriodoController`.
  * **/adm/perfil** (`resource`) → `PerfilController`.
  * **/adm/usuario** (`resource`) → `UsuarioController`.
  * **/adm/parametro** (`controller`) → `ParametrosController`.
  * **/adm/mensagem\_padrao** (`resource`) → `MensagemPadraoController`.
  * **/adm/scripts** (`resource`) → `ScriptsController`.
  * **/adm/periodo/clonar/{id}** (GET) → `PeriodoController@clonar`.
  * **/adm/inscricao/**… (GET/POST) → `AdminInscricaoController@...` (dados de inscrição/pessoais).
  * **/adm/meusdados/**… (GET/POST) → `MeusDadosController@...` (dados pessoais/docência).
  * **/adm/provatipos** (`resource`) → `ProvaTiposController`.
  * **/adm/prova** (`resource`) → `ProvasController`.
  * **/adm/prova/deletar** (POST) → `ProvasController@destroyMany`.
  * **/adm/prova/destroyajax** (GET) → `ProvasController@destroyajax`.

* **Período Ativo (subgrupo `periodo_ativo` dentro de `auth`)**

  * **Route::controller 'candidato/inscricao'** → `CandidatoInscricaoController`.
    **Acesso somente quando o período está ativo.** URIs implícitas — **não inferíveis** aqui.

* **Outros Módulos (sob `auth`)**

  * **faqs** → `FaqController`.
  * **nota** → `NotaController`.
  * **documentos** → `DocumentoController`.
  * **imagem** → `ImagemController`.
  * **id** → `IdController`.
  * **password** → `RemindersController` (rotas legadas de senha).

---

# Elementos Específicos Encontrados

* **`Route::resource` (REST):** Padrão 7 rotas por recurso. **Nomes de rotas** e **nomes de views** seguem convenções do Laravel 4; **não estão explicitados** aqui.
* **`Route::controller` (implícito, legado):** Converte métodos `getX/postY` em rotas. Útil para varrer rapidamente controllers legados; as URIs resultantes **dependem dos nomes de métodos**.
* **Parâmetros na URI:** Exemplos `{id}` em `/adm/periodo/clonar/{id}`. **Bindings** e **validações de tipo/regex** não aparecem no arquivo.
* **Subgrupos de acesso:** `admin` e `periodo_ativo` **empilham** sobre `auth`.

---

# Hipótese de Versão do Laravel (Estimativa)

* **Sinais observados:**

  * Uso de **`Route::group(array('before' => '...'), function(){...})`** (filtros “before” são típicos do **Laravel 4.x**).
  * Uso de **`Route::controller`** (roteamento implícito, removido/reduzido em versões posteriores).
  * Controller **`RemindersController`** para senha (padrões L4).
* **Faixa provável:** **Laravel 4.1–4.2**.
  *(Estimativa; confirmação exigiria `composer.json` ou `app/start/global.php`/`filters.php`.)*

---

# Limitações da Análise

* **Não inferível a partir deste arquivo:**

  * Conteúdo/lógica de **controllers** e **closures**.
  * Implementação de **filtros** `auth`, `admin`, `periodo_ativo` (ficam em `app/filters.php` no L4 ou providers correlatos).
  * **Nomes de rotas** (não declarados explicitamente) e **URIs geradas** por `Route::controller` (dependem dos métodos).
  * **Validações**/regex via `->where(...)` (não há no arquivo).
  * Política de **cache de rotas** e configurações de **namespaces** (não declaradas aqui).

---

# Critérios de Qualidade (checagem aplicada)

* **Cobertura total:** Todas as ocorrências de `Route::...` ativas foram mapeadas e consolidadas na tabela.
* **Herança correta:** Rotas dentro de `auth`, `admin` e `periodo_ativo` foram marcadas com filtros **efetivos** acumulados.
* **Neutralidade:** Não há recomendações de refatoração; descrição **fiel** ao arquivo.

---

## Anexo: Como ler “Route::controller” (para devs Python)

> **Exemplo ilustrativo (legado L4):**

```php
Route::controller('professor', 'ProfessorController');
```

* Um método `getIndex()` em `ProfessorController` responderá a **GET `/professor`**.
* Um método `postSalvar()` responderá a **POST `/professor/salvar`**.
* A regra geral é: prefixo de rota + sufixo do **nome do método** sem o prefixo `get`/`post`/`put` etc., convertido para *slug*.

*(Este comportamento é específico do roteamento implícito do Laravel 4 e não é recomendado em versões recentes, mas **faz parte do legado** que estamos documentando.)*

