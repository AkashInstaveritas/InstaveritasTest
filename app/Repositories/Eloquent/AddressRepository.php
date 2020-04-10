<?php 

namespace App\Repositories\Eloquent;

use App\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;  
use Auth;


class AddressRepository 
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

	public function currentUser()
    {
        $user = auth('api')->user();

        return $user;
    }

	/**
    * @param collection HasMany
    *
    * @return Model
    */
    
    public function addresses()
    {
        $address = $this->user->find(auth('api')->user()->id)->addresses;

        return $address;
    }

    /**
    * @param object
    *
    * @return Model
    */
    
    public function find($id)
    {
        return Address::findorFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Array $data
     * @return \Addition of new address
     */
    public function create(array $data)
    {
        return  Address::create([
                    'user_id'  => $this->currentUser()->id,
                    'name'     => $data['name'],
                    'landmark' => $data['landmark'],
                    'city'     => $data['city'],
                    'pincode'  => $data['pincode'],
                    'state'    => $data['state'],
                    'country'  => $data['country'], 
                ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Array $data
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $data, $id)
    {
        $address =  Address::where([
                        ['user_id', $this->currentUser()->id],
                        ['id', $id],
                    ])->firstorFail();

        return $address->update([
                    'name'     => $data['name'],
                    'landmark' => $data['landmark'],
                    'city'     => $data['city'],
                    'pincode'  => $data['pincode'],
                    'state'    => $data['state'],
                    'country'  => $data['country'], 
                ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return  Address::where([
                    ['user_id', $this->currentUser()->id],
                    ['id', $id],
                ])->firstorFail()->delete();
        
    }
    

}