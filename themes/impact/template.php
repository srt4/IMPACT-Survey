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
      
      // added by Yan for IMPACT profile page 3-3-10
      if ($_GET['q'] == 'node/51') {
          $variables['theme_hook_suggestions'][] = "page__myimpact";
          }
      
//Welcome Bar Date
  $uid=$variables['user']->uid;
  
    $field_date='';
   if($variables['logged_in']){

   //get the fielding dates from field_data_field_fielding_date
   $sql="SELECT field_fielding_date_value AS from_date, 
   field_fielding_date_value2 AS to_date 
   FROM {field_data_field_fielding_date} AS a, 
   {profile} AS b WHERE a.entity_id=b.pid AND b.uid=:uid";
   $result=db_query($sql, array('uid'=>$uid));

   $date1 = '';
   $date2 = '';
   foreach($result as $r){
        $date1=strtotime($r->from_date);
        $date2=strtotime($r->to_date);
   }


    $field_date=date('m/d/y', $date1).' - '.date('m/d/y', $date2);

    //output   
    $variables['field_date']="<br><span style='float: right;'>Fielding Dates:</span><br>".$field_date;
    
   //do not diplay the fielding date if it is empty
    if(isset($date1,$date2)){
    if ($date2=='' && $date1=='') $variables['field_date']='';
    }
   }
    
    // end 4-5
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