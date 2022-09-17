<?php
    namespace App\Controllers;

    class Cron extends BaseController
    {
        public function count_random_input_output()
        {
            $inputs_outputs_model = new \App\Models\InputsOutputsModel;
            
            $inputs_outputs_model->random();
            
            return view('cron/count_random_input_output');
        }
        
        public function agregate_input_output_hours()
        {
            $inputs_outputs_hours_model = new \App\Models\InputsOutputsHoursModel;
            
            $inputs_outputs_hours_model->agregate();
            
            return view('cron/agregate_input_output_hours');
        }
    }
?>
