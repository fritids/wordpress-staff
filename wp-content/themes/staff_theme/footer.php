<div id="footer">
<div id="footer-wrapper">
  <div id="footer-columns">
    <div id="footer-column-left">
      <div id="block-views-campaigns-block_1" class="block block-views">
        <?php
			if(function_exists('wrdsb_links_display'))
				{
				wrdsb_links_display();
				}
			else
				{
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('left')) : 
				endif;					
				}
		?>
        <br />
      </div>
    </div>
    <div id="footer-column-centre">
      <div id="block-block-9" class="block block-block">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('centre')) : ?>
        <?php endif; ?>
        <br />
      </div>
    </div>
    <div id="footer-column-right">
      <div id="block-block-7" class="block block-block">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('right')) : ?>
        <?php endif; ?>
        <br />
      </div>
    </div>
  </div>
  <div id="footer-address">
    <div id="address" class="vcard">
      <div id="block-block-4" class="block block-block">
<?php
	if(function_exists('wrdsb_school_info_display'))
		{
		wrdsb_school_info_display();
		}
	else
		{
?>
        <div class="content">
          <div class="org fn">Waterloo Region District School Board</div>
          <div class="adr">
            <div>51 Ardelt Avenue</div>
            <p> <span class="locality">Kitchener, Ontario</span><span class="postal-code"></span><br />
              <span class="country-name">Canada</span> </p>
            <p>N2C 2R5</p>
          </div>
          <div class="tel">519-570-0003</div>
        </div>
<?php
		}
?>
      </div>
    </div>
  </div>
</div>
<div id="footer-clear"></div>
<?php wp_footer(); ?>
