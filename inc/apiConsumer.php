<?php
class ApiConsumer 
{
    public function api($endpoint, $method = "GET", $post_fields = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.mercadolibre.com/sites/MLB/search?q=$endpoint",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "User-Agent: Thunder Client (https://www.thunderclient.com)"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON decode error: " . json_last_error_msg());
        }

        return $decoded;
    }

    public function getAllObjects()
    {
        $results = $this->api('all');

        // Verifique a estrutura correta do JSON
        if (!isset($results['results']) || !is_array($results['results'])) {
            throw new Exception("Unexpected API response format");
        }

        $objects = [];

        // Itere sobre os resultados retornados
        foreach ($results['results'] as $result) {
            $objects[] = $result['title'] ?? 'Unknown Title'; // Verifique se 'title' existe
        }

        return $objects;
    }
}

