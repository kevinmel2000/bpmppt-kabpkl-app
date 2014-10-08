<div class="jumbotron">
    <h3><?php echo $heading ?></h3>
    <p><?php echo (is_array($message) ? implode('</p></p>', $message) : $message) ?></p>
</div>
