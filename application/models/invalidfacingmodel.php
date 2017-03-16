<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invalidfacingmodel extends CI_Model {
	public function __construct(){

		parent:: __construct();

		$this->load->database();

	}
	public function viewAll($cus_id,$scan_date,$aisle,$upc_ean,$threshold){

		$scan_date=date("Y-m-d", strtotime($scan_date));
		$sanitiationQuery = $this->db->select('4d_cus.ID,

									4d_cus.4D_CUS_SCAN_LOCATION

								'); 

		$this->db->from('4d_cus');

		$this->db->join('4d_scan_dir', '4d_cus.ID = 4d_scan_dir.4D_CUS_ID');

		$this->db->where('4d_cus.4D_CUS_ID',$cus_id);

		$this->db->where('DATE(4d_scan_dir.SCAN_DATE_TIME) >=', $scan_date);

		$this->db->where('DATE(4d_scan_dir.SCAN_DATE_TIME) <=', $scan_date);
		$sanitiationQuery=$this->db->get();
		$rowcount = $sanitiationQuery->num_rows();

		if($rowcount>0){
			$row = $sanitiationQuery->row();
			$dCus_id=$row->ID;
			$query = $this->db->select('4d_tag_ocr.4D_TAG_OCR_ID AS id,

											

											4d_tag_ocr.4D_SHELF_TAG_SCAN_CREATE_DATE_TIME AS scan_date,

											4d_tag_ocr.CUS_AISLE_ID AS aisle,

											4d_tag_ocr.OCRD_SALES_PRICE AS sales_price,

											4d_tag_ocr.OCRD_REGULAR_PRICE AS regular_price,

											4d_tag_ocr.UNITS AS units,

											4d_tag_ocr.SHELF_TAG_TYPE AS tag_type,

											4d_tag_ocr.UPC_EAN AS upc_ean,

											4d_tag_ocr.MAN_DESC AS `name`,

											4d_tag_ocr.PROD_MAIN_DESC AS description,

											4d_tag_ocr.WEIGHT AS weight,

											4d_tag_ocr.WEIGHT_VOLUME_UNITS AS weight_unit,

											4d_tag_ocr.PRI_SHELF_TAG_POS_DIST_FROM_START_X AS pri_shelf_tag_pos_dist_from_start_x,

											4d_tag_ocr.PRI_SHELF_TAG_POS_DIST_FROM_FLOOR_Y AS pri_shelf_tag_pos_dist_from_floor_y,

											4d_tag_ocr.PRI_SHELF_TAG_POS_DIST_FROM_ISLE_PLANE_Z AS pri_shelf_tag_pos_dist_from_isle_plane_z,

											4d_tag_ocr.3D_MODEL_SHELF_NUM_FROM_FLOOR AS three_d_model_shelf_num_from_floor,

											4d_tag_ocr.4D_SHELF_TAG_SCAN_CREATE_DATE_TIME,

											4d_tag_ocr.OCR_PROD_X,4d_tag_ocr.OCR_PROD_Y,	4d_tag_ocr.OCR_PROD_z,4d_tag_ocr.VER_FAC,4d_tag_ocr.HOR_FAC,,4d_cus.4D_CUS_SCAN_LOCATION AS location,4d_cus.4D_CUS_ID as store_id,cus_tag_inf_inv.*,	FLOOR(4d_tag_ocr.PRI_SHELF_TAG_POS_DIST_FROM_START_X - 4d_tag_ocr.OCR_PROD_X) AS threshold,
											4d_tag_ocr.OCR_PROD_X,
											4d_tag_ocr.PROD_IMAGE_MATCHING ,4d_tag_ocr.PROMO_TAG'); 

			$this->db->from('4d_tag_ocr');

			$this->db->join('cus_tag_inf_inv', 'cus_tag_inf_inv.UPC_EAN = 4d_tag_ocr.UPC_EAN AND cus_tag_inf_inv.NUM_OF_HOR_FAC=4d_tag_ocr.HOR_FAC AND cus_tag_inf_inv.NUM_OF_VER_FAC=4d_tag_ocr.VER_FAC');

			$this->db->join('4d_cus', '4d_tag_ocr.4D_CUS_ID = 4d_cus.ID');
			$this->db->where('DATE(cus_tag_inf_inv.CUS_SHELF_TAG_COMPARE_CREATE_DATE_TIME) >=', $scan_date);
			$this->db->where('DATE(cus_tag_inf_inv.CUS_SHELF_TAG_COMPARE_CREATE_DATE_TIME) <=', $scan_date);
			$this->db->where('4d_tag_ocr.4D_CUS_ID',$dCus_id);

			$this->db->where('cus_tag_inf_inv.NUM_OF_HOR_FAC',1);

			$this->db->where('DATE(4d_tag_ocr.4D_SHELF_TAG_SCAN_CREATE_DATE_TIME) >=', $scan_date);

			$this->db->where('DATE(4d_tag_ocr.4D_SHELF_TAG_SCAN_CREATE_DATE_TIME) <=', $scan_date);
			if(isset($aisle) && !empty($aisle)){

				$this->db->where('4d_tag_ocr.4D_AISLE_SEQUENCE',$aisle);
			}

			if(isset($upc_ean) && !empty($upc_ean)){

				$this->db->where('4d_tag_ocr.UPC_EAN',$upc_ean);
			}
			$query=$this->db->get(); 

			//echo $this->db->last_query();exit;

			 return $query;
		}else{
			$response=array("code"=>404,"message"=>"Sorry no results found against store_id and date ,please provide valid store_id.","fields"=>"store_id,date");
			echo json_encode($response);
			exit(1);
		}

	}
}

