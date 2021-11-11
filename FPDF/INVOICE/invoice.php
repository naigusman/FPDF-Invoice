<?php
include("conn.php");
require('wrap.php');
$oid=$_GET['oid'];
header("X-Robots-Tag: noindex, nofollow", true);

function getorder_detail_col($colname,$order_uid)
{
    global $conn;
    $sql1=mysqli_query($conn,"SELECT * FROM `new_order` where `order_uid`='$order_uid'");
    if(mysqli_num_rows($sql1)>0)
    {
        $fetch_ord=mysqli_fetch_array($sql1);
        if($colname=="billing_name")
        {
            $nval=$fetch_ord['billing_name'];
            return $nval;

        }
        else if($colname=="total")
        {
            $nval=$fetch_ord['total'];
            return $nval;
        }
        else if($colname=="ord_date")
        {
            $nval=$fetch_ord['ord_date'];
            return $nval;   
        }
        else
        {
            $nval=0;
            return $nval;
        }
        
    }
    else
    {
        return 0;
    }
}

if(!empty($oid))
{
    $sql=mysqli_query($conn,"SELECT * FROM `new_order` where `order_uid`='$oid'");
    if(mysqli_num_rows($sql)>0)
    {
        $numrow=mysqli_num_rows($sql);
        if($numrow<5)
        {
            $height=150;
        }
        elseif($numrow>=5 && $numrow<=10)
        {
            $height=230;
        }
        else
        {
            $height=250;
        }

        // $sql1=mysqli_query($connect,"SELECT * FROM `new_order` where `order_uid`='$oid'");
        $fetch=mysqli_fetch_array($sql);
        $order_uid=$fetch['order_uid'];

        // $cus_mobile=getorder_detail_col('cus_mobile',$order_uid);
        // $cus_name=getorder_detail_col('cus_name',$order_uid);
        // $cus_info=$cus_name."M : +91-".$cus_mobile;
        $order_date=getorder_detail_col('ord_date',$order_uid);
        $order_time=getorder_detail_col('order_time',$order_uid);
        $order_dt=$order_date." ".$order_time;
        $final_amount=getorder_detail_col('total',$order_uid);

        $order_type=$fetch['order_type'];
        // $order_date=$fetch['ord_date'];
        $delivery_name=$fetch['delivery_name'];
        $delivery_contact=$fetch['delivery_contact'];

        $d_add="A : ";


                                            if(!empty($fetch['delivery_door']))
                                            {
                                              $d_add.=$fetch['delivery_door'];
                                            }
                                            if(!empty($fetch['delivery_fs']))
                                            {
                                              $d_add.=" ".$fetch['delivery_fs'];
                                            }
                                            if(!empty($fetch['delivery_landmark']))
                                            {
                                              $d_add.= ", ".$fetch['delivery_landmark'];
                                            }
                                            if(!empty($fetch['delivery_area']))
                                            {
                                              $d_add.= ", ".$fetch['delivery_area'];
                                            }
                                            if(!empty($fetch['delivery_city']))
                                            {
                                              $d_add.= ", ".$fetch['delivery_city'];
                                            }
                                            if(!empty($fetch['delivery_state']))
                                            {
                                              $d_add.= ", ".$fetch['delivery_state'];
                                            }
                                            if(!empty($fetch['delivery_pin']))
                                            {
                                              $d_add.= "- ".$fetch['delivery_pin'];
                                            } 
                                          


        $pdf=new PDF_MC_Table('P','mm',array(72,$height));
        $pdf->AddPage();

        $pdf->SetMargins(2,2,0);
        $pdf->Image('../logo.png',26,5,20,C);

        $pdf->Cell(72, 2, '', '', 1, '');        
            

        $pdf->SetFont('Arial','',7);
        $pdf->SetMargins(0,0,0);
        $pdf->MultiCell(70,3,'Reg Office : Complex,',0,C);
        $pdf->MultiCell(70,3,'Alkapuri, Vadodara -390011 Email : info@domain.in',0,C);
        $pdf->MultiCell(70,3,'Customer Care No : +91-xxxxxxxxxx',0,C);

        $pdf->SetMargins(2,2,0);
        $pdf->Cell(72, 2, '', '', 1, '');        
        

        $pdf->SetMargins(0,0,0);


        $pdf->SetMargins(2,0,0);
        $pdf->SetFillColor(179, 173, 173);
        $pdf->SetTextColor(255,255,255);

        $pdf->SetFont('Arial','',7);
        $pdf->Cell(28 ,5,'Invoice No : ',0,0,'L','TRUE');
        $pdf->Cell(40 ,5,'#'.$order_uid,0,1,'L','TRUE');
 
        

        $pdf->Cell(28 ,5,'Order Type : ',0,0,'L','TRUE');
        $pdf->Cell(40 ,5,$order_type,0,1,'L','TRUE');

        $pdf->Cell(28 ,5,'GST Registration No : ',0,0,'L','TRUE');
        $pdf->Cell(40 ,5,'24ABGCS2108F1ZR',0,1,'L','TRUE');

        $pdf->Cell(28 ,5,'Order Date : ',0,0,'L','TRUE');
        $pdf->Cell(40 ,5,$order_date,0,1,'L','TRUE');
        $pdf->Cell(28 ,5,'FSSAI : ',0,0,'L','TRUE');
        $pdf->Cell(40 ,5,'10721999000717',0,1,'L','TRUE');

        $pdf->SetTextColor(0);
        $pdf->SetFillColor(219, 221, 222);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(68 ,5,'Shipping Address',0,1,'C','TRUE');

        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(68 ,5,$delivery_name.' Mobile :'.$delivery_contact ,0,1,C);
        $pdf->SetFont('Arial','',10);
        
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial','',7);
        $pdf->MultiCell(68 ,4,$d_add,0,C);


        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(179, 173, 173);
        $pdf->SetTextColor(255,255,255);

        $pdf->Cell(30,8,'Product',1,0,'C','TRUE');        
        $pdf->Cell(8,8,'Qty',1,0,'C','TRUE');        
        $pdf->Cell(15,8,'Rate',1,0,'C','TRUE');
        $pdf->Cell(15,8,'Amount',1,1,'C','TRUE');

        $pdf->SetTextColor(0);
        $pdf->SetWidths(array(30,8,15,15));
        $pdf->SetFont('Arial','',7);
        $pdf->SetFillColor(255, 255, 255);

        foreach ($sql as $value) {

            $pdf->SetTopMargin(15);
            $name=$value['name'];
            // $name = iconv('UTF-8', 'windows-1252', $value['name']);
            $sku=$value['sku'];
            $orderqty=$value['order_qty'];

            if(!empty($value['size']))
            {
                $size=" | ".$value['size'];
            }
            if(!empty($value['color']))
            {
                $color=" | ".$value['color'];
            }
            $colorsize=$color.$size;
            $weight=$value['weight']." ".$value['unit'];
            $single_price=$value['sellerPrice'];
            $product_subtotal=$value['item_subtotal'];          
            
            $pdf->Row(array($name,$orderqty,$single_price,$product_subtotal));
            $pdf->Cell(68,4,'',0,1,'C','TRUE');
        }
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(15,8,'',0,0,L);
        $pdf->SetFont('Arial','B',10);
        
        $pdf->Cell(53,8,'Final Total Rs. '.$final_amount,0,1,R);

        // $pdf->Output();
        

        $pdf->Output('order_invoice/'.$order_uid.'.pdf','F');
        // $pdf->Output('order_invoice/'.$order_uid.'.pdf','D');
        $pdf->Output('order_invoice/'.$order_uid.'.pdf','I');



        // echo json_encode(array("status"=>1,"message"=>"Success"));
        // $pdf->Output($order_uid.'.pdf','D');
    }
}
else
{
    echo "Order Id Require";
}
// $pdf->Output('order_invoice/yourfilename.pdf','F');

//NOTE:FOR DownLoad
// $pdf->Output('yourfilename.pdf','D');
// Method 1: Saving the PDF to a file:
// $pdf->Output('yourfilename.pdf','F');
// Method 1 (for server): Saving the PDF file to server (make sure you have 777 writing permissions for that folder!):
// $pdf->Output('directory/yourfilename.pdf','F');
// Method 2: Prompting user to choose where to save the PDF file:
// $pdf->Output('yourfilename.pdf','D');
// Method 3: Automatically open PDF in your browser after being generated:
// $pdf->Output('yourfilename.pdf','I');
// Method 4: Returning the PDF file content as a string:
// $pdf->Output('', 'S');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="googlebot-news" content="nosnippet">
</head>

</html>
