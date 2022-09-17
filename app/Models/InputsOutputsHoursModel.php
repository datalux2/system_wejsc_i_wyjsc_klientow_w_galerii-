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
           $builder_inputs_outputs = $this->db->table('inputs_outputs');
           
           $builder_inputs_outputs_hours = $this->db->table('inputs_outputs_hours');
           
           $builder_inputs_outputs->select('DATE(datetime) date, HOUR(datetime) hour');
           
           $builder_inputs_outputs->distinct();
           
           $query = $builder_inputs_outputs->get();
           
           $result = $query->getResultArray();
           
           if (!empty($result))
           {
               foreach ($result as $row)
               {
                   $builder_inputs_outputs_hours->where('date', $row['date']);
                   $builder_inputs_outputs_hours->where('hour', $row['hour']);
                   $query2 = $builder_inputs_outputs_hours->get();
                   
                   $result2 = $query2->getRowArray();
                   
                   if(empty($result2))
                   {   
                        $result3 = $this->get_count_input_output($row['date'], $row['hour'], 1);
                       
                        $result4 = $this->get_count_input_output($row['date'], $row['hour'], 0);
                              
                        $data = [
                             'date' => $row['date'],
                             'hour'  => $row['hour'],
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
        
        public function chart_statistics()
        {
            $builder = $this->db->table('inputs_outputs_hours');
            
            $builder->orderBy('date, hour');
            
            $query = $builder->get();
            
            $result = $query->getResultArray();
            
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
    }
?>
