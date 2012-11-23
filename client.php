<?php include("head.php");
$_SESSION['cid'] = '';
$cid = store($_GET['cid']);
if($cid)
$_SESSION['id'] = $_SESSION['cid'];

$client = $dbc->fetch("SELECT * FROM clients WHERE id='".$cid."'",RETURN_ARRAY);
if($client['company_name']!='')
$clientName = retrieve(limitLetters($client['company_name'],30));
else
$clientName = retrieve($client['first_name']." ".$client['last_name']);

if(trim($clientName==''))
$clientName = "New Client";

$query = $dbc->query("SELECT * FROM client_addresses WHERE cid='".$cid."'");
while($addr = $dbc->fetchList($query,RETURN_ARRAY)){
	
	if($addr['address_type']==6 && $addr['custom_address_type']!='')
	$addressType = retrieve($addr['custom_address_type']);
	elseif(($addr['address_type']==6 && $addr['custom_address_type']=='') || ($addr['address_type']=='' || $addr['address_type']=='0'))
	$addressType = 'Unknown Address Type';
	else{
		$rowAT = $dbc->fetch("SELECT * FROM client_addresses_type WHERE id='".$addr['address_type']."'",RETURN_ARRAY);
		$addressType = $rowAT['type'];
	}
							
	$addrList.= '<h3 class="thin underline">'.$addressType.'</h3>';
	$addrList.= '<p class="button-height inline-label">
							<label for="address_type" class="label">Address Type</label>'.
							addressTypes($addr['address_type'],$addr['custom_address_type'],$cid).'
							 <span class="textOnly">'.$addressType.'</span>';
	$addrList.="<input type='hidden' name='aid[]' value='".$addr['id']."'/>";						
	
	$addrList.=' <p class="button-height inline-label">
							<label for="address" class="label">Address</label>
							<input type="text" name="address[]" id="address" size="9" class="input editable full-width" value="'.retrieve($addr['address']).'">
                            <span class="textOnly">'.retrieve($addr['address']).'</span>
						</p>';	
	$addrList.=' <p class="button-height inline-label">
							<label for="suburb" class="label">Suburb</label>
							<input type="text" name="suburb[]" id="suburb" size="9" class="input editable full-width" value="'.retrieve($addr['suburb']).'">
                            <span class="textOnly">'.retrieve($addr['suburb']).'</span>
						</p>';	
	$addrList.=' <p class="button-height inline-label">
							<label for="postcode" class="label">Postcode</label>
							<input type="text" name="postcode[]" id="postcode" size="9" class="input editable full-width" value="'.retrieve($addr['postcode']).'">
                            <span class="textOnly">'.retrieve($addr['postcode']).'</span>
						</p>';
	$addrList.=' <p class="button-height inline-label">
							<label for="state" class="label">State</label>
							<input type="text" name="state[]" id="state" size="9" class="input editable full-width" value="'.retrieve($addr['state']).'">
                            <span class="textOnly">'.retrieve($addr['state']).'</span>
						</p>';
	$addrList.=' <p class="button-height inline-label">
							<label for="country" class="label">Country</label>
							<input type="text" name="country[]" id="country" size="9" class="input editable full-width" value="'.retrieve($addr['country']).'">
                            <span class="textOnly">'.retrieve($addr['country']).'</span>
						</p>';
}

?>
<!-- Main content -->
	<section role="main" id="main">

		<noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

		<hgroup id="main-title" class="thin">
			<h1><?php echo $clientName;?></h1>
		</hgroup>

		<div class="with-padding">

			
			<form method="post" action="" id="clientInfo" class="columns" onsubmit="return false">

				<div class="four-columns six-columns-tablet twelve-columns-mobile">
				

					<p class="wrapped button-height">
						<input type="checkbox" name="toggleEdit" id="toggleEdit" class="switch float-right" onchange="toggleEditForm(this.value)" value="1">
						Toggle Edit
					</p>
                    
					<h3 class="thin underline">Client Details</h3>

					<fieldset class="fieldset">
						<legend class="legend">Contact</legend>

						
						<?php if($cid!='')
							echo "<input type='hidden' name='id' value='".$cid."'/>";
						?>

						<p class="button-height inline-label">
							<label for="company_name" class="label">Company Name</label>
							<input type="text" name="company_name" id="company_name" size="9" class="input editable full-width" value="<?php echo retrieve($client['company_name']);?>">
                            <span class='textOnly'><?php echo retrieve($client['company_name']);?></span>
						</p>

						<p class="button-height inline-label">
							<label for="first_name" class="label">Contact Name</label>
							<input type="text" name="first_name" id="first_name" size="9" class="input editable" style="width:41%;" value="<?php echo retrieve($client['first_name']);?>" placeholder="First Name"> <input type="text" name="last_name" id="last_name" size="9" class="input editable"  style="width:41%;" value="<?php echo retrieve($client['last_name']);?>" placeholder="Last Name">
                           <span class='textOnly'><?php echo retrieve($client['first_name']);?> <?php echo retrieve($client['last_name']);?></span>
						</p>
                        <?php 
						echo getRelatedAddiFields('clients','contact','client','cid',$cid,true);
						?>
                       

					</fieldset>

					<fieldset class="fieldset">
						<legend class="legend">Contact Numbers</legend>

						 <p class="button-height inline-label">
							<label for="work_number" class="label">Work Number</label>
							<input type="text" name="work_number" id="work_number" size="9" class="input editable full-width" value="<?php echo retrieve($client['work_number']);?>">
                            <span class='textOnly'><?php echo retrieve($client['work_number']);?></span>
						</p>
                         <p class="button-height inline-label">
							<label for="mobile_number" class="label">Mobile Number</label>
							<input type="text" name="mobile_number" id="mobile_number" size="9" class="input editable full-width" value="<?php echo retrieve($client['mobile_number']);?>">
                            <span class='textOnly'><?php echo retrieve($client['mobile_number']);?></span>
						</p>
                        <p class="button-height inline-label">
							<label for="home_number" class="label">Home Number</label>
							<input type="text" name="home_number" id="home_number" size="9" class="input editable full-width" value="<?php echo retrieve($client['home_number']);?>">
                            <span class='textOnly'><?php echo retrieve($client['home_number']);?></span>
						</p>
                         <?php 
						echo getRelatedAddiFields('clients','phone','client','cid',$cid,true);
						?>
                       
					</fieldset>

					<fieldset class="fieldset">
                    <legend class="legend">Email</legend>
						 <p class="button-height inline-label">
							<label for="primary_email_address" class="label">Primary Email</label>
							<input type="text" name="primary_email_address" id="primary_email_address" size="9" class="input editable full-width" value="<?php echo retrieve($client['primary_email_address']);?>">
                            <span class='textOnly'><?php echo retrieve($client['primary_email_address']);?></span>
						</p>
                        <p class="button-height inline-label">
							<label for="secondary_email_address" class="label">Secondary Email</label>
							<input type="text" name="secondary_email_address" id="secondary_email_address" size="9" class="input editable full-width" value="<?php echo retrieve($client['secondary_email_address']);?>">
                            <span class='textOnly'><?php echo retrieve($client['secondary_email_address']);?></span>
						</p>
                         <?php 
						echo getRelatedAddiFields('clients','email','client','cid',$cid,true);
						?>
					</fieldset>
                    
                    <fieldset class="fieldset">
                    <legend class="legend">Address</legend>
						
                         <?php 
						echo $addrList;
						?>
					</fieldset>
                    <p class="button-height">
						<a href="#" class="button huge editable full-width" onclick="saveClient();return false">Save Client</a>
					</p>

				</div>

				
			

			</form>

		</div>

	</section>
    <script>
	function toggleEditForm(value){
		
		
			
			
			if($("#toggleEdit").attr('checked')) {
				
				$(".editable").show();
				$(".textOnly").hide();
			}
			else{
				
				$(".editable").hide();
				$(".textOnly").show();
				
				
			}
			
			
			
		
		
		
	}
	function toggleCustomAddressType(aid,option,addressId){
	
	
	if(option==6){//// if custom address type
	
	$("#custom_address_type"+addressId).show();
	}
	else{
		$("#custom_address_type"+addressId).hide();
		$("#custom_address_type"+addressId).val('');
	}
	
	
}

function saveClient(){
	

	
	$.post("/system/scripts/php/insert.php?act=1",$("#clientInfo").serialize(),function(json){
					
					
					
					
					if(json.type=='success'){
						
						$("#id").val(json.id);
						//window.location.hash="Client|"+json.id;
						//changePage("Client-"+json.id+".html");
						//setTimeout(function(){
						//alertNotice(json.type,json.message,10);
						//},1000)
						if(json.id!='')
						window.location.href="Client-"+json.id+".html";
						
					}
					
				},'json')
	
	
}
$(document).ready(function(){
		
		var cid='<?php echo $cid;?>';
		if(cid!=''){
		
			$(".editable").hide();
			$(".textOnly").show();
		}
})

	</script>
	<!-- End main content -->
	<?php include("footer.php");?>