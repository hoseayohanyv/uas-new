<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound("User dengan ID $id tidak ditemukan.");
        }

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        // Validasi sederhana
        if (!isset($data['username']) || !isset($data['email'])) {
            return $this->fail('Username dan email wajib diisi.');
        }

        // Cek apakah data user ada
        $user = $this->model->find($id);
        if (!$user) {
            return $this->failNotFound("User dengan ID $id tidak ditemukan.");
        }

        // Lakukan update
        $updated = $this->model->update($id, [
            'username' => $data['username'],
            'email' => $data['email'],
        ]);

        if ($updated === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respond(['message' => 'Berhasil diupdate.']);
    }
}
