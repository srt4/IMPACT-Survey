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
 
 
 <!-- Demo Code Instruction -->
<p>We are working to make this process as easy as possible.  If you get stuck, please <a href="/contact">contact us</a> for assistance.</p>
<p>Please also include a static button or banner on your website if you use this option. That way if your patrons dismiss the survey at the start of their PAC session they will be able to return to it later. </p>
<p>Copy and paste the following code in the &lt;HEAD&gt; section of your website:</p>
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
<p>Download the attached zip file and extract it to your web directory.</p>
<p>
Now you just need to configure the impact.html file:
Open the impact.html file in a text editor and locate the command
href="http://www.uwsrd.org/impact/index.asp?LibID=XXTEST"
<em>Replace XXTEST with <strong><?php print token_replace('[current-user:profile-library-registration:field-library-reg-system]'); ?></strong></em>.
</p>
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