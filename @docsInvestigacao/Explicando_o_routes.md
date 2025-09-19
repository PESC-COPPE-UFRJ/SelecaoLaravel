# Visão Geral do Arquivo de Rotas

- **O que é este arquivo:** Arquivo de definição de rotas de uma aplicação **Laravel legada** (Laravel 4.x, estimado). Ele mapeia **métodos HTTP + URIs** para **ações** (closures ou métodos de controllers) e organiza blocos por filtros `before`.
- **Quando é chamado no ciclo de requisição:** Durante o **bootstrap**: `public/index.php` → `bootstrap/app.php` → `Http/Kernel` (em L4, `app/start`) → `RouteServiceProvider`/carregamento das rotas.
- **O que ele faz na aplicação:** Declara rotas públicas e rotas protegidas por **auth**, além de subgrupos **admin** e **periodo_ativo**. Aborda módulos como **adm/**, **candidato/**, **professor/**, **mensagem/**, **documentos/** etc.

## Conceitos Essenciais de Laravel (no contexto deste arquivo)

- **Roteamento (Routing):** Associação de *HTTP method + path* a um *handler*. Analogia: `urls.py` do **Django** ou `@app.route()` do **Flask**.
- **Filtros `before` (Laravel 4):** Antecessores de *middlewares*; rodam **antes** da action (ex.: `auth`, `admin`, `periodo_ativo`). Analogia: *decorators* de autorização no **Flask**/**Django**.
- **Controllers e Actions:** Classes onde cada método é uma *action* (`Controller@method`). 
- **`Route::controller` (roteamento implícito, legado):** Converte métodos `getX`/`postY` em rotas automaticamente sob um prefixo.
- **`Route::resource`:** Gera o conjunto REST canônico (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
- **Grupos de Rotas:** Herança de atributos via `Route::group(array('before' => '...'), function(){...});`.
- **Named Routes / Bindings / Fallback:** Não aparecem explicitamente neste arquivo. *Bindings* e *regex* `where` não são definidos aqui.

---

# Mapa Top-Down das Rotas

## Domínios/Prefixes principais
- **/** (raiz): página inicial (closure).
- **/adm**: gestão de período, perfil, usuário, parâmetros, provas, mensagens padrão e scripts (diversas rotas `resource` e `GET/POST` específicos).
- **/candidato**: `meusdados` (dados pessoais) e `inscricao` (acesso condicionado ao `periodo_ativo`).
- **/professor**: `inscricao` e ações gerais de professor.
- **/mensagem**: módulo de mensagens; o histórico (`mensagem/log`) está em subgrupo `admin`.
- **Outros**: `faqs`, `nota`, `documentos`, `imagem`, `id`, `password`.

### Grupos e Filtros
- **before=auth**: linhas 16–482 — todas as rotas internas exigem usuário autenticado.
- **before=admin**: linhas 434–437 — apenas `mensagem/log` (histórico) exige perfil administrativo (além de `auth`).
- **before=periodo_ativo**: linhas 477–480 — `candidato/inscricao` requer período ativo (além de `auth`).

---

# Tabela Canônica de Rotas

> Campo “Middlewares efetivos” combina herança dos grupos. Onde há `{id}`, indica somente parâmetro na URI; *binding* de modelo **não** é visível neste arquivo.

| # | Método(s) | URI efetiva | Nome | Destino | Middlewares efetivos | Parâmetros | Restrições | Grupo(s) | Observações |
|---|---|---|---|---|---|---|---|---|---|
| 1 | GET | panel | — | Closure | auth | — | — | before=auth | — |
| 2 | GET | pesquisar | — | CandidatoDadosPessoaisController@pesquisar | auth | — | — | before=auth | — |
| 3 | GET | classificar | — | CandidatoDadosPessoaisController@classificar | auth | — | — | before=auth | — |
| 4 | CONTROLLER | candidato/meusdados | — | MeusDadosController | auth | — | — | before=auth | Roteamento implícito (Laravel 4) |
| 5 | CONTROLLER | adm/inscricao | — | AdminInscricaoController | auth | — | — | before=auth | Roteamento implícito |
| 6 | CONTROLLER | faqs | — | FaqController | auth | — | — | before=auth | — |
| 7 | CONTROLLER | professor/inscricao | — | ProfessorInscricaoController | auth | — | — | before=auth | — |
| 8 | CONTROLLER | mensagem/log | — | MensagemHistoricoController | auth, admin | — | — | before=auth, before=admin | — |
| 9 | CONTROLLER | mensagem | — | MensagemController | auth | — | — | before=auth | — |
| 10 | CONTROLLER | mensagem-requerimento | — | MensagemRequerimentoController | auth | — | — | before=auth | — |
| 11 | CONTROLLER | nota | — | NotaController | auth | — | — | before=auth | — |
| 12 | GET | /adm/periodo/clonar/{id} | — | PeriodoController@clonar | auth | {id} | — | before=auth | — |
| 13 | RESOURCE | adm/periodo | — | PeriodoController | auth | — | — | before=auth | REST (7 ações padrão) |
| 14 | RESOURCE | adm/perfil | — | PerfilController | auth | — | — | before=auth | REST (7 ações padrão) |
| 15 | RESOURCE | adm/usuario | — | UsuarioController | auth | — | — | before=auth | REST (7 ações padrão) |
| 16 | CONTROLLER | adm/parametro | — | ParametrosController | auth | — | — | before=auth | — |
| 17 | RESOURCE | adm/mensagem_padrao | — | MensagemPadraoController | auth | — | — | before=auth | REST (7 ações padrão) |
| 18 | RESOURCE | adm/scripts | — | ScriptsController | auth | — | — | before=auth | REST (7 ações padrão) |
| 19 | GET | adm/inscricao/dados-inscricao/{id} | — | AdminInscricaoController@getDadosInscricao | auth | {id} | — | before=auth | — |
| 20 | POST | adm/inscricao/dados-inscricao/ | — | AdminInscricaoController@postDadosInscricao | auth | — | — | before=auth | — |
| 21 | GET | adm/meusdados/dados-pessoais/{id} | — | MeusDadosController@getDadosPessoais | auth | {id} | — | before=auth | — |
| 22 | POST | adm/meusdados/dados-pessoais/ | — | MeusDadosController@postDadosPessoais | auth | — | — | before=auth | — |
| 23 | GET | adm/meusdados/docencia/{id} | — | MeusDadosController@getDocencia | auth | {id} | — | before=auth | — |
| 24 | GET | adm/meusdados/docencia/ | — | MeusDadosController@postDocencia | auth | — | — | before=auth | — |
| 25 | POST | adm/prova/deletar | — | ProvasController@destroyMany | auth | — | — | before=auth | — |
| 26 | GET | adm/prova/destroyajax | — | ProvasController@destroyajax | auth | — | — | before=auth | — |
| 27 | RESOURCE | adm/provatipos | — | ProvaTiposController | auth | — | — | before=auth | REST (7 ações padrão) |
| 28 | RESOURCE | adm/prova | — | ProvasController | auth | — | — | before=auth | REST (7 ações padrão) |
| 29 | CONTROLLER | documentos | — | DocumentoController | auth | — | — | before=auth | — |
| 30 | CONTROLLER | professor | — | ProfessorController | auth | — | — | before=auth | — |
| 31 | CONTROLLER | candidato/inscricao | — | CandidatoInscricaoController | auth, periodo_ativo | — | — | before=auth, before=periodo_ativo | Acesso condicionado ao período ativo |
| 32 | CONTROLLER | imagem | — | ImagemController | — | — | — | — | — |
| 33 | CONTROLLER | id | — | IdController | — | — | — | — | — |
| 34 | CONTROLLER | password | — | RemindersController | — | — | — | — | Rotas legadas de senha |
| 35 | GET | / | — | Closure | — | — | — | raiz | Página inicial (closure) |

---

# Detalhamento Por Conjunto Funcional

## Público
- **GET /** → *Closure* (página inicial). **Middlewares:** —. **Parâmetros/Restrições:** —. **Conteúdo exato:** não inferível a partir deste arquivo.

## Autenticado (grupo `auth`)
- **Painel/Utilitários**
  - **GET /panel** → *Closure*. 
  - **GET /pesquisar** → `CandidatoDadosPessoaisController@pesquisar`.
  - **GET /classificar** → `CandidatoDadosPessoaisController@classificar`.

- **Candidato**
  - **`candidato/meusdados` (Route::controller)** → `MeusDadosController` (roteamento implícito).
  - **`candidato/inscricao`** (dentro de `periodo_ativo`) → `CandidatoInscricaoController`.

- **Professor**
  - **`professor/inscricao` (Route::controller)** → `ProfessorInscricaoController`.
  - **`professor` (Route::controller)** → `ProfessorController`.

- **Administração**
  - **`mensagem/log`** → `MensagemHistoricoController` (**auth + admin**).
  - **`mensagem`** → `MensagemController` (**auth**).
  - **`adm/periodo`** (resource) → `PeriodoController`; **GET /adm/periodo/clonar/{id}**.
  - **`adm/perfil`** (resource) → `PerfilController`.
  - **`adm/usuario`** (resource) → `UsuarioController`.
  - **`adm/parametro`** (controller) → `ParametrosController`.
  - **`adm/mensagem_padrao`** (resource) → `MensagemPadraoController`.
  - **`adm/scripts`** (resource) → `ScriptsController`.
  - **`adm/inscricao/dados-*`** (GET/POST) → `AdminInscricaoController@...`.
  - **`adm/meusdados/dados-*` e `adm/meusdados/docencia*`** (GET/POST) → `MeusDadosController@...`.
  - **`adm/provatipos` e `adm/prova`** (resource) → `ProvaTiposController` / `ProvasController`.
  - **`adm/prova/deletar` (POST)** e **`adm/prova/destroyajax` (GET)** → `ProvasController@...`.

- **Outros módulos**
  - **`faqs`**, **`nota`**, **`documentos`** → controllers dedicados.

## Fora de grupos (público/sem auth)
- **`imagem`**, **`id`**, **`password`** (controllers legados) e **GET /** (closure inicial).

---

# Elementos Específicos Encontrados

- **`Route::resource`**: cria 7 rotas REST convencionais por recurso.
- **`Route::controller`**: roteamento implícito (Laravel 4); URIs derivam dos nomes dos métodos (ex.: `getIndex` → `GET /prefix`, `postSalvar` → `POST /prefix/salvar`).
- **Parâmetros na URI**: `{id}` em `/adm/periodo/clonar/{id}`. Sem `where(...)`/regex explícito.
- **Empilhamento de filtros**: `mensagem/log` (auth + admin) e `candidato/inscricao` (auth + periodo_ativo).

---

# Hipótese de Versão do Laravel (Estimativa)

- **Indicadores**: uso de `Route::group(array('before' => '...'))` e `Route::controller`; presença de `RemindersController`.
- **Faixa provável**: **Laravel 4.1–4.2**. *(Confirmação dependeria de `composer.json`/`app/filters.php`.)*

---

# Limitações da Análise

- Lógica interna de **controllers** e **closures** não é acessível aqui.
- Implementação de filtros `auth`, `admin`, `periodo_ativo` reside em arquivos de filtros/providers (**não inferível**).
- **Named routes**, *bindings* e **regex** não estão declarados.
- Políticas de **cache** de rotas e namespaces não são visíveis neste arquivo.

---

## Apêndice — Nota para devs Python sobre `Route::controller`
```php
Route::controller('professor', 'ProfessorController');
// getIndex()  → GET /professor
// postSalvar() → POST /professor/salvar
```
Esse mecanismo é específico do legado Laravel 4 e explica por que as URIs detalhadas de controllers “implícitos” não aparecem diretamente no arquivo.
