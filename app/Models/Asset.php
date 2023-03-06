<?php

namespace App\Models;

use App\Models\Objects\Field;
use App\Models\Objects\Values\RelationValue;
use App\Support\RelationValuesTrait;
use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Asset.
 */
class Asset extends Model {
    use UuidScopeTrait, HasFactory, RelationValuesTrait;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        $result = [
            'open' => url("/api/assets/{$this->uuid}"),
            'download' => url("/api/assets/{$this->uuid}/download")
        ];
        if ($this->type == 'image') {
            $result['full'] = url("/api/assets/{$this->uuid}/render");
            $result['thumb'] = url("/api/assets/{$this->uuid}/render?width=300");
        }
        return $result;
    }

    public function coordinates()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'accuracy' => $this->accuracy
        ];
    }

    public function output()
    {
        return [
            'id' => $this->uuid,
            'type' => $this->type,
            'mime' => $this->mime,
            'filename' => $this->filename,
            'extension' => $this->extension,
            'links' => $this->links(),
            'user' => $this->user->output(),
            'coordinates' => $this->coordinates(),
            'created_at' => $this->created_at->toIso8601String(),
            'created_by' => $this->user->name,
        ];
    }

    public function saveValue($fieldName, $object)
    {
        $field = Field::byUuidOrName($fieldName)->first();
        $relationValue = RelationValue::create();
        $relationValue->set($this);
        $relationValue->update([
            'field_id' => $field->id,
            'object_id' => $object->id,
        ]);
    }
}
