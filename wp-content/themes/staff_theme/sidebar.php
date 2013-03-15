<div id="side-menu">
  <div id="block-menu_block-1" class="block block-menu_block">
    <div class="content">
      <div class="menu-name-primary-links parent-mlid-0 menu-level-2">
        <div id="options_menu">
        
          <?php
		  if (function_exists('wrdsb_insert_buttons'))
		  	{
			wrdsb_insert_buttons();
			}
		  $thewidgets = get_option('sidebars_widgets');
		  $sidewidgets = $thewidgets['sidebar'];
		  //print_r($thewidgets);
		  $thepages = 'TRUE';
		  if ($sidewidgets)
		  	{
			  foreach ($sidewidgets as $s)
				{
				if (strpos($s,'pages') !== FALSE OR strpos($s,'menu') !== FALSE)
					{
					$thepages = 'FALSE';
					}
				}
			}

				if (is_active_sidebar('sidebar'))
					{
					//echo "<ul>";
					dynamic_sidebar('sidebar');
					//echo "</ul>";
					}

			?>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
