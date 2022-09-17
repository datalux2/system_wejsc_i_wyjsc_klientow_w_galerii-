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
           
           //var_dump($result);
           
           if (!empty($result))
           {
               //echo 'a';
               foreach ($result as $row)
               {
                   //echo 'a';
                   $builder_inputs_outputs_hours->where('date', $row['date']);
                   $builder_inputs_outputs_hours->where('hour', $row['hour']);
                   $query2 = $builder_inputs_outputs_hours->get();
                   
                   $result2 = $query2->getRowArray();
                   
                   //var_dump($result2);
                   //die;
                   
                   if(empty($result2))
                   {
                       //echo $row['date'];
                       $builder_inputs_outputs->select('COUNT(*) count_input, DATE(datetime) date, HOUR(datetime) hour');
                       $builder_inputs_outputs->where('direction = 1');
                       $builder_inputs_outputs->where('DATE(datetime)', $row['date']);
                       $builder_inputs_outputs->where('HOUR(datetime)', $row['hour']);
                       $builder_inputs_outputs->groupBy('date, hour');
                       
                       $query3 = $builder_inputs_outputs->get();
                       
                       $result3 = $query3->getResultArray();
                       
                       $builder_inputs_outputs->select('COUNT(*) count_output, DATE(datetime) date, HOUR(datetime) hour');
                       $builder_inputs_outputs->where('direction = 0');
                       $builder_inputs_outputs->where('DATE(datetime)', $row['date']);
                       $builder_inputs_outputs->where('HOUR(datetime)', $row['hour']);
                       $builder_inputs_outputs->groupBy('date, hour');
                       
                       $query4 = $builder_inputs_outputs->get();
                       
                       $result4 = $query4->getResultArray();
                       
                       //var_dump($result3);
                       
                       if (!empty($result3))
                       {        
                            foreach ($result3 as $key => $row2)
                            {
                                $data = [
                                     'date' => $row2['date'],
                                     'hour'  => $row2['hour'],
                                     'input'  => $row2['count_input'],
                                     'output' => $result4[$key]['count_output']
                                 ];

                                 $builder_inputs_outputs_hours->insert($data);
                            }
                       }
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
    }
?>
