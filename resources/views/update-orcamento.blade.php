@extends('layout')
@section('title', "Editar Orçamento")
@section('content')
@include('includes.errorMessages')
@include('includes.successMessages')

<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light">Atualizar Orçamento</h3>
        <form action="{{ route('orcamento.insertUpdate', ['id' => $orcamento->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="input-field col s12">
                <input type="text" name="id" value="{{ $orcamento->id }}">
                <label for="id">Id</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="nome_cliente" value="{{ $orcamento->user->nome }}">
                <label for="nome_cliente">Nome do Cliente</label>
            </div>

            <div class="input-field col s12">
                <input type="email" name="email_cliente" value="{{ $orcamento->user->email }}">
                <label for="email">Email do Cliente</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="telefone_cliente" value="{{ $orcamento->user->telefone }}">
                <label for="telefone_cliente">Telefone do cliente</label>
            </div>

            <div class="input-field col s12">
                <select name="id_vendedor">
                    <option disabled selected>Escolha um vendedor</option>
                    @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" @if ($vendedor->id == $orcamento->id_vendedor) selected @endif>{{ $vendedor->nome }}</option>
                    @endforeach
                </select>
                <label>Selecionar Vendedor</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="descricao" value="{{ $orcamento->descricao }}">
                <label for="descricao">Descrição</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="valor_do_orcamento" value="{{ $orcamento->valor }}">
                <label for="valor_do_orcamento">Valor do Orçamento</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="data_do_orcamento" value="{{ date('d/m/Y', strtotime($orcamento->data_do_orcamento)) }}">
                <label for="data_do_orcamento">Data do orçamento</label>
            </div>

            <button type="submit" name="btn-atualizar" class="btn green">Atualizar</button>
            <a href="{{ route('site.index') }}" class="btn blue">Lista de Clientes</a>

        </form>

    </div>
</div>
@endsection
