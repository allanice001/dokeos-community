<?php

/**
 * model databse
 * @author johnny, <johnny1402@gmail.com>
 * @package index 
 */
class application_announcement_models_database extends Database
{
    /**
     * metodo para obtener data de la Base de datos.
     * @param type $sql
     * @return array 
     */
    public function getData($sql)
    {
        $result = $this->query($sql);
        $array  = array();
        while ($objectStyle = $this->fetch_object($result))
        {
            array_push($array, $objectStyle);
        }
        return $array;        
    }
    /**
     * Metodo para insertar datos
     * @param type $objAnnouncement
     * @param type $primaryKey 
     */
    public function insertData($objAnnouncement, $primaryKey='')
    {
        if(strlen(trim($primaryKey))>0)
        {
            //var_dump(property_exists($objAnnouncement, $primaryKey));
            if(property_exists($objAnnouncement, $primaryKey))
            {
                $sql ='INSERT INTO '.$this->escape_string($objAnnouncement->_table);
                $sql.=' ( ';
                $array_key = array();
                $array_value = array();
                foreach($objAnnouncement as $key => $value) 
                {
                    if($key == $primaryKey)
                        $value = 'NULL';
                    if($key['0'] != '_')
                    {
                        array_push($array_key, $key);
                        if($key == $primaryKey)
                            array_push($array_value, $value);
                        else
                            array_push($array_value, "'".$value."'");
                    }
                }
                $sql.= implode(',', $array_key);
                $sql.=' ) ';
                $sql.=' VALUE ( ';
                $sql.= implode(',', $array_value);
                $sql.=' ) ';
                
            $this->query($sql);
            $lastInsertId = $this->insert_id();
            $objAnnouncement->id=$lastInsertId;
            $objAnnouncement->_result= true;
            $objAnnouncement->_message= 'Los datos se guardaron en forma satisfactoria';            
            }
            else
            {
               $objAnnouncement->_result= false;
               $objAnnouncement->_message = 'La llave primaria no existe';
            }
        }
        else
        {
            $sql ='INSERT INTO '.$this->escape_string($objAnnouncement->_table);
            $sql.=' ( ';
            $array_key = array();
            $array_value = array();
            foreach($objAnnouncement as $key => $value) 
            {
                if($key['0'] != '_')
                {
                    array_push($array_key, $key);
                    array_push($array_value, "'".$value."'");
                }
            }
            $sql.= implode(',', $array_key);
            $sql.=' ) ';
            $sql.=' VALUE ( ';
            $sql.= implode(',', $array_value);
            $sql.=' ) ';
            
            $this->query($sql);
            $lastInsertId = $this->insert_id();
            $objAnnouncement->id=$lastInsertId;
            $objAnnouncement->_result= true;
            $objAnnouncement->_message= 'Los datos se guardaron en forma satisfactoria';
            
        }
        return $objAnnouncement;
    }
    
    public function execute($sql)
    {
        $this->query($sql);
        $affectedRow = $this->affected_rows(); 
        return $affectedRow;
    }
    
    public function update($objAnnouncementBean, $where)
    {
        $sql = "UPDATE ".$this->escape_string($objAnnouncementBean->_table)." SET ";
        $array_set = array();
        foreach($objAnnouncementBean as $key => $value) 
        {
            if($key['0'] != '_')
            {
                $set=" ".$key." = '".$value."'";
                array_push($array_set, $set);
            }
        }
        $sql.=" ".implode(',', $array_set)." ";
        $sql.=" WHERE ";
        if(is_array($where))
        {
            if(count($where) > 0)
            {
                $array_condition = array();
                foreach($where as $index=>$value2)
                {
                    $condition=" ".$index." = '".$value2."' ";
                    array_push($array_condition, $condition);
                }
                
                $sql.=implode("AND", $array_condition);
            }
        }
        else
        {
            $sql.=$where;
        }
            $this->query($sql);
            //$lastInsertId = $this->insert_id();
            //$objAnnouncementBean->_id=$lastInsertId;
            $objAnnouncementBean->_result= true;
            $objAnnouncementBean->_message= 'Los datos se actualizaron en forma satisfactoria';        
      return $objAnnouncementBean;      
    }
    
    public function fetchRow($sql)
    {
        $result = $this->query($sql);
        $objResult = null;
        while ($objectRow = $this->fetch_object($result))
                $objResult = $objectRow;
        return $objResult;        
    }
    
    public function fetchOne($sql)
    {
        $result = $this->query($sql);
        $objResult = null;
        while ($objectRow = $this->fetch_row($result))
                $objResult = $objectRow[0];
        return $objResult;
    }
}