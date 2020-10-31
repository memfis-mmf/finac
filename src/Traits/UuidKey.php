<?php
namespace memfisfa\Finac\Traits;
use Ramsey\Uuid\Uuid;

trait UuidKey
{
    /**
     * Boot the Uuid trait for the model.
     */
    public static function bootUuidKey()
    {
        static::creating(function ($model) {
            $model->setAttribute('uuid', (string) Uuid::uuid4());
        });
    }
    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        return $this->casts;
    }
}
