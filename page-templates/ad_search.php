<?php
/*
Template Name: Search Ad
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
      <form id='adsearch_form' name="adsearch_form">
        <div class="inner-form">
          <div class="basic-search">
            <div class="input-field">
              <!--<input id="search" type="text" placeholder="Type Keywords" />
              <div class="icon-wrap">
                <svg class="svg-inline--fa fa-search fa-w-16" fill="#ccc" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                </svg>
              </div>-->
            </div>
          </div>
          <div class="advance-search">
         
		
            <div class="row">
              <div class="input-field">
			  <p>Budget</p>
                <div class="input-select">
                   <input name="budget-min" size="4" type="text" placeholder="Min"> to
				   <input name="budget-max" size="5" type="text" placeholder="Max">
                </div>
				
                  
               
              </div>
              <div class="input-field">
			    <p >Move In</p>
                <div class="input-select">
				<input type="checkbox" name="is-custom-move" checked value="yes"> Any
                  <select data-trigger="" name="move-in-day">
                    <option placeholder="" value="">Day</option>
					<?php for($i=1;$i<=31;$i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php } ?>
                  </select>
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
			    <p >Length of stay</p>
                <div class="input-select">
                  <select name="min_term" id="minTerm">
					  <option value="0">Any</option>
					  <option value="1">1 Month</option>
					  <option value="2">2 Months</option>
					  <option value="3">3 Months</option>
					  <option value="4">4 Months</option>
					  <option value="5">5 Months</option>
					  <option value="6">6 Months</option>
					  <option value="7">7 Months</option>
					  <option value="8">8 Months</option>
					  <option value="9">9 Months</option>
					  <option value="10">10 Months</option>
					  <option value="11">11 Months</option>
					  <option value="12">1 Year</option>
		
					  <option value="24">2 Years</option>
				  </select>
				  to
				  <select name="max_term" id="maxTerm">
				  <option value="0">Any</option>
				  <option value="1">1 Month</option>
				  <option value="2">2 Months</option>
				  <option value="3">3 Months</option>
				  <option value="4">4 Months</option>
				  <option value="5">5 Months</option>
				  <option value="6">6 Months</option>
				  <option value="7">7 Months</option>
				  <option value="8">8 Months</option>
				  <option value="9">9 Months</option>
				  <option value="10">10 Months</option>
				  <option value="11">11 Months</option>
				  <option value="12">1 Year</option>
		
				  <option value="24">2 Years</option>
				  <option value="36">3 Years</option></select>
                </div>
			
                  
               
              </div>
            </div>
            <div class="row second">
              <div class="input-field">
			   <p >Room size</p>
                <div class="input-select" >
                
                  <input type="radio" name="room-size" checked value="any">Any
                  <input type="radio" name="room-size" value="large">Large room
				  <input type="radio" name="room-size" value="small">Small room
                 
                </div>
              </div>
              <div class="input-field">
			   <p >Pref. Occupation</p>
                <div class="input-select">
				
                  <select name="pref-occupation" data-trigger="">
                    <option placeholder="" value="A">Any occupation</option>
                    <option value="P">Professionals</option>
                    <option value="O">Student</option>
        
                  </select>
                </div>
              </div>
              <div class="input-field">
			     <p >Age range</p>
                <div class="input-select">
                  <input name="age-min" size="4" type="text" placeholder="Min age">
				   <input name="age-max" size="5" type="text" placeholder="Max age">
                </div>
              </div>
            </div>
			 <div class="row second">
			 <div class="input-field">
			     <p >Smoking Pref.</p>
                <div class="input-select">
                  <select data-trigger="" name="pref-smoking">
                    <option placeholder="" value="any">Any</option>
                    <option value="smoking">Smoking</option>
                    <option value="nosmoking">Non-Smoking</option>
        
                  </select>
                </div>
              </div>

			  <div class="input-field">
			   <p >Pets</p>
                <div class="input-select">
                  <input value="Pets" type="radio" checked name="pref-pet">Pets ok
                  <input value="NoPets" type="radio" name="pref-pet" >No Pets
                
                 
                </div>
              </div>
			  <div class="input-field">
				
                <div class="input-select">
			 <input id="search_ad_favorites" type="checkbox" name="search_ad_favorite" value = "yes" class="clicker">Show Favorites
                </div>
              </div>
			 </div>
            <div class="row third">
              <div class="input-field">
                <div style="visibility:hidden;" id="result-count" class="result-count">
                </div>
                <div class="group-btn">
                  <button class="btn-delete" id="delete">RESET</button>
                  <button id="search_ad_button" type="button" class="btn-search clicker">SEARCH</button>
                </div>
              </div>
            </div>
			 <div style="visibility:hidden;" id="result-count" class="result-count ">
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
		var formdata = $("#adsearch_form").serializeArray();
		var x = document.getElementById('result-count');
		var tx = document.getElementById('openings');
		tx.innerHTML = "";
$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/ad_get.php" ?>',
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
									   "<th>Budget</th>"+
									   "<th>Room Size</th>"+
									    "<th>Pets</th>"+
										"<th>Smoking</th>"+
									"</tr>"+
								 " </thead>";
					
					x.style.visibility = 'visible';

					x.innerHTML = "<span>"+data.ad_count+" </span>results";
					temp_table += "<tbody>";
					for(i = 0; i < data.roommate_ad_id.length;i++) {
						if(data.profile[i] == true){
							
							profile_img ="<?php echo THEME_DIR; ?>";
							profile_img +="/assets/front/img/profiles/"+data.roommate_user_profilepic[i];
						} else {
							profile_img ="<?php echo THEME_DIR; ?>";
							profile_img += "/assets/front/img/"+data.roommate_user_profilepic[i];
						}
						aid = data.roommate_ad_id[i];
						temp_table +="<tr class='opening'>"+
						"<td class='opening-logo'>"+
						"<div class='star'>"+
						"</div>"+
						"<a href='view-ad?ad_id="+aid+"'>"+
						"<img src='"+profile_img+"' alt='Logo'></a>"+
						"</td> "+
						"<td class='opening-meta'>"+
						"<h2><a href='view-ad?ad_id="+aid+"' class='opening-name'>"+data.roommate_ad_title[i]+"</a>"+
						"</h2> <h3><a href='view-ad?ad_id="+aid+"' class='company'>"+
						data.roommate_user_name[i]+" "+data.roommate_ad_occupation[i]+" "+data.roommate_user_gender[i]+" "+data.roommate_ad_age[i]+"</a></h3> "+
						"</td>"+
						"<td class='opening-type'> <p class='freelance'>"+data.roommate_ad_budget[i]+"</p>"+
						"</td> <td  class='opening-location'>"+
						"<p><a href='#'>"+data.roommate_ad_roomsizepref[i]+"</a></p> </td>"+
						"<td class='opening-location'>"+
						"<p><a href='#'>"+data.roommate_ad_haspets[i]+"</a></p> </td>"+
						"<td class='opening-location'>"+
						"<p><a href='#'>"+data.roommate_ad_issmoker[i]+"</a></p> </td>"+
						"</tr>"+
						"<tr class='' >"+
						"<td colspan='6'>Description:<p><a href='href='view-ad?ad_id="+aid+"'>"+
						data.roommate_ad_description[i]+"</a></p></td></tr>";
						
					
					}
						temp_table +="</tbody>";
					tx.innerHTML = temp_table;
				} else{
					x.style.visibility = 'hidden';
				}
            },
		error: function (request, status, error) {
		  console.log(request.responseText);
		}
        });
});
</script>
<?php get_sidebar(); ?>

<?php get_footer(); ?>