<?php 

namespace App\Trait;

trait ResponseTrait
{
    protected $response;

    protected function createResponse($status = 200, $message, $data = null)
    {
        [$status_code, $status_message] = $this->getStatus($status);
        return $this->response = [
            'smartapp' => [
                'status' => [
                    'code' => $status_code,
                    'message' => $status_message 
                ],
                'message' => $message,
                'data' => $data
            ]
        ];
    }

    private function getStatus($status)
    {
        $code_list = [200, 300, 404, 500];
        $message_list = ['success', 'redirect', 'not found', 'server error'];
        $status_index_pos = array_search($status, $code_list);
        !$status_index_pos ? 3 : '';

        return [ $code_list[$status_index_pos], $message_list[$status_index_pos] ];
    }
}
