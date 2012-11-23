<?php include ("head.php");?>
	<!-- Main content -->
	<section role="main" id="main">

		<noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

		<hgroup id="main-title" class="thin">
			<h1>Dashboard</h1>
			<h2><?php echo date("M");?> <strong><?php echo date("d");?></strong></h2>
		</hgroup>

		<div class="dashboard">

			<div class="columns">

				

				<div class="three-columns twelve-columns-mobile new-row-mobile">
					<ul class="stats split-on-mobile">
						<li><a href="#">
							<strong><?php echo $totalClients;?></strong> active <br>clients
						</a></li>
						<li><a href="#">
							<strong><?php echo $totalGroups;?></strong> current <br>groups
						</a></li>
						<li>
							<strong><?php echo $totalInvoices;?></strong> active <br>invoices
						</li>
						<li>
							<strong><?php echo $totalProducts;?></strong> total <br>products
						</li>
					</ul>
				</div>

			</div>

		</div>

		<div class="with-padding">

			<div class="columns">

				<div class="four-columns six-columns-tablet twelve-columns-mobile">

					<h2 class="relative thin">
						Active Invoices
						<span class="info-spot">
							<span class="icon-info-round"></span>
							<span class="info-bubble">
								Current Active Invoices.
							</span>
						</span>
                        
						
					</h2>

					<ul class="list spaced">
						<?php 
						if($_SESSION['authenticationType'] !=ADMINISTRATOR)
							$andWhere = "AND (uid='".USERID."' || uid='0')";
						else
							$andWhere = '';
		
						$query = $dbc->query("SELECT * FROM client_invoices WHERE invstatus='".UNPAID."' ".$andWhere." ORDER BY invduedate DESC");
						
						while($inv = $dbc->fetchList($query,RETURN_ARRAY)){
							$duedate=($inv['invduedate']);
							$daysoverdue=(strtotime("NOW")-$duedate);	
							$daysoverdue=round($daysoverdue/24/60/60);
							
							if($daysoverdue>14)
								$meter = '<span class="meter red-gradient"></span>
											<span class="meter red-gradient"></span>
											<span class="meter red-gradient"></span>
											<span class="meter red-gradient"></span>';
							
							elseif($daysoverdue>9 && $daysoverdue<14)
								$meter = '<span class="meter orange-gradient"></span>
											<span class="meter orange-gradient"></span>
											<span class="meter red-gradient"></span>
											<span class="meter red-gradient"></span>';
							elseif($daysoverdue>4 && $daysoverdue<9)
								$meter = '<span class="meter green-gradient"></span>
											<span class="meter green-gradient"></span>
											<span class="meter orange-gradient"></span>
											<span class="meter orange-gradient"></span>';
							else
							$meter = '<span class="meter green-gradient"></span>
											<span class="meter green-gradient"></span>
											<span class="meter green-gradient"></span>
											<span class="meter orange-gradient"></span>';
							
							$list.='<li>
							<a href="#" class="list-link icon-user" title="Click to view">'.$meter;
							$clientName = getClientName($inv['cid']);
							$list.="&nbsp;".limitLetters($clientName,15).'</a>
							
							
							<div class="button-group absolute-right compact show-on-parent-hover">
								<a href="Client-'.$inv['cid'].'.html" class="button icon-pencil">View</a>
								<a href="#" class="button icon-gear with-tooltip confirm" title="Mark Paid"></a>
								<a href="#" class="button icon-trash with-tooltip confirm" title="Delete"></a>
							</div>
							</li>
							';
											
						}
						echo $list;
						?>
						

					</ul>

				</div>

				

			</div>

		</div>

	</section>
	<!-- End main content -->

<?php include("footer.php");?>