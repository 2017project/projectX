<?php

namespace App\Common\Transformers;


class UserTransformer extends Transformer
{
    protected $resourceName = 'user';

    protected $config = [
        'username' => 'username',
        'email' => 'email1',
        'first_name' => 'first_name',
        'bio' => 'bio',
    ];

    protected function getCustomTransform($keys)
    {
        if ($keys) {
            return array_flip(array_filter(array_flip($this->config), function ($k) use ($keys) {
                return in_array($k, $keys);
            }));
        }
        return array_keys($this->config);
    }

    public function transform($data, $option = null)
    {
        $keys = $this->getCustomTransform($option);

        return collect($keys)->map(function ($key, $value) use ($data) {
            return $this->getValueForKey($data, $value);
        });

    }
}
