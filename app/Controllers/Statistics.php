<?php
    namespace App\Controllers;
    
    use CodeIgniter\Controller;

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
            
            $days = $inputs_outputs_hours_model->get_days();
            
            return view('statistics/chart_statistics', [
                'get_input_camera1' => $get_input_camera1,
                'get_output_camera1' => $get_output_camera1,
                'get_input_camera2' => $get_input_camera2,
                'get_output_camera2' => $get_output_camera2,
                'get_input_global' => $get_input_global,
                'get_output_global' => $get_output_global,
                'get_count_persons' => $get_count_persons,
                'days' => $days
            ]);
        }
        
        public function get_chart_statistics_by_day()
        {
            if($this->request->getMethod() == 'post')
            {
                $day = $this->request->getPost('day');
            
                $inputs_outputs_hours_model = new \App\Models\InputsOutputsHoursModel;

                $chart_statistics = $inputs_outputs_hours_model->get_chart_statistics_by_day($day);

                return json_encode($chart_statistics);
            }
        }
    }
?>
