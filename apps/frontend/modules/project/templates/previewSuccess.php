<?php echo use_helper('markdown'); ?>
<style type="text/css" media="screen">
    body{
        font: 75% "Lucida Grande", "Trebuchet MS", Verdana, sans-serif;
    }
</style>

<div class="markdownbloc">
 <?php echo Markdown($description_preview); ?>
</div>