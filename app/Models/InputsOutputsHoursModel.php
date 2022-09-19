<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class InputsOutputsHoursModel extends Model
    {
        protected $db;
        
        public function __construct()
        {
            $this->db = \Config\Database::connect();
        }
        
        public function agregate()
        {  
           $date_today = date('Y-m-d');
           
           $hour_today = date('H');
           
           $date_yesterday = date('Y-m-d', strtotime($date_today . ' ' . $hour_today . ':00:00') - 60 * 60);
           
           $hour_yesterday = date('H', strtotime($date_today . ' ' . $hour_today . ':00:00') - 60 * 60);
           
           if (!empty($this->if_datetime_exists($date_yesterday, $hour_yesterday)))
           {
                $this->agregate_db($date_yesterday, $hour_yesterday);
           }
           
           if (!empty($this->if_datetime_exists($date_today, $hour_today)))
           {
                $this->agregate_db($date_today, $hour_today); 
           }
        }
        
        public function if_datetime_exists($date, $hour)
        {
           $builder_inputs_outputs = $this->db->table('inputs_outputs');
           
           $builder_inputs_outputs->where('date(datetime)', $date);
           $builder_inputs_outputs->where('hour(datetime)', $hour);
           
           $query = $builder_inputs_outputs->get();
           
           $result = $query->getResultArray();
           
           return $result;
        }
        
        public function agregate_db($date, $hour)
        {
            $builder_inputs_outputs = $this->db->table('inputs_outputs');
           
            $builder_inputs_outputs_hours = $this->db->table('inputs_outputs_hours');
            
            $builder_inputs_outputs_hours->where('date', $date);
            $builder_inputs_outputs_hours->where('hour', $hour);
            $query2 = $builder_inputs_outputs_hours->get();

            $result2 = $query2->getRowArray();

            if(empty($result2))
            {   
                 $result3 = $this->get_count_input_output($date, $hour, 1);

                 $result4 = $this->get_count_input_output($date, $hour, 0);

                 $data = [
                      'date' => $date,
                      'hour'  => $hour,
                      'input'  => $result3['count_input'],
                      'output' => $result4['count_output']
                  ];

                  $builder_inputs_outputs_hours->insert($data);
            }
            else
            {
                $result3 = $this->get_count_input_output($result2['date'], $result2['hour'], 1);

                $result4 = $this->get_count_input_output($result2['date'], $result2['hour'], 0);

                 $data = [
                      'input' => $result3['count_input'],
                      'output'  => $result4['count_output']
                 ];
                 $builder_inputs_outputs_hours->where('date', $result2['date']);
                 $builder_inputs_outputs_hours->where('hour', $result2['hour']);
                 $builder_inputs_outputs_hours->update($data);
            }
        }
        
        public function get_count_persons()
        {
            $builder = $this->db->table('inputs_outputs_hours');
            
            $builder->select('(sum(input) - sum(output)) as count_persons');
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        private function get_count_input_output($date, $hour, $direction)
        {
            $builder_inputs_outputs = $this->db->table('inputs_outputs');
            
            $builder_inputs_outputs->select('COUNT(*) ' . (($direction == 1) ? 'count_input': (($direction == 0) ? 'count_output':'')) . ', DATE(datetime) date, HOUR(datetime) hour');
            $builder_inputs_outputs->where('direction', $direction);
            $builder_inputs_outputs->where('DATE(datetime)', $date);
            $builder_inputs_outputs->where('HOUR(datetime)', $hour);
            $builder_inputs_outputs->groupBy('date, hour');
            
            $query = $builder_inputs_outputs->get();
            
            $result = $query->getRowArray();
            
            if(empty($result))
            {
                if ($direction == 1)
                {
                    $result['count_input'] = 0;
                }
                else if ($direction == 0)
                {
                    $result['count_output'] = 0;
                }
            }
            
            return $result;
        }
        
        public function get_days()
        {
            $builder_inputs_outputs_hours = $this->db->table('inputs_outputs_hours');
            
            $builder_inputs_outputs_hours->select("DATE_FORMAT(date, '%d-%m-%Y') day, date");
            
            $builder_inputs_outputs_hours->distinct();
            
            $builder_inputs_outputs_hours->orderBy('date asc');
            
            $query = $builder_inputs_outputs_hours->get();
            
            $result = $query->getResultArray();
            
            return $result;
        }
        
        public function get_chart_statistics_by_day($day)
        {
            $builder = $this->db->table('inputs_outputs_hours');
            
            $builder->where('date', $day);
            
            $builder->orderBy('date, hour');
            
            $query = $builder->get();
            
            $result = $query->getResultArray();
            
            return $result;
        }
    }
?>
