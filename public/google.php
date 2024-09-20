<?php

set_time_limit(0);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

    $requestBody = file_get_contents('php://input');
    $req_dump = print_r( $requestBody, true );
    $fp = file_put_contents('../request.log', $req_dump );
    $json = json_decode($requestBody);
    $intent = $json->queryResult->intent->displayName;


    switch ($intent) {

        case 'Episodios':
        {
            $episodios = json_decode(file_get_contents('assets/json/episodios.json', true));

            $entrevistado = $json->queryResult->parameters->entrevistado;

            if (empty($entrevistado)) {

                $episodio = $episodios[array_rand($episodios, 1)];

            } else {
                $nomes = array_column($episodios, 'Entrevistado');
                $episodio = $episodios[array_search($entrevistado, $nomes)];
            }

            $speech = "The Velopers #" . $episodio['Episodio'] .
                ' - Entrevista com: ' . $episodio['Entrevistado'] .
                ' - ' . $episodio['Descricao'] . ' - Assista pelo link: ' .
                $episodio['Link'];


            $speech =  'foi';
            break;
        }


        default:
            $speech = 'nenhuma intenção corresponde a sua frase.';
    }

    $response = '{
  "fulfillmentMessages": [
    {
      "text": {
        "text": [
          "' . $speech . '"
        ]
      }
    }
  ]
}';

    echo $response;
} else {
    echo 'Método não aceito';
}
