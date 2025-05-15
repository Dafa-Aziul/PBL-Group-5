<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $name = '';
    #[Validate('required|email|unique:users,email')]
    public string $email = '';
    #[Validate('required|in:admin,mekanik,owner')]
    public string $role = '';   
    #[Validate('nullable|string|min:8|regex:/[A-Z]/|regex:/[^a-zA-Z\d]/')]
    public string $password = '';
}
