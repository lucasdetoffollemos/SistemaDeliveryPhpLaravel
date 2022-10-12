<?php

namespace App\Http\Controllers;

use App\Models\TipoProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoProdutoController extends Controller
{
    public function index()
    {
        try{
            $tipoProdutos = DB::select('select * from Tipo_Produtos');
        }
        catch(\Throwable $th){
            return view("TipoProduto/index")->with("tipoProdutos", [])->with("message", [$th->getMessage(), "danger"]);
        }
        //print_r($tipoProdutos);

        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos);
    }
    public function indexMessage($message)
    {
        try {
            $tipoProduto = DB::select('SELECT * FROM Tipo_Produtos');
        } catch (\Throwable $th) {
            return view("TipoProduto/index")->with("tipoProdutos", [])->with("message", [$th->getMessage(), "danger"]);
        }
        return view("TipoProduto/index")->with("tipoProdutos", $tipoProduto)->with("message", $message);
    }

    public function create()
    {
        try{
            return view("TipoProduto/create");
        } catch (\Throwable $th) {
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
        
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

        try{
            $tipoProduto =  new TipoProduto();
            $tipoProduto->descricao =  $request->descricao;
            $tipoProduto->save();
        }
        catch (\Throwable $th) {
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
    
        //return $this->indexMessage( ["Tipo produto cadastrado com sucesso", "success"] );
        return redirect()->route('tipoproduto.index', ["Tipo produto cadastrado com sucesso", "success"] );
    }

    public function show($id)
    {
        $tipoProduto = TipoProduto::find($id);

        try{
            if (isset($tipoProduto)) {
                return view("TipoProduto/show")->with("tipoProduto", $tipoProduto);
            }
            return $this->indexMessage(["Tipo Produto não encontrado", "warning"]);
        }
        catch(\Throwable $th){
            return $this->indexMessage([$th->getMessage(),"danger"]);
        }


        //$produto = Produto::find($id);

        
    }

    public function edit($id)
    {
        try{
            $tipoProduto = TipoProduto::find($id); //retorna obj ou num
            if (isset($tipoProduto)) {
                return view("TipoProduto/edit")->with("tipoProduto", $tipoProduto);
            }

            return $this->indexMessage( ["Tipo Produto não encontrado", "warning"] );

        }catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $tipoProduto = TipoProduto::find($id);

            if(isset($tipoProduto)){
                $tipoProduto->descricao = $request->descricao;
                $tipoProduto->update();
                $tipoProduto->update();
                return redirect()->route('tipoproduto.index', ["Tipo produto atualizado com sucesso", "success"] );
                //return $this->indexMessage( ["Tipo Produto atualizado com sucesso", "success"] );
            }
            return $this->indexMessage( ["Tipo Produto não encontrado", "warning"] );
        }
        catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
    }

    public function destroy($id)
    {
        try{
            $tipoProduto = TipoProduto::find($id);

            if(isset($tipoProduto)){
                $tipoProduto->delete();
                //return \Redirect::route('produto.index');
                //return $this->index();
                return redirect()->route('tipoproduto.index', ["Tipo Produto removido com sucesso", "success"] );
            }
            return $this->indexMessage( ["Tipo Produto não encontrado", "warning"] );
        }
        catch (\Throwable $th) {
            // Retorno quando dá erro
            return $this->indexMessage( [$th->getMessage(), "danger"] );
        }
    }
}
