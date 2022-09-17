<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class InputsOutputsModel extends Model
    {
        protected $db;
        
        public function __construct()
        {
            $this->db = \Config\Database::connect();
        }
        
        public function random()
        {
            $builder = $this->db->table('inputs_outputs');
            
            for($i = 1; $i <= 5; $i++)
            {
                $direction = random_int(0, 1);

                $camera_number = random_int(1, 2);

                $data = [
                    'datetime' => date('Y-m-d H:i:s'),
                    'direction'  => $direction,
                    'camera_number'  => $camera_number
                ];

                $builder->insert($data);
            }
        }
        
        public function get_input_camera1()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wejsc');
            $builder->where('direction', 1);
            $builder->where('camera_number', 1);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        public function get_output_camera1()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wyjsc');
            $builder->where('direction', 0);
            $builder->where('camera_number', 1);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        public function get_input_camera2()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wejsc');
            $builder->where('direction', 1);
            $builder->where('camera_number', 2);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        public function get_output_camera2()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wyjsc');
            $builder->where('direction', 0);
            $builder->where('camera_number', 2);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        public function get_input_global()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wejsc');
            $builder->where('direction', 1);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
        
        public function get_output_global()
        {
            $builder = $this->db->table('inputs_outputs');
            
            $builder->select('count(*) as count_wyjsc');
            $builder->where('direction', 0);
            
            $query = $builder->get();
            
            $result = $query->getRowArray();
            
            return $result;
        }
    }
?>
