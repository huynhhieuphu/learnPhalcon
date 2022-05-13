<?php
namespace App\Validations;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\File as FileValidator;

class CreateProductPost extends Validation
{
    public function initialize()
    {
        $this->add('name', new PresenceOf());
        $this->add('category_id', new PresenceOf());
        $this->add('price', new Between([
            "minimum" => 1,
            "maximum" => 999999,
            "message" => "The price must be between 1 and 999999",
        ]));
        $this->add('price', new Numericality());
        $this->add('status', new PresenceOf());
    }
}