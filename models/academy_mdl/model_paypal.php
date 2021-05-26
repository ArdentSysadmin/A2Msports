<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_paypal extends CI_Model {
	
		public function __construct()	{
			parent:: __construct();
		}

		public function upd_mem_payment_ot($data, $where_to) {
			$query	= $this->db->where($where_to);
			$query	= $this->db->update('Membership_PaymentLinks', $data);

			return $query;
		}

		public function upd_mem_payment_subscr($data, $where_to) {
			$query	= $this->db->where($where_to);
			$query	= $this->db->update('Membership_PaymentLinks', $data);
			//echo "test";
//echo "<pre>"; print_r($where_to);print_r($data); $this->db->last_query(); exit;

			return $query;
		}

	}