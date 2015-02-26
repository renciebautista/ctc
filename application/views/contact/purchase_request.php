

<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Purchase Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>Thank you for your interest in our products and services. Please fill in the following information and a Chasetech Representative will contact you to answer questions and provide the information you require.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<div>
			<h2>Information Details</h2>
		</div>
		<hr>

		<div class="field">
			<label class="meduim" for="client">Client Name</label>
			<input class="input" id="client" name="client" type="text" value="<?php echo set_value('client');?>"/>
			<?php echo form_error('client'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="salesorder">Sales Order #</label>
			<input class="input" id="salesorder" name="salesorder" type="text" value="<?php echo set_value('salesorder');?>"/>
			<?php echo form_error('salesorder'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="requestor">Requested By</label>
			<input maxlength="35" class="input" id="requestor" name="requestor" type="text" value="<?php echo set_value('requestor');?>"/>
			<?php echo form_error('requestor'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>
		

		<br>
		<div>
			<h2>Items</h2>
		</div>
		<hr>
		<div id="field">
	        <table id="field_grid">
	            <tr class="odd">
	                <th style="text-align:center;">Barcode</th>
	                <th style="text-align:center;">Description</th>
	                <th style="text-align:center;">Qty</th>
	                <th style="text-align:center;">Remarks</th>
	            </tr>
	            <tr>
	                <td> 
	                    <input style="width:100px; margin-left:-5px;" type="text" value=""  name="barcode[]" placeholder="Barcode" />
	                </td>
	                <td>
	                    <input style="width:250px; margin-left:5px;" type="text" value=""  name="desc[]" placeholder="Description" />
	                </td>
	                 <td>
	                 	<input style="width:40px; margin-left:5px;" type="text" value="" class="num" name="qty[]" placeholder="Qty" />
	                 </td>
	                 <td>
	                    <input style="width:150px; margin-left:5px;" type="text" value=""  name="remarks[]" placeholder="Remarks" />
	                </td>
	                <td>
	                    <a href="#" class="btn-remove">Delete</a>
	                </td>

	        </tr>
	        </table>
	    </div>
	    <div class="action-buttons btn-group">
	        <button id="add_field">Add Field</button>
	    </div>

		<?php $this->load->view('shared/file_attach'); ?>

		<?php $this->load->view('shared/anti_spam'); ?>

		<div class="field">
			<input type="submit" class="submit" value="Submit">
		</div>
	<?php echo form_close(); ?>
	
	</div>
</div>



<script type="text/javascript">
$(document).ready(function() {
	$("#form").validate({
		errorElement: "span", 
		//set the rules for the field names
		rules: { 
			client: { required: true },
			salesorder: { required: true },
			requestor: { required: true },
			email: { required: true,email: true },
			captcha: { required: true}
		},
		messages: {
        captcha: "Security code is required."
        
    	},
		errorPlacement: function(error, element) {               
			error.appendTo(element.parent());     
			// error.appendTo('#error-' + element.attr('id'));
		}
	});

	function addField() {
        var row = '<tr>';
	        row += '<td>';
	        row += '<input style="width:100px; margin-left:-5px;" type="text" value=""  name="barcode[]" placeholder="Barcode" />';
	        row += '</td>';
	        row += '<td>';
	        row += '<input style="width:250px; margin-left:5px;" type="text" value=""  name="desc[]" placeholder="Description" />';
	        row += '</td>';
	        row += '<td>';
	        row += '<input style="width:40px; margin-left:5px;" type="text" value="" class="num" name="qty[]" placeholder="Qty" />';
	        row += '</td>';
	        row += '<td>';
	        row += '<input style="width:150px; margin-left:5px;" type="text" value=""  name="remarks[]" placeholder="Remarks" />';
	        row += '</td>';
	        row += '<td>';
	        row += '<a href="#" class="btn-remove">Delete</a>';
	        row += '</td>';
	        row += '</tr>';
        $('#field_grid tbody').append(row);

        $( ".num" ).each(function() {
			$( this ).numericonly();
		});
        // $('#field_grid').find("tr:nth-child(odd)").removeClass('even').removeClass('odd').addClass("odd");
        // $('#field_grid').find("tr:nth-child(even)").removeClass('even').removeClass('odd').addClass("even");
    }
 
    function removeField(o) {
        if ($(o).parents('tbody').find('tr').length <= 2) {
            addField();
        }
        $(o).parents('tr').remove();
    }

	$('#add_field').on('click', function(e) {
        addField();
        return e.preventDefault();
    });

     $('#field_grid').on('click', '.btn-remove', function(e) {
        removeField(e.target);
        return e.preventDefault();
    });

    $( ".num" ).each(function() {
		$( this ).numericonly();
	});

});
</script>