<?php

namespace App\Controllers;

use App\Models\Book;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
    public function update($id = null)
    {
        $model = new Book();
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'sampul' => [
                'label' => 'File Image',
                'rules' => 'uploaded[sampul]|is_image[sampul]|ext_in[sampul,png,jpg,jpeg,gif]|mime_in[sampul,image/png,image/jpg,image/jpeg,image/gif]',
                'errors' => [
                    'uploaded' => '{field} wajib upload',
                    'mime_in' => '{field} kesalahan mime'
                ]
            ]
        ]);
        if (!$valid) {
            $error_msg = [
                'err_upload' => $validation->getError()
            ];
            $respons = [
                'status' => 404,
                'error' => 404,
                'message' => $error_msg
            ];

            return $respons;
        }
        $img = $this->request->getFile('sampul');
        if (!$img->hasMoved()) {
            $img->move('sampul', $img->getName() . '.' . $img->getExtension());
        }
        $data = [
            'sampul' => $img->getName()
        ];
        $model->update($id, $data);
        $respons = [
            'status' => 201,
            'error' => 201,
            'message' => 'upload sampul berhasil'
        ];
        dd($img->getName());

        return $respons;
    }
}
