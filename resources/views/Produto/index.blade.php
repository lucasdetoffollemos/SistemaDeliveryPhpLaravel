<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index de Produto</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        @if (isset($message))
            <div class="alert alert-{{$message[1]}} alert-dismissible fade show" role="alert">
                <span>{{$message[0]}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="my-1"> 
            <a class="btn btn-primary"href="{{route("produto.create")}}">Criar Produto</a>
            <a class="btn btn-primary" href="#">Voltar</a>
        </div>
       

        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Preco</th>
                <th scope="col">Tipo</th>
                
              </tr>
            </thead>
            <tbody>
            @foreach ($produtos as $produto)
            <tr>
                <th scope="row">{{$produto->id}}</th>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->preco}}</td>
                <td>{{$produto->descricao}}</td>
                <td>
                <a href="{{route("produto.show", $produto->id)}}" class="btn btn-primary">Mostrar</a>
                    <a href="{{route("produto.edit", $produto->id)}}" class="btn btn-secondary">Editar</a>
                    <a href="#" class="btn btn-danger class-button-destroy" data-bs-toggle="modal" data-bs-target="#destroyModal" value="{{route("produto.destroy", $produto->id)}}">Remover</a>
                </td>
              </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="destroyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remo????o de recurso</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       Deseja realmente remover este recurso?
                    </div>
                    <div class="modal-footer">
                       <form id="id-form-modal-botao-remover" method="post" action="" style="display: inline;">
                            @csrf
                            @method('delete')
                            <!--<input name="_method" type="hidden" value="DELETE">-->
                            <input type="submit" value="Confirmar" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const arrayBtnRemover = document.querySelectorAll(".class-button-destroy")
            const formModalBotaoRemover = document.querySelector("#id-form-modal-botao-remover")

            arrayBtnRemover.forEach(bnRemover => {
                bnRemover.addEventListener('click', configurarBotaoRemoverModal)
            });

            function configurarBotaoRemoverModal(){
                //console.log(this.getAttribute("value"));
                formModalBotaoRemover.setAttribute("action", this.getAttribute("value"));
            }
        </script>
</body>
</html>