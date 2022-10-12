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
        try{
            $produtos = DB::select(" 
            SELECT produtos.id, produtos.nome, produtos.preco, tipo_produtos.descricao
            FROM restaurantedb.produtos
            JOIN restaurantedb.tipo_produtos 
            ON produtos.Tipo_Produtos_id = tipo_produtos.id;"
            );
        }catch(\Throwable $th){
            return view("Produto/index")->with("produtos", [])->with("message", [$th->getMessage(), "danger"]);
        }

        return view("Produto/index")->with("produtos", $produtos);
    }

    public function indexMessage($message)
    {
        try {
            $produtos = DB::select('SELECT Produtos.id,
                                       Produtos.nome,
                                       Produtos.preco,
                                       Tipo_Produtos.descricao,
                                       Produtos.ingredientes,
                                       Produtos.urlImage,
                                       Produtos.updated_at,
                                       Produtos.created_at
                                FROM Produtos
                                JOIN TIPO_PRODUTOS on Produtos.Tipo_Produtos_id = Tipo_Produtos.id');
        } catch (\Throwable $th) {
            return view("Produto/index")->with("produtos", [])->with("message", [$th->getMessage(), "danger"]);
        }
        return view("Produto/index")->with("produtos", $produtos)->with("message", $message);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        try {
            $tipoProdutos = DB::select("SELECT id, descricao FROM Tipo_Produtos");
        } catch (\Throwable $th) {
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
        
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

        try{
            $produto = new Produto();
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->Tipo_Produtos_Id = $request->tipo;
            $produto->ingredientes = $request->ingredientes;
            $produto->urlImage = $request->urlDaImagem;
            $produto->save();
        }catch (\Throwable $th) {
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
        
        return $this->indexMessage( ["Produto cadastrado com sucesso", "success"] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

        
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
            return $this->indexMessage(["Produto não encontrado", "warning"]);
        }catch(\Throwable $th){
            return $this->indexMessage([$th->getMessage(),"danger"]);
        }

        //$produto = Produto::find($id);
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

        try{
            if(isset($produto)){
                $tipoProdutos = TipoProduto::all();
                return view("Produto/edit")->with("produto", $produto)->with("tipoProdutos", $tipoProdutos);
            }

            return $this->indexMessage( ["Produto não encontrado", "warning"] );

        }catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
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
        try{
            $produto = Produto::find($id);

            if(isset($produto)){
                $produto->nome = $request->nome;
                $produto->preco = $request->preco;
                $produto->Tipo_Produtos_Id = $request->tipo;
                $produto->ingredientes = $request->ingredientes;
                $produto->urlImage = $request->urlDaImagem;
                $produto->update();
                return $this->indexMessage( ["Produto atualizado com sucesso", "success"] );
            }
            return $this->indexMessage( ["Produto não encontrado", "warning"] );
        }
        catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
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
        try{
            $produto = Produto::find($id); // obj encontyrado ou null

            if(isset($produto)){
                $produto->delete();
                //return \Redirect::route('produto.index');
                //return $this->index();
                return $this->indexMessage( ["Produto removido com sucesso", "success"] );
            }
            return $this->indexMessage( ["Produto não encontrado", "warning"] );
        }
        catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
    }
}
