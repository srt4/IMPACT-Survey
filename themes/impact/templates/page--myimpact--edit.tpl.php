<?php //test $Id$ 

  $uid = $user->uid;
  $output='';
  
  //print ($_POST['record']);
  $flag=0;
  //print_r($_POST);
  if(!empty($_POST)) {
  
  $records=explode('/',$_POST['record']);

  
 //trim the space
  foreach($_POST as $key => $value){
  	$_POST[$key]=trim($value);
  }
  foreach($records as $key => $value){
  	$records[$key]=trim($value);
  }
  
if(!empty($_POST['UserName']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['position']) && !empty($_POST['phoneNum']) && !empty($_POST['email'])){

//tell the length of Number
if(strlen($_POST['phoneNum'])>10 or strlen($_POST['phoneNum'])<6){ 
	//drupal_set_message(t('@warn',array('@warn'=>'The Phone Number should be no more than 10 digits and no less than 6 digits')),'error');
	$warn="The Phone Number should be no more than 10 digits and no less than 6 digits";
	$flag=1;
}

//tell if the phone number is numeric
elseif ((!is_numeric($_POST['phoneExt']) && !empty($_POST['phoneExt'])) or !is_numeric($_POST['phoneNum'])){ 
	//drupal_set_message(t('@warn',array('@warn'=>'The Phone Number should be no more than 10 digits and no less than 6 digits')),'error');
	$warn="The Phone Number should be numeric";
	$flag=1;
}

else{	
//update user name
$updated = db_update('users')
  ->fields(array(
    'name' => $_POST['UserName'],
  ))
  ->condition('uid',$uid, '=')
  ->execute();

//get the entity_id
$entity_id=pid($uid);

//update or insert the first name
if(!empty($records['1'])){
$updated = db_update('field_data_field_library_reg_fname')
  ->fields(array(
    'field_library_reg_fname_value' => $_POST['fname'],
  ))
  ->condition('entity_id',$entity_id, '=')
  ->execute();}
else{
	$inserted = db_insert('field_data_field_library_reg_fname') 
		->fields(array(
  		'field_library_reg_fname_value' => $_POST['fname'],
  		'entity_id' => $entity_id,
		'delta' =>'0',
		'entity_type' => 'profile2',
		'bundle'=>'library_registration',
		'deleted'=>'0',
		'revision_id'=>$entity_id,
		'language'=>'und',
))
->execute();		
}

//update or insert last name
if(!empty($records['2'])){
$updated = db_update('field_data_field_library_reg_lname')
  ->fields(array(
    'field_library_reg_lname_value' => $_POST['lname'],
  ))
  ->condition('entity_id',$entity_id, '=')
  ->execute();  
}
else{
		$inserted = db_insert('field_data_field_library_reg_lname') 
		->fields(array(
  		'field_library_reg_lname_value' => $_POST['lname'],
  		'entity_id' => $entity_id,
		'delta' =>'0',
		'entity_type' => 'profile2',
		'bundle'=>'library_registration',
		'deleted'=>'0',
		'revision_id'=>$entity_id,
		'language'=>'und',
))
->execute();
}


//update or insert position
if(!empty($records['3'])){
$updated = db_update('field_data_field_library_reg_position')
  ->fields(array(
    'field_library_reg_position_value' => $_POST['position'],
  ))
  ->condition('entity_id',$entity_id, '=')
  ->execute();  
}
else{
		$inserted = db_insert('field_data_field_library_reg_position') 
		->fields(array(
  		'field_library_reg_position_value' => $_POST['position'],
  		'entity_id' => $entity_id,
		'delta' =>'0',
		'entity_type' => 'profile2',
		'bundle'=>'library_registration',
		'deleted'=>'0',
		'revision_id'=>$entity_id,
		'language'=>'und',
))
->execute();
}

 //update or insert phone number
if(!empty($records['4'])){
$updated = db_update('field_data_field_library_reg_phone')
  ->fields(array(
    'field_library_reg_phone_value' => $_POST['phoneNum'],
  ))
  ->condition('entity_id',$entity_id, '=')
  ->execute();   
}
else{
		$inserted = db_insert('field_data_field_library_reg_phone') 
		->fields(array(
  		'field_library_reg_phone_value' => $_POST['phoneNum'],
  		'entity_id' => $entity_id,
		'delta' =>'0',
		'entity_type' => 'profile2',
		'bundle'=>'library_registration',
		'deleted'=>'0',
		'revision_id'=>$entity_id,
		'language'=>'und',
))
->execute();
}

 //update or insert phone extention
if(!empty($records['5']) or $records['5']=='0'){	
	//if updated to empty, delete the record
	if(empty($_POST['phoneExt'])){
			$deleted = db_delete('field_data_field_library_reg_extension')
  			->condition('entity_id',$entity_id, '=')
 			->execute();
	}
	else{
	$updated = db_update('field_data_field_library_reg_extension')
  		->fields(array(
    		'field_library_reg_extension_value' => $_POST['phoneExt'],
  		))
  	->condition('entity_id',$entity_id, '=')
  	->execute();
	}   
}
else {
	if(!empty($_POST['phoneExt'])){
		$inserted = db_insert('field_data_field_library_reg_extension') 
		->fields(array(
  		'field_library_reg_extension_value' => $_POST['phoneExt'],
  		'entity_id' => $entity_id,
		'delta' =>'0',
		'entity_type' => 'profile2',
		'bundle'=>'library_registration',
		'deleted'=>'0',
		'revision_id'=>$entity_id,
		'language'=>'und',
		))
		->execute();
	}
}

//update email
  $updated = db_update('users')
  ->fields(array(
    'mail' => $_POST['email'],
  ))
  ->condition('uid',$uid, '=')
  ->execute();

  drupal_goto('myimpact');
}

}
else {
	$warn="Please fill out all the fields";
	
	//flag is used to tell whether we use the data filled out or not
	$flag=1;
}
  }

//get the pid, which is the entity_id in profile tables
function pid($uid){
	$sql="select pid from {profile} where uid=:uid and type='library_registration'";
	$result=db_query($sql, array('uid'=>$uid))->fetchField();
	
	if(!empty($result)) return $result;
	else{
		$inserted = db_insert('profile') 
		->fields(array(
  		'type' => 'library_registration',
  		'uid' => $uid,
		))
		->execute();
		
	$sql="select pid from {profile} where uid=:uid and type='library_registration'";
	$result=db_query($sql, array('uid'=>$uid))->fetchField();		
	
	return $result;
	}	
}

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
           
          // add system name as link to profile at top of page
       
             //get the alternative name from field_data_field_library_name_pref
   				$sql="select field_library_reg_pref_value as value from {field_data_field_library_reg_pref} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid and b.type='library_registration' ";
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
          
         <?php print $messages;
         if(isset($warn)) print "<div id='warn' style=' color:red;'><b>".$warn."</b></div>"; ?>
         
          
        
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
				
				if($flag==1){
					$firstname=$_POST['fname'];
					$lastname= $_POST['lname'];
					$jobtitle= $_POST['position'];
					$phonenum= $_POST['phoneNum'];
					$phoneext= $_POST['phoneExt'];
					
										
					//remember the privous record
					$record_post=$_POST['record'];
				}            
            	else{

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
                  
       			 $records=array($user->name, $firstname, $lastname, $jobtitle, $phonenum, $phoneext, $user->mail);
       			 $record_post=implode('/',$records);            	
            	}          	
            	
               //Output
                $output = "<h3>$system_name</h3>";
                //Username: ".$user->name."<br>Registered User:  ".$firstname." ".$lastname."<br>Position:".$jobtitle."<br>  ".substr($phonenum,0,3)."-".substr($phonenum,3,3)."-".substr($phonenum,-4).'<br>'.$user->mail;
       			 print $output;

			 
       			 ?>
                <!-- Edit form -->
                <form action="" method="post">
                Username: <input name="UserName" value="<?php print $user->name; ?>"></input><br>
                Registered User: <input name="fname" value="<?php print $firstname; ?>"></input>
                <input name="lname" value="<?php print $lastname; ?>"></input><br>
                Position: <input name="position" value="<?php print $jobtitle; ?>"></input><br>
                Phone Number: <input name="phoneNum" value="<?php print $phonenum; ?>"></input>-ex<input name="phoneExt" value="<?php print $phoneext;?>"/><br>
                Email: <input name="email" value="<?php print $user->mail; ?>"></input><br>
                <input type="hidden" name="record" value="<?php print $record_post;?>"></input>
                <input type="submit" value="Save"/>
                </form>
             
                <?php
        
                //Survey URL: 
                print "<br><Br>Survey URL:"."http://www.uwsrd.org/impact/index.asp?LibID=".token_replace("[current-user:profile-library-registration:field-library-reg-system]");             
                
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
                if($date<time()){
                	$flag=4;
                }
                }
                
                switch($flag){
                    case 0: 
                        print "1. Complete the <a href=./profile-imls_data>Library IMLS Data</a>";
                        break;
                    case 1:
                        print "2. Select <a href=./profile-intake_form>Information Form</a>";
                        break;
                    case 2:
                        print "3. <a href=./profile-survey_fielding>Verify Library Fielding Dates</a>";
                        break;
                    case 3:
                        print "4. <a href=./codebox>Link to the Web Survey</a>";
                        break; 
                    case 4:
                        print "Your report is done, view it <a href=./reports>here</a>";
                        break;            
                }
                //print $flag;
              ?>
            	
                <?php //print $myimpact; ?>
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
  

