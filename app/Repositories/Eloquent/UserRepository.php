<?php 

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;  
use Auth;


class UserRepository 
{
	/**      
     * @var Model      
     */     
     protected $user;       

    /**      
     * ProductRepository constructor.      
     *      
     * @param Product $model      
     */     
    public function __construct(User $user)     
    {         
        $this->user = $user;
    }

	

	/**
    * @param collection
    *
    * @return Model
    */
    public function all()
    {
    	return $this->user->all();
    }

    /**
    * @param $id
    * @return Model
    */
    public function find()
    {
        $user = auth('api')->user();

        return $user;
    }

    

}