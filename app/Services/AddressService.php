<?php


namespace App\Services;

use App\Repositories\AddressRepository;


class AddressService
{
    protected AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }


    public function listUserAddresses($userId)
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('User ID is required');
        }
        
        return $this->addressRepository->showAddresseUser($userId);
    }

    public function createAddress(array $data)
    {
        $this->validateAddressData($data);
        
        return $this->addressRepository->addAddresse($data);
    }

    public function getAddressById($userId, $id)
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('User ID is required');
        }
        
        if (empty($id)) {
            throw new \InvalidArgumentException('Address ID is required');
        }
        
        return $this->addressRepository->findId($userId, $id);
    }
    
    public function updateAddress($id, array $data)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Address ID is required');
        }
        
        $this->validateAddressData($data, false);
        
        return $this->addressRepository->editAddress($id, $data);
    }
    
    public function deleteAddress($userId, string $id)
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('User ID is required');
        }
        
        if (empty($id)) {
            throw new \InvalidArgumentException('Address ID is required');
        }
        
        return $this->addressRepository->deleteAddress($userId, $id);
    }
    
    private function validateAddressData(array $data, bool $isCreate = true)
    {
        if ($isCreate && empty($data['user_id'])) {
            throw new \InvalidArgumentException('User ID is required');
        }
        
        if (empty($data['street']) && isset($data['street'])) {
            throw new \InvalidArgumentException('Street cannot be empty');
        }
        
        if (empty($data['city']) && isset($data['city'])) {
            throw new \InvalidArgumentException('City cannot be empty');
        }
        
        if (empty($data['state']) && isset($data['state'])) {
            throw new \InvalidArgumentException('State cannot be empty');
        }
        
        if (isset($data['zip_code']) && !empty($data['zip_code'])) {
            $zipCode = preg_replace('/[^0-9]/', '', $data['zip_code']);
            if (strlen($zipCode) !== 8) {
                throw new \InvalidArgumentException('Invalid ZIP code format');
            }
        }
    }
}
