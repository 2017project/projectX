<?php

namespace App\Common\Transformers;

use App\Common\Filters\Pagination;
use Illuminate\Support\Collection;

abstract class Transformer
{
    /**
     * Resource name of the json object.
     *
     * @var string
     */
    protected $resourceName = 'data';

    /**
     * Transform a collection of items.
     *
     * @param Collection $data
     * @return array
     */
    public function collection(Collection $data)
    {
        return [
            str_plural($this->resourceName) => $data->map([$this, 'transform'])
        ];
    }

    /**
     * Transform a single item.
     *
     * @param $data
     * @return array
     */
    public function item($data)
    {
        return [
            $this->resourceName => $this->transform($data)
        ];
    }

    /**
     * Transform a paginated item.
     *
     * @param Pagination $paginated
     * @return array
     */
    public function paginate(Pagination $paginated)
    {
        $resourceName = str_plural($this->resourceName);

        $countName = str_plural($this->resourceName) . '_count';

        $data = [
            $resourceName => $paginated->data()->map([$this, 'transform'])
        ];

        return array_merge($data, [
            $countName => $paginated->total(),
            'current_page' => $paginated->page(),
            'item_per_page' => $paginated->perPage()
        ]);
    }

    /**
     * Apply the transformation.
     *
     * @param $data
     * @param null $option
     * @return mixed
     */
    public abstract function transform($data, $option = null);

    protected function getValueForKey($data, $key)
    {
        $keys = explode('.', $key);
        $pathData = $data[$keys[0]];
        unset($keys[0]);
        foreach ($keys as $k) {
            $pathData = $pathData[$k];
        }
        return $pathData;
    }
}
