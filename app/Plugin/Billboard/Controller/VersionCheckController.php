<?php

class VersionCheckController extends AppController {

    public $components = array('RequestHandler', 'SchoolInformation', 'Styling');
  
    public function beforeFilter() {
        $this->Auth->allow('check');
    }
    
    public function check() {      
        $versionData = array(
            'current' => $this->_generateHash(),
        );
        
        if (isset($this->request->query['hash'])) {
            $versionData['checked'] = $this->request->query['hash'];
            $versionData['up-to-date'] = $versionData['current'] == $versionData['checked'];
        } 
        
        $this->set(array(
            'version' => $versionData,
            '_serialize' => array('version')
        ));
    }
    
    private function _generateHash() {
        $parts = array();
        
        $di = new RecursiveDirectoryIterator(dirname(__FILE__) . '/..');
        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
            $parts[] = filemtime($filename);
        }
        
        $parts = array_merge($parts, $this->Styling->getStyle());
        
        return md5(implode(' ', $parts));
    }
    
}
