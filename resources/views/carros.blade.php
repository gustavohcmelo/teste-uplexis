@extends('layouts.app')

@section('content')
<div class="text-center mt-3">
    <a href="{{ route('home') }}" class="btn btn-default">Página Inicial</a>
</div>
<div class="container py-3 d-flex flex-wrap">
    @if(count($carros) > 0)
        @foreach($carros as $carro)
        <div class="col-md-6 p-2">
            <div class="card">
                <h5 class="card-header">{{ $carro->nome_veiculo }}</h5>
                <div class="card-body">
                    <div class="d-flex flex-wrap descriptions">
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Ano: </span>{{ $carro->ano }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Quilometragem: </span>{{ $carro->quilometragem }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Combustível: </span>{{ $carro->combustivel }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Câmbio: </span>{{ $carro->cambio }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Portas: </span>{{ $carro->portas }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="card-text space-between"><span class="font-weight-bold">Cor: </span>{{ $carro->cor }}</p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="col-md-6">
                            <a href="{{ $carro->link }}" target="_blank" class="mt-3 btn btn-outline-primary center d-block">Ver detalhes</a>
                        </div>
                        <div class="col-md-6">
                            <a target="_blank"  data-id="{{ $carro->id }}" onclick="remove(this.dataset.id)" class="mt-3 btn btn-outline-danger center d-block">Remover</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="text-center py-4 col-md-12">
            <i class="las la-car"></i>
            <h3 class="text-secondary">Não existem veículos salvos.</h3>
        </div>
    @endif
</div>
<script type="application/javascript">       
function remove(id){
    axios.delete('{{ url("carros/destroy") }}/' + id, {
        headers:{
            'CSRF_TOKEN': '{{ csrf_token() }}'
        }
    })
    .then((response) => {
        Swal.fire('Sucesso!', response.data.message,'success')
        .then(function(){ 
        window.location.reload();
        });
    })
    .catch((error) => {
        Swal.fire('Opsss!', 'Falha na exclusão. Tente Novamente.','error')
        .then(function(){ 
        window.location.reload();
        });
    })
}
</script>
@endsection