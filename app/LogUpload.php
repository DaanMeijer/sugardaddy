<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LogUpload extends Model
{

    public function lines(){
        return $this->hasMany(LogLine::class);
    }

    public function save(array $options = [])
    {

        $lines = [];

        if($this->isDirty(['upload'])){


            $this->lines()->delete();



            /** @var \SplFileObject $fileObj */
            $csvData = ($this->upload);


            $lines = preg_split("/[\r\n]+/", $csvData);

        }

        $result = parent::save($options);


        if(count($lines) > 0){

            //discard these for now
            $meta = array_shift($lines);
            $header = array_shift($lines);

            $logLines = [];

            foreach($lines as $line){

                $parts = str_getcsv($line);

                if(count($parts) < 10){
                    continue;
                }


                list($meterName, $serial, $timestamp, $dataType,
                    $historicGlucose, $scanGlucose, $fastWorkingInsulin,
                    $fastWorkingInsulinUnits, $food, $carbGrams,
                    $carbPortions, $longWorkingInsulin,
                    $longWorkingInsulinUnits, $notes, $stripGlucose,
                    $keton, $mealInsulin, $correctionInsulin,
                    $userChangesInsulin
                    ) = $parts;

                $timestamp = Carbon::parse($timestamp);


                $logLines[] = new LogLine([
                    'timestamp' => $timestamp,
                    'historic_glucose' => str_replace(",",".",$historicGlucose),
                    'scan_glucose' => str_replace(",",".",$scanGlucose),
                    'strip_glucose' => str_replace(",",".",$stripGlucose),
                ]);

            }

            $this->lines()->saveMany($logLines);
        }
    }

    protected $fillable = [
        'user_id',
        'upload',
        'name',
    ];
}
