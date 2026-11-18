# Guia de estudo do simulado

Os enunciados estão no `README.md`. Este guia só indica **onde** estão as dicas de cada questão. As dicas ficam em comentários que começam com `GUIA` ou com o número da questão, dentro dos arquivos que você vai editar.

Se quiser simular a prova de verdade, tente cada questão sem ler o comentário e só consulte quando travar.

| Questão | Onde está a dica | Arquivos que você vai criar |
|---|---|---|
| Q1 | `app/Http/Controllers/EventoController.php` (topo e método `index`) | model `Evento` e migration de `eventos` |
| Q2 | `app/Http/Controllers/LoginController.php` (`attempt` e `logout`) | nenhum |
| Q3 | `routes/web.php` (topo) | nenhum |
| Q4 | `bootstrap/app.php` e `routes/web.php` | middleware `EnsureUserIsOrganizador` |
| Q5 | `app/Http/Controllers/EventoController.php` (método `store`) | `StoreEventoRequest` |
| Q6 | `app/Http/Controllers/EventoController.php` (método `store`, passo 5) | nenhum |
| Q7 | `app/Http/Controllers/PedidoController.php` (topo e método `store`) | model `Pedido`, migrations de `pedidos` e `evento_pedido` |
| Q8 | `app/Http/Controllers/PedidoController.php` (método `index`) | nenhum |
| Bônus | `app/Http/Controllers/PedidoController.php` (método `store`, passos 4 e 6) | nenhum |

## Ordem sugerida

Q1 → Q2 → Q3 → Q4 → Q5 → Q6 → Q7 → Q8 → Bônus. Depois de cada questão, rode o roteiro "Como será corrigido" do `README.md` no navegador antes de passar para a próxima.

## Erros comuns

- **"Eventos não semeados" continua aparecendo:** falta alguma coluna na migration ou o nome está diferente do contrato. Rode `php artisan migrate:fresh --seed` de novo depois de corrigir.
- **`Class "App\Models\Evento" not found`:** a model ainda não foi criada (Q1) ou falta o `use` no topo do controller.
- **403 ao enviar o formulário de cadastro, mesmo como organizador:** o `authorize()` do FormRequest está devolvendo `false`.
- **Erro 419 ao enviar formulário:** a sessão expirou; recarregue a página e envie de novo.
- **`Attempt to read property "name" on null` na agenda:** o `belongsTo` da model `Evento` está sem o segundo argumento `'organizador_id'`.
- **`Target class [organizador] does not exist`:** o apelido não foi registrado em `bootstrap/app.php`.
- **`no such table: evento_pedido`:** a pivô tem outro nome ou a migration não rodou.
- **Mensagem de sucesso não aparece:** a chave usada no `with()` não é `sucesso`.
