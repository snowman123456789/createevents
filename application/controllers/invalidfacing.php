<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Invalidfacing  extends CI_Controller {
	 public function __construct(){

		parent:: __construct();

		$this->load->database();

		$this->load->library('session');

		$this->load->helper('url');
		}
	public function index()

    {

		header('Content-Type: application/json');

		$store_id=$this->input->get('store_id');

		$date=$this->input->get('date');

		$aisle=$this->input->get('aisle');

		$upc_ean=$this->input->get('upc_ean');

		$threshold=$this->input->get('threshold');
		$scan_date_arr  = explode('-',$date);
		if(!empty($store_id) && !empty($date) && isset($_GET['date'])){
			$store_id =  $store_id;
			// Validate the id.

			if ($store_id <= 0)
			{
				// Invalid id, set the response and exit.

				$response=array("code"=>400,"message"=>"Invalid input format for the parameter store_id, it should be valid string value.","fields"=>"store_id");
				echo json_encode($response);
				exit(1);
			}
			if(isset($_GET['threshold']) && !empty($_GET['threshold']) ){
				$threshold = (int) $threshold;
			// Validate the threshold.

				if ($threshold <=0 || $threshold >100)

				{
					// Invalid id, set the response and exit.

					$response=array("code"=>400,"message"=>"Invalid input format for the parameter threshold, it should be integer value between 0 and 100.","fields"=>"store_id");
					echo json_encode($response);

					exit(1);
				}
			}	

			////date validation	

			if(isset($_GET['date']) && !empty($_GET['date']) ){

				if (count($scan_date_arr) > 1) {

					//echo $scan_date_arr[2];echo $scan_date_arr[1];echo $scan_date_arr[0];exit;

					if (checkdate($scan_date_arr[1],$scan_date_arr[2], $scan_date_arr[0])) {

						$date_format=true;

					} else {
						$response=array("code"=>400,"message"=>"Invalid input format for the parameter date. It should be in YYYY-MM-DD format.","fields"=>"date");
						echo json_encode($response);
						exit(1);
					}

				} else {
					$response=array("code"=>400,"message"=>"Invalid input format for the parameter date. It should be in YYYY-MM-DD format.","fields"=>"date");
					echo json_encode($response);
					exit(1);
				}
			}
			$this->load->model('invalidfacingmodel');

			$result=$this->invalidfacingmodel->viewAll($store_id,$date,$aisle,$upc_ean,$threshold);

			if($result->num_rows()==0){
				$response=array("code"=>404,"message"=>"Sorry no record found ","fields"=>"store_id");
				echo json_encode($response);
				exit(1);
			}
			$i=0;

			$j=1;

			foreach($result->result() as $data) {

				$timestamp=date("Y-m-dT H:i:s", strtotime($data->scan_date));

				$PROMO_DATE_START=date("Y-m-d T H:i:s", strtotime($data->PROMO_DATE_START));

				$PROMO_DATE_END=date("Y-m-d T H:i:s", strtotime($data->PROMO_DATE_END));

				$tmp['seq_no']=$j;

				$tmp['4d_seq_no']=$data->id;

				$tmp['date']=$timestamp;

				$tmp['invalid_facing_pro']=$data->upc_ean;

				$tmp['aisle']=$data->aisle;

				$tmp['store']=array('id'=>$data->store_id,'location'=>$data->location);

				$tmp['pro_ocr']=array('upc_ean'=>$data->upc_ean,'name'=>$data->name,'description'=>$data->description,'weight'=>$data->weight,'weight_unit'=>$data->weight_unit,'hor_fac'=>$data->HOR_FAC,'ver_fac'=>$data->VER_FAC,'tag_type'=>$data->tag_type,'promo_tag'=>$data->PROMO_TAG);
				$tmp["tag_position"]=array("x"=>$data->pri_shelf_tag_pos_dist_from_start_x,"y"=>$data->pri_shelf_tag_pos_dist_from_floor_y,"z"=>$data->pri_shelf_tag_pos_dist_from_isle_plane_z);

				$tmp["pro_position"]=array("x"=>$data->OCR_PROD_X,"y"=>$data->OCR_PROD_Y,"z"=>$data->OCR_PROD_z);
				$response[$i]=$tmp;

			$i++;

			$j++;

			}

			//$response["ocr"] = $tmp;

			

			echo json_encode($response);

		}elseif(empty($store_id) && $store_id==0){

			

			$response=array("code"=>400,"message"=>"A required input parameter is not provided store_id.","fields"=>"store_id");

			

			echo json_encode($response);

			

		}elseif(empty($date) && $date==0){
			$response=array("code"=>400,"message"=>"A required input parameter is not provided date.","fields"=>"date");
			echo json_encode($response);
		}else{
			$response=array("code"=>400,"message"=>"The required input parameters are not provided store and date.","fields"=>"date");
			echo json_encode($response);
		}

    }
}