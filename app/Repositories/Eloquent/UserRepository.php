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
    public function currentUser()
    {
        $user = auth('api')->user();

        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Array $data
     * @return \Addition of new user
     */
    public function create(array $data)
    {
        return  User::create([
                    'name'     => $data['name'],
                    'email' => $data['email'],
                    'phone'     => $data['phone'],
                    'password'  => bcrypt($data['password']), 
                ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Array $data
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $data)
    {
        $user =  User::findorFail($this->currentUser()->id);

        return  $user->update([
                    'name'     => $data['name'],
                    'email' => $data['email'],
                    'phone'     => $data['phone'], 
                ]);
        
    }
}