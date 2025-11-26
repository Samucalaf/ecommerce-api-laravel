<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{


    protected $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }


    public function showAddresseUser($userId)
    {
        return $this->model->forUser($userId)->get();
    }

    public function addAddresse(array $data)
    {
        return $this->model->create($data);
    }

    public function findId($userId, $id)
    {
        return $this->model->forUser($userId)->find($id);
    }

    public function editAddress($id, array $data)
    {
        $address = $this->model->findOrFail($id);
        return $address->update($data);
    }

    public function deleteAddress($userId, string $id)
    {
        $address = $this->model->forUser($userId)->findOrFail($id);
        return $address->delete();
    }
}
