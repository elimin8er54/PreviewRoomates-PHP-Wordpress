<?php
/*
Template Name: Search Property
*/
?>
<?php get_header();


		?>
		  <link rel="stylesheet" href="<?php echo THEME_DIR ?>/assets/front/colorlib-search-9/css/main.css?v=2">
			<script src="<?php echo THEME_DIR; ?>/assets/front/colorlib-search-9/js/main.js"> </script>
			<script src="<?php echo THEME_DIR; ?>/assets/front/colorlib-search-9/js/extention/choices.js"> </script>
			<script src="<?php echo THEME_DIR; ?>/assets/front/colorlib-search-9/js/extention/custom-materialize.js"> </script>
			<script src="<?php echo THEME_DIR; ?>/assets/front/colorlib-search-9/js/extention/flatpickr.js"> </script>
		
		<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<div class="block_content">
<div class="s009">
      <form id='propertysearch_form' name="propertysearch_form">
        <div class="inner-form">
          <div class="basic-search">
            <div class="input-field">
            
            </div>
          </div>
          <div class="advance-search">
         
		
            <div class="row">
              <div class="input-field">
			  <p>Rent</p>
                <div class="input-select">
                   <input name="budget-min" size="4" type="text" placeholder="Min"> to
				   <input name="budget-max" size="5" type="text" placeholder="Max">
                </div>
				
                  
               
              </div>
              <div class="input-field">
			    <p >Available</p>
                <div class="input-select">
				<input type="checkbox" name="is-custom-move" checked value="yes"> Any
                 
				  <select data-trigger="" name="move-in-month">
                    <option placeholder="" value="">Month</option>
                    <?php for($i=1;$i<=12;$i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php } ?>
                  </select>
				  <select data-trigger="" name="move-in-year">
                    <option placeholder="" value="">Year</option>
                    <?php for($i=date("Y");$i<=date("Y")+2;$i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
             <div class="input-field">
			   <p >Pets</p>
                <div class="input-select">
				  <input value="any" type="radio" checked name="pref-pet">Don't care
                  <input value="Pets" type="radio"  name="pref-pet" >Pets OK
                  <input value="NoPets" type="radio" name="pref-pet" >No Pets
                
                 
                </div>
              </div>
            </div>
         
	
            <div class="row">
			<div class="input-field">
			
                  <div class="input-select">
                 
                  <input id="search_ad_favorites" type="checkbox" name="search_ad_favorite" value = "yes" class="clicker">Show Favorites
                </div>
              </div>
              <div class="input-field">
               
				
                <div class="group-btn">
                  <button class="btn-delete" id="delete">RESET</button>
                  <button id="search_ad_button" type="button" class="btn-search clicker">SEARCH</button>
                </div>
              </div>
            </div>
			 <div style="visibility:hidden;" id="result-count" class="result-count">
                </div>
          </div>
        </div>
      </form>
    </div>
	<div class = "post">
	<table id="openings" class="openings openingstable">
	
	</table>
</div>
	</div>

	</div><!--/.pad-->

</section><!--/.content-->
<script>
$( ".clicker" ).click(function() {
	var formdata = $("#propertysearch_form").serializeArray();
	var x = document.getElementById('result-count');
	var tx = document.getElementById('openings');
	tx.innerHTML = "";
	$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/property_get.php" ?>',
            data: { 
			'ajax_call' : '1',
			'sendFormData' : JSON.stringify(formdata)
		},
		 dataType: "json", 
            success: function(data) {
			
				if(data.adExists) {
					
					temp_table = "<thead>"+
									"<tr id='header_search'>"+
									 " <th></th>"+
									  "<th>Info</th>"+
									   "<th>Landlord Fee</th>"+
									    "<th>Available Date</th>"+
									"</tr>"+
								 " </thead>";
					
					x.style.visibility = 'visible';

					
				

					x.innerHTML = "<span>"+data.ad_count+" </span>results";
					for(i = 0; i < data.property_ID.length;i++) {
						
						pid = data.property_ID[i];
						temp_table += "<tbody><tr class='opening'>"+
						"<td class='opening-logo'>"+
						"<div class='star'>"+
						"</div>"+
						"<a href='view-property?property_id="+pid+"'>"+
						"<img src='"+data.photo_Thumb[i]+"' alt='Logo'></a>"+
						"</td> "+
						"<td class='opening-meta'>"+
						"<h2><a href='view-property?property_id="+pid+"' class='opening-name'>"+data.property_LeasePrice[i]+" / month</a>"+
						"</h2> <h3><a href='view-property?property_id="+pid+"' class='company'>"+
						data.property_Bedrooms[i]+" "+data.property_City[i]+" "+data.property_Zip[i]+"</a></h3> "+
						"</td>"+
						"<td class='opening-type'> <p class='freelance'>"+data.property_LPayingFee[i]+"</p>"+
						"</td> <td class='opening-location'>"+
						"<p><a href='#'>"+data.property_AvailableTS[i]+"</a></p> </td>"+
		
						"</tr> </tbody>";
					}
					tx.innerHTML = temp_table;
				} else{
					x.style.visibility = 'hidden';
				}
            },
		error: function (request, status, error) {
		 
		}
        });
});
</script>
<?php get_sidebar(); ?>

<?php get_footer(); ?>