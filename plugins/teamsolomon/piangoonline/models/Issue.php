<?php namespace TeamSolomon\PiangoOnline\Models;

use Model;
use RainLab\Location\Models\Country;

/**
 * Model
 */
class Issue extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $incrementing = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'teamsolomon_piangoonline_issues';

    public function beforeCreate()
    {
       // $this->id = Uuid::uuid4()->toString();
    }

    public function getCountryOptions(){
        //get countries
    $Countries = Country::all();
    
    $countries = array();
    
    foreach($Countries as $country){ $countries[] = $country;}
    return $countries;
    }

    /**
     * @var array Validation rules
     */
    public $rules = [];

    public $attachMany = [
        'files'=>['System\Models\File']
    ];

    public $belongsTo = [
        'status'=>['TeamSolomon\PiangoOnline\Models\Status'],
        'country'=>['RainLab\Location\Models\Country'],
        'category'=>['TeamSolomon\PiangoOnline\Models\Category']
    ];

    public $attachOne = [
        'country'=>['RainLab\Location\Models\Country'],
        'category'=>['TeamSolomon\PiangoOnline\Models\Category']
    ];

}