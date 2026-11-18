# Simulado da prova final – TPA – 3ª etapa

**Versão:** SIM-A · simulado no formato da prova final (treino, não vale nota)

## Instruções do simulado

- **Duração sugerida:** 100 minutos, sem pausas. Marque o tempo.
- **Individual.** Faça como se fosse a prova: sem copiar de exercícios anteriores.
- **Consulta sugerida:** apenas a documentação oficial do Laravel.
- Cada questão é corrigida em separado, pelo roteiro "Como será corrigido". Questão que não passa no roteiro não pontua.
- Não altere os contratos (nomes de rotas, models, tabelas, colunas e campos de formulário). As telas dependem deles.
- Ao final, o projeto precisa rodar com `php artisan migrate:fresh --seed` e `php artisan serve`.

## Contexto

O **Portal de Eventos** é uma bilheteria: **organizadores** cadastram Eventos e **participantes** compram ingressos.

O site já está pronto, com layout, telas e rotas. Sua tarefa é implementar as features que faltam, descritas nas questões abaixo.

Crie o que faltar com o Artisan (`make:model`, `make:migration`, `make:middleware`, `make:request`). O seeder de usuários e o de Eventos já existem. Comece pela Q1.

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Até você concluir a Q1, o seeder avisa que os Eventos não foram semeados. Isso é esperado.

Usuários de teste (senha `senha123`):

| E-mail | Tipo |
|---|---|
| alice@eventos.test | organizador |
| bento@eventos.test | organizador |
| clara@eventos.test | participante |
| davi@eventos.test | participante |

## Contratos (não altere)

**Entidade:** model `Evento`, tabela `eventos`.

| Coluna | Tipo | Validação |
|---|---|---|
| titulo | texto | obrigatório, texto de 3 a 100 caracteres |
| categoria | texto | obrigatório, um destes: `Show`, `Teatro`, `Palestra`, `Esporte` |
| duracao_minutos | inteiro | **obrigatório, inteiro entre 30 e 480** |
| preco | decimal (8,2) | obrigatório, número maior ou igual a zero (evento gratuito é permitido) |
| vagas | inteiro | obrigatório, inteiro ≥ 1 |
| organizador_id | chave estrangeira → `users` | definido pelo sistema (Q6) |

**Rotas** (já existem em `routes/web.php`):

| Método e URL | Nome | Quem acessa |
|---|---|---|
| `GET /eventos` | `eventos.index` | qualquer pessoa |
| `GET /login` · `POST /login` · `POST /logout` | `login` · `login.attempt` · `logout` | qualquer pessoa |
| `GET /eventos/create` · `POST /eventos` | `eventos.create` · `eventos.store` | só organizador logado |
| `GET /pedidos/create` · `POST /pedidos` · `GET /pedidos` | `pedidos.create` · `pedidos.store` · `pedidos.index` | só usuário logado |

**Pedido:** model `Pedido`, tabela `pedidos` (`id`, `participante_id` → `users`, timestamps). A relação N:M com Eventos se chama `eventos()` e usa a tabela pivô `evento_pedido` (`pedido_id`, `evento_id`, `quantidade`, `preco_unitario`, timestamps).

**Formulário de pedido:** envia `ingressos[id_do_evento] = quantidade`. Eventos com quantidade 0 ficam de fora.

**Mensagens de sucesso:** o layout mostra o que estiver na sessão com a chave `sucesso`.

**Middleware de perfil:** apelido `organizador`.

## Questões

| # | Questão | Pontos |
|---|---|---|
| Q1 | Agenda pública de Eventos | 2,0 |
| Q2 | Login e logout | 1,5 |
| Q3 | Middleware `auth` | 1,0 |
| Q4 | Middleware `organizador` | 2,0 |
| Q5 | Cadastro validado | 2,0 |
| Q6 | Dono do evento | 1,0 |
| Q7 | Pedido de ingressos | 2,5 |
| Q8 | Meus pedidos | 2,0 |
| Bônus | Vagas | 2,0 |

Total: 14,0 pontos. O bônus pode compensar questões não feitas, mas a nota máxima continua sendo 14,0.

### Q1 – Agenda pública de Eventos (2,0)

Crie a migration e a model `Evento` compatíveis com o `EventoSeeder` (tabela de contratos), com o relacionamento `organizador()` (belongsTo `User`, chave `organizador_id`). Implemente `EventoController@index`: busque os Eventos **em ordem alfabética de título**, carregando o organizador com `with()`, e devolva a view `eventos.index` com a variável `$eventos`.

**Como será corrigido:**

1. `php artisan migrate:fresh --seed` roda sem o aviso "não semeados".
2. Sem login, http://localhost:8000/eventos mostra os 5 Eventos do seeder.
3. A primeira linha é "Festival de Jazz" e a última é "Show de Rock Nacional".
4. A coluna **Organizador** traz "Alice Organizadora" ou "Bento Organizador" em cada linha.

### Q2 – Login e logout (1,5)

Implemente `LoginController@attempt` com `Auth::attempt` (campos `email` e `password`). Com credenciais inválidas, volte ao login com uma mensagem de erro. Implemente `LoginController@logout` para encerrar a sessão.

**Como será corrigido:**

1. Em http://localhost:8000/login, `clara@eventos.test` com senha errada volta ao login com uma mensagem de erro.
2. `clara@eventos.test` com `senha123` redireciona, e o topo mostra "Clara Participante" com o tipo `participante`.
3. Ao clicar em **Sair**, o topo volta a mostrar o botão **Entrar**.

### Q3 – Middleware `auth` (1,0)

Em `routes/web.php`, aplique o middleware `auth` às duas rotas de cadastro de Eventos e às três rotas de pedidos. A agenda continua pública.

**Como será corrigido:**

1. Sem login, **Cadastrar Evento**, **Comprar ingressos** e **Meus pedidos** levam à tela de login.
2. Sem login, **Eventos** abre normalmente.

### Q4 – Middleware `organizador` (2,0)

Crie um middleware que interrompa a requisição com `abort(403)` quando o usuário logado não for do tipo `organizador`. Registre-o com o apelido `organizador` em `bootstrap/app.php` e aplique-o às rotas de cadastro de Eventos.

**Como será corrigido:**

1. Logado como `clara@eventos.test` (participante), **Cadastrar Evento** mostra a página **403 – Acesso negado**.
2. Logado como `alice@eventos.test` (organizador), **Cadastrar Evento** mostra o formulário.

### Q5 – Cadastro validado (2,0)

Crie o FormRequest `StoreEventoRequest` com as regras da tabela de contratos e use-o em `EventoController@store`. Salve o registro com os dados validados e redirecione para a agenda com a mensagem de sucesso "Evento cadastrado!".

**Como será corrigido** (logado como `alice@eventos.test`):

1. O formulário vazio mostra uma mensagem de erro em cada campo.
2. Com os dados válidos do passo 5, trocando um campo por vez, o erro aparece só nesse campo:
   - **Título**: `Oi`
   - **Duração (minutos)**: `20`
   - **Duração (minutos)**: `500`
   - **Vagas**: `0`
3. **Ingresso (R$)** com `-5` mostra erro nesse campo.
4. **Ingresso (R$)** com `0` é aceito (evento gratuito).
5. Os dados abaixo são aceitos. Você volta à agenda, com a mensagem "Evento cadastrado!" e o novo item na tabela:
   - **Título**: `Stand-up de Sexta`
   - **Categoria**: `Teatro`
   - **Duração (minutos)**: `75`
   - **Ingresso (R$)**: `45.50`
   - **Vagas**: `12`

### Q6 – Dono do evento (1,0)

Em `EventoController@store`, preencha `organizador_id` com o id do usuário logado (`Auth::id()`). Esse valor nunca vem do formulário.

**Como será corrigido:**

1. Um evento cadastrado por `alice@eventos.test` aparece com "Alice Organizadora" na coluna **Organizador**.
2. Um evento cadastrado por `bento@eventos.test` aparece com "Bento Organizador".

### Q7 – Pedido de ingressos (2,5)

Crie as migrations de `pedidos` e da pivô `evento_pedido` (colunas nos contratos) e a model `Pedido`, com a relação `eventos()` (belongsToMany com `withPivot('quantidade', 'preco_unitario')`). Em `PedidoController@store`:

1. ignore os eventos com quantidade 0;
2. se não sobrar nenhum evento, volte ao formulário com uma mensagem de erro, sem criar pedido;
3. crie o pedido com `participante_id` igual ao id do usuário logado;
4. para cada evento, chame `attach` com a `quantidade` e o `preco_unitario` (o preço atual do evento);
5. redirecione para `pedidos.index` com a mensagem de sucesso "Pedido realizado!".

**Como será corrigido** (logado como `clara@eventos.test`):

1. Em **Comprar ingressos**, com todas as quantidades em 0, **Finalizar pedido** volta com uma mensagem de erro.
2. Com quantidade **3** em um evento e **1** em outro, **Finalizar pedido** redireciona para **Meus pedidos** com a mensagem "Pedido realizado!".
3. Depois da Q8, o pedido aparece com exatamente os dois eventos, nas quantidades 3 e 1.

### Q8 – Meus pedidos (2,0)

Em `PedidoController@index`, busque só os pedidos do usuário logado, **do mais recente para o mais antigo**, carregando os eventos com `with('eventos')`, e devolva a view `pedidos.index` com a variável `$pedidos`. A view já calcula subtotais e total a partir da pivô.

**Como será corrigido:**

1. Logado como `clara@eventos.test`, depois de dois pedidos, **Meus pedidos** mostra os dois, com eventos, quantidades, preço unitário, subtotais e total. O pedido de número maior aparece primeiro.
2. Logado como `davi@eventos.test`, os pedidos da Clara **não** aparecem.

### Bônus – Vagas (2,0)

Em `PedidoController@store`, recuse o pedido (volte com uma mensagem de erro) se alguma quantidade passar das vagas do evento. Ao concluir o pedido, diminua as vagas de cada evento com `decrement`.

**Como será corrigido** (logado como `clara@eventos.test`):

1. Pedir **9** ingressos de "Final do Campeonato de Vôlei" (8 vagas) volta com uma mensagem de erro, e nenhum pedido é criado.
2. Depois de pedir **2** ingressos desse evento, a coluna **Vagas disponíveis** dele mostra 6.

## Entrega

1. Confira se o projeto roda com `php artisan migrate:fresh --seed` e `php artisan serve`.
2. Compacte a pasta do projeto inteira em um `.zip`.
3. Anote quanto tempo você levou e quais questões ficaram sem fazer.
