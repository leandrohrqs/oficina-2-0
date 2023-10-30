<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oficina 2.0</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>

<div class="row">
    <div class="col s12">
        <h3 class="light">Orçamento</h3>
        <button onclick="window.location.href = '{{ route('site.index') }}'" type="button" class="waves-effect waves-light btn">Lista de Orçamentos</button>
        <table class="highlight">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $orcamento->id }}</td>
                </tr>
                <tr>
                    <th>Vendedor</th>
                    <td>{{ $orcamento->seller->nome }}</td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td>{{ $orcamento->user->nome }}</td>
                </tr>
                <tr>
                    <th>Telefone do Cliente</th>
                    <td>{{ $orcamento->user->telefone }}</td>
                </tr>
                <tr>
                    <th>Email do Cliente</th>
                    <td>{{ $orcamento->user->email }}</td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <td>{{ $orcamento->descricao }}</td>
                </tr>
                <tr>
                    <th>Valor</th>
                    <td>R$ {{ number_format($orcamento->valor, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Data do orçamento</th>
                    <td>{{ date('d/m/Y', strtotime($orcamento->data_do_orcamento)) }}</td>
                </tr>
                <tr>
                    <th>Criado em:</th>
                    <td>{{ $orcamento->created_at }}</td>
                </tr>
                <tr>
                    <th>Atualizado em:</th>
                    <td>{{ $orcamento->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>
</body>
</html>
