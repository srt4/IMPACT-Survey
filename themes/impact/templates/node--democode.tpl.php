<?php // $Id$   ?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
  <?php if($display_submitted && !$page): ?>
    <div class="date">
      <div class="textdate">
        <div class="day"><?php print format_date($created, 'custom', 'j'); ?></div>
        <div class="month"><?php print format_date($created, 'custom', 'M'); ?></div>
      </div>
    </div>
  <?php endif; ?>
	<?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2 class="title"<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
	<?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <div class="meta">
      <span class="submitted"><?php print t('Submitted by !username on !datetime', array('!username' => $name, '!datetime' => $date)); ?></span>
    </div>
  <?php endif; ?>
  <?php if($user_picture): print $user_picture; endif; ?>
  <div class="content clear-block"<?php print $content_attributes; ?>>
 
 
 <!-- Demo Code Instruction -->
<br>
<li>Step 1: Simply insert the below code into the HEAD section of your page:</li>
<br>
<form name="codeform">
<textarea name="code" id="code" class="codecontainer" rows="11" name="S1" cols="65" wrap="virtual" onclick="this.focus();this.select()">
<link rel="stylesheet" type="text/css" href="interstitial.css" />

<script type="text/javascript" src="interstitial.js">

/***********************************************
* Interstitial Content Box- Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
</textarea>
</form>
<li>Step 2: Uncompress the demo.zip to  the same directory as where your webpage is in</li>
<br>
  
  
  <?php
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>
  <?php if($content['links']): ?><div class="node-links"><?php print render($content['links']); ?></div><?php endif; ?>
</div>
<?php print render($content['comments']); ?>