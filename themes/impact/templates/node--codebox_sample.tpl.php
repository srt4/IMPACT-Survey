<?php
// $Id: node.tpl.php,v 1.34 2010/12/01 00:18:15 webchick Exp $

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<div id="node-<?php print $node->nid; ?>"
	class="<?php print $classes; ?> clearfix" <?php print $attributes; ?>>
<?php print $user_picture; ?> <?php print render($title_prefix); ?> <?php if (!$page): ?>
<h2 <?php print $title_attributes; ?>><a
	href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
<?php endif; ?> <?php print render($title_suffix); ?> <?php if ($display_submitted): ?>
<div class="submitted"><?php print $submitted; ?></div>
<?php endif; ?>

<div class="content" <?php print $content_attributes; ?>>
<h3>Instructions</h3>
<ol>
	<li>Right click on the image and save it to your computer.</li>
	<li>Upload the image to an appropriate location on your web server.</li>
	<li>Press the button to select and copy your code.</li>
	<li>Paste this code into an appropriate place in your website, you may
	need to seek a developer for help.</li>
</ol>

<?php
$fscs = token_replace("[current-user:profile-library-registration:field-library-reg-system]");
$field_image = $node->field_image['und'][0]['filename'];
//dpm($field_image);
//dpm($field_image['und'][0]['filename']);
//echo $node->field_image->und->0->filename;
$code = "&lt;a href='http://www.uwsrd.org/impact/index.asp?LibID=$fscs'&gt;&lt;img title='Click here to take our survey' alt='Click here to take our survey' src='$field_image' border='0' /&gt;&lt;/a&gt;";
?> <?php
// We hide the comments and links now so that we can render them later.
hide($content['comments']);
hide($content['links']);
hide($content['body']);
hide($content['field_codebox_type']);
print render($content);
?>
<form name="code_form"><textarea name="code_area" id="code" rows="6"
	cols="25">
	<?php print $code;?>
	</textarea> <br>
Click to copy <object id='clipboard'
	codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0'
	width='16' height='16' align='middle'>
	<param name='allowScriptAccess' value='always' />
	<param name='allowFullScreen' value='false' />
	<param name='movie' value='clipboard.swf' />
	<param name='quality' value='high' />
	<param name='bgcolor' value='#ffffff' />
	<param name='wmode' value='transparent' />
	<param name='flashvars' value='callback=f1' />
	<!--Below is the positon of SWF--> <embed src='clipboard.swf'
		flashvars='callback=f1' quality='high' bgcolor='#ffffff' width='16'
		height='16' wmode='transparent' name='clipboard' align='middle'
		allowscriptaccess='always' allowfullscreen='false'
		type='application/x-shockwave-flash'
		pluginspage='http://www.adobe.com/go/getflashplayer' /></object> 
		<!--new javascript-->
<script type="text/javascript">
     function f1() {
     var s = document.getElementById('code').value;

     var div = document.createElement('div');
     //div.innerText = '"' + s + '" copied to clipboard.';
     //var display = '"' + s + '" copied to clipboard.';
                alert('Content has been copied');
                document.body.appendChild(div);

     if (window.clipboardData)
     window.clipboardData.setData('text', s);
     else
     return (s);
     }
    </script></form>
<!-- 
	<input onclick="selectit('code_form.code_area')" type="button" value="Press to Select the Text" name="select">

	<script LANGUAGE="JavaScript">
    function selectit(theField) {
    var tempval=eval("document."+theField)
    tempval.focus()
    tempval.select()
    }
    </script>
 	--></div>
 	<?php print render($content['links']); ?> <?php print render($content['comments']); ?>

</div>
