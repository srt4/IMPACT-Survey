<?php if(!$logged_in): ?>
<h3 style="color:red">Please Log In</h3>
<p style="color:red">This page is intented to be viewed while <a href="/user">logged in</a>, otherwise the code will not be customized for your library.</p>
<?php endif; ?>
<div id="node-<?php print $node->nid; ?>"
	class="<?php print $classes; ?> clearfix" <?php print $attributes; ?>>
<?php print $user_picture; ?> <?php print render($title_prefix); ?> <?php if (!$page): ?>
<h2 <?php print $title_attributes; ?>><a
	href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
<?php endif; ?> <?php print render($title_suffix); ?> <?php if ($display_submitted): ?>
<div class="submitted"><?php print $submitted; ?></div>
<?php endif; ?>

<div class="content" <?php print $content_attributes; ?>>
<?php
// We hide the comments and links now so that we can render them later.
hide($content['comments']);
hide($content['links']);
hide($content['body']);
hide($content['field_codebox_type']);
print render($content);
?>
<h3>Instructions - Hotlinked</h3>
<p>This is the easiest method, use it if your website configuration allows it.</p>
<ol>
	<li>Copy the code below.</li>
	<li>Paste it in your website code where you would like the image to appear.</li>
</ol>
<p class="code"><code>
	<?php $fscs = token_replace("[current-user:profile-library-registration:field-library-reg-system]");
$field_image = 'http://impactsurvey.org/codebox/host/' . $node->field_image['und'][0]['filename'];
$code = "&lt;a href='http://impactsurvey.org/libselect/index.php?fscs=$fscs&utm_source=codebox&utm_medium=button-hotlinked&utm_content=$field_image&utm_term=$fscs&utm_campaign=pre-pilot'&gt;&lt;img title='Click here to take our survey' alt='Click here to take our survey' src='$field_image' border='0' /&gt;&lt;/a&gt;";
print $code;?>
</code></p>
<h3>Instructions - Hosted</h3>
<p>If your website doesn't permit hotlinked images, use this method.</p>
<ol>
	<li>Right click on the image and save it to your computer.</li>
	<li>Upload the image to a new directory called "impact" in the root of your web directory</li>
	<li>Press the button to select and copy your code.</li>
	<li>Paste this code into your website files.<br>You may need to adjust the image location.</li>
</ol>
<p class="code"><code>
	<?php $fscs = token_replace("[current-user:profile-library-registration:field-library-reg-system]");
$field_image = $node->field_image['und'][0]['filename'];
$code = "&lt;a href='http://impactsurvey.org/libselect/index.php?fscs=$fscs&utm_source=codebox&utm_medium=button-hosted&utm_content=$field_image&utm_term=$fscs&utm_campaign=pre-pilot'&gt;&lt;img title='Click here to take our survey' alt='Click here to take our survey' src='impact/$field_image' border='0' /&gt;&lt;/a&gt;";
print $code;?>
</code></p>