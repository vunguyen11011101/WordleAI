<?php 

class WordleClient {
    /**
     * @param string $endpoint
     * @return array
     * @throws Exception
     */

    private string $baseUrl = "https://wordle.votee.dev:8000";

    public function guessDaily(string $guess): array
    {
        $query = http_build_query(
            [
                'guess' => $guess,
                'size' => 5
            ]
        );
        return $this->request("/daily?" . $query);
    }

    public function guessRandom(string $guess): array
    {
        $query = http_build_query(
            [
                'guess' => $guess,
                'size' => 5
            ]
        );
        return $this->request("/random?" . $query);
    }

    public function guessWord(string $word, string $guess): array
    {
        $query = http_build_query(
            [
                'guess' => $guess,
                'size' => 5
            ]
        );
        return $this->request("/word/" . urlencode($word) . "?" . $query);
    }


    private function request(string $endpoint): array
    {
        $url = $this->baseUrl . $endpoint;

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ]
        ]);

        $response = curl_exec($curl);

        // Kiểm tra lỗi cURL
        if ($response === false) {

            $error = curl_error($curl);

            curl_close($curl);

            throw new Exception("cURL Error: {$error}");
        }

        // Lấy HTTP Status Code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        // Kiểm tra HTTP Status
        if ($statusCode !== 200) {
            throw new Exception("HTTP Error: {$statusCode}");
        }

        // Chuyển JSON -> Array
        $data = json_decode($response, true);

        // Kiểm tra JSON hợp lệ
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(
                "JSON Decode Error: " . json_last_error_msg()
            );
        }

        return $data;
    }
}