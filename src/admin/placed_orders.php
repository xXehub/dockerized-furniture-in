<?php
include '../components/connect.php';
ob_start();
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
   $order_id = $_POST['order_id'];
   $payment_status = htmlspecialchars($_POST['payment_status'], ENT_QUOTES, 'UTF-8');
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'Payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

// fungsi gawe pagination
$limit = 8;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; 
$offset = ($page - 1) * $limit; 

$total_orders_query = $conn->prepare("SELECT COUNT(*) FROM `orders`");
$total_orders_query->execute();
$total_orders = $total_orders_query->fetchColumn();
$total_pages = ceil($total_orders / $limit); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Jawir.In - eCommerce Website</title>

   <!--- favicon-->
   <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="./assets/css/admin_style.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <main>
      <div class="product-container">
         <div class="container">
            <!-- pembeli terbaru -->
            <div class="sidebar  has-scrollbar" data-productsle-menu>
               <div class="sidebar-top">
                  <h2 class="sidebar-title">10 Pembeli Teratas</h2>

                  <button class="sidebar-close-btn" data-productsle-menu-close-btn>
                     <ion-icon name="close-outline"></ion-icon>
                  </button>
               </div>
               <div class="sidebar-category">
                  <!-- query ambil data kategori -->
                  <?php
                  $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC LIMIT $limit OFFSET $offset");
                  $select_orders->execute();
                  if ($select_orders->rowCount() > 0) {
                     while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                        <ul class="sidebar-menu-category-list">
                           <li class="sidebar-menu-category">
                              <button class="sidebar-accordion-menu" data-accordion-btn>
                                 <form action="" method="post" class="swiper-slide slide">
                                    <input type="hidden" name="name" value="<?= $fetch_orders['name']; ?>">
                                    <div class="menu-title-flex">
                                       <a class="menu-title"
                                          href="category.php?category=<?= $fetch_orders['name']; ?>"><?= $fetch_orders['name']; ?></a>
                                    </div>
                                 </form>
                                 <?php
                     }
                  } else {
                     echo '<p class="empty">no products added yet!</p>';
                  }
                  ?>
                           <!-- <div>
                                                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                                                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                                            </div> -->

                        </button>

                        <ul class="sidebar-submenu-category-list" data-accordion>

                           <li class="sidebar-submenu-category">
                              <a href="#" class="sidebar-submenu-title">
                                 <p class="product-name">Shirt</p>
                                 <data value="300" class="stock" title="Available Stock">300</data>
                              </a>
                           </li>

                           <li class="sidebar-submenu-category">
                              <a href="#" class="sidebar-submenu-title">
                                 <p class="product-name">shorts & jeans</p>
                                 <data value="60" class="stock" title="Available Stock">60</data>
                              </a>
                           </li>

                           <li class="sidebar-submenu-category">
                              <a href="#" class="sidebar-submenu-title">
                                 <p class="product-name">jacket</p>
                                 <data value="50" class="stock" title="Available Stock">50</data>
                              </a>
                           </li>

                           <li class="sidebar-submenu-category">
                              <a href="#" class="sidebar-submenu-title">
                                 <p class="product-name">dress & frock</p>
                                 <data value="87" class="stock" title="Available Stock">87</data>
                              </a>
                           </li>

                        </ul>

                     </li>
                     <!--  -->
                  </ul>

               </div>

            </div>

            <!-- pesanan -->
            <div class="product-box">
               <div class="product-main">
                  <h2 class="title"><i class="fa-solid fa-cart-shopping"></i> LIST PESANAN</h2>
                  <div class="product-grid">
                     <?php
                     $select_orders = $conn->prepare("SELECT * FROM `orders` LIMIT $limit OFFSET $offset");
                     $select_orders->execute();
                     if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                           ?>
                           <div class="showcase-wrapper has-scrollbar">
                              <div class="showcase-container">
                                 <div class="showcase">
                                    <div class="showcase-content">
                                       <a href="#">
                                          <h4 class="showcase-title"><i class="fa-solid fa-user"></i>
                                             <span><?= $fetch_orders['name']; ?></span>
                                          </h4>
                                       </a>

                                       <a href="#" class="showcase-category"><i class="fa-solid fa-calendar"></i>
                                          <span><?= $fetch_orders['placed_on']; ?></span> </a>
                                       <a class="showcase-category">
                                          <p><i class="fa-solid fa-truck"></i> <span><?= $fetch_orders['method']; ?></span>
                                          </p>
                                       </a>
                                       <div class="price-box">
                                          <p class="price"><span>Rp.<?= $fetch_orders['total_price']; ?>,00</span></p>
                                       </div>
                                       <form action="" method="post">
                                          <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                          <select name="payment_status" class="kolom-field">
                                             <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                             <option value="pending">pending</option>
                                             <option value="completed">completed</option>
                                          </select>
                                          <div class="price-box">
                                             <button type="submit" value="perbarui" class="btn btn-wishlist"
                                                name="update_payment"><i class="fa-solid fa-pen-to-square"></i></button>
                                             <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>"
                                                class="btn btn-delete" onclick="return confirm('Hapus pesanan ini?');"><i
                                                   class="fa-solid fa-trash"></i></a>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php
                        }
                     } else {
                        echo '<p class="empty">Tidak ada pesanan!</p>';
                     }
                     ?>
                  </div>
               </div>
               <style>
                  .pagination {
                     display: flex;
                     justify-content: center;
                     align-items: center;
                     margin-top: 20px;
                  }

                  .pagination a {
                     display: inline-block;
                     padding: 5px 10px;
                     margin: 0 3px;
                     font-size: 14px;
                     font-weight: bold;
                     color: #333;
                     background-color: #f1f1f1;
                     border: 1px solid #ccc;
                     text-decoration: none;
                     border-radius: 3px;
                     transition: background-color 0.2s;
                  }

                  .pagination a:hover {
                     background-color: var(--salmon-pink);
                     color: white;
                  }

                  .pagination .active {
                     background-color: var(--salmon-pink);
                     color: white;
                     pointer-events: none;

                  }
               </style>

               <div class="pagination">
                  <?php
                  $count_query = $conn->prepare("SELECT COUNT(*) FROM `orders`");
                  $count_query->execute();
                  $total_orders = $count_query->fetchColumn();
                  $total_pages = ceil($total_orders / $limit);

                  // Previous page link
                  if ($page > 1) {
                     echo '<a href="placed_orders.php?page=' . ($page - 1) . '" class="arrow">&#8592;</a>';
                  } else {
                     echo '<a href="#" class="arrow" disabled>&#8592;</a>';
                  }
                  for ($i = 1; $i <= $total_pages; $i++) {
                     if ($i == $page) {
                        echo '<a href="#" class="active">' . $i . '</a>';
                     } else {
                        echo '<a href="placed_orders.php?page=' . $i . '">' . $i . '</a>';
                     }
                  }

                  // Next page link
                  if ($page < $total_pages) {
                     echo '<a href="placed_orders.php?page=' . ($page + 1) . '" class="arrow">&#8594;</a>';
                  } else {
                     echo '<a href="#" class="arrow" disabled>&#8594;</a>';
                  }
                  ?>
               </div>
            </div>

         </div>

      </div>

   </main>

   <script src="../js/admin_script.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>

</body>

</html>