@extends('layout')
@section('title', "Cadastrar Orçamento")
@section('content')
@include('includes.errorMessages')


<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light">Novo Orçamento</h3>
        <form action="{{ route('orcamento.insert') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="input-field col s12">
                <input type="text" name="id">
                <label for="id">Id</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="nome_cliente">
                <label for="nome_cliente">Nome do Cliente</label>
            </div>

            <div class="input-field col s12">
                <input type="email" name="email_cliente">
                <label for="email">Email do Cliente</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="telefone_cliente">
                <label for="telefone_cliente">Telefone do cliente</label>
            </div>

            <div class="input-field col s12">
                <select name="id_vendedor">
                    <option name disabled selected>Escolha um vendedor</option>
                        @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}">{{ $vendedor->nome }}</option>
                        @endforeach
                </select>
                <label>Selecionar Vendedor</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="descricao">
                <label for="descricao">Descrição</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="valor_do_orcamento">
                <label for="valor_do_orcamento">Valor do Orçamento</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="data_do_orcamento">
                <label for="data_do_orcamento">Data do orçamento</label>
            </div>

            <button type="submit" name="btn-cadastrar" class="btn green">Cadastrar</button>
            <a href="{{ route('site.index')}}" class="btn blue">Lista de Clientes</a>

        </form>

    </div>
</div>

@endsection
