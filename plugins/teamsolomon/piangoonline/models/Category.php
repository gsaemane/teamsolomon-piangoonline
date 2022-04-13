<?php namespace TeamSolomon\PiangoOnline\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'teamsolomon_piangoonline_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
