<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Kyc extends Model
{
    protected $table = 'tbl_ivr_kyc';
	protected $fillable = ['client_id', 'business_type', 'business_name', 'business_pan', 'gst_state', 'gstin', 'billing_address','billing_country', 'billing_state', 'billing_city', 'billing_pincode', 'primary_contact_name', 'primary_contact_email', 'primary_contact_mobile', 'designation_country', 'verification_type', 'kyc_id_proof_type', 'id_proof_doc', 'kyc_address_proof_type', 'address_proof_doc'];
}
