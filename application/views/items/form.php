<style>
.myinput{
	width : 100%;
}
</style>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open('items/save/'.$item_info->item_id, array('id'=>'item_form', 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal')); ?>

<fieldset id="item_basic_info">
		<div class="form-group form-group-sm" style=display:none;>
			<?php echo form_label($this->lang->line('items_item_number'), 'item_number', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<div class="input-group">
					<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-barcode"></span></span>
					<?php echo form_input(array(
							'name'=>'item_number',
							'id'=>'item_number',
							'class'=>'form-control input-sm',
							'value'=>$item_info->item_number)
							);?>
				</div>
			</div>
		</div>

		<div class="form-group form-group-sm " name="name">
			<?php echo form_label($this->lang->line('items_name'), 'name', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_input(array(
						'name'=>'name',
						'id'=>'name',
						
						'class'=>'form-control input-sm',
						'value'=>$item_info->name)
						);?>
			</div>
		</div>

		<div id=onload="console.log('The Script will load now.')" class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_category'), 'category', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<div class="input-group">
					<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-tag"></span></span>
					<?php
						if($this->Appconfig->get('category_dropdown'))
						{
							echo form_dropdown('category', $categories, $selected_category, array('class'=>'form-control','id'=>'category'));
						}
						else
						{
							echo form_input(array(
								'name'=>'category',
								'id'=>'category',
								'class'=>'form-control input-sm',
								'value'=>$item_info->category)
								);
						}
					?>
				</div>
			</div>
		</div>

		
		<div class="form-group form-group-sm" >
			<?php echo form_label($this->lang->line('items_stock_type'), 'stock_type', !empty($basic_version) ? array('class'=>'required control-label col-xs-3') : array('class'=>'control-label col-xs-3')); ?>
			<div class="col-xs-8">
				<label class="radio-inline">
					<?php echo form_radio(array(
							'name'=>'stock_type',
							'type'=>'radio',
							'id'=>'stock_type',
							'value'=>0,
							'checked'=>$item_info->stock_type == HAS_STOCK)
					); ?> <?php echo $this->lang->line('items_stock'); ?>
				</label>
				<label class="radio-inline">
					<?php echo form_radio(array(
							'name'=>'stock_type',
							'type'=>'radio',
							'id'=>'stock_type',
							'value'=>1,
							'checked'=>$item_info->stock_type == HAS_NO_STOCK)
					); ?><?php echo $this->lang->line('items_nonstock'); ?>
				</label>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_type'), 'item_type', !empty($basic_version) ? array('class'=>'required control-label col-xs-3') : array('class'=>'control-label col-xs-3')); ?>
			<div class="col-xs-8">
				<label class="radio-inline">
					<?php
						$radio_button = array(
							'name'=>'item_type',
							'type'=>'radio',
							'id'=>'item_type',
							'value'=>0,
							'checked'=>$item_info->item_type == ITEM);
						if($standard_item_locked)
						{
							$radio_button['disabled'] = TRUE;
						}
						echo form_radio($radio_button); ?> <?php echo $this->lang->line('items_standard'); ?>
				</label>
				<label class="radio-inline">
					<?php
						$radio_button = array(
							'name'=>'item_type',
							'type'=>'radio',
							'id'=>'item_type',
							'value'=>1,
							'checked'=>$item_info->item_type == ITEM_KIT);
						if($item_kit_disabled)
						{
							$radio_button['disabled'] = TRUE;
						}
						echo form_radio($radio_button); ?> <?php echo $this->lang->line('items_kit');
					?>
				</label>
				<?php
				if($this->config->item('derive_sale_quantity') == '1')
				{
				?>
					<label class="radio-inline">
						<?php echo form_radio(array(
								'name' => 'item_type',
								'type' => 'radio',
								'id' => 'item_type',
								'value' => 2,
								'checked' => $item_info->item_type == ITEM_AMOUNT_ENTRY)
						); ?><?php echo $this->lang->line('items_amount_entry'); ?>
					</label>
				<?php
				}
				?>
				<?php
				if($allow_temp_item == 1)
				{
				?>
					<label class="radio-inline">
						<?php echo form_radio(array(
								'name'=>'item_type',
								'type'=>'radio',
								'id'=>'item_type',
								'value'=>3,
								'checked'=>$item_info->item_type == ITEM_TEMP)
						); ?> <?php echo $this->lang->line('items_temp'); ?>
					</label>
				<?php
				}
				?>
			</div>
		</div>

		

		

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_cost_price'), 'cost_price', array('class'=>'required control-label col-xs-3')); ?>
			<div class="col-xs-4">
				<div class="input-group input-group-sm">
					
					<?php echo form_input(array('type'=>'number', 'min'=>1,
							'name'=>'cost_price',
							'id'=>'cost_price',
							'class'=>'form-control input-sm',
							'onClick'=>'this.select();',
							'value'=>$item_info->cost_price)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="form-group form-group-sm" id="salespricediv">
			<?php echo form_label($this->lang->line('items_unit_price'), 'unit_price', array('class'=>'required control-label col-xs-3')); ?>
			<div class='col-xs-4'>
				<div class="input-group input-group-sm">
					<?php if (!currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
					<?php echo form_input(array('type'=>'number', 'min'=>1,
							'name'=>'unit_price',
							'id'=>'unit_price',
							'class'=>'form-control input-sm',
							'onClick'=>'this.select();',
							'value'=>$item_info->unit_price)
							);?>
					<?php if (currency_side()): ?>
						<span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
					<?php endif; ?>
				</div>
			</div>
		</div>		
		<div>	
		
    	<div id="dynamic">

					</div>

		</div>		
			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('items_hsn_code'), 'category', array('class'=>' required control-label col-xs-3')); ?>
				<div class='col-xs-8'>
					<div class="input-group">
						<?php echo form_input(array(
								'name'=>'hsn_code',
								'id'=>'hsn_code',
								'class'=>'required form-control input-sm',
								'value'=>$item_info->hsn_code)
						);?>
					</div>
				</div>
			</div>

		<?php
		if(!$use_destination_based_tax)
		{
		?>
			<div class="form-group form-group-sm" style=display:none;>
				<?php echo form_label($this->lang->line('items_tax_1'), 'tax_percent_1', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-4'>
					<?php echo form_input(array(
							'name'=>'tax_names[]',
							'id'=>'tax_name_1',
							'class'=>'required form-control input-sm',
							'value'=>isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : $this->config->item('default_tax_1_name'))
							);?>
				</div>
				<div class="col-xs-4">
					<div class="input-group input-group-sm" style=display:none;>
						<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_1',
								'class'=>'form-control input-sm',
								'value'=>isset($item_tax_info[0]['percent']) ? to_tax_decimals($item_tax_info[0]['percent']) : to_tax_decimals($default_tax_1_rate))
								);?>
						<span class="input-group-addon input-sm"><b>%</b></span>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm" style=display:none;>
				<?php echo form_label($this->lang->line('items_tax_2'), 'tax_percent_2', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-4'>
					<?php echo form_input(array(
							'name'=>'tax_names[]',
							'id'=>'tax_name_2',
							'class'=>'form-control input-sm',
							'value'=>isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : $this->config->item('default_tax_2_name'))
							);?>
				</div>
				<div class="col-xs-4">
					<div class="input-group input-group-sm" style=display:none;>
						<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'class'=>'form-control input-sm',
								'id'=>'tax_percent_name_2',
								'value'=>isset($item_tax_info[1]['percent']) ? to_tax_decimals($item_tax_info[1]['percent']) : to_tax_decimals($default_tax_2_rate))
								);?>
						<span class="input-group-addon input-sm"><b>%</b></span>
					</div>
				</div>
			</div>
		<?php
		}
		?>

		<?php if($use_destination_based_tax): ?>
			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('taxes_tax_category'), 'tax_category', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-8'>
					<div class="input-group input-group-sm" style=display:none;>
						<?php echo form_input(array(
								'name'=>'tax_category',
								'id'=>'tax_category',
								'class'=>'form-control input-sm',
								'size'=>'50',
								'value'=>$tax_category)
						); ?>
						<?php echo form_hidden('tax_category_id', $tax_category_id); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if($include_hsn): ?>
			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('items_hsn_code'), 'category', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-8'>
					<div class="input-group">
						<?php echo form_input(array(
								'name'=>'hsn_code',
								'id'=>'hsn_code',
								'class'=>'form-control input-sm',
								'value'=>$hsn_code)
						);?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php
		foreach($stock_locations as $key=>$location_detail)
		{
		?>
			<div class="form-group form-group-sm" id="stock_qty">
				<?php echo form_label($this->lang->line('items_quantity'), 'quantity_' . $key, array('class'=>'required control-label col-xs-3')); ?>
				<div class='col-xs-4'>
					<?php echo form_input(array(
							'name'=>'quantity_' . $key,
							'id'=>'quantity_' . $key,
							'class'=>'required quantity form-control',
							'onClick'=>'this.select();',
							'value'=>isset($item_info->item_id) ? to_quantity_decimals($item_info->receiving_quantity) : to_quantity_decimals(0))
							);?>
				</div>
			</div>
		<?php
		}
		?>

		<div class="form-group form-group-sm" id="receiving_quantity_display">
			<?php echo form_label($this->lang->line('items_receiving_quantity'), 'receiving_quantity', array('class'=>' control-label col-xs-3')); ?>
			<div class='col-xs-4'>
				<?php echo form_input(array(
						'name'=>'receiving_quantity',
						'id'=>'receiving_quantity',
						'class'=>'required form-control input-sm',
						'onClick'=>'this.select();',
						'value'=>isset($item_info->item_id) ? to_quantity_decimals($item_info->receiving_quantity) : to_quantity_decimals(0))
						);?>
			</div>
		</div>
		<div class="form-group form-group-sm" id="supplierdiv">
			<?php echo form_label($this->lang->line('items_supplier'), 'supplier', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_dropdown('supplier_id', $suppliers, $selected_supplier, array('id'=>'supplier_id' ,'class'=>'form-control')); ?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_reorder_level'), 'reorder_level', array('class'=>' control-label col-xs-3')); ?>
			<div class='col-xs-4'>
				<?php echo form_input(array(
						'name'=>'reorder_level',
						'id'=>'reorder_level',
						'class'=>'form-control input-sm',
						'onClick'=>'this.select();',
						'value'=>isset($item_info->item_id) ? to_quantity_decimals($item_info->reorder_level) : to_quantity_decimals(0))
						);?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_description'), 'description', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_textarea(array(
						'name'=>'description',
						'id'=>'description',
						'class'=>'form-control input-sm',
						'value'=>$item_info->description)
						);?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_image'), 'items_image', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<div class="fileinput <?php echo $logo_exists ? 'fileinput-exists' : 'fileinput-new'; ?>" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;"></div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100px; max-height: 100px;">
						<img data-src="holder.js/100%x100%" alt="<?php echo $this->lang->line('items_image'); ?>"
							 src="<?php echo $image_path; ?>"
							 style="max-height: 100%; max-width: 100%;">
					</div>
					<div>
						<span class="btn btn-default btn-sm btn-file">
							<span class="fileinput-new"><?php echo $this->lang->line("items_select_image"); ?></span>
							<span class="fileinput-exists"><?php echo $this->lang->line("items_change_image"); ?></span>
							<input type="file" name="item_image" accept="image/*">
						</span>
						<a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><?php echo $this->lang->line("items_remove_image"); ?></a>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_branch'), 'branch', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
			<select name="branch" id="branch"  class='form-control'>
                <option value="" >--Select Branch--</option >
                <option value="Madurai" >Madurai</option>
                <option value="Salem" >Salem</option>
                <option value="Chennai" >Chennai</option>
                <option value="Namakkal" >Namakkal</option>
      </select>
			</div>
		</div>
		
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_location'), 'location', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_input(array(
						'name'=>'location',
						'id'=>'location',
						'class'=>'form-control input-sm',
						'value'=>$item_info->location)
				);?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_rack'), 'rack', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_input(array(
						'name'=>'rack',
						'id'=>'rack',
						'class'=>'form-control input-sm',
						'value'=>$item_info->rack)
				);?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_bin'), 'bin', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
				<?php echo form_input(array(
						'name'=>'bin',
						'id'=>'bin',
						'class'=>'form-control input-sm',
						'value'=>$item_info->bin)
				);?>
			</div>
		</div>

		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('items_pack_type'), 'pack_type', array('class'=>'control-label col-xs-3')); ?>
			<div class='col-xs-8'>
			<select name="pack_type" id="pack_type"  class='form-control'>
                <option value="" >--Select Pack Type--</option >
                <option value="Pieces" >Pieces</option>
                <option value="Dozens" >Dozens</option>
                <option value="Pairs" >Pairs</option>
                <option value="Box" >Box</option>
      </select>
			</div>
		</div>	

		<?php
		if($this->config->item('multi_pack_enabled') == '1')
		{
			?>
			
			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('items_pack_name'), 'name', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-8'>
					<?php echo form_input(array(
							'name'=>'pack_name',
							'id'=>'pack_name',
							'class'=>'form-control input-sm',
							'value'=>$item_info->pack_name)
					);?>
				</div>
			</div>
			<div class="form-group  form-group-sm">
				<?php echo form_label($this->lang->line('items_low_sell_item'), 'low_sell_item_name', array('class'=>'control-label col-xs-3')); ?>
				<div class='col-xs-8'>
					<div class="input-group input-group-sm">
						<?php echo form_input(array(
								'name'=>'low_sell_item_name',
								'id'=>'low_sell_item_name',
								'class'=>'form-control input-sm',
								'value'=>$selected_low_sell_item)
						); ?>
						<?php echo form_hidden('low_sell_item_id', $selected_low_sell_item_id);?>
					</div>
				</div>
			</div>
			<?php
		}
		?>	

	</fieldset>
	<?php
			
			$j = 0;
			foreach($customer_category_inform as $supplier)
			{
			$category_info[$j] = $supplier['customer_category_name'];		
			$j++;			
			}

			?>
	<?php
			$k = 0;
			foreach($customer_category_id as $supplier)
			{
			$category_info_new[$k] = $supplier['customer_category_id'];		
			$k++;			
			}
			
			?>


<?php
			$new = 0;
			foreach($fetch_item_id as $supplier)
			{
			$item_id_new[$new] = $supplier['item_id'];		
			$new++;	
				
			}

			// $item_id_new_counter = $item_id_new[$new-1] + 1;

			?>


<?php
			//echo $item_customer_category_price_fetch;


			$one = 0;
			$check_name = $item_info->name;	
			$check_null_flag = 2;
			$check_item_id_null = 2;
			$f = 0;
			$customer_category_price_fetched=array();
			if($check_name == "")
			{
				$check_null_flag = 0;//add mode
			}
			else
			{
				if($item_customer_category_price_fetch == "null"){
					
					$check_item_id_null = 1;
				}else{
					foreach($item_customer_category_price_fetch as $supplier)
					{
					$customer_category_price_fetched[$f] = $supplier['sales_price'];//edit		
					$f++;				
					}
					
				}
					
		
				$check_null_flag =1;
				
			}

			$arg_fun = $check_null_flag."..".$check_name;

			
			
			
			


			?>

<?php echo form_close(); ?>

<script type="text/javascript">

	


	

function stock_quantity_editable_fun(){
	var stk_qty = document.getElementById("stock_qty");
	var sup_disp = document.getElementById("supplierdiv");
	var stock_quantity_editable = document.getElementById("quantity_1");
	var name =document.getElementById("name");
	var flag = <?php echo $check_null_flag; ?>;

	if(flag == 0){
		//alert("new");
		stk_qty.style.display = "none";
		
	}
	if(flag == 1){
		//alert("edit");
		stock_quantity_editable.setAttribute('readonly',true);
		sup_disp.style.display = "none";
		name.setAttribute('readonly',true);


		
	}

}




function receiving_quantity_display_fun(){
	var receiving_quantity_display = document.getElementById("receiving_quantity_display");
	var flag = <?php echo $check_null_flag; ?>;

	if(flag == 0){
		
	}
	if(flag == 1){
		
		receiving_quantity_display.style.display = "none";
	}

}

function addFields()
{
            var number =<?php echo $customer_category_num; ?>
		
            var container = document.getElementById("dynamic");
			


			var jQueryArray = <?php echo json_encode($category_info); ?>;

			var jQueryArray2 = <?php echo json_encode($category_info_new); ?>;
			var flag = <?php echo $check_null_flag; ?>;	


			var check_itemid_null = <?php echo $check_item_id_null; ?>;
				
		
			var sale_price=<?php echo json_encode($customer_category_price_fetched); ?>;
		// console.log(sale_price.length);
		if(flag==1)
		{
			var jQueryArray3 = <?php echo json_encode($customer_category_price_fetched); ?>;
			var jQueryArray3_counter = <?php echo $f; ?>;
					
		}
			
            while (container.hasChildNodes())
		 {
                container.removeChild(container.lastChild);
         }
            for (i=0;i<number;i++)
		{
			let string1 = "Sales Price for Customer category - " + jQueryArray[i];
			
			if(flag == 0)
			{
				//addmode
				 $("#salespricediv").after('<div class="form-group form-group-sm"><label class=" control-label col-xs-3">'+string1 + '</label><div class="col-xs-4"><div class="input-group input-group-sm"><?php if (!currency_side()): ?><span class="input-group-addon input-sm"><b><?php echo "₹"; ?></b></span><?php endif; ?><input type="text" name="customer_category_price_'+i+'" value="0" id="customer_category_price_'+i+'" class="form-control input-sm" value="<?php echo $item_info->location; ?>" onclick="this.select(); "></div></div></div>');
				 
			 }
			 if(flag==1)
			 {
				//editmode
				
				
				if(check_itemid_null == 2){

					if(typeof jQueryArray3[i] === 'undefined'){
						jQueryArray3[i] = 0;
					}

					// if(typeof myVar !== 'undefined'){
					// 	console.log(jQueryArray3[i]);
					// }
								
				 $("#salespricediv").after('<div class="form-group form-group-sm"><label class=" control-label col-xs-3">'+string1 + '</label><div class="col-xs-4"><div class="input-group input-group-sm"><?php if (!currency_side()): ?><span class="input-group-addon input-sm"><b><?php echo "₹"; ?></b></span><?php endif; ?><input type="text" name="customer_category_price_'+i+'" value="'+jQueryArray3[i]+'" id="customer_category_price_'+i+'" class="form-control input-sm" value="<?php echo $item_info->location; ?>" onclick="this.select(); "></div></div></div>');
				}
				if(check_itemid_null == 1){
					$("#salespricediv").after('<div class="form-group form-group-sm"><label class=" control-label col-xs-3">'+string1 + '</label><div class="col-xs-4"><div class="input-group input-group-sm"><?php if (!currency_side()): ?><span class="input-group-addon input-sm"><b><?php echo "₹"; ?></b></span><?php endif; ?><input type="text" name="customer_category_price_'+i+'" value="0" id="customer_category_price_'+i+'" class="form-control input-sm" value="<?php echo $item_info->location; ?>" onclick="this.select(); "></div></div></div>');
				}


			 }
				 $("#salespricediv").after('<div class="form-group form-group-sm"  style=display:none;><label class=" control-label col-xs-3">'+jQueryArray[i] + '</label><div class="col-xs-4"><div class="input-group input-group-sm"><input type="text" value="'+jQueryArray2[i]+'" name="customer_category_name_'+i+'" id="customer_category_price_'+i+'" class="form-control input-sm"  onclick="this.select();"></div></div></div>');

				 $("#salespricediv").after('<div class="form-group form-group-sm" style=display:none;><label class=" control-label col-xs-3">'+number + '</label><div class="col-xs-4"><div class="input-group input-group-sm"><input type="text" value="'+number+'" name="counter" id="customer_category_price_'+i+'" class="form-control input-sm" onclick="this.select();"></div></div></div>');

				
				
            }
  }



//validation and submit handling
$(document).ready(function()
{ 
	
	stock_quantity_editable_fun();
	receiving_quantity_display_fun();
	addFields();
	
$('#supplierdiv').hide();
	$('#new').click(function() {
		
		stay_open = true;
		$('#item_form').submit();
	});
	
	$('#submit').click(function() {
	
		stay_open = false;
	
	});
	$('#receiving_quantity').change(function(){
	var receiving_qty=$('#receiving_quantity').val();
		if(receiving_qty == 0)
		{
			$('#supplierdiv').hide();
		}
		else{
		$('#supplierdiv').show();
		}
	});

	$("input[name='tax_category']").change(function() {
		!$(this).val() && $(this).val('');
	});
	

	var fill_value = function(event, ui) {
		event.preventDefault();
		$("input[name='tax_category_id']").val(ui.item.value);
		$("input[name='tax_category']").val(ui.item.label);
	};

	$('#tax_category').autocomplete({
		source: "<?php echo site_url('taxes/suggest_tax_categories'); ?>",
		minChars: 0,
		delay: 15,
		cacheLength: 1,
		appendTo: '.modal-content',
		select: fill_value,
		focus: fill_value
	});

	var fill_value = function(event, ui) {
		event.preventDefault();
		$("input[name='low_sell_item_id']").val(ui.item.value);
		$("input[name='low_sell_item_name']").val(ui.item.label);
	};

	$('#low_sell_item_name').autocomplete({
		source: "<?php echo site_url('items/suggest_low_sell'); ?>",
		minChars: 0,
		delay: 15,
		cacheLength: 1,
		appendTo: '.modal-content',
		select: fill_value,
		focus: fill_value
	});


	$('#category').load(function(){

			});

	$('#category').autocomplete({
		source: "<?php echo site_url('items/suggest_category');?>",
		delay: 10,
		appendTo: '.modal-content'
	});

	$('a.fileinput-exists').click(function() {
		$.ajax({
			type: 'GET',
			url: '<?php echo site_url("$controller_name/remove_logo/$item_info->item_id"); ?>',
			dataType: 'json'
		})
	});

	$.validator.addMethod('valid_chars', function(value, element) {
		return value.match(/(\||_)/g) == null;
	}, "<?php echo $this->lang->line('attributes_attribute_value_invalid_chars'); ?>");

	var init_validation = function() {
		
		$('#item_form').validate($.extend({
			// alert($('#receiving_quantity'),val());
			submitHandler: function(form, event) {
				
				$(form).ajaxSubmit({
					
					success: function(response) {
						console.log('success');
						var stay_open = dialog_support.clicked_id() != 'submit';
						// console.log('hi');
						if(stay_open)
						{  
							// alert($('#receiving_quantity').val());
							console.log('if');
							// set action of item_form to url without item id, so a new one can be created
							$('#item_form').attr('action', "<?php echo site_url('items/save/')?>");
							// use a whitelist of fields to minimize unintended side effects
							$(':text, :password, :file, #description, #item_form').not('.quantity, #reorder_level, #tax_name_1, #receiving_quantity, ' +
								'#tax_percent_name_1, #category, #reference_number, #name, #cost_price, #unit_price, #taxed_cost_price, #taxed_unit_price, #definition_name, [name^="attribute_links"]').val('');
							// de-select any checkboxes, radios and drop-down menus
							$(':input', '#item_form').removeAttr('checked').removeAttr('selected');
						}
						else
						{
							 console.log('else');
							dialog_support.hide();
						}
						// console.log(response);
					  console.log('out of else');
						table_support.handle_submit('<?php echo site_url('items'); ?>', response, stay_open);
						 window.location.reload();
						init_validation();
						
					},
					
					dataType: 'json'
				});
			},
			
			errorLabelContainer: '#error_message_box',

rules:
{
	supplier_id: 'required',
	hsn_code:
	{
	required: true,
		remote: 
		{
			
			url: "<?php echo site_url($controller_name . '/hsn_code_check')?>",
			type: 'POST',
			data: {
				
				'hsn_code' : function()
				{
				
					// alert($('#hsn_code').val());
					 return  $('#hsn_code').val();
				}	
			},
		}
	},
	
	name:
	{
		required: true,
		remote: {
			url: "<?php echo site_url($controller_name . '/item_name_stringcmp')?>",
			type: 'POST',
			data: {
				'item_name' : "<?php echo $item_info->name; ?>",
				'mode' : "<?php echo $check_null_flag; ?>",
				'name' : function()
				{ 
					return $('#name').val();
				},
			}
		}
	},
	
	 
	category:
	{
		required: true,
		remote: 
		{
			
			url: "<?php echo site_url($controller_name . '/category_name_stringcmp/'.$one)?>",
			type: 'POST',
			data: {
				
				'category' : function()
				{
				
					//alert($('#category').val());
					 return  $('#category').val();
				},
		}
	}
		


	},

	item_number:
	{
		required: false,
		remote:
		{
			url: "<?php echo site_url($controller_name . '/check_item_number')?>",
			type: 'POST',
			data: {
				'item_id' : "<?php echo $item_info->item_id; ?>",
				'item_number' : function()
				{ 
					return $('#item_number').val();
				},
			}
		}
	},
	
	cost_price:
	{	
		
		
		required: true,
		remote: 
		{
			url: "<?php echo site_url($controller_name . '/cost_price_validate')?>",
			type: 'POST',
			data: {
						
						'cost_price' : function()
						{
						
							//alert($('#category').val());
							return  $('#cost_price').val();
						},
				}
		}
	},
	unit_price:
	{
		
		required: true,
		remote: 
		{
			url: "<?php echo site_url($controller_name . '/sale_price_validate')?>",
			type: 'POST',
			data: {
						
						'unit_price' : function()
						{
						
							//alert($('#category').val());
							return  $('#unit_price').val();
						},
				}

		}
	},
	<?php
	foreach($stock_locations as $key=>$location_detail)
	{
	?>
	<?php echo 'quantity_' . $key ?>:
		{
			required: true,
			remote: "<?php echo site_url($controller_name . '/check_numeric')?>"
		},
	<?php
	}
	?>
	receiving_quantity:
	{
		required: true,
		remote: "<?php echo site_url($controller_name . '/check_numeric');?>"
	},
	reorder_level:
	{
		required: true,
		remote: "<?php echo site_url($controller_name . '/check_numeric');?>"
	},
	tax_percent:
	{
		required: true,
		remote: "<?php echo site_url($controller_name . '/check_numeric');?>"
	}
},

messages:
{
	hsn_code:
	{
		required: "<?php echo $this->lang->line('hsn_code_required'); ?>",
		remote:"Your hsn code  is not in database please add this hsn code in database or enter other hsn code"

	},
	supplier_id:
	{
		required: "<?php echo $this->lang->line('supplier_name_required'); ?>"

	},
	
	name:
	{ 
		required:  "<?php echo $this->lang->line('items_name_required'); ?>",
		remote: "<?php echo $this->lang->line('item_name_message'); ?>",
	},
	item_number: "<?php echo $this->lang->line('items_item_number_duplicate'); ?>",
	category:{
		required: "<?php echo $this->lang->line('items_category_required'); ?>",
		remote: "<?php echo $this->lang->line('items_category_exits'); ?>",

	},
	 
	cost_price:
	{
		required: "<?php echo $this->lang->line('items_cost_price_required'); ?>",
		remote: "<?php echo $this->lang->line('items_cost_price_number'); ?>"
	},
	unit_price:
	{
		required: "<?php echo $this->lang->line('items_unit_price_required'); ?>",
		remote: "<?php echo $this->lang->line('items_unit_price_number'); ?>"
	},
	<?php
	foreach($stock_locations as $key=>$location_detail)
	{
	?>
	<?php echo 'quantity_' . $key ?>:
		{
			required: "<?php echo $this->lang->line('items_quantity_required'); ?>",
			number: "<?php echo $this->lang->line('items_quantity_number'); ?>"
		},
	<?php
	}
	?>
	receiving_quantity:
	{
		required: "<?php echo $this->lang->line('items_quantity_required'); ?>",
		number: "<?php echo $this->lang->line('items_quantity_number'); ?>"
	},
	reorder_level:
	{
		required: "<?php echo $this->lang->line('items_reorder_level_required'); ?>",
		number: "<?php echo $this->lang->line('items_reorder_level_number'); ?>"
	},
	tax_percent:
	{
		required: "<?php echo $this->lang->line('items_tax_percent_required'); ?>",
		number: "<?php echo $this->lang->line('items_tax_percent_number'); ?>"
	}
}
}, form_support.error));
};

init_validation();

});
</script>


