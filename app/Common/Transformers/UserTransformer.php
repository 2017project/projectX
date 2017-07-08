<?php

namespace App\Common\Transformers;

class UserTransformer extends Transformer
{
    protected $resourceName = 'users';

    public function transform($data)
    {
        return [
            'username' => $this->getValueForKey($data, 'username'),
        ];
    }
}
