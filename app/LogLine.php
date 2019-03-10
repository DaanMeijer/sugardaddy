<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogLine extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'historic_glucose',
        'scan_glucose',
        'strip_glucose',
    ];

    public function save(array $options = [])
    {
            foreach($this->getDirty() as $key => $value){
            switch($key){
                case 'historic_glucose':
                case 'scan_glucose':
                case 'strip_glucose':
                    if(!is_numeric($this->getAttribute($key))){
                        $this->setAttribute($key, null);
                    }
                    break;
            }
        }
        return parent::save($options);
    }

    public function getGlucoseAttribute(){
        return $this->historic_glucose + $this->scan_glucose + $this->strip_glucose;
    }

    protected $dates = ['timestamp'];
}
