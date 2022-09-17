<?php
    namespace App\Controllers;

    class Statistics extends BaseController
    {
        public function chart_statistics()
        {
            $inputs_outputs_model = new \App\Models\InputsOutputsModel;
            
            $inputs_outputs_hours_model = new \App\Models\InputsOutputsHoursModel;
            
            $get_input_camera1 = $inputs_outputs_model->get_input_camera1();
            
            $get_output_camera1 = $inputs_outputs_model->get_output_camera1();
            
            $get_input_camera2 = $inputs_outputs_model->get_input_camera2();
            
            $get_output_camera2 = $inputs_outputs_model->get_output_camera2();
            
            $get_input_global = $inputs_outputs_model->get_input_global();
            
            $get_output_global = $inputs_outputs_model->get_output_global();
            
            $get_count_persons = $inputs_outputs_hours_model->get_count_persons();
            
            $chart_statistics = $inputs_outputs_hours_model->chart_statistics();
            
            return view('statistics/chart_statistics', [
                'get_input_camera1' => $get_input_camera1,
                'get_output_camera1' => $get_output_camera1,
                'get_input_camera2' => $get_input_camera2,
                'get_output_camera2' => $get_output_camera2,
                'get_input_global' => $get_input_global,
                'get_output_global' => $get_output_global,
                'get_count_persons' => $get_count_persons,
                'chart_statistics' => $chart_statistics
            ]);
        }
    }
?>
