@extends('layout')
  <!-- Modal Structure -->
<div id="delete-{{ $orcamento->id }}" class="modal">
    <div class="modal-content">
        <h4><i class="material-icons">delete</i> Tem certeza? </h4>
        <div class="row">
            <p>Tem certeza que deseja excluir este orçamento?</p>
        </div>
        <a href="#!" class="modal-close waves-effect waves-green btn blue right">Cancelar</a>

        <form action="{{ route('orcamento.delete', $orcamento->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="waves-effect waves-green btn red right">Deletar</button>
        </form>

    </div>
</div>
