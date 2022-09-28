<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoProduto;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $produtos = DB::select(" 
        SELECT produtos.id, produtos.nome, produtos.preco, tipo_produtos.descricao
        FROM restaurantedb.produtos
        JOIN restaurantedb.tipo_produtos 
        ON produtos.Tipo_Produtos_id = tipo_produtos.id;"
        );


        return view("Produto/index")->with("produtos", $produtos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipoProdutos = DB::select(" 
        SELECT id, descricao
        FROM  restaurantedb.tipo_produtos;"
        );

        return view("Produto/create")->with("tipoProdutos", $tipoProdutos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required',
            'preco' => 'required|max:7',
            'tipo' => 'required',
            'ingredientes' => 'required',
            'urlDaImagem' => 'required',
        ], 
        [
            'nome.required' => 'Necessario preencher o campo nome',
            'preco.required' => 'Necessario preencher o campo preço',
            'preco.max' => 'O preço pode ter até 7 números',
            'tipo.required' => 'Selecione um tipo',
            'ingredientes.required' => 'Necessario preencher o campo ingredientes',
            'urlDaImagem.required' => 'Necessario preencher o campo url da imagem',
        ]);

        $produto = new Produto();
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->Tipo_Produtos_Id = $request->tipo;
        $produto->ingredientes = $request->ingredientes;
        $produto->urlImage = $request->urlDaImagem;
        $produto->save();
        return redirect()->route('produto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tipoProdutos = DB::select(
            "
        SELECT id, descricao
        FROM  restaurantedb.tipo_produtos;"
        );


        $produtos = DB::select(
            "
        SELECT produtos.Tipo_Produtos_id, produtos.id, produtos.nome, produtos.preco, produtos.ingredientes, produtos.urlImage,  tipo_produtos.descricao 
        FROM restaurantedb.produtos
        JOIN restaurantedb.tipo_produtos
        ON produtos.Tipo_Produtos_id = tipo_produtos.id
        WHERE produtos.id = ?", [$id]
        );

        if(count($produtos)>0){
            return view("Produto/show")->with("produto", $produtos[0])->with("tipoProdutos", $tipoProdutos);
        }

        //$produto = Produto::find($id);

        echo "Produto não encontrado";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::find($id);//retorna obj ou num

        if(isset($produto)){
            $tipoProdutos = TipoProduto::all();
            return view("Produto/edit")->with("produto", $produto)->with("tipoProdutos", $tipoProdutos);
        }

        echo "Produto não encontrado";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if(isset($produto)){
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->Tipo_Produtos_Id = $request->tipo;
            $produto->ingredientes = $request->ingredientes;
            $produto->urlImage = $request->urlDaImagem;
            $produto->update();
            return redirect()->route('produto.index');
        }

        echo "Produto não encontrado";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("delete * from produtos where produtos.id = ?",[$id]);

        echo "Produto excluido";
    }
}
