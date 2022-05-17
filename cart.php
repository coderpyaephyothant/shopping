<?php
include 'header.php';
require 'config/config.php';
// print"<pre>";
// print_r($_SESSION['cart']);
 ?>

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_price =0;
                              if (!empty($_SESSION['cart'])){

                                foreach ($_SESSION['cart'] as $key => $quantity) :

                                  $keyId = str_replace('id','',$key);
                                  $pdo_cart_products = $pdo->prepare(" SELECT * FROM products WHERE id=$keyId ");
                                  $pdo_cart_products->execute();
                                  $result_session_products = $pdo_cart_products->fetch(PDO::FETCH_ASSOC);

                                  $total_each = $result_session_products['price'] * $quantity;
                                  // echo $total_each;
                                  $total_price += $total_each;
                                  // echo $total_price;
                                  ?>
                                  <tr>
                                      <td>
                                          <div class="media">
                                              <div class="d-flex" style="width:100px; height:80px; background-size:cover;">
                                                  <img src="admin/images/<?php echo escape($result_session_products['image']); ?>" alt="" width="100%" height="100%">
                                              </div>
                                              <div class="media-body">
                                                  <b><?php echo escape($result_session_products['name']); ?></b>
                                                  <p><?php echo escape($result_session_products['description']); ?></p>
                                              </div>
                                          </div>
                                      </td>
                                      <td>
                                          <h5><?php echo escape($result_session_products['price'].' MMK'); ?></h5>
                                      </td>
                                      <td>
                                          <div class="product_count">
                                              <input type="text" readonly name="qty" id="sst" maxlength="12" value="<?php echo escape($quantity); ?>" title="Quantity:"
                                                  class="input-text qty">
                                          </div>
                                      </td>
                                      <td>
                                          <h5><?php echo escape($total_each); ?></h5>
                                      </td>
                                      <td>
                                        <a href="clear_item.php?cat_id=<?php echo escape($result_session_products['id']); ?>"
                                          class="btn btn-success"
                                            onclick="return confirm('Are you sure you want to delete this item?')"
                                          >Delete</a>
                                      </td>
                                  </tr>
                              <?php
                            endforeach

                                 ?>

                            <?php  } ?>


                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <!-- <td>

                                </td> -->
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo escape($total_price); ?></h5>
                                </td>
                            </tr>

                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                      <a class="gray_btn" href="index.php"><i class="fa fa-caret-left"></i>&nbsp;  Back</a> &nbsp; &nbsp;
                                      <a class="btn btn-success" href="clear_all.php"><i class="fa fa-trash"></i> Clear Orders</a>&nbsp; &nbsp;
                                        <a class="btn btn-success" href="submit_orders.php"><i class="fa fa-calculator"></i> Submit Orders</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

  <?php
  include 'footer.php';
   ?>
