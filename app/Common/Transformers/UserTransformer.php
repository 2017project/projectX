<?php

namespace App\Common\Transformers;

class UserTransformer extends Transformer
{
    protected $resourceName = 'user';

    public function transform($data)
    {
        // if lay full mail
        return [
            'username' => $this->getValueForKey($data, 'username'),

        ];
        // if lay thong tin co ban

    }
}
