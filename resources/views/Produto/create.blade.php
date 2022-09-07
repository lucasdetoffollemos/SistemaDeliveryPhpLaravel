<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Produto</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <form action="/produto" method="post" onsubmit="return validateSelect()">
            @csrf
            <div class="form-group">
              <label for="id-input-id">ID</label>
              <input type="text" class="form-control" id="id-input-id" aria-describedby="idHelp" placeholder="#" disabled>
              <small id="idHelp" class="form-text text-muted">Não é necessário cadastrar um ID para um novo dado.</small>
            </div>
            <div class="form-group">
              <label for="id-input-nome">Nome</label>
              <input name="nome" type="text" class="form-control" id="id-input-nome" placeholder="Digite o nome do produto">
            </div>
            <div class="form-group">
                <label for="id-input-preco">Preço</label>
                <input name="preco" type="number" class="form-control" id="id-input-preco" placeholder="Digite o preço do produto" step=".01">
            </div>
            <div class="form-group">
                <label for="id-select-tipo">Tipo</label>
                <select name="tipo" id="id-select-tipo" class="form-select" aria-label="Selecione um tipo" required="required">
                    <option value="-1">Selecione um tipo</option>
                    <@foreach ($tipoProdutos as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>
                    @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label for="id-input-ingredientes">Ingredientes</label>
                <input name="ingredientes" type="text" class="form-control" id="id-input-ingredientes" placeholder="Digite os Ingredientes do produto">
            </div>
            <div class="form-group">
                <label for="id-input-ingredientes">Url da Imagem</label>
                <input name="urlDaImagem" type="text" class="form-control" id="id-input-urlDaImagem" placeholder="Digite a Url da Imagem">
            </div>
            <div class="my-1">
                
                <button  type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-primary" href="/produto">Voltar</a>
            </div>
        </form>
    </div>   
    <script>
        function validateSelect(){
            let selectOption = document.getElementById('id-select-tipo').value;
            if(selectOption == -1){
                alert('Por favor preencha um tipo de produto');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>