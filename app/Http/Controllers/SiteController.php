<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Orcamento;
use App\Models\Cliente;
use App\Models\Vendedor;
use Illuminate\Support\Carbon;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        /* Declarando variáveis dos filtros */
        $orcamentos = Orcamento::orderBy('data_do_orcamento', 'desc');

        $filtro_cliente = $request->input('search_client');
        $filtro_vendedor = $request->input('search_vendedor');
        $filtro_data_inicio = $request->input('search_start_date');
        $filtro_data_fim = $request->input('search_end_date');

        /* Validando os filtros */
        if ($request->filled('search_client') || $request->filled('search_vendedor') || $request->filled('search_start_date') || $request->filled('search_end_date')) {
            if ($request->filled('search_client')) {
                $orcamentos->whereHas('user', function ($query) use ($request) {
                    $query->where('nome', 'like', "%{$request->search_client}%");
                });
            }

            if ($request->filled('search_vendedor')) {
                $orcamentos->whereHas('seller', function ($query) use ($request) {
                    $query->where('nome', 'like', "%{$request->search_vendedor}%");
                });
            }

            if ($request->filled('search_start_date')) {
                $start_date = date('Y/m/d', strtotime(str_replace('/', '-', $request->search_start_date)));
                $orcamentos->where('data_do_orcamento', '>=', $start_date);
            }

            if ($request->filled('search_end_date')) {
                $end_date = date('Y/m/d', strtotime(str_replace('/', '-', $request->search_end_date)));
                $orcamentos->where('data_do_orcamento', '<=', $end_date);
            }

            $orcamentos = $orcamentos->paginate($orcamentos->count());
        }
        else {
            $orcamentos = $orcamentos->paginate(5);
        }

        return view('welcome', compact('orcamentos', 'filtro_cliente', 'filtro_vendedor', 'filtro_data_inicio', 'filtro_data_fim'));
    }

    public function details($id){
        $orcamento = Orcamento::where('id', $id)->first();

        return view('orcamentodetails', compact('orcamento'));

    }

    public function criarOrcamento(){

        $vendedores = Vendedor::all();

        return view('criar-orcamento', compact('vendedores'));
    }

    public function insertOrcamento(Request $request){

        /* Declarando variáveis do formulário */
        $errors = [];
        $success = [];
        $id = $request->input('id');
        $nome_cliente = $request->input('nome_cliente');
        $email_cliente = $request->input('email_cliente');
        $telefone_cliente = $request->input('telefone_cliente');
        $vendedor_id = $request->input('id_vendedor');
        $descricao = $request->input('descricao');
        $valor_orcamento = $request->input('valor_do_orcamento');
        $data_do_orcamento = $request->input('data_do_orcamento');


        /* Validação dos campos vazios*/
        if (empty($data_do_orcamento)) {
            $errors[] = 'O campo "Data do Orçamento" estava vazio, preencha todos os campos!';
        }
        else {
            try {
                $data_orcamento = Carbon::createFromFormat('d/m/Y', $data_do_orcamento)->format('Y/m/d');
            }
            catch (Exception $e) {
                $errors[] = 'Formato de data inválido. Certifique-se de fornecer a data no formato dd/mm/aaaa.';
            }
        }

        if (empty($id)) {
            $errors[] = 'O campo "ID" está vazio, preencha todos os campos!';
        }

        if (empty($nome_cliente)) {
            $errors[] = 'O campo "Nome do cliente" estava vazio, preencha todos os campos!';
        }

        if (empty($email_cliente)) {
            $errors[] = 'O campo "Email do cliente" estava vazio, preencha todos os campos!';
        }

        if (empty($telefone_cliente)) {
            $errors[] = 'O campo "Telefone do cliente" estava vazio, preencha todos os campos!';
        }

        if (empty($vendedor_id)) {
            $errors[] = 'O campo "Vendedor" estava vazio, preencha todos os campos!';
        }

        if (empty($descricao)) {
            $errors[] = 'O campo "Descrição" estava vazio, preencha todos os campos!';
        }

        if (empty($valor_orcamento)) {
            $errors[] = 'O campo "Valor do Orçamento" está vazio, preencha todos os campos!';
        }

        if (!empty($errors)) {
            return redirect()->back()->with('errors', $errors);
        }

        /* Verifica o ID é um número */
        if (!is_numeric($id)) {
            $errors[] = 'O ID é invalido, deve ser um número.';
            return redirect()->back()->with('errors', $errors);

        }
        /* Verifica se o ID do orçamento já existe */
        $orcamentoExists = Orcamento::where('id', $id)->exists();

        if ($orcamentoExists) {
            $errors[] = 'O ID do orçamento já existe.';
            return redirect()->route('site.index')->with('errors', $errors);
        }


        /* Checando se o e-mail do cliente é válido */
        if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'O e-mail do cliente é inválido.';
            return redirect()->back()->with('errors', $errors);
        }

        /* Verifica se o cliente existe */
        $cliente = Cliente::where('email', $email_cliente)->first();

        if (!$cliente) {
            $cliente = new Cliente();
            $cliente->nome = $nome_cliente;
            $cliente->email = $email_cliente;
            $cliente->telefone = $telefone_cliente;
            $cliente->save();
        }
        else {
            $nome_cliente = $cliente->nome;
            $success[] = 'Cliente cadastrado com sucesso. Já existe um cliente cadastrado com o email ' . $email_cliente . '. O nome do cliente é ' . $nome_cliente;
            return redirect()->route('site.index')->with('success', $success);
        }

        /* Verifica o telefone é um número */
        if (!is_numeric($telefone_cliente)){
            $errors[] = 'Telefone inválido.';
            return redirect()->back()->with('errors', $errors);
        }

        /* Verifica o valor do orçamento é um número */
        if (!is_numeric($valor_orcamento)){
            $errors[] = 'O valor do roçamento está inválido';
            return redirect()->back()->with('errors', $errors);
        }

        /* Cria o orçamento */
        $orcamento = new Orcamento();
        $orcamento->id = $id;
        $orcamento->id_cliente = $cliente->id;
        $orcamento->id_vendedor = $vendedor_id;
        $orcamento->descricao = $descricao;
        $orcamento->valor = $valor_orcamento;
        $orcamento->data_do_orcamento = $data_orcamento;
        $orcamento->save();

        $success[] = 'O orçamento foi inserido com sucesso!';
        return redirect()->route('site.index')->with('success', $success);
    }


    public function updateOrcamento($id)
    {
    $orcamento = Orcamento::where('id', $id)->first();
    $vendedores = Vendedor::all();

    return view('update-orcamento', compact('orcamento', 'vendedores'));
    }

    public function insertUpdate(Request $request){

    $errors = [];
    $success = [];

    $id = $request->input('id');

    if (empty($id)) {
        $errors[] = 'O campo "ID" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    if (!is_numeric($id)) {
        $errors[] = 'O ID é inválido, deve ser um número.';
        return redirect()->back()->with('errors', $errors);
    }

    $nome_cliente = $request->input('nome_cliente');

    if (empty($nome_cliente)) {
        $errors[] = 'O campo "Nome do Cliente" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    $email_cliente = $request->input('email_cliente');

    if (empty($email_cliente)) {
        $errors[] = 'O campo "E-mail do Cliente" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    if (!filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'O e-mail do cliente é inválido';
        return redirect()->back()->with('errors', $errors);
    }

    $telefone_cliente = $request->input('telefone_cliente');

    if (empty($telefone_cliente)) {
        $errors[] = 'O campo "Telefone do Cliente" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    if (!is_numeric($telefone_cliente)){
        $errors[] = 'O telefone deve ser um número.';
        return redirect()->back()->with('errors', $errors);
    }

    $vendedor_id = $request->input('id_vendedor');

    if (empty($vendedor_id)) {
        $errors[] = 'O campo "Vendedor" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    $descricao = $request->input('descricao');

    if (empty($descricao)) {
        $errors[] = 'O campo "Descrição" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    $valor_orcamento = $request->input('valor_do_orcamento');

    if (empty($valor_orcamento)) {
        $errors[] = 'O campo "Valor do Orcamento" está vazio, preencha todos os campos!';
        return redirect()->back()->with('errors', $errors);
    }

    if(!is_numeric($valor_orcamento)){
        $errors[] = 'O valor do orcamento deve ser um número.';
        return redirect()->back()->with('errors', $errors);
    }

    $data_do_orcamento = $request->input('data_do_orcamento');
    if (empty($data_do_orcamento)) {
        $errors[] = 'O campo "Data do Orçamento" estava vazio, preencha todos os campos!';
    }
    else {
        try {
            $data_orcamento = Carbon::createFromFormat('d/m/Y', $data_do_orcamento)->format('Y/m/d');
        }
        catch (Exception $e) {
            $errors[] = 'Formato de data inválido. Certifique-se de fornecer a data no formato dd/mm/aaaa.';
        }
    }

    $orcamento = Orcamento::find($id);

    if ($orcamento) {
        $errors = [];
        $success = [];

        $existingOrcamento = Orcamento::where('id', $id)->first();
        if ($existingOrcamento && $existingOrcamento->id != $orcamento->id) {
        $errors[] = 'O ID do orçamento já existe no banco de dados!';
        }

        if ($orcamento->descricao !== $descricao) {
            $orcamento->descricao = $descricao;
            $orcamento->save();
            $success[] = 'A descrição do orçamento foi atualizada com sucesso!';
        }

        if ((float)$orcamento->valor !== (float)$valor_orcamento) {
            $orcamento->valor = $valor_orcamento;
            $orcamento->save();
            $success[] = 'O valor do orçamento foi atualizado com sucesso!';
        }

        if ($orcamento->data_do_orcamento !== $data_orcamento) {
            $orcamento->data_do_orcamento = $data_orcamento;
            $orcamento->save();
        }

        if ((int)$orcamento->id_vendedor !== (int)$vendedor_id) {
            $orcamento->id_vendedor = $vendedor_id;
            $orcamento->save();
            $success[] = 'O vendedor foi atualizado com sucesso!';
        }

        $cliente = Cliente::find($orcamento->id_cliente);

        if ($cliente) {
            if ($email_cliente !== $cliente->email) {
                $cliente->email = $email_cliente;
                $cliente->save();
                $success[] = 'O email do cliente foi atualizado com sucesso!';

            }

            if ($cliente->nome !== $nome_cliente) {
                $cliente->nome = $nome_cliente;
                $cliente->save();
                $success[] = 'O nome do cliente foi atualizado com sucesso!';

            }

            if ($cliente->telefone !== $telefone_cliente) {
                $cliente->telefone = $telefone_cliente;
                $cliente->save();
                $success[] = 'O telefone do cliente foi atualizado com sucesso!';
            }
        }

        if (count($success) > 0) {
            return redirect()->route('site.index')->with('success', $success);
        }
        if (count($success) == 0) {
            $errors[] = 'Nenhum dado foi atualizado.';
        }


        return redirect()->route('site.index')->with('errors', $errors);
    }

    $errors[] = 'O orçamento não foi encontrado.';
    return redirect()->route('site.index')->with('errors', $errors);
    }

    public function destroy($id)
    {
        $orcamento = Orcamento::find($id);

        $success = [];

        $orcamento->delete();

        $success[] = 'O orçamento foi deletado com sucesso!';

        return redirect()->route('site.index')->with('success', $success);
    }


}
