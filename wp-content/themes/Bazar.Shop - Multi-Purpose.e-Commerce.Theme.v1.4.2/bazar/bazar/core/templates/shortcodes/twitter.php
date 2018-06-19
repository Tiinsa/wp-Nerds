<?php 
	$time = (isset($time) && strcmp($time, 'yes') == 0) ? 'true' : 'false';
	$replies = (isset($replies) && strcmp($replies, 'yes') == 0) ? 'true' : 'false';	
?>

<div class="<?php echo $class; ?>"></div>

<script type="text/javascript">
jQuery(function($){
    $('.<?php echo $class; ?>').tweetable({
        id: 'tweets',
        username: '<?php echo $username; ?>', 
        time: <?php echo $time; ?>, 
        limit: <?php echo $items; ?>, 
        replies: <?php echo $replies; ?>
    });
});
</script>