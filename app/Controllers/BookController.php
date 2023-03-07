<?php

namespace App\Controllers;

use App\Models\Book;
use CodeIgniter\RESTful\ResourceController;

class BookController extends ResourceController
{
    protected $modelName = 'App\Models\Book';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'status' => true,
            'message' => 'Get data successfuly',
            'data' => $this->model->findAll()
        ];
        return $this->response->setJSON($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = [
            'status' => true,
            'message' => 'Get data success',
            'data' => $this->model->find($id)
        ];
        if ($data['data'] == null) {
            return $this->failNotFound('book not found');
        }
        return $this->response->setJSON($data, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = $this->validate([
            'judul' => 'required',
            'kode' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'kota_terbit' => 'required',
            'isi_konten' => 'required',
            'sampul' => 'uploaded[sampul]|max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]'
        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];

            return $this->failValidationErrors($respons);
        }

        // upload gambar 
        $sampul = $this->request->getFile('sampul');
        $sampulName = $sampul->getRandomName();
        $sampul->move('sampul', $sampulName);
        $data = [
            'judul' => $this->request->getVar('judul'),
            'kode' => $this->request->getVar('kode'),
            'pengarang' => $this->request->getVar('pengarang'),
            'penerbit' => $this->request->getVar('penerbit'),
            'tahun_terbit' => $this->request->getVar('tahun_terbit'),
            'kota_terbit' => $this->request->getVar('kota_terbit'),
            'isi_konten' => $this->request->getVar('isi_konten'),
            'sampul' => $sampulName,
        ];
        $this->model->insert($data);

        $respons = [
            'status' => true,
            'message' => 'add data success'
        ];
        return $this->respondCreated($respons, 200);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'judul' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kode' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah tersedia'
                ]
            ],
            'pengarang' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'penerbit' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'tahun_terbit' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kota_terbit' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'isi_konten' => [
                'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ]
        ]);
        if (!$rules) {
            $respons = [
                'status' => false,
                'message' => $this->validator->getErrors(),
            ];
            return $this->failValidationErrors($respons);
        }
        $model = new Book();

        $data = [
            'judul'         => $this->request->getVar('judul'),
            'kode'          => $this->request->getVar('kode'),
            'pengarang'     => $this->request->getVar('pengarang'),
            'penerbit'      => $this->request->getVar('penerbit'),
            'tahun_terbit'  => $this->request->getVar('tahun_terbit'),
            'kota_terbit'   => $this->request->getVar('kota_terbit'),
            'isi_konten'    => $this->request->getVar('isi_konten'),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);
        $respons = [
            'status' => true,
            'message' => 'update data success'
        ];
        return $this->respond($respons, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $oldSampul = $this->model->find($id);
        if ($oldSampul['sampul'] != '') {
            unlink('sampul/' . $oldSampul['sampul']);
        }
        $this->model->delete($id);
        $respons = [
            'status' => true,
            'message' => 'Delete data success'
        ];
        return $this->respondDeleted($respons);
    }
}
