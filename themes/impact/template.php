<?php //$Id$
  function impact_preprocess_page(&$variables)
  {
      if (isset($variables['main_menu'])) {
          $pid = variable_get('menu_main_links_source', 'main-menu');
          $tree = menu_tree($pid);
          $variables['primary_nav'] = str_replace('menu', 'sf-menu menu', drupal_render($tree));
      } else {
          $variables['primary_nav'] = false;
      }
      
      
      //put them in the template
      
      //if view is not edited, direct to edit
      if (isset($variables['page']['content']['system_main']['profile2']['']['empty'])) {
          drupal_goto($_GET['q'] . '/edit');
      }
      
      //check if edit part are using profile2
      $tell = explode('-', $_GET['q']);
      
      
      
      
      //delete the tabs of profile2 and edit the "Edit" title
      if ($tell[0] == 'profile') {
          $variables['tabs'] = '';
          $tell2 = explode('/', $tell[1]);
          if (isset($tell2[2]) && $tell2[2] == 'edit') {
              //get the label of the page
              $type = $tell2[0];
              $sql = "select label from {profile_type} where type=:type";
              $result_l = db_query($sql, array('type' => $type));
              foreach ($result_l as $l) {
                  $label = $l->label;
              }
              $variables['title'] = 'Edit ' . $label;
          }
      }
      
		if($_GET['q'] == 'node/8') {
		//$variables['page']['content']['system_main']['nodes'][8]['body'][0]['#markup'] == 'lol';
      //dpm($variables);
		}
      
      // added by Yan for IMPACT profile page 3-3-10
      if ($_GET['q'] == 'node/51') {
          $variables['theme_hook_suggestions'][] = "page__myimpact";
          /*$output = '';
          if ($_GET['status'] == 1 && !$variables['logged_in']) {
              $output = '<h3>Thank you for your application</h3>Your account is currently pending approval by the site administrator.
In the meantime, a welcome message with further instructions has been sent to your e-mail address.<br><a href="/">Home</a>';
          } else {
              //defalt forms
              $sql = "select type,label from {profile_type} ORDER BY weight ASC";
              $type_results = db_query($sql);
              
              $i = 0;
              foreach ($type_results as $type) {
                  $def_type[$i] = $type->type;
                  $def_label[$i] = $type->label;
                  $i++;
              }
              //user filled forms
              $uid = $variables['user']->uid;
              $sql = "select type from {profile} where uid=:uid order by type";
              $results = db_query($sql, array('uid' => $uid));
              
              $i = 0;
              foreach ($results as $type) {
                  $user_type[$i] = $type->type;
                  $i++;
              }
              $j = 0;
              //test whether match
              foreach ($def_type as $def) {
                  $i = '0';
                  foreach ($user_type as $user) {
                      if ($user == $def) {
                          $output .= "<div id='completed-form'>You have finished <b>" . $def_label[$j] . "</b>&nbsp&nbsp<a href=./profile-$def>View</a><br></div>";
                          $i = '1';
                      }
                      //used as flag
                  }
                  
                  if ($i == '0')
                      $output .= "<div id='incomplete-form'>You have NOT finished <b>" . $def_label[$j] . "</b>&nbsp&nbsp<a href=./profile-$def>Edit</a><br></div>";
                  $j++;
              }
          }
          $variables['myimpact'] = $output;
     */ }
      
      
      //3-21
  //Welcome Bar
    $welcome='';
   if($variables['logged_in']){

  //print the user's name e.g. "Welcome Admin". If we do not need it, please delete it.
    $welcome='Welcome  '.$variables['user']->name.'<br>';

   //get the alternative name from field_data_field_library_name_pref
   $sql="select field_library_name_pref_value as value from {field_data_field_library_name_pref} as a, {profile} as b where a.entity_id=b.pid and b.uid=:uid";
   $uid=$variables['user']->uid;
   $result=db_query($sql, array('uid'=>$uid));
	$pre_name = '';
   foreach($result as $r){
        $pre_name=$r->value;
   }

   $welcome.=$pre_name.'<br>';

   //get the fielding dates from field_data_field_fielding_date
   $sql="SELECT field_fielding_date_value AS from_date, 
   field_fielding_date_value2 AS to_date 
   FROM {field_data_field_fielding_date} AS a, 
   {profile} AS b WHERE a.entity_id=b.pid AND b.uid=:uid";
   $result=db_query($sql, array('uid'=>$uid));

   $date1 = '';
   $date2 = '';
   foreach($result as $r){
        $date1=$r->from_date;
        $date2=$r->to_date;
   }


    $welcome.='From '.$date1.'to '.$date2;
}
    //output
    $variables['welcome']=$welcome;
    // end 3-21
  }
  
  
  function impact_breadcrumb(&$variables)
  {
      $breadcrumb = $variables['breadcrumb'];
      if (!empty($breadcrumb)) {
          // Provide a navigational heading to give context for breadcrumb links to
          // screen-reader users. Make the heading invisible with .element-invisible.
          $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
          
          $output .= '<div class="breadcrumb">' . implode(' | ', $breadcrumb) . '</div>';
      } else {
          $output = '<div class="breadcrumb">' . t('Home') . '</div>';
      }
      return $output;
  }
  
  function impact_feed_icon(&$variables)
  {
      $text = t('Subscribe to @feed-title', array('@feed-title' => $variables['title']));
      if ($image = theme('image', array('path' => path_to_theme() . '/images/rss.png', 'alt' => $text))) {
          return l($image, $variables['url'], array('html' => true, 'attributes' => array('class' => array('feed-icon'), 'title' => $text)));
      }
  }