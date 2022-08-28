<?php

use Illuminate\Support\Facades\Route;
use \App\Models\TipoProduto;
use \App\Models\Produto;
use Illuminate\Support\Facades\DB;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function(){
   echo "<html>
            <h1>Página de teste</h1>
        </html>";

});

Route::get('/ola/{nome}/{sobrenome}', function($nome, $sobrenome){
    echo "Seja bem vindo $nome $sobrenome";
 
 });

 Route::get('/ola/{nome?}', function($nome=null){
    if(isset($nome)){
        echo "Ola! Seja bem vindo $nome.";
    }
    else{
        echo "Olá! Seja bem vindo anônimo";
    }
 
 });


 Route::get("tipoproduto/add/{descricao}", function($descricao){
    $tipoProduto = new TipoProduto();
    $tipoProduto->descricao = $descricao;
    $tipoProduto->save();

    echo "<h1>Tipo Produto salvo com sucesso!</h1>";
   

    $tiposProdutos = DB::select("select * from tipo_produtos");
    echo "<h3>Tipo produtos salvos: </h3>";
    print_r($tiposProdutos);
});

Route::get("produto/add/{nome}/{preco}/{Tipo_Produtos_id}/{ingredientes}/{urlImage}",
function($nome, $preco, $Tipo_Produtos_id, $ingredientes, $urlImage){
    $produto = new Produto();
    $produto->nome = $nome;
    $produto->preco = $preco;
    $produto->Tipo_Produtos_id = $Tipo_Produtos_id;
    $produto->ingredientes = $ingredientes;
    $produto->urlImage = $urlImage;
    $produto->save();

    echo "<h1>Produto salvo com sucesso!</h1>";
   

    $produtos = DB::select("select * from produtos");
    echo "<h3>Produtos salvos: </h3>";
    print_r($produtos);
    
});
