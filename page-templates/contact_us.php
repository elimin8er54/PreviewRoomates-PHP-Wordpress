<?php
/*
Template Name: Contact Us
*/
?>
<?php get_header(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR ."/assets/front/css/adcss.css?version=1" ?>">
		<style>
		.thh {
  border: 1px solid black;
   padding: 15px;
}
		</style>
		
		<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<div class="block_content">
		

                    <div class="col l6 m12 s12" >
                        <div >
                            <h2 class="title">contact us</h2>
                            <table  style = " border-collapse: collapse; margin: 0 auto;"  class = "detail-table">
                                <tbody >
                                    <tr>
                                        <td class="thh">Report issue or a change for our website</td>
                                       
                                        <td class="thh">shaunt.keshishian@gmail.com</td>
                                    </tr>
									 <tr>
                                        <td class="thh">Owner/Broker</td>
                                      
                                        <td class="thh">2018amason@gmail.com</td>
                                    </tr>
                                    <tr>
                                        <td class="thh">Admins</td>
                               
                                        <td class="thh">fionapreview@gmail.com <br> amberpreview@gmail.com </td>
                                    </tr>
									
									

                                </tbody>
                            </table>
                        </div>
                        <!-- /.personal-details-right -->
                    </div>
					
                <!-- /.success-child-right -->
            </div>
            <!-- /.success -->
			
        </div>
		</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>