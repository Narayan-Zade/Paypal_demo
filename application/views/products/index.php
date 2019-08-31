<div class="col-lg-12">
<!-- List all products -->
<?php 
$this->db->select('*');
        $this->db->from('products');
        $query = $this->db->get();
        $result = $query->result_array();
 
        for($i=0;$i<count($result);$i++){ ?>
        <center>
    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="<?php echo base_url('assets/images/'.$result[$i]['image']); ?>" width="200" height="200">
            <div class="caption">
                <h4 class="pull-right">$<?php echo $result[$i]['price']; ?> INR</h4>
                <h4><a href="javascript:void(0);"><?php echo $result[$i]['name']; ?></a></h4>
               
            </div>
           
               
                <form action="<?php echo base_url('index.php/Products/buy/'.$result[$i]['id']); ?>" method="post">
                    <!-- Identify your business so that you can collect the payments. -->
                    
                    <input type='hidden' name='notify_url' value="<?php echo base_url().'/index.php/Product/ipn/';?>">
                    
                    <!-- Specify details about the item that buyers will purchase. -->
                    <input type="hidden" name="item_name" value="<?php echo $result[$i]['name']; ?>">
                    <input type="hidden" name="item_number" value="<?php echo $result[$i]['id']; ?>">
                    <input type="hidden" name="amount" value="<?php echo $result[$i]['price']; ?>">
                    
                    <!-- Display the payment button. -->
                    <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif">
                </form>
            
        </div>
    </div>
    </center>
<?php } ?>
</div>