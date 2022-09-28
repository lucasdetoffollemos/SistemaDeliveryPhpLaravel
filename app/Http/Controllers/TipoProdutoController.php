<?php

namespace App\Http\Controllers;

use App\Models\TipoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoProdutoController extends Controller
{
    public function index()
    {
        $tipoProdutos = DB::select('select * from Tipo_Produtos');
        //print_r($tipoProdutos);
        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos);
    }

    public function create()
    {
        //
        return view("TipoProduto/create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|min:2|max:50',
        ], 
        [
            'descricao.required' => 'Necessario preencher o campo descricao',
            'descricao.min' => 'O preço necessita ter no minimo 2 números',
            'descricao.max' => 'O preço pode ter até 50 números'
        ]);

        //
        $tipoProduto =  new TipoProduto();
        $tipoProduto->descricao =  $request->descricao;
        $tipoProduto->save();
        return $this->index();
    }

    public function show($id)
    {
        $tipoProduto = TipoProduto::find($id);


        if (isset($tipoProduto)) {
            return view("TipoProduto/show")->with("tipoProduto", $tipoProduto);
        }

        //$produto = Produto::find($id);

        echo "Tipo Produto não encontrado";
    }

    public function edit($id)
    {
        $tipoProduto = TipoProduto::find($id); //retorna obj ou num

        if (isset($tipoProduto)) {

            return view("TipoProduto/edit")->with("tipoProduto", $tipoProduto);
        }

        echo "Tipo de Produto não encontrado";
    }

    public function update(Request $request, $id)
    {
        $tipoProduto = TipoProduto::find($id);

        if (isset($tipoProduto)) {
            $tipoProduto->descricao = $request->descricao;
            $tipoProduto->update();
            return $this->index();
        }

        echo "Tipo Produto não encontrado";
    }

    public function destroy($id)
    {
        //
    }
}
