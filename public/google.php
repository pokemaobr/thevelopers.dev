<?php

set_time_limit(0);

$method = $_SERVER['REQUEST_METHOD'];

return $method;

if ($method == 'POST') {

    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);
    $intent = $json->queryResult->intent->displayName;
    $response = $json;

/*    switch ($intent) {

        case 'listar':
        {
           break;
        }

        case 'criar':
        {
            break;

        }

        case 'deletar':
        {


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
}';}
*/
    echo $response;
} else {
    echo 'Método não aceito';
}