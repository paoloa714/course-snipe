<?php
require_once('vendor/autoload.php');

class requestController {

    
    public function delete($params){
        $clientID = $params->clientID;
        $path = trim($params->configPath, '%');

        $criteria = array ('_id' => $clientID);
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
    
    public function get($params) {
        $path = trim($params->configPath, '%');
        $clientID = ($params->clientID);
        $decrypt = false;
        
        if(isset($params->encrypted)){
            $decrypt = $params->encrypted;
        }      

        $db = $this->_getDbConnection();

        //since were querying by unique id we don't need to worry about getting multiple docs back
        $result = $db->findOne(
                array('_id' => $clientID), array($path => true)
        );

        //parse through result
        $PathAccessors = explode('.', $path);
        foreach ($PathAccessors as $PathAccessor) {
            $result = $result[$PathAccessor];
        }
        
        if ($decrypt && isset($result)){
           $crypt = $this->_getEncrypter();
           $return =  $crypt->decrypt($result);
           return $return;
        }
        return $result;
    }

    public function set($params) {
        $path = trim($params->configPath, '%');
        $clientID = ($params->clientID);
        $encrypt = false;
        
        if(isset($params->encrypted)){
            $encrypt = $params->encrypted;
        }
        
        if($encrypt && isset($params->value)){
            $crypt = $this->_getEncrypter();
            $value = $crypt->encrypt($params->value);
        }else{
            $value = $params->value;
        }

        $db = $this->_getDbConnection();
        
        
        $criteria = array ('_id' => $clientID);
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

    protected function _getDbConnection() {
        return utils::getDbConnection('config');
    }
    
    private function _fetchConfig(){
        return utils::getConfig('config');
    }
    
    private function _getEncrypter(){
         $config = $this->_fetchConfig();
         return new Illuminate\Encryption\Encrypter($config['key']);
    }
    
    
}