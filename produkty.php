<?php 
while ($row = mysqli_fetch_row($data)) : ?>
    <div class="product">
        <img src="<?=ROOT.'/'.$row[3]?>" alt="product">
            <div class="container">
                <label class="category"><?= $row[1] ?></label><br>
                <a href="#" class="product-name"><?= $row[0] ?>'</a>
            </div>
            <div class="flex-price-bottom container">
                <label class="price"><?= $row[2] ?>zł</label>
                <form action="<?= ROOT ?>/add-to-cart.php" method="POST">
                    <input type="hidden" name="id" value="<?= $row[4] ?>"/>
                    <button type="submit" class="add-btn">+</button>
                </form>
            </div> 
        </div>
    
<?php endwhile;
mysqli_close($conn);