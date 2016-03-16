<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	/*
	 * get all stores
	 */
    public function getAllRecords() {
        return Store::orderBy('id','asc')->get();
    }

    /*
	 * get store by id
	 */
    public function getRecordById($id) {
    	return Store::find($id);
    }
}
