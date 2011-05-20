<?php //test $Id$

$publicPath=variable_get('file_public_path', conf_path() . '/files'); 

?>

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
             $uid = $user->uid;
          // add system name as link to profile at top of page
       
             //get the alternative name from field_data_field_library_name_pref
   				$sql="select field_library_reg_pref_value as value from {field_data_field_library_reg_pref} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
   				$result=db_query($sql, array('uid'=>$uid));
				$alt_name = '';
   				foreach($result as $r){
        			$alt_name=$r->value;
   				}
   
   		if($alt_name==''){
          $fscs = 	token_replace("[current-user:profile-library-registration:field-library-reg-system]");
          $query = "SELECT library_name FROM {library_lookup} WHERE fscs_key = '$fscs'";
          $system_name = db_query($query)->fetchField();
   		}
   		else $system_name=$alt_name;
   		
          $welcome = array( 
          		'href' => 'myimpact',
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
         
         
         <!--  fielding date -->
         <div id='date' style="float: right;margin: -106px 45px 0 0;">
           <?php if(isset($field_date)) print $field_date;?>
         </div> 
         
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
          
         <?php print $messages; ?>
         
          
        
          <?php if($page['content_top']): ?>
            <div id="content_top" class="blockregion">
              <?php print render($page['content_top']); ?>
            </div>
          <?php endif; ?>
        
          <div id="content">  
          <div id="contentLeft" Style="float:left">      
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
            <?php $status = isset($_GET['status']) ? $_GET['status'] : '';?>
            
            <?php 
            //redirect to this content after creating an account
            if(!user_is_logged_in() && $status == 1){
            print '<h3>Thank you for your application</h3>Your account is currently pending approval by the site administrator.
In the meantime, a welcome message with further instructions has been sent to your e-mail address.<br><a href="/">Home</a>';
            }
            ?>
        
            <?php 
            // check whether the user has the access
            if (!user_is_logged_in() && $status != 1): ?>
            	<p>Please log in to access your profile.</p>	
            <?php elseif (user_is_logged_in()): ?>
             
            <?php 
                $uid = $user->uid;

                //Name
                $sql="select field_library_reg_fname_value as value from {field_data_field_library_reg_fname} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
                $firstname=db_query($sql,array('uid'=>$uid))->fetchField();

                $sql="select field_library_reg_lname_value as value from {field_data_field_library_reg_lname} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
                $lastname=db_query($sql,array('uid'=>$uid))->fetchField();

                //Job title
                $sql="select field_library_reg_position_value as value from {field_data_field_library_reg_position} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
                $jobtitle=db_query($sql,array('uid'=>$uid))->fetchField();

                //Phone number
                $sql="select field_library_reg_phone_value as value from {field_data_field_library_reg_phone} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
                $phonenum=db_query($sql,array('uid'=>$uid))->fetchField();

                //Phone extension
                 $sql="select field_library_reg_extension_value as value from {field_data_field_library_reg_extension} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration'";
                $phoneext=db_query($sql,array('uid'=>$uid))->fetchField();
                if(!empty($phoneext)) $phoneext="-ex($phoneext)";

                                
               //Output
                $output = "<h3>$system_name</h3>Username: ".$user->name."<br>Registered User:  ".$firstname." ".$lastname."<br>Position:".$jobtitle."<br>  ".substr($phonenum,0,3)."-".substr($phonenum,3,3)."-".substr($phonenum,-(strlen($phonenum)-6)).$phoneext.'<br>'.$user->mail;

                print $output;
                
                //Survey URL: 
                print "<br><Br>Survey URL:"."http://impactsurvey.org/libselect/index.php?fscs=".token_replace("[current-user:profile-library-registration:field-library-reg-system]"); 

                
                //Edit URL?>
                <br><br><input type="button" value="Edit" onClick="window.location.href='myimpact/edit'"/>
                
              
                <?php 
                //"Next Step" 
                print "<Br><h4>Next Step</h4>";
                
                //get the forms filled out
                $sql="select type from {profile} where uid=:uid";
                $results=db_query($sql,array('uid'=>$uid));

                $i=0;
                foreach($results as $type){
                    $user_filled[$i]=$type->type;
                    $i++;
                }

                //check IMLS
                $flag=0;            
                foreach($user_filled as $r){
                     if ($r=="imls_data") $flag='1';
                }
                
                //check Information Form
                if($flag=='1'){
                foreach($user_filled as $r){
                    if ($r=="intake_form") $flag='2';
                }
                }

                //chek Dates
                if ($flag=='2'){
                foreach($user_filled as $r){
                   if ($r=="survey_fielding") $flag='3';
                }              
                
           	    //get dates
           	    $sql="select field_fielding_date_value2 from {profile} as p,{field_data_field_fielding_date} as f where p.uid=:uid and p.type='survey_fielding' and f.entity_id=p.pid";
                $date=db_query($sql,array('uid'=>$uid))->fetchField();
                $date=strtotime($date);
                
                //check whether the date is expired.
                   if(isset($date)){
                	if(empty($date)) $flag=3;
                	elseif($date<time()) $flag=4;
                }
                
                
                }
                
                switch($flag){
                    case 0: 
                        print "1. Confirm your library's <a href=./profile-imls_data>IMLS Data</a>";
                        break;
                    case 1:
                        print '2. Complete the <a href=./profile-intake_form>Intake Form</a>';
                        break;
                    case 2:
                        print '3. Select your <a href=./profile-survey_fielding>survey fielding</a> dates';
                        break;
                    case 3:
                        print '4. <a href=./codebox>Get your survey links.</a>';
                        break; 
                    case 4:
                        print 'Your report is done, view it <a href=./reports>here</a>';
                        break;            
                }
                //print $flag;
              ?>
            	
            <?php endif; ?>
            <div class="feedicons">
              <?php echo $feed_icons ?>
            </div>
            </div><!-- contentLeft -->
       
   
 
          <div id='centerRight' Style='float: right; margin: -5px 80px 0px 0px; '>
            
           <?php   
            if(user_is_logged_in()){
           $tag="Change";

          //get the path of logo
           $sql="select uri from {profile} as p,{field_data_field_reg_logo_pic} as f, {file_managed} as m where p.uid=:uid and p.type='photo_logo' and f.entity_id=p.pid and m.fid=f.field_reg_logo_pic_fid";
           $logo=db_query($sql,array('uid'=>$uid))->fetchField();
           //print logo;
          
           
       
           //get the path of library pic
           $sql="select uri from {profile} as p,{field_data_field_reg_library_pic} as f, {file_managed} as m where p.uid=:uid and p.type='photo_logo' and f.entity_id=p.pid and m.fid=f.field_reg_library_pic_fid";
           $libPic=db_query($sql,array('uid'=>$uid))->fetchField();
           //print $logo;
           
           //default tips
           if(empty($logo) or empty($libPic)) $tip="<h5>Please upload your library<br> logo and picture,so we<br> could use them in your report.</h5>";
           else $tip="<br><br><br>";
           $output = $tip;
           
           //default pictures
           if(empty($logo)) {$logo="public://default_images/default_logo.jpg";$tag="Upload";}
		   if(empty($libPic)) {$libPic="public://default_images/default_library_pic.jpg";$tag="Upload";} 
		   	   
		   $output.="<img width=100px height=100px src='".convUri($logo, $publicPath)."' alt='logo'/>"."<br>";
           $output.="<img width=100px height=100px src='".convUri($libPic, $publicPath)."' alt='Library Pic' align=center />";
           //button
           //$output.="<br><div align='center'><a href='./profile-photo_logo/".$uid."/edit'><input type='button' value='".$tag."' /></a></div>";

          // $output.="<br><div align='center'><input type='button' value='".$tag."' onClick='".$click."'/></div>";
            }
       
           if(user_is_logged_in()): print $output;
           
           $url = "./profile-photo_logo/$uid/edit";
           
		   ?>
           
           <br><div align='center'><input type='button' value="<?php print $tag;?>" onClick="window.location.href = '<?php print $url;?>'"/></div>
           
           
           <?php endif;
           //deal with the uri from the DB
          function convUri($uri="", $publicPath){
        	 $position=explode("://",$uri);

          	return $publicPath."/".$position[1];  	
          } 
        ?>      
           
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
  

