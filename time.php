<!-- problem in page products update

netlify.com => sarah-1994+

////////////////////////////

1) prepare design of dashboard.php ok ok ok /// it still: prepare 5 latest products / still some issues

3) prepare website issues ok ok ok/// it still only page descover the product i guess

4) i must made function get 5 latest ok ok ok

5) i must made subcategories in page descover to upload more pictures to the same product. video 117. ?????????
also i mast prepare page discover.??????

6) i must made total product is... ???? / OK OK OK OK.

I must made the condition of (if) in page products in folder admin OK OK OK OK OK

i must prepare page orders / field of control (delete) .
///////////////////////////
i am in page products in do == "picture" -->

thanks to the GOD, i find the solution of this: problem of :
 if(isset($_GET["productid"]) && is_numeric($_GET["productid"])){$productid = intval($_GET["productid"]);}else{$productid = 0 ;}
<!-- 
0) i must prepare change photo in products in line 187 } 0 it's ok

0) i must find a solution for update major picture in line 224 in page products. } 0 --> it's ok

<!-- 1 i must prepare avatar in products page manage -->  it's ok

2) i must prepare avatar in page stock in manage: AFTER


important: i must made tables dynamique of products, stock, orders

<!-- it still a problem in update photo in page products in $do == update line 197. --> it's ok

<!--
3) i must find a solution for table orders and the amount of goods: i mean when the order done  the amount must get mince 1 of it amount.  }

3) thought of this and try it: if(.....){update $row[amount] - 1}  it's ok
i am still between page orders and stock. 
--> it's ok
i am now in line 36 in of page time.php.

for Mohammad

i am in page buy.php in line 10, you will understand everything.