<?php


namespace Hogus\Tencent\Tim\Messages;


use Illuminate\Support\Arr;

class Image extends Message
{
    protected $type = 'TIMImageElem';

    protected $properties = [
        'uuid',
        'format',
        'info',
    ];

    protected $aliases = [
        'UUID' => 'uuid',
        'ImageFormat' => 'format',
        'ImageInfoArray' => 'info',
    ];

    protected $attributes_aliases = [
        'Type' => 'type',
        'Size' => 'size',
        'Width' => 'width',
        'Height' => 'height',
        'URL' => 'url'
    ];

    protected $attributes_required = [
        'type',
        'size',
        'width',
        'height',
        'url'
    ];

    /**
     * Image constructor.
     *
     * @param string $uuid 图片序列号
     * @param int    $format 图片格式 JPG = 1，GIF = 2，PNG = 3，BMP = 4，其他 = 255。
     * @param array  $attributes 原图、缩略图或者大图下载信息
     */
    public function __construct(string $uuid, int $format, array $attributes)
    {
        $info = [];

        foreach ($attributes as $attribute) {

            $this->checkRequired($attribute);

            $array = [];
            foreach ($attribute as $key => $value) {
                $alias = array_search($key, $this->attributes_aliases, true);

                $array[$alias ?: $key] = $value;
            }

            $info[] = $array;
        }

        parent::__construct(compact('uuid', 'format', 'info'));
    }

    protected function checkRequired($attribute)
    {
        foreach ($this->attributes_required as $value) {
            if (is_null(Arr::get($attribute, $value))) {
                throw new \InvalidArgumentException("attributes [$value] cannot be empty.");
            }
        }
    }
}
