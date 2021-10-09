<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class CarrosController extends Controller
{
    /**
     * 
     * Return data about the cars.
     * 
     * @params $request
     * @return array
     * 
     */
    public function index(Request $request)
    {
        $carros = Carro::orderBy('nome_veiculo')->paginate(6);

        return view('carros', [
            'carros' => $carros
        ]);
    }


    /**
     * 
     * Store all data from www.questmultimarcas.com.br.
     * 
     * @params $request
     * @return array
     * 
     */
    public function store(Request $request)
    {
        $source = $this->generateSource($request);

        preg_match_all('/<article class="card clearfix"*(.*?)<\/article>/is', $source, $articles);

        if($articles[0])
        {
            foreach($articles[0] as $article)
            {
                
                $data_car = $this->FormatData($article);

                $carros = Carro::updateOrCreate(
                    ['link' => $data_car['link']],
                    [
                        'user_id'       => Auth::user()->id,
                        'nome_veiculo'  => $data_car['nome'],
                        'ano'           => $data_car['description']['ano'],
                        'quilometragem' => $data_car['description']['quilometragem'],
                        'combustivel'   => $data_car['description']['combustivel'],
                        'cambio'        => $data_car['description']['cambio'],
                        'portas'        => $data_car['description']['portas'],
                        'cor'           => $data_car['description']['cor'],
                    ]
                );

                if(!$carros)
                {
                    $nome = $data_car['nome'];
                    Log::debug(["message" => "falha ao salvar dos dados do veículo: $nome", "user_id" => Auth::user()->id]);
                    return redirect()->back()->with('error',"Falha ao salvar os dados do veículo: $nome");
                }
            }
        }

        $founds = count($articles[0]);

        return view('home', [
            'founds' => $founds
        ]);
    }


    /**
     * 
     * Generate source to formatData function.
     * 
     * @params $array
     * @return array
     * 
     */
    private function generateSource($data)
    {
        if($data->termo)
        {
            $termo = urlencode($data->termo);
            $source = file_get_contents('https://www.questmultimarcas.com.br/estoque?termo=' . $termo);
        } 
        else
        {
            $source = file_get_contents('https://www.questmultimarcas.com.br/estoque');
        }

        return $source;
    }


    /**
     * 
     * Format data to save in on database.
     * 
     * @params $array
     * @return array
     * 
     */
    private function FormatData($veiculo_data)
    {
        $cars = [];
        $item_name = ['ano', 'quilometragem', 'combustivel', 'cambio', 'portas', 'cor'];

        //LINK PARA O VEÍCULO
        preg_match('/href=*(.*?)>/is', $veiculo_data, $links); //link para o carro
        $cars['link'] = preg_replace('/"/', '', $links[1]);

        
        //NOME DO VEÍCULO
        preg_match('/<h2 class="card__title ui-title-inner"><a href=*(.*?)<\/a>/is', $veiculo_data, $nome); //link para o carro
        $cars['nome'] = explode('>',$nome[1])[1];
        
        //DESCRIÇÃO DO VEÍCULO
        preg_match_all('/<span class="card-list__info">*(.*?)<\/span>/is', $veiculo_data, $infos); //informações do carro

        foreach($infos[1] as $key => $items)
        {
            $descriptions[$key] = trim($items);
        }

        $cars['description'] = array_combine($item_name, $descriptions);

        return $cars;

    }


    /**
     * 
     * Remove data from a specific car;
     * 
     * @params $array
     * @return view
     * 
     */
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
