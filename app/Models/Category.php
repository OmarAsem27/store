<?php

namespace App\Models;

use App\Rules\Filter as RulesFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'image',
        'status'
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                "unique:categories,name,$id",
                /* function ($attributes, $value, $fails) {
                      if (strtolower($value) == 'laravel') {
                          $fails("the name can't be $value");
                      }
                }*/
                // new RulesFilter
                'filter:laravel,php,html'
            ],
            // Rule::unique('categories', 'name')->ignore($id),
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'in:active,archived'
        ];
    }
}
