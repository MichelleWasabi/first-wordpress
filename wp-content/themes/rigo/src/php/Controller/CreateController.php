<?php
namespace Rigo\Controller;

use Rigo\Types\Create;

class CreateController{
    
    public function getHomeData(){
        return [
            'name' => 'Rigoberto'
        ];
    }
    
    public function getCreates(){
        $query = Create::all([ 'post_status' => 'publish' ]);
        return $query->posts;
    }
    
}
?>