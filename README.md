<h1 align="center">Oficina 2.0</h1>

## Como foi feito o projeto

O projeto foi realizado utilizando PHP e Laravel além do Materialize CSS

Na homepage, temos os orçamentos cadastrados vindos do banco dados, ordenados por data decrescente e com um pagination de 5 rows.

Ainda na homepage temos os filtros, que permitem buscar em um intervalo de datas, nome do cliente e nome do vendedor, todos citados funcionam juntos ou individualmente.

Logo abaixo dos filtros, temos 3 botões:
- Criar orçamento: Leva a uma página de cadastro de dados
- Pesquisar: Aplica os filtros selecionados
- Limpar filtros: Limpa os filtros de busca

Ao lado dos dados, temos também, três botões, sendo eles:

- Visualizar: Leva para uma página com todos os dados do orçamento
- Editar: Permite a edição do orçamento
- Excluir: Deleta o dado selecionado

Logo abaixo, temos a paginação.

**Obs:** O código foi feito com apenas 1 semana de estudos, começando o PHP do 0. Abaixo de "Como rodar o projeto", terá o [repositório dos estudos](#Repositórios-de-Estudos)


## Como rodar o projeto

1. Clone o repositório

2. Crie seu banco de dados, e o informe no .env

3. Execute o comando `composer install`

4. Faça o migrate com `php artisan migrate`

5. Popule o banco de dados com `php artisan db:seed`

6. Rode o localhost com `php artisan serve`

E pronto, o sistema está pronto para ser utilizado

### Repositórios de Estudos

[Estudo Básico de PHP](https://github.com/ricksz1n/estudo-php-basico)

[Orientação a Objetos com PHP](https://github.com/ricksz1n/estudo-php-oop)

[Estudo Básico de PHP](https://github.com/ricksz1n/estudo-php-laravel)
