<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('indexmodel');
		$this->load->library('cart');
		$this->data['category']= $this->indexmodel->getCategoryHome();
		$this->data['brand']= $this->indexmodel->getBrandHome();
	}
	public function index()
	{

		//$data['all product'] = $this->indexmodel->getallproduct();
		//var_dump($data);
		$this->data['allproduct']= $this->indexmodel->getAllProduct();
		$this->load->view('pages/template/header',$this->data);
		$this->load->view('pages/template/slider');
		$this->load->view('pages/home',$this->data);
		$this->load->view('pages/template/footer');
	}
	public function category($id)
	{
	
		$this->data['category_product']= $this->indexmodel->getCategoryProduct($id);
		$this->data['title']= $this->indexmodel->getCategoryTitle($id);
		$this->load->view('pages/template/header',$this->data);
		//$this->load->view('pages/template/slider');
		$this->load->view('pages/category',$this->data);
		$this->load->view('pages/template/footer');
	}
	public function brand($id)
	{
	
		$this->data['brand_product']= $this->indexmodel->getBrandProduct($id);
		$this->data['title']= $this->indexmodel->getBrandTitle($id);
		$this->load->view('pages/template/header',$this->data);
		//$this->load->view('pages/template/slider');
		$this->load->view('pages/brand',$this->data);
		$this->load->view('pages/template/footer');
	}
	public function product($id)
	{
		$this->data['product_details']= $this->indexmodel->getProductDetails($id);
		$this->load->view('pages/template/header',$this->data);
		// $this->load->view('pages/template/slider');
		$this->load->view('pages/product_details',$this->data);
		$this->load->view('pages/template/footer');
	}
	public function cart()
	{
		
		$this->load->view('pages/template/header');
		// $this->load->view('pages/template/slider');
		$this->load->view('pages/cart');
		$this->load->view('pages/template/footer');
	}
	public function checkout(){
		$this->load->view('pages/template/header');
		// $this->load->view('pages/template/slider');
		$this->load->view('pages/checkout');
		$this->load->view('pages/template/footer');
	}
	public function add_to_cart(){
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$this->data['product_details']= $this->indexmodel->getProductDetails($product_id);
		//dathang
		foreach($this->data['product_details'] as $key => $pro){
			$cart = array(
				'id'      => $pro->id,
				'qty'     => $quantity,
				'price'   => $pro->price,
				'name'    => $pro->title,
				'options' => array('image' => $pro->image )
			);
		}
		$this->cart->insert($cart);
		redirect(base_url().'gio-hang','refresh');
	}
	public function delete_all_cart(){
		$this->cart->destroy();
		redirect(base_url().'gio-hang','refresh');
	}

	public function update_cart_item(){
		$rowid =$this->input->post('rowid');
		$quantity = $this->input->post('quantity');
		foreach ($this->cart->contents() as $items ){
			if($rowid ==$items['rowid']){
				$cart = array(
					'rowid'  => $rowid,
					'qty'     => $quantity,
				);
			}
		}
		$this->cart->update($cart);
		redirect(base_url().'gio-hang','refresh');
	}

	public function delete_item($rowid){
		$this->cart->remove($rowid);
		redirect(base_url().'gio-hang','refresh');
	}

	public function login()
	{

		$this->load->view('pages/template/header');
		$this->load->view('pages/template/slider');
		$this->load->view('pages/login');
		$this->load->view('pages/template/footer');
	}

}
