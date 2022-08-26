<?php

use Illuminate\Support\Facades\Route;
use \App\Models\TipoProduto;
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
    echo "<h3>Produtos salvos: </h3>";
    print_r($tiposProdutos);
});

//TODO
//salvar os dados do produto no banco
Route::get("produto/add/{nome}/{preco}/{Tipo_Produtos_id}/{ingredientes}/{urlImage}",
function($nome, $preco, $Tipo_Produtos_id, $ingredientes, $urlImage){
    
});
