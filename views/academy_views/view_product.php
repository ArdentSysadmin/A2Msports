<div class="row">
    <?php if(!empty($products)): foreach($products as $product): ?>
    <div class="thumbnail">
        <img src="<?php echo base_url().'images/'."1.jpg"; ?>" alt="">
        <div class="caption">
            <h4 class="pull-right">$<?php echo "$25.00"; ?> USD</h4>
            <h4><a href="javascript:void(0);"><?php echo "Test Product"; ?></a></h4>
        </div>
        <a href="<?php echo base_url().'products/buy/'.'25'; ?>"><img src="<?php echo base_url(); ?>images/x-click-but01.gif" style="width: 70px;"></a>
    </div>
    <?php endforeach; endif; ?>
</div>