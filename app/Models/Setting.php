<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group', 'type'];

    /**
     * Get the value attribute.
     * Automatically decodes JSON if type is json or array.
     */
    public function getValueAttribute($value)
    {
        if ($this->type === 'json' || $this->type === 'array') {
            return json_decode($value, true);
        }
        if ($this->type === 'boolean') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        return $value;
    }

    /**
     * Set the value attribute.
     * Automatically encodes JSON if type is json or array.
     */
    public function setValueAttribute($value)
    {
        if ($this->type === 'json' || $this->type === 'array') {
            $this->attributes['value'] = json_encode($value);
        } elseif (is_bool($value)) {
            $this->attributes['value'] = $value ? '1' : '0';
        } else {
            $this->attributes['value'] = $value;
        }
    }
}
