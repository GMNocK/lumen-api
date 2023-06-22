<?php 

namespace App\Trait;

use App\Models\User;

trait ResponseTrait
{
    protected $response;
    private $access_token;
    private $error = null;
    protected $has_token = false;

    protected function createResponse($status = 200, $message, $data = null, $access_token = null)
    {
        [$status_code, $status_desc] = $this->getStatus($status);
        return $this->response = [
            'smartapp' => [
                'token' => $this->access_token,
                'status' => [
                    'code' => $status_code,
                    'description' => $status_desc
                ],
                'message' => $message,
                'result' => [
                    'error' => $this->error,
                    'data' => $data
                ]
            ]
        ];
    }

    private function getStatus($status)
    {
        $code_list = [200, 300, 400, 403, 404, 500];
        $message_list = ['ok', 'redirect', 'bad request','unauthorize', 'not found', 'server error'];
        $status_index_pos = array_search($status, $code_list);
        !$status_index_pos ? 5 : '';

        return [ $code_list[$status_index_pos], $message_list[$status_index_pos] ];
    }

    protected function token_verify($request)
    {
        if ($request->has('_token')) {
            $this->access_token = $request->_token;
            $this->has_token = true;

            $user = User::access($request->_token)->get();
            if ($user == '[]') {
                $this->error = 'invalid given token';
                $this->has_token = false;
            }
        } else {
            $this->has_token = false;
        }
        
    }
}
