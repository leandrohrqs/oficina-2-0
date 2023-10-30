@extends('layout')
@section('title', "Orçamentos")
@section('content')
@include('includes.errorMessages')
@include('includes.successMessages')



<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light">Orçamentos</h3>

{{-- Filtro de Pesquisa --}}
<form action="{{ route('site.index') . '?' . http_build_query(request()->query()) }}" method="GET">
    <div class="row">
        <div class="input-field col s12 m6">
            <input id="search_client" name="search_client" type="text" value="{{$filtro_cliente}}">
            <label for="search_client">Buscar cliente</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="search_vendedor" name="search_vendedor" type="text" value="{{$filtro_vendedor}}">
            <label for="search_vendedor">Buscar vendedor</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6">
            <input id="search_start_date" name="search_start_date" type="text" value="{{$filtro_data_inicio}}">
            <label for="search_start_date">Data início</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="search_end_date" name="search_end_date" type="text" value="{{$filtro_data_fim}}">
            <label for="search_end_date">Data final</label>
        </div>
    </div>

    <div class="row">
        <div class="col s4 left-align">
            <a href="{{ route('orcamento.create')}}" class="btn waves-effect waves-light green"><strong>Criar orçamento</strong></a>
        </div>
        <div class="col s4 center-align">
            <button type="{{route('site.index')}}" class="btn waves-effect waves-light cyan darken-1"><strong>Pesquisar</strong></button>
        </div>
        <div class="col s4 right-align">
            <a href="{{ route('site.index')}}" class="btn waves-effect waves-light grey"><strong>Limpar filtros</strong></a>
        </div>
    </div>



</form>


        <table class="highlight centered responsive-table">
            <thead>
                <tr>
                    <th>Cliente:</th>
                    <th>Vendedor:</th>
                    <th>Descrição:</th>
                    <th>Valor:</th>
                    <th>Data do Orçamento:</th>
                </tr>
            </thead>
                <tbody>
                    @forelse ($orcamentos as $orcamento)
                        <tr>
                            <td>{{$orcamento->user->nome}}</td>
                            <td>{{$orcamento->seller->nome}}</td>
                            <td>{{Str::limit($orcamento->descricao, 20)}}</td>
                            <td>R$ {{number_format($orcamento->valor, 2, ',', '.')}}</td>
                            <td>{{date('d/m/Y', strtotime($orcamento->data_do_orcamento))}}</td>
                            <td><a href="{{ route('orcamento.details', $orcamento->id)}}" class="btn-floating orange"><i class="material-icons">visibility</a></td>
                            <td><a href="{{ route('orcamento.update', ['id' => $orcamento->id]) }}" class="btn-floating blue"><i class="material-icons">edit</i></a></td>

                            <td><a href="#delete-{{ $orcamento->id }}" class="btn-floating waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a></td>
                            @include('modal.delete')
                        </tr>

                        @empty
                        <tr>
                            <td>Não existem registros cadastrados ou que atendam os filtros de pesquisa.</td>
                        </tr>

                    @endforelse
            </tbody>
        </table>
        <br>


        <div class="row center">
            {{ $orcamentos->links('custom.pagination') }}
        </div>
    </div>
</div>

@endsection
