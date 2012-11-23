	<!-- Side tabs shortcuts -->
    <?php if($_GET['cid']){?>
	<ul id="shortcuts" role="complementary" class="children-tooltip tooltip-right">
		<li class="current"><a href="./" class="shortcut-dashboard" title="Dashboard">Dashboard</a></li>
		<li><a href="inbox.html" class="shortcut-contacts" title="New Client">New Client</a></li>
		<!--<li><a href="agenda.html" class="shortcut-agenda" title="Agenda"></a></li>
		<li><a href="tables.html" class="shortcut-contacts" title="Contacts">Contacts</a></li>
		<li><a href="explorer.html" class="shortcut-medias" title="Medias">Medias</a></li>
		<li><a href="sliders.html" class="shortcut-stats" title="Stats">Stats</a></li>
		<li class="at-bottom"><a href="form.html" class="shortcut-settings" title="Settings">Settings</a></li>
		<li><span class="shortcut-notes" title="Notes">Notes</span></li>-->
	</ul>
    <?php }?>

	<!-- Sidebar/drop-down menu -->
	<section id="menu" role="complementary">

		<!-- This wrapper is used by several responsive layouts -->
		<div id="menu-content">
					<p class="button-height inline-label" style='margin:5px;'>
							
							<input type="text" name="searchTerm" id="searchTerm" size="9" class="input full-width " placeholder="Client Search">
						</p>
                 <div style='display:none;' id='searchResult'>
                 	
                    <div id='searchResultContent'>
                    	<ul class="big-menu"></ul>
                    
                    </div>
                 
                 </div>
			<header>
				<?php echo authName($_SESSION['authenticationType']);?>
			</header>

			<div id="profile">
				<img src="img/user.png" width="64" height="64" alt="User name" class="user-icon">
				Hello
				<span class="name"><?php echo $_SESSION['firstName'];?> <b><?php echo $_SESSION['lastName'];?></b></span>
			</div>

			<!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
			<ul id="access" class="children-tooltip">
				<li><a href="Client.html" title="New Client"><span class="icon-user"></span><span class="count">+</span></a></li>
				<!--<li><a href="calendars.html" title="Calendar"><span class="icon-user"></span></a></li>
				<li><a href="login.php" title="Logout"><span class="icon-user"></span></a></li>
				<li class="disabled"><span class="icon-gear"></span></li>-->
			</ul>

			

			

		</div>
		<!-- End content wrapper -->

		
		

	</section>
	<!-- End sidebar/drop-down menu -->

	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Scripts -->
	
	<script src="js/setup.js"></script>

	<!-- Template functions -->
	<script src="js/developr.input.js"></script>
	<script src="js/developr.message.js"></script>
	<script src="js/developr.modal.js"></script>
	<script src="js/developr.navigable.js"></script>
	<script src="js/developr.notify.js"></script>
	<script src="js/developr.scroll.js"></script>
	<script src="js/developr.tooltip.js"></script>
	<script src="js/developr.confirm.js"></script>
	
	<script src="js/developr.tabs.js"></script>		<!-- Must be loaded last -->

	<!-- Tinycon -->
	<script src="js/libs/tinycon.min.js"></script>

	<script>

		// Call template init (optional, but faster if called manually)
		$.template.init();

		

		
	

	
	
		


	

	
	
$(document).ready(function(){
			
			 $("#searchTerm").autocomplete({
		  
		  source: "/system/scripts/php/autocomplete.php?act=1",
		  minLength: 2,
		  search: function(event,ui){
				$("#searchResult").show();
				$("#searchResultContent ul").empty();
			},
			

	}).data('autocomplete')._renderItem = function(ul, item) {

    return $('<li/>')
   .data('item.autocomplete', item)
   .append("<a href='Client-"+item.id+".html'>"+item.value+"</a>")
   .appendTo($('#searchResultContent ul'));
   
	}
			
})
	</script>
</body>
</html>