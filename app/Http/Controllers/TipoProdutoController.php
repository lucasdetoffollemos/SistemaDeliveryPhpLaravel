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
        //
        $tipoProduto =  new TipoProduto();
        $tipoProduto->descricao =  $request->descricao;
        $tipoProduto->save();
        return $this->index();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
