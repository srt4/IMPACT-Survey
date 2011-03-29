<?php // $Id$?>
  <div id="header">
    <?php if($page['header_top']): ?>
      <div id="headerTop" class="blockregion">
        <?php print render($page['header_top']); ?>
      </div>
    <?php endif; ?>
    
    <div id="headerWrapper">
      <?php if (!empty($secondary_menu)): ?>
        <div id="topMenu">
          <?php 
          // add system name as link to profile at top of page
          $fscs = 	token_replace("[current-user:profile-library-registration:field-library-reg-system]");
          $query = "SELECT library_name FROM {library_lookup} WHERE fscs_key = '$fscs'";
          $system_name = db_query($query)->fetchField();
          $welcome = array( 
          		'href' => 'user',
          		'title' => "Welcome $system_name",
          );
          array_unshift($secondary_menu, $welcome);
          
          print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix'))));?>
        </div>
      <?php endif; ?>
            
      <div id="searchBox">
      </div>
      
      
      <?php if($page['search_box']): ?>
        <div id="searchBox"><?php //print render($page['search_box']); ?></div>
      <?php endif; ?>
      
      <div id="siteName">
        <?php if ($logo): print '<a href="' . $front_page . '" title="' . t('Home') . '"> <img src="' . check_url($logo) . '" alt="' . t('Home') . '" id="logo" /></a>'; endif; ?>
        <div id="siteInfo">
          <?php if (!empty($site_name)): ?>
            <h1 id="siteTitle">
              <a href="<?php print $front_page ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
            </h1>
          <?php endif; ?>
          
          <?php if (!empty($site_slogan)): ?>
            <div id="siteSlogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>
        </div><!-- /siteInfo -->
      </div> <!-- /siteName-->
        
      <?php if($page['header']): ?>
        <div id="header-region" class="blockregion">
          <?php print render($page['header']); ?>
        </div>
      <?php endif; ?>
        
    </div><!-- /headerWrapper -->
  </div><!-- /header -->

  <div id="container">
    <div id="inner">  
      <div id="contentWrapper">
        <?php if (!empty($primary_nav)): ?>
          <div id="menuLeft"></div>
          <div id="primaryMenu">
            <?php print $primary_nav; ?>
          </div>
          <div id="menuRight"></div>
        <?php endif; ?> 
        
        <?php if($page['preface_top']): ?>
          <div id="preface_top" class="blockregion">
            <?php print render($page['preface_top']); ?>
          </div>
        <?php endif; ?>
        
        <?php if($page['sidebar_first']): ?>
          <div id="sidebar_first" class="sidebar">
            <?php print render($page['sidebar_first']); ?>
          </div>
        <?php endif; ?>
       
        <div id="center">
          <?php /*if (!empty($breadcrumb)): ?>
            <div id="breadcrumb">
              <?php print $breadcrumb; ?>
            </div>
          <?php endif; */?>
          
         <?php //print $messages; ?>
         
          
        
          <?php if($page['content_top']): ?>
            <div id="content_top" class="blockregion">
              <?php print render($page['content_top']); ?>
            </div>
          <?php endif; ?>
        
          <div id="content">        
            <?php //print render($title_prefix); ?>
            <?php if ($title): ?>
              <h2 class="title" id="page-title"><?php //print $title; ?></h2>
            <?php endif; ?>
            <?php print render($title_suffix); ?>
            <?php if ($tabs): ?>
              <div class="tabs"><?php //print render($tabs); ?></div>
            <?php endif; ?>
            <?php //print render($page['help']); ?>
            <?php if ($action_links): ?>
              <ul class="action-links"><?php //print render($action_links); ?></ul>
            <?php endif; ?>
            <h2>My IMPACT</h2>
            <?php $status = isset($_GET['status']) ? $_GET['status'] : '';
            if (!user_is_logged_in() && $status != 1): ?>
            	<p>Please log in to access your profile.</p>
            <?php elseif (user_is_logged_in()): ?>
            	<?php print $myimpact; ?>
            <?php endif; ?>
            <div class="feedicons">
              <?php echo $feed_icons ?>
            </div>
          </div>
        
          <?php if($page['content_bottom']): ?>
            <div id="content_bottom" class="blockregion">
              <?php print render($page['content_bottom']); ?>
            </div>
          <?php endif; ?>   
        </div><!-- /center --> 
    
        <?php if($page['sidebar_second']): ?>
          <div id="sidebar_last" class="sidebar">
            <?php print render($page['sidebar_second']); ?>
          </div>
        <?php endif; ?>
      
        <?php if($page['postscript_bottom']): ?>
          <div id="postscript_bottom" class="blockregion">
            <?php print render($page['postscript_bottom']); ?>
          </div>
        <?php endif; ?> 
      </div><!-- /contentWrapper -->
      
    </div><!-- /Inner -->
    
  </div><!-- /container -->
  
  <div id="footer">
    <div class="footer-text"><!-- Theme designed by <a href="http://www.carettedonny.be" title="Donny Carette">Donny Carette</a> -->
      <?php if($page['footer_message']): ?>
        | <?php print render($page['footer_message']); ?>
      <?php endif; ?>
    </div>
                    
    <?php if($page['footer_bottom']): ?>
      <div id="footer_bottom" class="blockregion">
        <?php print render($page['footer_bottom']); ?>
      </div>
    <?php endif; ?> 
  </div><!-- /footer -->
  

