<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class CarrosController extends Controller
{
    public function index(Request $request)
    {
        $carros = Carro::orderBy('nome_veiculo')->get();

        return view('carros', [
            'carros' => $carros
        ]);
    }

    public function store(Request $request)
    {
        $cars = [];
        $item_name = ['ano', 'quilometragem', 'combustivel', 'cambio', 'portas', 'cor'];

        if($request->termo)
        {
            $termo = urlencode($request->termo);
            $source = file_get_contents('https://www.questmultimarcas.com.br/estoque?termo=' . $termo);
        } 
        else
        {
            $source = file_get_contents('https://www.questmultimarcas.com.br/estoque');
        }

        preg_match_all('/<article class="card clearfix"*(.*?)<\/article>/is', $source, $articles);

        if($articles[0])
        {
            foreach($articles[0] as $keyArticle => $article)
            {
                
                //LINK PARA O VEÍCULO
                preg_match('/href=*(.*?)>/is', $article, $links); //link para o carro
                $cars[$keyArticle]['link'] = preg_replace('/"/', '', $links[1]);
    
                
                //NOME DO VEÍCULO
                preg_match('/<h2 class="card__title ui-title-inner"><a href=*(.*?)<\/a>/is', $article, $nome); //link para o carro
                $cars[$keyArticle]['nome'] = explode('>',$nome[1])[1];
                
                //DESCRIÇÃO DO VEÍCULO
                preg_match_all('/<span class="card-list__info">*(.*?)<\/span>/is', $article, $infos); //informações do carro
    
                foreach($infos[1] as $key => $items)
                {
                    $descriptions[$key] = trim($items);
                }
    
                $cars[$keyArticle]['description'] = array_combine($item_name, $descriptions);

                $carros = Carro::updateOrCreate(
                    ['link' => $cars[$keyArticle]['link']],
                    [
                        'user_id' => Auth::user()->id,
                        'nome_veiculo' => $cars[$keyArticle]['nome'],
                        'ano' => $cars[$keyArticle]['description']['ano'],
                        'quilometragem' => $cars[$keyArticle]['description']['quilometragem'],
                        'combustivel' => $cars[$keyArticle]['description']['combustivel'],
                        'cambio' => $cars[$keyArticle]['description']['cambio'],
                        'portas' => $cars[$keyArticle]['description']['portas'],
                        'cor' => $cars[$keyArticle]['description']['cor'],
                    ]
                );
            }
        }

        $founds = count($articles[0]);

        return view('home', [
            'founds' => $founds
        ]);
    }

    public function destroy($carro)
    {
        try {

            $carros = Carro::find($carro);
            $carros->delete();
    
            return response()->json(['message' => 'Carro removido com sucesso!']);

        } catch (\Throwable $th) {

            Log:debug(['Falha no processo de exclusão:' => $th]);
            return response()->json(['error' => 'Falha durante o processo de exclusão. Tente novamente ou contate o administrador do sistema!'], 422);

        }
    }
}
