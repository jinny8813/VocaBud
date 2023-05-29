<?php

namespace App\Controllers;
use App\Models\DatesModel;

class Manage extends BaseController
{
    public function addDates()
    {
        date_default_timezone_set('Asia/Taipei');
        $DatesModel = new DatesModel();

        for($i=0;$i<3000;$i++){
            $tmp= date('Y-m-d',strtotime(' + '.$i.' days'));
            $values = [
                'date' => $tmp,
            ];
            $DatesModel->insert($values);
        }
    }
}