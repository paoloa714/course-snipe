<?php
require_once('controllers/requestController.php');


class syncController extends requestController{
    
     public function set($params) {
        $path = trim($params->configPath, '%');
        $value = $params->value;
        $syncID = 1;
        
        $db = $this->_getDbConnection();
        
        
        $criteria = array ('_id' => (integer) $syncID);
        $data = array ('$set' => array( $path => $value));
        $options = array ('upsert' => true);
        
        try {
            
            $db->update($criteria,$data,$options);
        } catch (Exception $exc) {
            $string="\n";
            $string.=$exc->getMessage()."\n";
            $string.=$exc->getTraceAsString()."\n";
            
            $h = fopen(__DIR__.'server.log' ,'a+');
            fwrite($h , $string);
            fclose($h);
            
            return false;
        }
        return true;
    }
    
    public function get($params){
        $db = $this->_getDbConnection();
        
        $result = $db->findOne(array(
            '_id' => 1,
       ));
        
        return $result;
    }
    
    public function delete($params){
        $path = trim($params->configPath, '%');
        
        $criteria = array ('_id' => (integer) 1);
        $data = array ('$unset' => array( $path => true));
        
        $db = $this->_getDbConnection();
          try {
            
            $db->update($criteria,$data);
        } catch (Exception $exc) {
            $string="\n";
            $string.=$exc->getMessage()."\n";
            $string.=$exc->getTraceAsString()."\n";
            
            $h = fopen(__DIR__.'server.log' ,'a+');
            fwrite($h , $string);
            fclose($h);
            
            return false;
        }
        return true;
    }
    
    protected function _getDbConnection() {
        return utils::getDbConnection('sync');
    }
    
}
