<?php
session_start();


  if (isset($_SESSION['username'])) {
      $GLOBALS['main'] = $_SESSION['username'];
      $GLOBALS['mainid'] = $_SESSION['id'];
      $GLOBALS['level'] = $_SESSION['level'];
      $GLOBALS['lang'] = $_SESSION['lang'];
      $GLOBALS['b_id'] = $_SESSION['b_id'];

    $pageTitle = 'Contracts';

 include '../../init1.php';
 $do   = '';

    if (isset($_GET['do'])) {
      $do = $_GET['do'];
    } else {
      $do = 'Manage';
    }

	if($do == 'Manage')  {

		  $stmt = $con->prepare("SELECT  * FROM contract where b_id = ? and cancel != ?  ORDER BY id desc  ");
		  $stmt->execute(array($b_id,'1'));
		  $rows = $stmt->fetchAll();
		  $no = 1;

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>

<section class="content">
  <style type="text/css">
    .bg-red {
    background-color: #fff!important;
    color: #259888 !important;
}
  </style>

          <div class="box box-widget">
           <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">   <?php if($lang =='1'){ ?>  All Category Data    <?php }elseif($lang == '2'){ ?> العقود <?php } ?></h3>
                    <div class="pull-right">
                    <a href="?do=Add" class="btn btn-warning btn-flat" ><i class="fa fa-user-plus"></i>
                          <?php if($lang =='1'){ ?> Create   <?php }elseif($lang == '2'){ ?> إضافة <?php } ?> </a>
                    </div>
              </div>
			  	<div class="box-header" style="padding: 15px;">
        					<div class="fixed-table-toolbar">
        						<div class="row">
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=Manage"><button class="btn btn-block btn-success btn-lg btn-flat">  <i class="fa fa-book"></i> كل  الحجوزات </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=open"><button class="btn btn-block btn-primary btn-lg btn-flat"> <i class="fa fa-exchange"></i> المفتوحة </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                        <a href="?do=noconforim"><button class="btn btn-block btn-warning btn-lg btn-flat" > <i class="fa fa-hourglass-3"></i> الغير مؤكدة  </button></a>
			                       </div>
			                     </div>
								  <div class="col-md-3">
			                       <div class="space">
								   <a href="?do=cancel"><button class="btn btn-block btn-danger btn-lg btn-flat" >  <i class="fa fa-times-circle"></i> الملغية</button></a>

			                       </div>
			                     </div>

			                    </div>
							</div>
        				</div>
              <div class="box-body table-responsive">
                <table class="table table-striped table-bordered" id="table1">
                  <thead>
                  <tr>
                    <th>#</th>
				          	<th>رقم العقد </th>
                    <th>الإسم</th>
                    <th>جوال</th>
                    <th>مبلغ الإيجار</th>
                    <th>العربون</th>
                    <th>المتبقي</th>
                    <th> تاريخ  الانشاء </th>
                    <th> الحالة </th>
                    <th> بداية الإيجار</th>
                    <th>نهاية الإيجار</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php


				  $stmt = $con->prepare("SELECT  * FROM contract where b_id = ? and cancel != ?  ORDER BY id desc  ");
				  $stmt->execute(array($b_id,'1'));
				  $rows = $stmt->fetchAll();
				  $no = 1;



                    foreach ($rows as $row)
                  {?>
               <tr>
                    <td><?php echo $no++; ?></td>
						<td><?php echo $row['contract_no'] ?></td>
                        <td ><a href="?do=view&&id=<?php echo $row['contract_no'] ?>" style="color: #005"><?php  $row['contract_no'] ?><?php echo $row['name']; ?></a></td>

                        <td ><?php echo $row['phone']; ?></td>
                        <td ><span class="label label-danger"> <?php echo $row['rent_price']; ?></span></td>
                        <td ><span class="label label-warning"> <?php echo $row['down_payment']; ?></span></td>
                        <td><span class="label label-info"> <?php echo $row['remaining']; ?></td>

              <td><?php echo $row['date']; ?></td>
              <td><?php  $st=$row['st']; if($st == '0'){ ?> <span class="label label-danger">   <?php echo'غير  مؤكد ';  ?></span> <?php }elseif($st == '1'){ ?>
              <span class="label label-success">   <?php echo'  مؤكد ';  ?></span>  <?php }elseif($st == '2'){ ?>
              <span class="label label-primary">   <?php echo'  مفتوح  ';  ?></span>  <?php }elseif($st == '3'){ ?>
              <span class="label label-danger">   <?php echo'   ملغي  ';  ?></span> <?php } ?></td>
              <td ><?php echo $row['start_date']; ?></td>
              <td ><?php echo $row['end_date']; ?></td>

            <td style="width: 250px">
                  <?php $rem = $row['remaining']; if($rem == '0'){   }else{ ?>
                  <a  class="btn btn-primary btn-xs"   href="?do=pay&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-cc"></i>   سداد   </a>
                  <a  class="btn btn-warning btn-xs"   href="?do=Edit&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-edit"></i>  تعديل   </a>
                  <a href="#modalDelete" data-toggle="modal" onclick="$('#modalDelete #formDelete').attr('action', '?do=Delete&&id=<?php echo $row['contract_no'] ?>')" class="btn btn-danger btn-xs">
                  <i class="fa fa-trash"></i> <?php if($lang =='1'){ ?> Delete   <?php }elseif($lang == '2'){ ?> حذف <?php } ?>
                  </a>
                  <?php 	}	?>
						      <a  class="btn btn-success btn-xs"   href="?do=print&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-file-pdf-o"></i>  طباعة  </a>
           </td>
               </tr>

             <?php } ?>
             </tbody>

                </table>

              </div>

        </div>

		</div>


        <div class="modal fade" id="modalDelete">
        		<div class="modal-dialog modal-xs">
        					<div class="modal-content">
        							<div class="modal-header">
        									<button type="button" class="close" data-dixsiss="modal" aria-label="Close">
        											<span  aria-hidden="true">&times</span>
        									</button>
        									<h4>    <?php if($lang =='1'){ ?>  Are You Sure You Want To Delete
                          <?php }elseif($lang == '2'){ ?> هل انت متاكد من الحذف <?php } ?>
                            </h4>
        							</div>
        							<div class="modal-footer">
        								<form id="formDelete" action="" method="post">
        										<button class="btn btn-default" data-dixsiss="modal"><?php if($lang =='1'){ ?> Cancel
                            <?php }elseif($lang == '2'){ ?>   إلغاء <?php } ?>  </button>
        										<button class="btn btn-danger" type="submit"><?php if($lang =='1'){ ?>
                              Delete
                            <?php }elseif($lang == '2'){ ?>
                             نعم احذف <?php } ?>
                                 </button>
        								</form>
        							</div>
        						</div>
        				</div>
        			</div>


    </section>


<?php } elseif ($do == 'open') {


		  $no = 1;

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>

<section class="content">
  <style type="text/css">
    .bg-red {
    background-color: #fff!important;
    color: #259888 !important;
}
  </style>

          <div class="box box-widget">
           <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">   <?php if($lang =='1'){ ?>  All Category Data    <?php }elseif($lang == '2'){ ?> العقود <?php } ?></h3>
                    <div class="pull-right">
                    <a href="?do=Add" class="btn btn-warning btn-flat" ><i class="fa fa-user-plus"></i>
                          <?php if($lang =='1'){ ?> Create   <?php }elseif($lang == '2'){ ?> إضافة <?php } ?> </a>
                    </div>
              </div>
			  	<div class="box-header" style="padding: 15px;">
        					<div class="fixed-table-toolbar">
        						<div class="row">
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=Manage"><button class="btn btn-block btn-success btn-lg btn-flat">  <i class="fa fa-book"></i> كل  الحجوزات </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=open"><button class="btn btn-block btn-primary btn-lg btn-flat"> <i class="fa fa-exchange"></i> المفتوحة </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                        <a href="?do=noconforim"><button class="btn btn-block btn-warning btn-lg btn-flat" > <i class="fa fa-hourglass-3"></i> الغير مؤكدة  </button></a>
			                       </div>
			                     </div>
								  <div class="col-md-3">
			                       <div class="space">
								   <a href="?do=cancel"><button class="btn btn-block btn-danger btn-lg btn-flat" >  <i class="fa fa-times-circle"></i> الملغية</button></a>

			                       </div>
			                     </div>

			                    </div>
							</div>
        				</div>
              <div class="box-body table-responsive">
                <table class="table table-striped table-bordered" id="table1">
                  <thead>
                  <tr>
                    <th>#</th>
					          <th>رقم العقد </th>
                    <th>الإسم</th>
                    <th>جوال</th>
                    <th>مبلغ الإيجار</th>
                    <th>العربون</th>
                    <th>المتبقي</th>
                    <th> تاريخ  الانشاء </th>
                    <th> الحالة </th>
                    <th> بداية الإيجار</th>
                    <th>نهاية الإيجار</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php


					$stmt = $con->prepare("SELECT  * FROM contract where b_id = ? and cancel != ?  and copen = ?  ORDER BY id desc  ");
					$stmt->execute(array($b_id,'1','1'));
					$rows = $stmt->fetchAll();
				  $no = 1;



                    foreach ($rows as $row)
                  {?>
               <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['contract_no'] ?></td>
                        <td ><a href="?do=view&&id=<?php echo $row['contract_no'] ?>" style="color: #005"><?php  $row['contract_no'] ?><?php echo $row['name']; ?></a></td>
                        <td ><?php echo $row['phone']; ?></td>
                        <td ><span class="label label-danger"> <?php echo $row['rent_price']; ?></span></td>
                        <td ><span class="label label-warning"> <?php echo $row['down_payment']; ?></span></td>
                        <td><span class="label label-info"> <?php echo $row['remaining']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php  $st=$row['st']; if($st == '0'){ ?> <span class="label label-danger">   <?php echo'غير  مؤكد ';  ?></span> <?php }elseif($st == '1'){ ?>
                        <span class="label label-success">   <?php echo'  مؤكد ';  ?></span>  <?php }elseif($st == '2'){ ?>
                        <span class="label label-primary">   <?php echo'  مفتوح  ';  ?></span>  <?php }elseif($st == '3'){ ?>
                        <span class="label label-danger">   <?php echo'   ملغي  ';  ?></span> <?php } ?></td>
                        <td ><?php echo $row['start_date']; ?></td>
                        <td ><?php echo $row['end_date']; ?></td>

                        <td style="width: 250px">
                            <?php $rem = $row['remaining']; if($rem == '0'){   }else{ ?>
                            <a  class="btn btn-primary btn-xs"   href="?do=pay&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-cc"></i>   سداد   </a>
                            <a  class="btn btn-warning btn-xs"   href="?do=Edit&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-edit"></i>  تعديل   </a>
                            <a href="#modalDelete" data-toggle="modal" onclick="$('#modalDelete #formDelete').attr('action', '?do=Delete&&id=<?php echo $row['contract_no'] ?>')" class="btn btn-danger btn-xs">
                               <i class="fa fa-trash"></i> <?php if($lang =='1'){ ?> Delete   <?php }elseif($lang == '2'){ ?> حذف <?php } ?>
                            </a>
                            <?php 	}	?>
						               <a  class="btn btn-success btn-xs"   href="?do=print&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-file-pdf-o"></i>  طباعة  </a>
                      </td>
               </tr>

             <?php } ?>
             </tbody>

                </table>

              </div>

        </div>

		</div>


        <div class="modal fade" id="modalDelete">
        		<div class="modal-dialog modal-xs">
        					<div class="modal-content">
        							<div class="modal-header">
        									<button type="button" class="close" data-dixsiss="modal" aria-label="Close">
        											<span  aria-hidden="true">&times</span>
        									</button>
        									<h4>    <?php if($lang =='1'){ ?>  Are You Sure You Want To Delete
                          <?php }elseif($lang == '2'){ ?> هل انت متاكد من الحذف <?php } ?>
                            </h4>
        							</div>
        							<div class="modal-footer">
        								<form id="formDelete" action="" method="post">
        										<button class="btn btn-default" data-dixsiss="modal"><?php if($lang =='1'){ ?> Cancel
                            <?php }elseif($lang == '2'){ ?>   إلغاء <?php } ?>  </button>
        										<button class="btn btn-danger" type="submit"><?php if($lang =='1'){ ?>
                              Delete
                            <?php }elseif($lang == '2'){ ?>
                             نعم احذف <?php } ?>
                                 </button>
        								</form>
        							</div>
        						</div>
        				</div>
        			</div>


    </section>


<?php } elseif ($do == 'noconforim') {


		  $no = 1;

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>

<section class="content">
  <style type="text/css">
    .bg-red {
    background-color: #fff!important;
    color: #259888 !important;
}
  </style>

          <div class="box box-widget">
           <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">   <?php if($lang =='1'){ ?>  All Category Data    <?php }elseif($lang == '2'){ ?> العقود <?php } ?></h3>
                    <div class="pull-right">
                    <a href="?do=Add" class="btn btn-warning btn-flat" ><i class="fa fa-user-plus"></i>
                          <?php if($lang =='1'){ ?> Create   <?php }elseif($lang == '2'){ ?> إضافة <?php } ?> </a>
                    </div>
              </div>
			  	<div class="box-header" style="padding: 15px;">
        					<div class="fixed-table-toolbar">
        						<div class="row">
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=Manage"><button class="btn btn-block btn-success btn-lg btn-flat">  <i class="fa fa-book"></i> كل  الحجوزات </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=open"><button class="btn btn-block btn-primary btn-lg btn-flat"> <i class="fa fa-exchange"></i> المفتوحة </button></a>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                        <a href="?do=noconforim"><button class="btn btn-block btn-warning btn-lg btn-flat" > <i class="fa fa-hourglass-3"></i> الغير مؤكدة  </button></a>
			                       </div>
			                     </div>
								  <div class="col-md-3">
			                       <div class="space">
								   <a href="?do=cancel"><button class="btn btn-block btn-danger btn-lg btn-flat" >  <i class="fa fa-times-circle"></i> الملغية</button></a>

			                       </div>
			                     </div>

			                    </div>
							</div>
        				</div>
              <div class="box-body table-responsive">
                <table class="table table-striped table-bordered" id="table1">
                  <thead>
                  <tr>
                    <th>#</th>
					          <th>رقم العقد </th>
                    <th>الإسم</th>
                    <th>جوال</th>
                    <th>مبلغ الإيجار</th>
                    <th>العربون</th>
                    <th>المتبقي</th>
                    <th> تاريخ  الانشاء </th>
                    <th> الحالة </th>
                    <th> بداية الإيجار</th>
                    <th>نهاية الإيجار</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php


					$stmt = $con->prepare("SELECT  * FROM contract where b_id = ? and cancel != ?  and copen != ?  and st = ? ORDER BY id desc  ");
					$stmt->execute(array($b_id,'1','1','0'));
					$rows = $stmt->fetchAll();
				  $no = 1;

                    foreach ($rows as $row)
                  {?>
               <tr>
                    <td><?php echo $no++; ?></td>
						<td><?php echo $row['contract_no'] ?></td>
                        <td ><a href="?do=view&&id=<?php echo $row['contract_no'] ?>" style="color: #005"><?php  $row['contract_no'] ?><?php echo $row['name']; ?></a></td>

                        <td ><?php echo $row['phone']; ?></td>
                        <td ><span class="label label-danger"> <?php echo $row['rent_price']; ?></span></td>
                        <td ><span class="label label-warning"> <?php echo $row['down_payment']; ?></span></td>
                        <td><span class="label label-info"> <?php echo $row['remaining']; ?></td>

                         <td><?php echo $row['date']; ?></td>
                         <td><?php  $st=$row['st']; if($st == '0'){ ?> <span class="label label-danger">   <?php echo'غير  مؤكد ';  ?></span> <?php }elseif($st == '1'){ ?>
						 <span class="label label-success">   <?php echo'  مؤكد ';  ?></span>  <?php }elseif($st == '2'){ ?>
						 <span class="label label-primary">   <?php echo'  مفتوح  ';  ?></span>  <?php }elseif($st == '3'){ ?>
						 <span class="label label-danger">   <?php echo'   ملغي  ';  ?></span> <?php } ?></td>
                        <td ><?php echo $row['start_date']; ?></td>
                        <td ><?php echo $row['end_date']; ?></td>

                  <td style="width: 250px">
					<?php $rem = $row['remaining']; if($rem == '0'){   }else{ ?>
							<a  class="btn btn-primary btn-xs"   href="?do=pay&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-cc"></i>   سداد   </a>
							<a  class="btn btn-warning btn-xs"   href="?do=Edit&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-edit"></i>  تعديل   </a>
							<a href="#modalDelete" data-toggle="modal" onclick="$('#modalDelete #formDelete').attr('action', '?do=Delete&&id=<?php echo $row['contract_no'] ?>')" class="btn btn-danger btn-xs">
                       <i class="fa fa-trash"></i> <?php if($lang =='1'){ ?> Delete   <?php }elseif($lang == '2'){ ?> حذف <?php } ?>
                    </a>
					<?php 	}	?>

						<a  class="btn btn-success btn-xs"   href="?do=print&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-file-pdf-o"></i>  طباعة  </a>
          </td>
     </tr>
             <?php } ?>
             </tbody>

                </table>

              </div>

        </div>

		</div>


        <div class="modal fade" id="modalDelete">
        		<div class="modal-dialog modal-xs">
        					<div class="modal-content">
        							<div class="modal-header">
        									<button type="button" class="close" data-dixsiss="modal" aria-label="Close">
        											<span  aria-hidden="true">&times</span>
        									</button>
        									<h4>    <?php if($lang =='1'){ ?>  Are You Sure You Want To Delete
                          <?php }elseif($lang == '2'){ ?> هل انت متاكد من الحذف <?php } ?>
                            </h4>
        							</div>
        							<div class="modal-footer">
        								<form id="formDelete" action="" method="post">
        										<button class="btn btn-default" data-dixsiss="modal"><?php if($lang =='1'){ ?> Cancel
                            <?php }elseif($lang == '2'){ ?>   إلغاء <?php } ?>  </button>
        										<button class="btn btn-danger" type="submit"><?php if($lang =='1'){ ?>
                              Delete
                            <?php }elseif($lang == '2'){ ?>
                             نعم احذف <?php } ?>
                                 </button>
        								</form>
        							</div>
        						</div>
        				</div>
        			</div>


    </section>

<?php } elseif ($do == 'cancel') {


		  $no = 1;

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>

<section class="content">
  <style type="text/css">
    .bg-red {
    background-color: #fff!important;
    color: #259888 !important;
}
  </style>

          <div class="box box-widget">
           <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">   <?php if($lang =='1'){ ?>  All Category Data    <?php }elseif($lang == '2'){ ?> العقود <?php } ?></h3>
                    <div class="pull-right">
                    <a href="?do=Add" class="btn btn-warning btn-flat" ><i class="fa fa-user-plus"></i>
                          <?php if($lang =='1'){ ?> Create   <?php }elseif($lang == '2'){ ?> إضافة <?php } ?> </a>
                    </div>
              </div>
			  	<div class="box-header" style="padding: 15px;">
        					<div class="fixed-table-toolbar">
        						<div class="row">
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=Manage"><button class="btn btn-block btn-success btn-lg btn-flat">  <i class="fa fa-book"></i> كل  الحجوزات </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                       <a href="?do=open"><button class="btn btn-block btn-primary btn-lg btn-flat"> <i class="fa fa-exchange"></i> المفتوحة </button></a>
			                       </div>
			                     </div>
			                     <div class="col-md-3">
			                       <div class="space">
			                        <a href="?do=noconforim"><button class="btn btn-block btn-warning btn-lg btn-flat" > <i class="fa fa-hourglass-3"></i> الغير مؤكدة  </button></a>
			                       </div>
			                     </div>
								  <div class="col-md-3">
			                       <div class="space">
								   <a href="?do=cancel"><button class="btn btn-block btn-danger btn-lg btn-flat" >  <i class="fa fa-times-circle"></i> الملغية</button></a>

			                       </div>
			                     </div>

			                    </div>
							</div>
        				</div>
              <div class="box-body table-responsive">
                <table class="table table-striped table-bordered" id="table1">
                  <thead>
                  <tr>
                    <th>#</th>
					<th>رقم العقد </th>
                    <th>الإسم</th>
                    <th>جوال</th>
                    <th>مبلغ الإيجار</th>
                    <th>العربون</th>
                    <th>المتبقي</th>
                    <th> تاريخ  الانشاء </th>
                    <th> الحالة </th>
                    <th> بداية الإيجار</th>
                    <th>نهاية الإيجار</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php


					$stmt = $con->prepare("SELECT  * FROM contract where b_id = ? and cancel = ?    ORDER BY id desc  ");
					$stmt->execute(array($b_id,'1'));
					$rows = $stmt->fetchAll();
				  $no = 1;


                    foreach ($rows as $row)
                  {?>
               <tr>
                    <td><?php echo $no++; ?></td>
						<td><?php echo $row['contract_no'] ?></td>
                        <td ><a href="?do=view&&id=<?php echo $row['contract_no'] ?>" style="color: #005"><?php  $row['contract_no'] ?><?php echo $row['name']; ?></a></td>

                        <td ><?php echo $row['phone']; ?></td>
                        <td ><span class="label label-danger"> <?php echo $row['rent_price']; ?></span></td>
                        <td ><span class="label label-warning"> <?php echo $row['down_payment']; ?></span></td>
                        <td><span class="label label-info"> <?php echo $row['remaining']; ?></td>

                         <td><?php echo $row['date']; ?></td>
                         <td><?php  $st=$row['st']; if($st == '0'){ ?> <span class="label label-danger">   <?php echo'غير  مؤكد ';  ?></span> <?php }elseif($st == '1'){ ?>
						 <span class="label label-success">   <?php echo'  مؤكد ';  ?></span>  <?php }elseif($st == '2'){ ?>
						 <span class="label label-primary">   <?php echo'  مفتوح  ';  ?></span>  <?php }elseif($st == '3'){ ?>
						 <span class="label label-danger">   <?php echo'   ملغي  ';  ?></span> <?php } ?></td>
                        <td ><?php echo $row['start_date']; ?></td>
                        <td ><?php echo $row['end_date']; ?></td>

                        <td></td>
               </tr>

             <?php } ?>
             </tbody>

                </table>

              </div>

        </div>

		</div>


        <div class="modal fade" id="modalDelete">
        		<div class="modal-dialog modal-xs">
        					<div class="modal-content">
        							<div class="modal-header">
        									<button type="button" class="close" data-dixsiss="modal" aria-label="Close">
        											<span  aria-hidden="true">&times</span>
        									</button>
        									<h4>    <?php if($lang =='1'){ ?>  Are You Sure You Want To Delete
                          <?php }elseif($lang == '2'){ ?> هل انت متاكد من الحذف <?php } ?>
                            </h4>
        							</div>
        							<div class="modal-footer">
        								<form id="formDelete" action="" method="post">
        										<button class="btn btn-default" data-dixsiss="modal"><?php if($lang =='1'){ ?> Cancel
                            <?php }elseif($lang == '2'){ ?>   إلغاء <?php } ?>  </button>
        										<button class="btn btn-danger" type="submit"><?php if($lang =='1'){ ?>
                              Delete
                            <?php }elseif($lang == '2'){ ?>
                             نعم احذف <?php } ?>
                                 </button>
        								</form>
        							</div>
        						</div>
        				</div>
        			</div>


    </section>


<?php } elseif ($do == 'Add') { ?>
  <section class="content-header">
    <h1>
      <?php if($lang =='1'){ ?>
    Contracts
      <small>ALl System Category  </small>
      <?php }elseif($lang == '2'){ ?>
         <i class="fa fa-print"></i>       العقود
        <small> عرض كل العقود</small>
      <?php } ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> المخزن  <?php } ?>  </a></li>
      <li ><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?>    العقود   <?php } ?> </li>
      <li ><?php if($lang =='1'){ ?> Add Invoices  <?php }elseif($lang == '2'){ ?>    إضافة عقد    <?php } ?> </li>
    </ol>

  </section>

  <script language="javascript" type="text/javascript">

        function ajaxFunction(){
    var http;  // The variable that makes Ajax possible!

    try{
        // Opera 8.0+, Firefox, Safari
        http = new XMLHttpRequest();
    } catch (e){
        // Internet Explorer Browsers
        try{
            http = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try{
                http = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    var url = "php.php?param=";
                var idValue = document.getElementById("pric").value;
                var myRandom = parseInt(Math.random()*99999999);  // cache buster
                http.open("GET", "php.php?param=" + escape(idValue) + "&rand=" + myRandom, true);
                http.onreadystatechange = handleHttpResponse;
                http.send(null);
         function handleHttpResponse() {
                    if (http.readyState == 4) {
                        results = http.responseText.split(",");
                         document.getElementById('price').value = results[0];
                         document.getElementById('vat').value = results[1];
                           document.getElementById('total').value = results[2];

                        //documentetElementById('address').value = results[2];
                    }
                }
    }

</script>
    <section class="content">
       <div class="box">
             <div class="box-header with-border">
               <h3 class="box-title">   <?php if($lang =='1'){ ?>  Add Category  <?php }elseif($lang == '2'){ ?> إضافة  عقد <?php } ?>   </h3>
                 <div class="pull-right">
                     <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i>
                        <?php if($lang =='1'){ ?>  Back  <?php }elseif($lang == '2'){ ?> عودة <?php } ?>  </a>
                 </div>
             </div>
             <!-- /.box-header -->
             <div class="box-body  ">
			             <form action="?do=Insert" method="post" >
                 <div class="row">
                    <div class="col-md-12">
          						<div class="col-md-4 col-md-offset-2">
          							  <div class="form-group has-warning">
          							  	  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>  اليوم  </label>
          							   <?php $num=date("w");
          								$day=array("الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت");
          								?>
          									<input type="" readonly  class="form-control" name="day" value="<?php echo  $day[$num]; ?>"
          									id="inputwarning" placeholder="العنوان" required>
          						 </div>
						<div class="form-group has-warning">
						  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>  التاريخ  </label>
						   <input type="text" name="date" value="<?php echo date('Y-m-d');?>" readonly class="form-control">

						</div>
							<?php

								$stm = $con->prepare("SELECT MAX(contract_no) AS contract_no  FROM contract  where b_id = ? ");
								$stm ->execute(array($b_id));
								$invNum = $stm -> fetch(PDO::FETCH_ASSOC);
								 $contract = $invNum['contract_no'];
								$count =$stm->rowCount();
								if($contract == ''){
									$stmt = $con->prepare("SELECT * FROM branch where id  = ?  ");
									$stmt->execute(array($b_id));
									$rus = $stmt-> fetch();
									$p_id = $rus['invoice'];
									$contract_no = $p_id+1;
								}else{
							        $contract_no = $contract+1;
								}

							?>
					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-list-ol "></i>  رقم  العقد </label>
					  <input type="text" class="form-control" name="contract_no" readonly="" value="<?php echo $contract_no ?>" id="inputwarning" placeholder="رقم الحفيظة" required>
					</div>

				 <div class="form-group has-warning">
					   <label class="control-label" for="inputwarning"><i class="fa fa-address-book-o "></i> الإسم</label>
					   <input type="text" name="name" class="form-control" required="" placeholder="الاسم ">
					</div>

					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-map-marker"></i>  العنوان</label>
					  <input type="text" class="form-control" name="address" id="inputwarning" placeholder="العنوان" required="" >
					</div>


					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-mobile"></i>  جوال</label>
					  <input type="number" class="form-control" name="phone" id="inputwarning" placeholder="جوال" required="">
					</div>

				  <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-whatsapp"></i> Whatsapp </label>
					  <input type="number" class="form-control" name="phone1" id="inputwarning" placeholder="Whatsapp"  >
					</div>

					<div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-id-card"></i> رقم الهوية   </label>
					  <input type="text" class="form-control" name="hafiza_no" id="inputwarning" placeholder=" رقم الهوية " required="">
					</div>

					 <div class="form-group has-warning">
							<label class="control-label" for="inputwarning"><i class="fa fa-money"></i> مبلغ الإيجار</label>
							<input type="number" class="form-control"  id="pric" name="total"  placeholder="مبلغ الإيجار" onchange="ajaxFunction();" required="">
							<div class="form-group has-warning">
							<input type="hidden" class="form-control" id="price" name="rent_price"  placeholder="مبلغ الإيجار" required="" />
					  </div>
					</div>
					<div class="form-group has-warning">
						  <label class="control-label" for="inputwarning"><i class="fa fa-percent "></i> القيمة المضافة</label>
							  <?php
							   $stmt = $con->prepare(" SELECT * FROM p_vat WHERE status = ? ");
							  $stmt->execute(array('0'));
							  $info = $stmt->fetch()?>
						  <input type="text" class="form-control" name="vat"  required  id="vat" value="<?php echo $info['rate'];?>" readonly id="inputwarning" placeholder="القيمة المضافة" required="" >
					</div>

					<div class="form-group has-warning">
						<label class="control-label" for="inputwarning"><i class="fa fa-credit-card-alt"></i> المبلغ  قبل الضريبة </label>
						<input type="text" class="form-control" name="price"  id="total"  readonly placeholder="" required="">
					</div>


		</div>


         <div class="col-md-4">
				<div class="form-group has-warning">
					<label class="control-label" for="inputwarning"><i class="fa fa-indent  "></i> العربون</label>
					<input type="number" class="form-control" name="down_payment"  id="inputwarning" placeholder="العربون" required="">
				</div>
					<div class="form-group has-warning">
						<label class="control-label" for="inputwarning"><i class="fa fa-hand-o-right"></i>  العربون  كتابة  </label>
						<input name="totalwrite"  type="text" class="form-control" rows="1" placeholder="عشرة الف ريال " required="">
						</div>

              <div class="form-group has-warning">
                <label class="control-label" for="inputwarning"><i class="fa fa-hdd-o"></i> التأمين</label>
                 <input type="text" class="form-control"  value="1000" name="tameen" id="inputwarning" placeholder="التأمين" required="">

              </div>

			 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-male"></i> <i class="fa fa-female"></i> عدد المتزوجين </label>

					    <select class="form-control select2" name="marrid_no"  style="width: 100%">

                          <?php

                              $stmt = $con->prepare("SELECT * FROM married  ");
                              $stmt->execute();
                              $rows = $stmt-> fetchAll();
                              foreach ($rows as $row) {
                           ?>
                           <option value="<?php echo $row['id'];?>"> <?php echo $row['name']; ?></option>
                      <?php } ?>

                      </select>
			   </div>


						<h3 class="text-warning" style="font-size:14px;color:#f4aa48"> <i class="fa fa-calendar"></i> التاريخ الهجري </h5>


                  <div class="form-group has-warning col-md-4">

                    <label class="control-label"> اليوم   </label>
                        <select class="form-control select2" name="hd" style="width: 100%" required>
                                <option>إختر  اليوم </option>
                                <?php
                                  $stm = $con->prepare(" SELECT * FROM day  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
                  <div class="form-group has-warning col-md-4">
                    <label class="control-label"> الشهر  </label>
                        <select class="form-control select2" name="hm" style="width: 100%" required>
                                <option>إختر الشهر</option>
                                <?php
                                  $stm = $con->prepare(" SELECT * FROM month  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo $employee['id']; ?>"> <?php echo $employee['id']; ?> - <?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
                   <div class="form-group col-md-4">
				   	<div class="form-group has-warning">
                    <label class="control-label"> السنة  </label>
                        <select class="form-control select2" name="hy" style="width: 100%" required>
                                <option>إختر السنة </option>
                                <?php
                                  $stm = $con->prepare(" SELECT * FROM year  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
				  </div>
				 	<div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"> <i class="fa fa-calendar-check-o"></i> بداية الإيجار</label>

                  <input type="date" class="form-control" name="start_date" id="inputwarning" placeholder="بداية الإيجار" required="">
                </div>

			<div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-calendar-times-o"></i> نهاية الإيجار</label>
                  <input type="date" class="form-control" name="end_date" id="inputwarning" placeholder="نهاية الإيجار" required="">
                </div>

					<div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-clock-o"></i> من  الساعة </label>

                  <input type="time" class="form-control" value="16:00" name="fclock" id="inputwarning" placeholder="بداية الإيجار" >
                </div>

			<div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-clock-o"></i>  الي  الساعة </label>
                  <input type="time" class="form-control" value="03:00" name="tclock" id="inputwarning" placeholder="نهاية الإيجار">
                </div>




                 <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-calculator  "></i> الخصم عند وجود مسأجر آخر</label>
                  <input type="number" class="form-control" value="1000" name="subtraction" id="inputwarning" placeholder="الخصم" required>
                </div>


                <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-sticky-note-o"></i> ملاحظات</label>

                  <textarea class="form-control" name="note" id="inputwarning" placeholder="ملاحظات" rows="4"></textarea>
                </div>

					</div>
						   <div class="col-md-3">
							    <label class="control-label"  style="text-align:right;font-size:11px"for="inputwarning">
								<i class="fa fa-calculator  "></i>  الخزينة 	</label>
						   <input type="number"  value="" class="form-control" name="Type0" id="inputwarning" placeholder=" " required>
							</div>
							<div class="col-md-3">
							    <label class="control-label"  style="text-align:right;font-size:11px"for="inputwarning">
								<i class="fa fa-calculator  "></i>  نقاط البيع	</label>
						   <input type="number"  value="" class="form-control" name="Type1" id="inputwarning" placeholder=" " required>
							</div>
							<div class="col-md-3">
							    <label class="control-label"  style="text-align:right;font-size:11px"for="inputwarning">
								<i class="fa fa-calculator  "></i>  تحويل بنكي 	</label>
						   <input type="number"  value="" class="form-control" name="Type2" id="inputwarning" placeholder=" " required>
							</div>
							<div class="col-md-3">
							    <label class="control-label"  style="text-align:right;font-size:11px"for="inputwarning">
								<i class="fa fa-calculator  "></i>   شيك مصرفي	</label>
						   <input type="number"  value="" class="form-control" name="Type3" id="inputwarning" placeholder=" " required>
							</div>

																<hr>
								</div>
						</div>
								<hr>
								<div class="row">
								<div class="col-md-12">

								 <div class="box-body" >

				  <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">شيك برقم</label>
                    <input type="text" name="serial_no" class="form-control" placeholder="شيك برقم">
                  </div>
				  </div>
				  <div class="col-md-3">
                    <div class="form-group">
                    <label class="control-label">رقم الحساب </label>
                    <input type="text" name="account_id" class="form-control" placeholder="شيك برقم">
                  </div>
					     </div>
				  <div class="col-md-3">


                  <div class="form-group">

                              <?php
                              $stmt = $con->prepare("SELECT * FROM bank where b_id = ? and Type != ? ");
                              $stmt->execute(array($b_id,'1'));
                              $rows = $stmt-> fetchAll();
                              ?>
                              <div class="form-group ">
                               <label>
                                <?php if($lang =='1'){ ?>  from account *  <?php }elseif($lang == '2'){ ?>  الى حساب   * <?php } ?>

                                  </label>
                              <select class="form-control select2" name="bank_account_id" >
                                    <option value="">     إختر  الحساب
                                     </option>
                                    <?php
                                    foreach ($rows as $row) {
                                     ?>
                                     <option value="<?php echo $row['ID'];?>"> <?php echo $row['Name'];?> <?php echo $row['Account_Number'];?></option>
                                <?php } ?>
                                </select>
                              </div>

                  </div>
				    </div>
				  <div class="col-md-3">

                  <div class="form-group">
                    <label class="control-label">المبلغ</label>
                    <input type="number" step="any" name="amount" class="form-control" placeholder="المبلغ ">
                  </div>
				    </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">حالة الشيك</label>
                    <select name="status" class="form-control">
                      <option value="">إختر الحالة</option>
                     <option value="تمت الاضافة">تمت الاضافة</option>
            <option value="قيد الصرف">قيد الصرف </option>
                    </select>
                  </div>
				    </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">تاريخ اللصرف </label>
                    <input type="date" name="exchange_at" class="form-control">
                  </div>
				    </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">التفاصيل</label>
					 <input type="text" name="details" class="form-control">

                  </div>
                   <input type="hidden"  name="ws"  value="1" required autofocus  class="form-control">
              </div>

				  <div class="col-md-3">

                     <div class="form-group ">
                           <div class="radio">
                            <input type="hidden" name="st"  disabled  id="superadmin" value="1" >
                          </div>
                          <div class="radio">
                            <input type="hidden" name="st" id="admin" value="0" checked="">
                          </div>
                    </div>
					    </div>
					</div>
        </div>
              <div class="modal-footer">
   		            <div class="text-center">
                    <button  type="submit"  class="btn btn-warning btn-flat"><i class="fa fa-paper-plane"></i><?php if($lang =='1'){ ?>   Save<?php }elseif($lang == '2'){ ?> حفظ<?php } ?>  </button>
                    <button type="reset"  class="btn btn-danger btn-flat">
                         <i class="fa fa-refresh"></i><?php if($lang =='1'){ ?> Reset<?php }elseif($lang == '2'){ ?>إعادة تعيين <?php } ?>
                     </button>
                  </div>
   					        </form>
   		          </div>

               </div>
           </div>

</section>



<?php } elseif ($do == 'print') {

  $id = isset($_GET['id']) ? $_GET['id'] : 0;

  $stmt = $con->prepare("SELECT * from contract where contract_no = ?  and b_id  = ? ");
  $stmt->execute(array($id,$b_id));
  $row = $stmt->fetch();

  // بيانات الفرع (الترويسة)
  $stmt = $con->prepare(" SELECT * FROM  branchen  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $infoEn = $stmt->fetch();

  // بيانات القاعة / الشعار
  $stmt = $con->prepare(" SELECT * FROM  branch  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $info = $stmt->fetch();

  // الشهر والسنة الهجرية
  $stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
  $stvat->execute(array($row['hm']));
  $hMonth = $stvat->fetch();
  $hMonth = $hMonth ? $hMonth['name'] : '';

  $stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
  $stvat->execute(array($row['hy']));
  $hYear = $stvat->fetch();
  $hYear = $hYear ? $hYear['name'] : '';

  $e = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
 ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

<style>
  @page {
    size: A4 portrait;
    margin: 8mm 10mm;
  }

  .contract-a4 {
    direction: rtl;
    font-family: 'Tajawal', 'Cairo', Tahoma, Arial, sans-serif;
    font-size: 9pt;
    line-height: 1.4;
    color: #222;
    background: #fff;
    width: 210mm;
    min-height: 297mm;
    margin: 20px auto;
    padding: 10mm 12mm;
    box-sizing: border-box;
    box-shadow: 0 0 12px rgba(0, 0, 0, .15);
  }
  .contract-a4 *, .contract-a4 *::before, .contract-a4 *::after { box-sizing: border-box; }

  /* الترويسة */
  .contract-a4 .c-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 6mm;
    padding-bottom: 2mm;
    border-bottom: 2px solid #1f4e8c;
  }
  .contract-a4 .c-header .side { flex: 1; font-size: 8.5pt; line-height: 1.5; color: #444; }
  .contract-a4 .c-header .side p { margin: 0; }
  .contract-a4 .c-header .side h2 {
    font-family: 'Cairo', sans-serif;
    font-size: 14pt;
    font-weight: 700;
    color: #1f4e8c;
    margin: 0 0 1mm;
  }
  .contract-a4 .c-header .side.en { direction: ltr; text-align: left; }
  .contract-a4 .c-header .side.ar { text-align: right; }
  .contract-a4 .c-header .logo { flex: 0 0 34mm; text-align: center; }
  .contract-a4 .c-header .logo img { max-height: 22mm; max-width: 34mm; object-fit: contain; }

  .contract-a4 .c-title {
    text-align: center;
    margin: 2.5mm 0 2mm;
  }
  .contract-a4 .c-title h1 {
    display: inline-block;
    font-family: 'Cairo', sans-serif;
    font-size: 14pt;
    font-weight: 700;
    margin: 0;
    padding: 0 8mm;
    border: 1.5px solid #1f4e8c;
    border-radius: 4px;
    color: #1f4e8c;
  }
  .contract-a4 .c-title .no { display: block; font-size: 10pt; margin-top: 1mm; color: #1f4e8c; font-weight: 700; }

  /* القيم المعبأة */
  .contract-a4 .v {
    font-weight: 700;
    color: #000;
    padding: 0 1.5mm;
    border-bottom: 1px dotted #777;
    white-space: nowrap;
  }

  .contract-a4 .intro p { margin: 0 0 0.8mm; text-align: justify; }
  .contract-a4 .intro .agree { font-weight: 700; margin-top: 1mm; }

  /* البنود */
  .contract-a4 ol.terms {
    margin: 1mm 0 0;
    padding-right: 6mm;
    padding-left: 0;
  }
  .contract-a4 ol.terms li {
    margin-bottom: 0.5mm;
    text-align: justify;
    padding-right: 1mm;
  }
  .contract-a4 ol.terms li::marker { font-weight: 700; color: #1f4e8c; }

  .contract-a4 table.money {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5mm 0;
    font-size: 8.5pt;
    text-align: center;
  }
  .contract-a4 table.money th,
  .contract-a4 table.money td { border: 1px solid #bbb; padding: 0.4mm 2mm; }
  .contract-a4 table.money th { background: #e3ecf7; font-weight: 700; }
  .contract-a4 table.money td:first-child { text-align: right; font-weight: 600; }

  .contract-a4 .notes { margin: 2mm 0 0; }

  /* التواقيع */
  .contract-a4 .c-footer {
    display: flex;
    justify-content: space-between;
    gap: 8mm;
    margin-top: 4mm;
    page-break-inside: avoid;
    break-inside: avoid;
  }
  .contract-a4 .c-footer .party {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 2mm 4mm;
  }
  .contract-a4 .c-footer h5 {
    font-family: 'Cairo', sans-serif;
    font-size: 11pt;
    font-weight: 700;
    margin: 0 0 2mm;
    color: #1f4e8c;
  }
  .contract-a4 .c-footer p { margin: 0 0 2mm; }
  .contract-a4 .c-footer .stamp {
    flex: 0 0 30mm;
    border: 1px dashed #aaa;
    border-radius: 50%;
    height: 24mm;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-weight: 700;
  }

  .contract-actions { text-align: center; margin: 10px 0 30px; }

  @media print {
    html, body {
      background: #fff !important;
      margin: 0 !important;
      padding: 0 !important;
      height: auto !important;
      min-height: 0 !important;
      overflow: visible !important;
    }
    /* إخفاء كل محتوى لوحة التحكم وإبقاء العقد فقط */
    body > *:not(.contract-a4) { display: none !important; }
    .contract-a4 {
      display: block !important;
      position: static !important;
      width: auto;
      min-height: 0;
      margin: 0;
      padding: 0;
      box-shadow: none;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    .no-print, .no-print * { display: none !important; }
  }
</style>


<div class="contract-a4">

  <!-- الترويسة -->
  <header class="c-header">
    <div class="side ar">
      <h2><?php echo $e($info['name']); ?></h2>
      <p>س.ت: <?php echo $e($info['Cphone']); ?></p>
      <p>هاتف: <?php echo $e($info['Phone']); ?> - فاكس: <?php echo $e($info['Fax']); ?></p>
      <p>جوال: <?php echo $e($info['Mobile']); ?> - <?php echo $e($info['Mobile1']); ?></p>
      <p><?php echo $e($info['Country']); ?></p>
      <p>الرقم الضريبي: <?php echo $e($info['Vat_Number']); ?></p>
    </div>

    <div class="logo">
      <img src="../../layout/dist/img/<?php echo $e($info['Avatar']); ?>" alt="logo">
    </div>

    <div class="side en">
      <h2><?php echo $e($infoEn['name']); ?></h2>
      <p>C.R: <?php echo $e($infoEn['Cphone']); ?></p>
      <p>Tel: <?php echo $e($infoEn['Phone']); ?> - Fax: <?php echo $e($infoEn['Fax']); ?></p>
      <p>Mobile: <?php echo $e($infoEn['Mobile']); ?> - <?php echo $e($infoEn['Mobile1']); ?></p>
      <p><?php echo $e($infoEn['Country']); ?></p>
      <p>VAT No: <?php echo $e($infoEn['Vat_Number']); ?></p>
    </div>
  </header>

  <div class="c-title">
    <h1>عقد إيجار</h1>
    <span class="no">رقم العقد: <?php echo $e($row['contract_no']); ?></span>
  </div>

  <!-- المقدمة -->
  <section class="intro">
    <p>
      إنه في يوم <span class="v"><?php echo $e($row['day']); ?></span>
      - <span class="v"><?php echo $e($row['bhd']); ?></span>
      الموافق <span class="v"><?php echo $e($row['date']); ?> م</span>
    </p>
    <p>تم بعون الله وتوفيقه الاتفاق بين كل من:</p>
    <p>
      <strong>أولاً:</strong> صاحب <span class="v"><?php echo $e($info['name']); ?></span> بالأحساء - <strong>طرف أول (مؤجر)</strong>.
    </p>
    <p>
      <strong>ثانياً:</strong> <span class="v"><?php echo $e($row['name']); ?></span>
      صاحب الهوية رقم <span class="v"><?php echo $e($row['hafiza_no']); ?></span>
      - جوال رقم <span class="v"><?php echo $e($row['phone']); ?><?php if (!empty($row['phone1'])) { echo ' / ' . $e($row['phone1']); } ?></span>
      - <strong>طرف ثانٍ (مستأجر)</strong>.
    </p>
    <p class="agree">وأقر الطرفان بكامل أهليتهما المعتبرة شرعاً واتفقا على ما يلي:</p>
  </section>

  <!-- البنود -->
  <ol class="terms">
    <li>بموجب هذا العقد أجّر الطرف الأول للطرف الثاني <span class="v"><?php echo $e($info['name']); ?></span> الكائنة بمحاسن، وما تضمنته من أثاث ومفروشات وأدوات، وهي على أحسن حال وصالحة للغرض المستأجرة لأجله.</li>

    <li>
      مدة العقد تبدأ من الساعة <span class="v"><?php echo $e($row['fclock']); ?></span>
      يوم <span class="v"><?php echo $e($row['s_name']); ?> <?php echo $e($row['hd']); ?>/<?php echo $e($hMonth); ?>/<?php echo $e($hYear); ?>هـ</span>
      الموافق <span class="v"><?php echo $e($row['start_date']); ?></span>،
      وتنتهي في تمام الساعة <span class="v"><?php echo $e($row['tclock']); ?></span>
      يوم <span class="v"><?php echo $e($row['e_name']); ?> <?php echo $e($row['hd'] + 1); ?>/<?php echo $e($hMonth); ?>/<?php echo $e($hYear); ?>هـ</span>
      الموافق <span class="v"><?php echo $e($row['end_date']); ?></span>.
    </li>

    <li>تعهد الطرف الثاني باستعمال الموقع للغرض الذي أُعد من أجله، والمحافظة على أثاثه ومفروشاته الموجودة به ومبانيه وديكوراته.</li>

    <li>
      اتفق الطرفان على قيمة الإيجار وتفاصيل السداد كالتالي:
      <table class="money">
        <thead>
          <tr>
            <th>البيان</th>
            <th>المبلغ</th>
            <th>ضريبة القيمة المضافة (15%)</th>
            <th>المجموع (ريال)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>قيمة الإيجار</td>
            <td><?php echo $e($row['m']); ?></td>
            <td><?php echo $e($row['youm']); ?></td>
            <td><strong><?php echo $e($row['rent_price']); ?></strong></td>
          </tr>
          <tr>
            <td>المدفوع (العربون)</td>
            <td><?php echo $e($row['cdp']); ?></td>
            <td><?php echo $e($row['dpv']); ?></td>
            <td><strong><?php echo $e($row['down_payment']); ?></strong></td>
          </tr>
          <tr>
            <td>المتبقي</td>
            <td><?php echo $e($row['crv']); ?></td>
            <td><?php echo $e($row['rv']); ?></td>
            <td><strong><?php echo $e($row['remaining']); ?></strong></td>
          </tr>
        </tbody>
      </table>
    </li>

    <li>عند إلغاء الحجز لا يُرد العربون المدفوع، ومدة استرجاع التأمين شهر من تاريخ الحفل، بعدها يعتبر التأمين من ضمن إيجار القاعة ولا يحق المطالبة به.</li>
    <li>يدفع المستأجر <span class="v"><?php echo $e($row['tameen']); ?></span> ريال تأميناً للقاعة قبل الزواج بـ (7) أيام، ويلتزم بالزيادة في حالة الأضرار البالغة.</li>
    <li>لا يُرجع العربون في حالة إلغاء عقد إيجار القاعة وقيمته <span class="v"><?php echo $e($row['down_payment']); ?></span> ريال، وإذا أوجد مستأجراً يحل مكانه يُخصم فقط <span class="v"><?php echo $e($row['subtraction']); ?></span> ريال.</li>
    <li><strong>لا يُستبدل الحجز حتى يتوفر مستأجر آخر يحل محله، وإلا يُخصم العربون.</strong></li>
    <li>لا يحق لمستأجر القاعة تأجيرها لطرف ثالث إطلاقاً (يُمنع أي حفل خارج القاعة المغلقة إلا بتصريح من الشرطة أو الإمارة).</li>
    <li>يُمنع منعاً باتاً النوم في القاعة من قبل أهل العروسين أو المدعوين.</li>
    <li>يجب تسليم مفاتيح القاعة فور الانتهاء من الزواج (منعاً لتحمل أي مسؤولية).</li>
    <li>عدم إدخال الأرز داخل قاعة الرجال أو النساء، ويقتصر على قاعة الطعام.</li>
    <li>عند طلب صاحب الحفل حضور أهله والعروس قبل الساعة الرابعة يدفع إيجاراً قدره 300 ريال.</li>
    <li>صاحب الفرح يتحمل مسؤولية التفحيط وإطلاق النار أو استخدام الألعاب النارية داخل وخارج القاعة، أو في حالة الشجار، أو إدخال جوال الكاميرا أو التصوير في قاعة النساء.</li>
    <li>عدم استخدام الفحم داخل القاعة نهائياً. <strong>(يلتزم المستأجر بدفع باقي قيمة الإيجار في حالة عدم إقامة الحفل)</strong></li>
    <li>الطاقة الاستيعابية لصالة الرجال <span class="v"><?php echo $e($info['mhc']); ?></span> فرد، والطاقة الاستيعابية لصالة النساء <span class="v"><?php echo $e($info['whc']); ?></span> فرد.</li>
    <li>عدد المتزوجين <span class="v"><?php echo $e($row['marrid_no']); ?></span> فقط.</li>
    <li>إذا حدث تخريب في محتويات القاعة تُحجز الكوشة إلى حين دفع قيمة التخريب.</li>
    <li>يُمنع الشكشكة والدبكات وجلسات العود داخل وخارج الصالة، ويُمنع منعاً باتاً إطلاق الأعيرة النارية وحمل السلاح والألعاب النارية.</li>
    <li><strong>في حال دفع المتبقي من إيجار القاعة قبل الزواج لا يُسترد مهما كانت الظروف.</strong></li>
    <li>عند عمل العقد الرجاء مراجعة قسم الشرطة (الضبط الإداري) من أجل إحضار تفويض لإقامة الحفل.</li>
    <li>يتعهد الطرف الثاني بعدم حمل السلاح أو وضع مواد ملتهبة أو ضارة داخل وخارج القاعة أو إطلاق النار أو استخدام الألعاب النارية من قبله أو أحد المدعوين، وفي حال خلاف ذلك يكون مسؤولاً أمام السلطات الحكومية ويتحمل كل ما يترتب على ذلك.</li>
    <li>العرضة والسامري تقام فقط داخل قاعة الرجال، والمستأجر يتحمل تكلفة التلفيات ولا يحق له الاعتراض.</li>
    <li>يتعهد الطرف الثاني بمسؤوليته عن كل حريق أو سرقة تحصل للموقع أو موجوداته مهما كانت الأسباب.</li>
  </ol>

  <?php if (trim((string) $row['note']) !== '') { ?>
  <p class="notes"><strong>ملاحظات:</strong> <?php echo nl2br($e($row['note'])); ?></p>
  <?php } ?>

  <!-- التواقيع -->
  <footer class="c-footer">
    <div class="party">
      <h5>الطرف الأول (المؤجر)</h5>
      <p>الاسم: <strong><?php echo $e($info['name']); ?></strong></p>
      <p>التوقيع: ..............................</p>
    </div>
    <div class="stamp">الختم</div>
    <div class="party">
      <h5>الطرف الثاني (المستأجر)</h5>
      <p>الاسم: <strong><?php echo $e($row['name']); ?></strong></p>
      <p>التوقيع: ..............................</p>
    </div>
  </footer>

</div>

<div class="contract-actions no-print">
  <button type="button" class="btn btn-primary btn-flat" onclick="window.print()"><i class="fa fa-print"></i> طباعة</button>
  <a href="?do=Manage" class="btn btn-warning btn-flat"><i class="fa fa-reply"></i> رجوع</a>
</div>

<script>
  (function () {
    var printed = false;

    // نقل العقد ليكون مباشرة داخل body حتى لا تؤثر عليه عناصر لوحة التحكم عند الطباعة
    function prepare() {
      var contract = document.querySelector('.contract-a4');
      if (contract && contract.parentNode !== document.body) {
        document.body.appendChild(contract);
      }
    }

    function doPrint() {
      if (printed) { return; }
      printed = true;
      prepare();
      setTimeout(function () { window.print(); }, 300);
    }

    window.addEventListener('beforeprint', prepare);
    window.addEventListener('load', function () {
      if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(doPrint);
        setTimeout(doPrint, 2500);
      } else {
        doPrint();
      }
    });
  })();
</script>


<?php } elseif ($do == 'view') {
 ?>

    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>


				<link rel="stylesheet" href="normalize.css"/>
				<link rel="stylesheet" href="style.css"/>
				<link rel="preconnect" href="https://fonts.googleapis.com"/>


<style>
@font-face {
    font-family: 'myFont';
    src: url(Amiri-Bold.ttf);
}
body{
font-family: myFont;
}



.invoice{

	margin-top: -30px;
}
</style>

</br>
  <?php

   $id = $_GET['id'];

            $stmt = $con->prepare("SELECT * from contract where contract_no = ? ");
      $stmt->execute(array($id));
      $count = $stmt->rowCount();
      $row = $stmt-> fetch();


        ?>
<section class="content contract">

        			<div class="box box-warning">
        				<div class="box-body">

						<main class="main">
							<div class="row">


						<?php
						   $stmt = $con->prepare(" SELECT * FROM  branchen  where id = ? ORDER BY id DESC ");
						  $stmt->execute(array($b_id));
						  $info = $stmt->fetch();
					  ?>
      <div class="col-xs-5 pull-right heading" style="direction:rtl;">
         <h3 class="heading-en heading text-left"><?php echo $info['name'];?></h3>
                <p class="small-text text-left">C.R <?php echo $info['Cphone'];?></p>
                <p class="small-text text-left">Tel/  <?php echo $info['Phone'];?> - Fax/ <?php echo $info['Fax'];?></p>
                <p class="small-text text-left">Mobile/ <?php echo $info['Mobile'];?>  - <?php echo $info['Mobile1'];?></p>
                <p class="small-text text-left"> <?php echo $info['Country'];?></p>
                <p class="small-text text-left">VAT No/  <?php echo $info['Vat_Number'];?></p>
      </div>
        <?php
   $stmt = $con->prepare(" SELECT * FROM  branch  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $info = $stmt->fetch();
  ?>
      <div class="col-xs-2 pull-right">
         <img src="../../layout/dist/img/<?php echo $info['Avatar'];?>" class="img-responsive" style="height: 100px" alt="muth'hila logo">
		   <center> <p class="text-danger text-center" style="margin-top:1px;color: red"> عقد إيجار  رقم :<?php echo $row['contract_no']; ?></p> </center>
      </div>
       <div class="col-xs-5 pull-left heading" style="direction:rtl;">

                <h2 class="heading heading-ar"><?php echo $info['name'];?></h2>
                <p class="small-text-right">س-ت   <?php echo $info['Cphone'];?></p>
                <p class="small-text-right">ت\ <?php echo $info['Phone'];?> - فاكس\  <?php echo $info['Fax'];?> </p>
                <p class="small-text-right">جوال/ <?php echo $info['Mobile'];?> - <?php echo $info['Mobile1'];?></p>
                <p class="small-text-right"> <?php echo $info['Country'];?> </p>

                <p class="small-text-right">الرقم الضريبي/ <?php echo $info['Vat_Number'];?></p>
            </div> <!-- right side header end-->

      <!-- /.col -->
    </div>

    <!-- title row -->


 <hr style="border-top: 1px solid #C35275;">



            <div class="row">
			 <div class="space">

                <p>انه في يوم  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['day'];?>  </span>
-<span type="date"  class="small-input" name="rent-date" id="rent-date">     <?php echo $row['bhd'];?> </span>
				الموافق
                  <span type="date"  class="small-input" name="rent-date" id="rent-date">     <?php echo $row['date'];?> م </span>
				  </p>
				  <p>
						تم بعون الله و توفيقه الإتفاق بين الطرفين كل من:-

                      أولا: صاحب   <?php echo $info['name'];?> بالأحساء طرف أول مؤجر  </span>
                    ثانيا: <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['name'];?>  </span>
                    صاحب الهوية رقم :  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['hafiza_no'];?> </span>
					  - جوال رقم :  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['phone'];?> /  <?php echo $row['phone1'];?> </span>
					طرف ثاني مستأجر
                    <strong>و أقر الطرفان بكامل قواهم العقلية المعتبرة شرعا و إتفقا على ما يلي: -</strong>
                </p>


                               <li>بموجب هذا العقد أجر الطرف الاول للطرف الثاني    <?php echo $info['name'];?> الكائنة بمحاسن, و ما تضمنه من أثاث و مفروشات و أدوات و هي على أحسن حال و صالحة للغرض المستأجر لأجله</li>
                <li>مدة العقد تبدأ من الساعة    <span class="small-input" name="" id=""><?php echo $row['fclock'];?></span>  يوم / <span class="small-input" name="" id=""><?php echo $row['s_name'];?>  - <?php echo $row['hd'];?>/<?php  $row['hm'];
					$stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
          $stvat->execute(array($row['hm']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];
				?>/<?php  $row['hy'];
				$stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
          $stvat->execute(array($row['hy']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];?></span>
                     <span type="date" class="small-input" name="rent-date" id="input-date2"></span> الموافق
                    <span type="date"  class="small-input" name="rent-date" id="rent-date">    <?php echo $row['start_date'];?> </span> <br>
                 وتنتهي في تمام الساعة  <span class="small-input" name="" id=""><?php echo $row['tclock'];?></span>   يوم   / <span type="text" class="small-input" name="rent-end-day" id="rent-end-day"> <?php echo $row['e_name'];?>  <?php  $hd=$row['hd']; echo $hd+1;?>/<?php  $row['hm'];
					$stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
          $stvat->execute(array($row['hm']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];
				?>/<?php  $row['hy'];
				$stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
          $stvat->execute(array($row['hy']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];?></span>    <span type="date" name="rent-end-date" id="rent-end-date"> / </span> ا لموافق  <span class="small-input">   <?php echo $row['end_date'];?></span>
                    <span type="date" name="rent-end-date" id="rent-end-date"></span> <span class="dummy"></span>
                </li>
                <li>تعهد الطرف الثاني بإستعمال الموقع للغرض الذي أعد من أجله و المحافظة على أساسه و مفروشاته و مفروشاته الموجودة به و مبانيه وديكوراته</li>
                <li>إتفق الطرفان على إيجار  وقدره/ <span class="small-input" type="number" name="" id=""> <?php echo $row['m'];?></span> +  <span class="small-input" type="number" name="" id=""> <?php echo $row['youm'];?> </span>  ضريبة القيمة المضافة.   (15 % )المجموع
                    <span class="small-input" type="number" name="" id="">   <?php echo $row['rent_price'];?> </span> ريال <br>
                دفع منها المستأجر مبلغ و قدره  / <span class="small-input" type="number" name="" id=""><?php echo $row['cdp'];?>  </span>   +<span class="small-input"> <?php echo $row['dpv'];?></span
                        class="small-input" type="number" name="" id=""></span> (15 % )    ضريبة  القيمة المضافة.  <span
                        class="small-input" type="number" name="" id=""> المجموع    <?php echo $row['down_payment'];?> </span> ريال <br>
                باقي المبلغ و قدره  /<span class="small-input" type="number" name="" id="">   <?php  echo $crv = $row['crv'];  ?>  </span>  +  <span
                        class="small-input" type="number" name="" id="">  <?php  echo $rv = $row['rv']; ?> </span>(15%)ضريبة القيمة المضافة. المجموع <span
                        class="small-input" type="number" name="" id=""> <?php echo $remaining = $row['remaining'];?> ريال  </span>  <br>
                </li>
                <li>عند إلغاء الحجز لا يرد العربون المدفوع, و مدة إسترجاع التأمين شهر من تاريخ الحفل بعدها يعتبر التأمين من ضمن إيجار القاعة ولا يحق لك المطالبة به</li>
                <li>يدفع المستأجر <span type="number"  class="small-input" name="" id=""><?php echo $row['tameen'];?>  </span> ريال تأمين للقاعة قبل الزواج ب(7) أيام و يلزم بالزيادة في حالة الأضرار البالغة</li>
                <li>لا  يرجع العربون في حالة إالغاء عقد إيجار القاعة و قيمته <span type="number" class="small-input"  name="" id=""><?php echo $row['down_payment'];?></span> ريال و إذا أوجد مستأجر يحل مكانه يخصم فقط <span type="number" name="" class="small-input" id=""> <?php echo $row['subtraction'];?></span> ريال </li>
                <li><strong>لا يستبدل الحجز حتى يتوفر مستأجر آخر يحل محله و إلا يخصم العربون</strong></li>
                <li>لا يحق لمستأجر القاعة تأجيرها لطرف تالت إطلاقا (يمنع أي حفل يكون خارج قاعة الصالة المغلقة إلا بتصريح من الشرطة أو الإمارة)</li>
                <li>يمنع منعا باتا النوم في القاعة من قبل أهل العروسين أو المدعوين</li>
                <li>يجب تسليم مفاتيح القاعة فور الإنتهاء من الزواج (منعا لتحمل أي مسؤولية)</li>
                <li>عدم إدخال الأرز داخل قاعة الرجال أو النساء و يقتصر على قاعة الطعام</li>
                <li>عند طلب صاحب الحفل الحضور لأهله و العروسة قبل الساعة الرابعة يدفع يدفع إيجار 300 ريال</li>
                <li>صاحب الفرح يتحمل مسؤولية التفحيط و طلق النار أو إستخدام الألعاب الناريةداخل و خارج القاعةأو في حالة الشجارأو إدخال جوال الكاميراأو التصوير في قاعة النساء</li>
                <li>عدم إستخدام الفحم داخل القاعة نهائيا. <strong>(يلتزم المستأجر بدفع باقي قيمة الإيجار في حالة عدم إقامة الحفل)</strong></li>
                <li>الطاقة الاستيعابية لصالة الرجال   <span class="small-input"> <?php echo $info['mhc'];?> </span> فرد و الطاقة الاستيعابيةلصالة  <span class="small-input"> <?php echo $info['whc'];?> </span>  فرد</li>
                <li>عدد المتزوجين <span class="small-input" type="number" name="" id=""> <?php echo $row['marrid_no'];?> </span> فقط. ملاحظة: مع الغداء <span class="small-input" type="number" name="" id="">
                        </span> بدون الغداء <span class="small-input" type="number" name="" id=""></span> <span class="dummy"></span></li>
                <li>إذا حدث تخريب في محتويات القاعة تحجز الكوشة إلى حين دفع قيمة التخريب</li>
                <li>يمنع الشكشكة و الدبكات و جلسات العود في داخل و خارج الصالة. و يمنع منعا باتا اطلاق الأعيرة النارية و حمل السلاح و الألعاب النارية</li>
                <li><strong>في حال دفع المتبقي من إيجار القاعة قبل الزواج لا يسترد مهما كانت الظروف</strong></li>
                <li>عند عمل العقد الرجاء مراجعة قسم الشرطة (الضبط الإداري) من أجل إحضار تفويض لإقامة الحفل</li>
                <li>يتعهد الطرف الثاني بعدم حمل السلاح أو وضع مواد ملتهبة أو ضارة داخل و خارج القاعة أو طلق نار أو إستخدام الألعاب النارية من قبله أو أحد المدعوين للزواج و في حال خلاف ذلك يكون مسؤول أمام السلطات الحكومية و يتحمل كل ما يترتب على ذلك</li>
                <li>العرضة والسامري تقام فقط في داخل قاعة الرجال والمستأجر يتحمل تكلفة التلفيات و لا يحق له الإعتراض</li>
                <li>يتعهد الطرف الثاني بمسؤوليته عن كل حريق أو سرقة تحصل للموقع أ موجوداته مهما كانت الأسباب</li>
            </p>


            <Strong>ملاحظات :<span class="dummy"></span></Strong> <span class="small-input" type="text"> <?php echo $row['note'];?></span> <span class="dummy"></span>

            <!-- footer start  -->
            <footer class="rent-footer">
                <div class="owner-footer">
                    <h5>الطرف الأول (المؤجر)</h5>
                    <p>الإسم : <strong><?php echo $info['name'];?></strong></p>
                    <p style="margin-right:-85px">التوقيع : <strong></strong></p>
                </div>
                <div class="tenant-footer">
                    <h5>الطرف الثاني (المستأجر)</h5>
                    <p><span class="small-input" type="text"></span>الإسم : <span class="dummy"><?php echo $row['name'];?> </span> </p>
                    <p  style="margin-right:-95px"><span class="small-input" type="text"></span>التوقيع : <span class="dummy"></span> </p>
                </div>

                  <div class="sign">
                    <h5>الختم</h5>

                </div>
            </footer>
            <!-- footer end -->
			</div>
			</br>
			<div class="row">
			<div class="footer">
			<center>
			<a href ="?do=file&&id=<?php echo $_GET['id'];?>" class="btn btn-primary btn-flat no-print"> <i class="fa fa-picture-o  "></i> ارفاق نسخة العميل   </a>
			 <a href="?do=Manage" class="btn btn-warning btn-flat no-print" ><i class="fa fa-reply"></i> رجوع  </a>
			</div>

				</br>	</br>
		 </div>

	 </div>
        </main>

      </div>
	  </div>
  </section>


<?php } elseif ($do == 'file') {

      $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM contract WHERE  contract_no = ?  and b_id = ? LIMIT 1");
        $stmt->execute(array($id,$b_id));
        $row = $stmt-> fetch();
  ?>
  <section class="content-header">
    <h1>
      <?php if($lang =='1'){ ?>
    Stock
      <small>ALl System Stock  </small>
      <?php }elseif($lang == '2'){ ?>
             سداد متبقي العقد
        <small> عرض كل سداد متبقي العقد </small>
      <?php } ?>
    </h1>

  </section>
    <section class="content">
       <div class="box">
             <div class="box-header with-border">
               <h3 class="box-title"> سدداد  فاتورة    </h3>
                 <div class="pull-right">
                     <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> Back </a>
                 </div>

             </div>

             <!-- /.box-header -->
             <div class="box-body table-responsive">
                 <div class="row">
                     <div class="col-md-4 col-md-offset-4">
						<form method="POST" action="?do=Upload" enctype="multipart/form-data">


                             <div class="form-group ">
                                 <label> رقم  العقد  * </label>

                                 <input class="form-control" readonly="" name="contract_no" value="<?php echo $id?>"
                                  required  type="text" placeholder="stock">
							</div>
                              <div class="form-group ">
                                 <label> الملف   </label>file contract_no

                                 <input class="form-control"  name="file"
                                    type="file" placeholder="stock">

                             </div>



                     </div>


             </div>

             </div>
			 <hr>
             <div class="row text-center">

						     <button class="btn btn-danger" name="upload"><span class="glyphicon glyphicon-upload"></span> حفظ</button>
                              <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> رجوع  </a>
               </form>

			</div>
	   </br>
	    </div>



</section>

<?php } elseif ($do == 'Upload') {

	  $msar = $images.''.'contracts/'.$b_id.'/';
    if(ISSET($_POST['upload'])){
		$contract_no = $_POST['contract_no'];
        $file_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $exp = explode(".", $file_name);
        $ext = end($exp);
        $name = date("Y-m-d h-i-s").".".$ext;
        $path = $msar.$name;

        if($file_size > 5242880){
            echo "<script>alert('File too large')</script>";
            echo "<script>window.location='?do.Manage'</script>";
        }else{
            try{
                if(move_uploaded_file($file_temp, $path)){
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$stmt = $con->prepare("INSERT INTO attachments (contract_no,file,b_id) VALUES (?,?,?)");
					$stmt->execute(array($contract_no,$name,$b_id));


                }

            }catch(PDOException $e){
                echo $e->getMessage();
            }

            $conn = null;

				 echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";

        }
    }


	 echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";

 } elseif ($do == 'pay') {

      $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM contract WHERE  contract_no = ?  and b_id = ? LIMIT 1");
        $stmt->execute(array($id,$b_id));
        $row = $stmt->fetch();
  ?>
  <section class="content-header">
    <h1>
      <?php if($lang =='1'){ ?>
    Stock
      <small>ALl System Stock  </small>
      <?php }elseif($lang == '2'){ ?>
             سداد متبقي العقد
        <small> عرض كل سداد متبقي العقد </small>
      <?php } ?>
    </h1>

  </section>
    <section class="content">
       <div class="box">
             <div class="box-header with-border">
               <h3 class="box-title"> سدداد  فاتورة    </h3>
                 <div class="pull-right">
                     <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> Back </a>
                 </div>

             </div>

             <!-- /.box-header -->
             <div class="box-body table-responsive">
                 <div class="row">
                     <div class="col-md-4 col-md-offset-2">

                         <form action="?do=process_payment" method="post">

                             <div class="form-group ">
                                 <label>رقم  الفاتورة  * </label>

                                 <input class="form-control" readonly="" name="invoice_id" value="<?php echo $id?>"
                                  required  type="text" placeholder="stock">

                                     <div class="form-group ">
                                 <label> اجمالي  الفاتورة  </label>

                                 <input class="form-control" readonly="" name="total" value="<?php echo $row['rent_price']?>"
                                  required  type="text" placeholder="stock">

                             </div>
							             <div class="form-group ">
                                 <label> المتبقي    </label>
                                 <input class="form-control" readonly="" name="remaing" value="<?php echo $remaining = $row['remaining']?>"
                                  required  type="text" placeholder="stock">
                             </div>
                       </div>
                     </div>
                      <div class="col-md-4 col">
                              <div class="form-group ">
                                 <label> المدفوع   * </label>
                                 <input class="form-control" name="paid"  readonly="" value="<?php echo $row['down_payment']?>"
                                  required  type="text" placeholder="stock">
                             </div>
                               <div class="form-group ">
                                 <label> المبلغ * </label>
                                 <input class="form-control" name="amount" value="<?php echo $remaining ?>"
                                  required  type="number"        max="<?php echo $remaining?>" placeholder="المبلغ">
                             </div>


                             <div class="form-group ">
                                <label>  المبلغ كتابتا   * </label>
                                <input class="form-control" name="totalwrite2" required  type="text" placeholder="المبلغ كتابتة">
                            </div>


								   <div class="form-group has-warning">
									  <?php
										$stmt = $con->prepare("SELECT * FROM bank where b_id = ? and opening_balance != ?  ");
										$stmt->execute(array($b_id,'1'));
										$rows = $stmt-> fetchAll();
										foreach ($rows as $row) { ?>

									   <div class="col-md-6">
											<label class="control-label"  style="text-align:right;font-size:11px"for="inputwarning">
											<i class="fa fa-calculator  "></i> <?php echo $row['Name'];  ?>	</label>
									   <input type="number"  value="0" class="form-control" name="Type<?php echo $row['Type'];?>" id="inputwarning" placeholder="<?php echo $row['Name'];  ?>" required>


										</div>
								  <?php } ?>
								</div>


						</div>

             </div>
			 <hr>
             <div class="row text-center">
             <button  type="submit"   class="btn btn-danger btn-flat">
                        <i class="fa fa-save"></i>    حفظ
                        </button>
                              <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> رجوع  </a>
               </form>

       </div>

	      </div>
		   </div>
 <!-- /.box -->

</section>

<?php } elseif ($do == 'process_payment') {
			$date = date('Y-m-d');
      $stvat = $con->prepare(" SELECT * FROM hijri   where  date = ? ");
      $stvat->execute(array($date));
      $vv = $stvat->fetch();
      $hdate =$vv['hdate'];

      $stvat = $con->prepare(" SELECT * FROM p_vat   where  status = ? ");
      $stvat->execute(array('1'));
      $vv = $stvat->fetch();
      $va =$vv['rate'];
      $svat = $va;
      $contract_no  = $_POST['invoice_id']; echo "</br>";
      $totalwrite2  = $_POST['totalwrite2']; echo "</br>";
      $paid  = $_POST['paid']; echo "</br>";
       $amount  = $_POST['amount'];"</br>";
      $down_payment = $amount; echo "</br>";
      $cdp = $down_payment/$svat; echo "</br>";
      $dpv = $down_payment-$cdp; echo "</br>";

      $month = date('m'); echo "</br>";
      $year = date('Y'); echo "</br>";
      $date     = date('Y-m-d'); echo "</br>";
      $IP = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
      $computerName = gethostbyaddr($IP);
      $type0 = $_POST['Type0'];
      $type1 = $_POST['Type1'];
       $payment = $type0+$type1;

			if($amount != $payment ){
					echo "<meta http-equiv='refresh' content='0; url=?do=paymentwarning' />";
			}

      if($type0 != 0){

      $stv = $con->prepare(" SELECT * FROM b_vat   where  status = ? ");
      $stv->execute(array('1'));
      $bann = $stv->fetch();
      $bancoo =$bann['rate'];

      $bankcommission = $type0*$bancoo;
      $bankcommwvat=  $bankcommission*$svat;
      $tamount = $type0 -$bankcommwvat;
      $vatcommissi = $bankcommwvat/$svat;
      $vatcommission = $bankcommwvat-$vatcommissi;
      $commamount = $vatcommissi;
      }else{
      $bankcommission =0;$bankcommwvat=0;$tamount=0;$vatcommission=0;$commamount=0;
      }

        $stm = $con->prepare("UPDATE contract SET  remaining = remaining - ?, totalwrite2 =  ?
        WHERE contract_no = ?     ");
        $stm->execute(array($amount,$totalwrite2,$contract_no));


        $stm = $con->prepare("SELECT MAX(bill) AS bill  FROM vatcal  where b_id = ? ");
          $stm ->execute(array($b_id));
          $invNum = $stm -> fetch(PDO::FETCH_ASSOC);
          $bill = $invNum['bill'];
          $count =$stm->rowCount();
          if($bill == ''){
          $stmt = $con->prepare("SELECT * FROM branch where id  = ?  ");
          $stmt->execute(array($b_id));
          $rus = $stmt-> fetch();
        	$p_id = $rus['bill'];
        	$bill = $p_id+1;
          }else{
        	$bill = $bill+1;
          }

          if($type1 != 0  AND $type0 != 0){
          echo	$type = 2;
          }elseif($type1 != 0 ){
          echo 	$type = 1;
          }elseif($type0 != 0 ){
          echo	$type = 0;
          }


      $stm = $con->prepare("INSERT INTO vatcal (invon,sub,vat,total,date,month,year,type,payment,b_id,type0,type1,bill,bankcommission,tamount,vatcommission,commamount,totalwrite)
      VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stm->execute(array($contract_no,$cdp,$dpv,$down_payment,$date,$month,$year,'0','0',$b_id,$type0,$type1,$bill,$bankcommwvat,$tamount,$vatcommission,$commamount,$totalwrite2));

      $stmt = $con->prepare("INSERT INTO revenues (name,price,descr,date,customer_id,type,b_id,month,year) VALUES (?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($name,$down_payment,'  إيراد عقد - '.$contract_no,$date,$contract_no,'1',$b_id,$month,$year));

      $stmt = $con->prepare("INSERT INTO custody (Income,Outcome,Details,L_ID,RegDate,b_id,date,month,year) VALUES (?,?,?,?,now(),?,?,?,?)");
      $stmt->execute(array($down_payment,0,' إيراد  عقد    '. $contract_no,$contract_no,$b_id,$date,$month,$year));

      $stmt = $con->prepare("INSERT INTO active (Name,Oper,OperDesc,OperDate,OperTime,IPV4) VALUES (?,?,?,now(),now(),?)");
      $stmt->execute(array($main,'Add Category','إضافة فئة جديدة باسم '.$name,$computerName));
      if($type1 !==  0){

        $stm1  = $con->prepare("SELECT * From bank where Type = ? and b_id = ?  ");
        $stm1 ->execute(array('1',$b_id));
        $ro1 = $stm1->fetch();
        $Name  = $ro1['Name'];
        $OBlance  = $ro1['Blance'];
        $ID  = $ro1['ID'];
        $newbalance = $OBlance+$type1;

        $stmt2 = $con->prepare("INSERT INTO safe_statment (date,month,year,descr,income,toutcome,st,invoice_no) VALUES (?,?,?,?,?,?,?,?) ");
        $stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type1,$newbalance,'1',$contract_no));

        $stm = $con->prepare("UPDATE bank SET Blance = Blance + ?
        WHERE ID = ?    ");
        $stm->execute(array($type1,$ID));


         $stv = $con->prepare(" SELECT * FROM contract   where  contract_no = ? ");
      $stv->execute(array($contract_no));
      $bann = $stv->fetch();
      $remaining =$bann['remaining'];
      if($remaining  == '0'){

          $stm = $con->prepare("UPDATE contract SET  st =  ?
        WHERE contract_no = ?     ");
        $stm->execute(array('1',$contract_no));

      }

      }if($type0 != 0){

         $stm1  = $con->prepare("SELECT * From bank where Type =  ? and opening_balance != ? and b_id = ? ");
        $stm1 ->execute(array('0','1',$b_id));
        $ro1 = $stm1->fetch();
        $Name  = $ro1['Name'];
        $OBlance  = $ro1['Blance'];
         $newbalance = $OBlance+$type0;
        $ID  = $ro1['ID'];

        $stmt2 = $con->prepare("INSERT INTO bank_statment (date,month,year,descr,income,toutcome,st,invoice_no,bankcommission,tamount,vatcommission)
        VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
        $stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type0,$newbalance,'1',$contract_no,$bankcommission,$tamount,$vatcommission));

        $stm = $con->prepare("UPDATE bank SET Blance = Blance + ?  WHERE ID = ?  and opening_balance != ?   ");
        $stm->execute(array($type0,$ID,'1'));

      }
       echo "<meta http-equiv='refresh' content='0; url=payment.php?do=view&&id=$bill&&las=1' />";

			//echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";

 } elseif ($do == 'ReView') {
        $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM contract WHERE contract_no = ? LIMIT 1");
        $stmt->execute(array($id));
        $row = $stmt-> fetch();
  ?>





    <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>
    </section>

				<link rel="stylesheet" href="normalize.css"/>
				<link rel="stylesheet" href="style.css"/>
				<link rel="preconnect" href="https://fonts.googleapis.com"/>


<style>
@font-face {
    font-family: 'myFont';
    src: url(Amiri-Bold.ttf);
}
body{
font-family: myFont;
}


 .no-print, .no-print *
    {
        display: none !important;
    }

.invoice{

	margin-top: -30px;
}
</style>

</br>
  <?php

   $id = $_GET['id'];

            $stmt = $con->prepare("SELECT * from contract where contract_no = ? and b_id = ? ");
      $stmt->execute(array($id,$b_id));
      $count = $stmt->rowCount();
      $row = $stmt-> fetch();


        ?>
<section class="content contract">

        			<div class="box box-warning">
        				<div class="box-body">


      <main class="main">

    <div class="row">
	  <?php
   $stmt = $con->prepare(" SELECT * FROM  branchen  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $info = $stmt->fetch();
  ?>
      <div class="col-xs-5 pull-right heading" style="direction:rtl;">
         <h3 class="heading-en heading text-left"><?php echo $info['name'];?></h3>
                <p class="small-text text-left">C.R <?php echo $info['Cphone'];?></p>
                <p class="small-text text-left">Tel/  <?php echo $info['Phone'];?> - Fax/ <?php echo $info['Fax'];?></p>
                <p class="small-text text-left">Mobile/ <?php echo $info['Mobile'];?>  - <?php echo $info['Mobile1'];?></p>
                <p class="small-text text-left"> <?php echo $info['Country'];?></p>
                <p class="small-text text-left">VAT No/  <?php echo $info['Vat_Number'];?></p>
      </div>
        <?php
   $stmt = $con->prepare(" SELECT * FROM  branch  where id = ? ORDER BY id DESC ");
  $stmt->execute(array($b_id));
  $info = $stmt->fetch();
  ?>
      <div class="col-xs-2 pull-right">
         <img src="../../layout/dist/img/<?php echo $info['Avatar'];?>" class="img-responsive" style="height: 100px" alt="muth'hila logo">
		   <center> <p class="text-danger text-center" style="margin-top:1px;color: red">  عقد إيجار رقم :<?php echo $row['contract_no']; ?></p> </center>
      </div>
       <div class="col-xs-5 pull-left heading" style="direction:rtl;">

                <h2 class="heading heading-ar"><?php echo $info['name'];?></h2>
                <p class="small-text-right">س-ت   <?php echo $info['Cphone'];?></p>
                <p class="small-text-right">ت\ <?php echo $info['Phone'];?> - فاكس\  <?php echo $info['Fax'];?> </p>
                <p class="small-text-right">جوال/ <?php echo $info['Mobile'];?> - <?php echo $info['Mobile1'];?></p>
                <p class="small-text-right"> <?php echo $info['Country'];?> </p>

                <p class="small-text-right">الرقم الضريبي/ <?php echo $info['Vat_Number'];?></p>
            </div> <!-- right side header end-->

      <!-- /.col -->
    </div>

    <!-- title row -->


 <hr style="border-top: 1px solid #C35275;">


   <style>
  		   .space {
      margin: 0px;
      padding-bottom: 5px;
      padding: 0 50px;
  }
</style>
              <div class="row">
			  <div class="space">

                <p>انه في يوم  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['day'];?>  </span>
-<span type="date"  class="small-input" name="rent-date" id="rent-date">     <?php echo $row['bhd'];?> </span>
				الموافق
                  <span type="date"  class="small-input" name="rent-date" id="rent-date">     <?php echo $row['date'];?> م </span>
				  </p>
				  <p>
						تم بعون الله و توفيقه الإتفاق بين الطرفين كل من:-

                      أولا: صاحب   <?php echo $info['name'];?> بالأحساء طرف أول مؤجر  </span>
                    ثانيا: <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['name'];?>  </span>
                    صاحب الهوية رقم :  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['hafiza_no'];?> </span>
					  - جوال رقم :  <span type="date"  class="small-input" name="rent-date" id="rent-date">  <?php echo $row['phone'];?> /  <?php echo $row['phone1'];?> </span>
					طرف ثاني مستأجر
                    <strong>و أقر الطرفان بكامل قواهم العقلية المعتبرة شرعا و إتفقا على ما يلي: -</strong>
                </p>


                               <li>بموجب هذا العقد أجر الطرف الاول للطرف الثاني    <?php echo $info['name'];?> الكائنة بمحاسن, و ما تضمنه من أثاث و مفروشات و أدوات و هي على أحسن حال و صالحة للغرض المستأجر لأجله</li>
                <li>مدة العقد تبدأ من الساعة    <span class="small-input" name="" id=""><?php echo $row['fclock'];?></span>  يوم / <span class="small-input" name="" id=""><?php echo $row['s_name'];?>  - <?php echo $row['hd'];?>/<?php  $row['hm'];
					$stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
          $stvat->execute(array($row['hm']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];
				?>/<?php  $row['hy'];
				$stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
          $stvat->execute(array($row['hy']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];?></span>
                     <span type="date" class="small-input" name="rent-date" id="input-date2"></span> الموافق
                    <span type="date"  class="small-input" name="rent-date" id="rent-date">    <?php echo $row['start_date'];?> </span> <br>
                 وتنتهي في تمام الساعة  <span class="small-input" name="" id=""><?php echo $row['tclock'];?></span>   يوم   / <span type="text" class="small-input" name="rent-end-day" id="rent-end-day"> <?php echo $row['e_name'];?>  <?php  $hd=$row['hd']; echo $hd+1;?>/<?php  $row['hm'];
					$stvat = $con->prepare(" SELECT * FROM month   where  id = ? ");
          $stvat->execute(array($row['hm']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];
				?>/<?php  $row['hy'];
				$stvat = $con->prepare(" SELECT * FROM year   where  id = ? ");
          $stvat->execute(array($row['hy']));
          $vv = $stvat->fetch();
         echo $name =$vv['name'];?></span>    <span type="date" name="rent-end-date" id="rent-end-date"> / </span> ا لموافق  <span class="small-input">   <?php echo $row['end_date'];?></span>
                    <span type="date" name="rent-end-date" id="rent-end-date"></span> <span class="dummy"></span>
                </li>
                <li>تعهد الطرف الثاني بإستعمال الموقع للغرض الذي أعد من أجله و المحافظة على أساسه و مفروشاته و مفروشاته الموجودة به و مبانيه وديكوراته</li>
                <li>إتفق الطرفان على إيجار  وقدره/ <span class="small-input" type="number" name="" id=""> <?php echo $row['m'];?></span> +  <span class="small-input" type="number" name="" id=""> <?php echo $row['youm'];?> </span>  ضريبة القيمة المضافة.   (15 % )المجموع
                    <span class="small-input" type="number" name="" id="">   <?php echo $row['rent_price'];?> </span> ريال <br>
                دفع منها المستأجر مبلغ و قدره  / <span class="small-input" type="number" name="" id=""><?php echo $row['cdp'];?>  </span>   +<span class="small-input"> <?php echo $row['dpv'];?></span
                        class="small-input" type="number" name="" id=""></span> (15 % )    ضريبة  القيمة المضافة.  <span
                        class="small-input" type="number" name="" id=""> المجموع    <?php echo $row['down_payment'];?> </span> ريال <br>
                باقي المبلغ و قدره  /<span class="small-input" type="number" name="" id="">   <?php  echo $crv = $row['crv'];  ?>  </span>  +  <span
                        class="small-input" type="number" name="" id="">  <?php  echo $rv = $row['rv']; ?> </span>(15%)ضريبة القيمة المضافة. المجموع <span
                        class="small-input" type="number" name="" id=""> <?php echo $remaining = $row['remaining'];?> ريال  </span>  <br>
                </li>
                <li>عند إلغاء الحجز لا يرد العربون المدفوع, و مدة إسترجاع التأمين شهر من تاريخ الحفل بعدها يعتبر التأمين من ضمن إيجار القاعة ولا يحق لك المطالبة به</li>
                <li>يدفع المستأجر <span type="number"  class="small-input" name="" id=""><?php echo $row['tameen'];?>  </span> ريال تأمين للقاعة قبل الزواج ب(7) أيام و يلزم بالزيادة في حالة الأضرار البالغة</li>
                <li>لا  يرجع العربون في حالة إالغاء عقد إيجار القاعة و قيمته <span type="number" class="small-input"  name="" id=""><?php echo $row['down_payment'];?></span> ريال و إذا أوجد مستأجر يحل مكانه يخصم فقط <span type="number" name="" class="small-input" id=""> <?php echo $row['subtraction'];?></span> ريال </li>
                <li><strong>لا يستبدل الحجز حتى يتوفر مستأجر آخر يحل محله و إلا يخصم العربون</strong></li>
                <li>لا يحق لمستأجر القاعة تأجيرها لطرف تالت إطلاقا (يمنع أي حفل يكون خارج قاعة الصالة المغلقة إلا بتصريح من الشرطة أو الإمارة)</li>
                <li>يمنع منعا باتا النوم في القاعة من قبل أهل العروسين أو المدعوين</li>
                <li>يجب تسليم مفاتيح القاعة فور الإنتهاء من الزواج (منعا لتحمل أي مسؤولية)</li>
                <li>عدم إدخال الأرز داخل قاعة الرجال أو النساء و يقتصر على قاعة الطعام</li>
                <li>عند طلب صاحب الحفل الحضور لأهله و العروسة قبل الساعة الرابعة يدفع يدفع إيجار 300 ريال</li>
                <li>صاحب الفرح يتحمل مسؤولية التفحيط و طلق النار أو إستخدام الألعاب الناريةداخل و خارج القاعةأو في حالة الشجارأو إدخال جوال الكاميراأو التصوير في قاعة النساء</li>
                <li>عدم إستخدام الفحم داخل القاعة نهائيا. <strong>(يلتزم المستأجر بدفع باقي قيمة الإيجار في حالة عدم إقامة الحفل)</strong></li>
                <li>الطاقة الاستيعابية لصالة الرجال   <span class="small-input"> <?php echo $info['mhc'];?> </span> فرد و الطاقة الاستيعابيةلصالة  <span class="small-input"> <?php echo $info['whc'];?> </span>  فرد</li>
                <li>عدد المتزوجين <span class="small-input" type="number" name="" id=""> <?php echo $row['marrid_no'];?> </span> فقط. ملاحظة: مع الغداء <span class="small-input" type="number" name="" id="">
                        </span> بدون الغداء <span class="small-input" type="number" name="" id=""></span> <span class="dummy"></span></li>
                <li>إذا حدث تخريب في محتويات القاعة تحجز الكوشة إلى حين دفع قيمة التخريب</li>
                <li>يمنع الشكشكة و الدبكات و جلسات العود في داخل و خارج الصالة. و يمنع منعا باتا اطلاق الأعيرة النارية و حمل السلاح و الألعاب النارية</li>
                <li><strong>في حال دفع المتبقي من إيجار القاعة قبل الزواج لا يسترد مهما كانت الظروف</strong></li>
                <li>عند عمل العقد الرجاء مراجعة قسم الشرطة (الضبط الإداري) من أجل إحضار تفويض لإقامة الحفل</li>
                <li>يتعهد الطرف الثاني بعدم حمل السلاح أو وضع مواد ملتهبة أو ضارة داخل و خارج القاعة أو طلق نار أو إستخدام الألعاب النارية من قبله أو أحد المدعوين للزواج و في حال خلاف ذلك يكون مسؤول أمام السلطات الحكومية و يتحمل كل ما يترتب على ذلك</li>
                <li>العرضة والسامري تقام فقط في داخل قاعة الرجال والمستأجر يتحمل تكلفة التلفيات و لا يحق له الإعتراض</li>
                <li>يتعهد الطرف الثاني بمسؤوليته عن كل حريق أو سرقة تحصل للموقع أ موجوداته مهما كانت الأسباب</li>
            </p>


            <Strong>ملاحظات :<span class="dummy"></span></Strong> <span class="small-input" type="text"> <?php echo $row['note'];?></span> <span class="dummy"></span>

            <!-- footer start  -->
            <footer class="rent-footer">
                <div class="owner-footer">
                    <h5>الطرف الأول (المؤجر)</h5>
                    <p>الإسم : <strong><?php echo $info['name'];?></strong></p>
                        <p  style="margin-right:-95px"> التوقيع  : <strong></strong></p>
                </div>
                <div class="tenant-footer">
                    <h5>الطرف الثاني (المستأجر)</h5>
                    <p><span class="small-input" type="text"></span>الإسم : <span class="dummy"><?php echo $row['name'];?> </span> </p>
                    <p style="margin-right:-95px"><span class="small-input" type="text"></span>التوقيع : <span class="dummy"></span> </p>
                </div>

                  <div class="sign">
                    <h5>الختم</h5>

                </div>
            </footer>
            <!-- footer end -->
			</div>
			<div class="row">
				<div class="footer">
						<a  class="btn btn-success btn-xs"   href="?do=print&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-file-pdf-o"></i>  طباعة  </a>
						<a  class="btn btn-warning btn-xs"   href="?do=Edit&&id=<?php echo $row['contract_no'] ?>"><i class="fa fa-edit"></i>  تعديل   </a>
						<a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> رجوع  </a>
				</div>
			</div>
			</div>
        </main>

			</div>
				</div>



  </section>


<?php } elseif ($do == 'Edit') {
        $id = $_GET['id'];
		$contract_no =$id;
        $stmt = $con->prepare("SELECT * FROM contract WHERE contract_no = ? LIMIT 1");
        $stmt->execute(array($id));
        $row = $stmt-> fetch();
  ?>

  <script language="javascript" type="text/javascript">

        function ajaxFunction1(){
    var http;  // The variable that makes Ajax possible!

    try{
        // Opera 8.0+, Firefox, Safari
        http = new XMLHttpRequest();
    } catch (e){
        // Internet Explorer Browsers
        try{
            http = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try{
                http = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    var url = "php1.php?param1=";
                var idValue = document.getElementById("pric1").value;
                var myRandom = parseInt(Math.random()*99999999);  // cache buster
                http.open("GET", "php1.php?param1=" + escape(idValue) + "&rand=" + myRandom, true);
                http.onreadystatechange = handleHttpResponse;
                http.send(null);
         function handleHttpResponse() {
                    if (http.readyState == 4) {
                        results = http.responseText.split(",");
                         document.getElementById('price1').value = results[0];
                         document.getElementById('vat1').value = results[1];
                           document.getElementById('total1').value = results[2];

                        //documentetElementById('address').value = results[2];
                    }
                }
    }

</script>
   <section class="content-header">
    <h1>
      <?php if($lang =='1'){ ?>
    Contracts
      <small>ALl System Category  </small>
      <?php }elseif($lang == '2'){ ?>
         <i class="fa fa-print"></i>       العقود
        <small> عرض كل العقود</small>
      <?php } ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> المخزن  <?php } ?>  </a></li>
      <li ><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?>    العقود   <?php } ?> </li>
      <li ><?php if($lang =='1'){ ?> Add Invoices  <?php }elseif($lang == '2'){ ?>    تعديل  عقد    <?php } ?> </li>
    </ol>

  </section>


    <section class="content">
       <div class="box">
             <div class="box-header with-border">
               <h3 class="box-title">   <?php if($lang =='1'){ ?>  Add Category  <?php }elseif($lang == '2'){ ?> تعديل عقد <?php } ?>   </h3>
                 <div class="pull-right">
                     <a href="?do=Manage" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i>
                        <?php if($lang =='1'){ ?>  Back  <?php }elseif($lang == '2'){ ?> عودة <?php } ?>  </a>
						   <a href="settings.php" class="btn btn-warning btn-flat" ><i class="fa fa-reply"></i> رجوع  </a>
                 </div>
             </div>
             <!-- /.box-header -->
             <div class="box-body table-responsive">
			    <form action="?do=Update" method="post" >
                 <div class="row">

                    <div class="col-md-12">

						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" readonly class="form-control">
						<div class="col-md-4 col-md-offset-2">
							  <div class="form-group has-warning">
							  	  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>  اليوم  </label>
							   <?php $num=date("w");
								$day=array("الأحد","الأثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت");
								?>
									<input type="" readonly  class="form-control" name="day" value="<?php echo  $day[$num]; ?>"
									id="inputwarning" placeholder="العنوان" required>
						 </div>
						<div class="form-group has-warning">
						  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>  التاريخ  </label>
						   <input type="text" name="date" value="<?php echo date('Y-m-d');?>" readonly class="form-control">

						</div>

					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>رقم  العقد </label>
					  <input type="text" class="form-control" name="contract_no" readonly="" value="<?php echo $contract_no ?>" id="inputwarning" placeholder="رقم الحفيظة" required>
					</div>

				 <div class="form-group has-warning">
					   <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> الإسم</label>
					   <input type="text" name="name" value="<?php echo $row['name'];?>" class="form-control">
					</div>

					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>العنوان</label>
					  <input type="text" class="form-control" name="address"  value="<?php echo $row['address'];?>" id="inputwarning" placeholder="العنوان" required>
					</div>


					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> جوال</label>
					  <input type="text" value="<?php echo $row['phone'];?>"  class="form-control" name="phone" id="inputwarning" placeholder="جوال" required>
					</div>

					  <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i>  جوال  1 </label>
					  <input type="text" class="form-control" value="<?php echo $row['phone1'];?>"  name="phone1" id="inputwarning" placeholder="جوال" required>
					</div>

					 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-id-card"></i> رقم الهوية   </label>
					  <input type="text" class="form-control" name="hafiza_no"  value="<?php echo $row['hafiza_no'];?>" id="inputwarning" placeholder=" رقم الهوية " required>
					</div>

					 <div class="form-group has-warning">
							<label class="control-label" for="inputwarning"><i class="fa fa-check"></i> مبلغ الإيجار</label>
							<input type="hidden" class="form-control"   name="oldprice"  value="<?php echo $row['m'];?>"   placeholder="1" >
							<div class="form-group has-warning">
							<input type="text" step="any" class="form-control" id="pric1" value="<?php echo $row['m'];?>" name="rent_price"  placeholder="2"  onchange="ajaxFunction1();">
							<input type="hidden" class="form-control" id="price1" name="price1" value="<?php echo $row['m'];?>" placeholder="3" >
					  </div>
					</div>
					<div class="form-group has-warning">
						  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> القيمة المضافة</label>
							 <?php
								$stvat = $con->prepare(" SELECT * FROM p_vat   where  status = ? ");
								$stvat->execute(array('1'));
								$vv = $stvat->fetch();
								$va =$vv['rate'];
				?>
						  <input type="text" class="form-control" name="vat" value="<?php echo $va?>"  id="vat1" readonly  id="inputwarning" placeholder="القيمة المضافة" required>
					</div>

					<div class="form-group has-warning">
						<label class="control-label" for="inputwarning"><i class="fa fa-check"></i> المبلغ النهائي </label>
						<input type="hidden" class="form-control"  value="<?php echo $row['rdate'];?>" name="oldtotal"  placeholder="مبلغ الإيجار"/ >
						<input type="text" class="form-control" id="total1"   value="<?php echo $row['rdate'];?>" name="total"  placeholder="مبلغ الإيجار"/ >
					</div>


        </div>

       <div class="col-md-4">
				<div class="form-group has-warning">
					<label class="control-label" for="inputwarning"><i class="fa fa-check"></i> العربون</label>
						<input type="hidden"  value="<?php echo $row['down_payment'];?>"  class="form-control" name="old_down_payment"  id="inputwarning" placeholder="العربون" required>
					<input type="number"  value="<?php echo $row['down_payment'];?>"  class="form-control" name="down_payment"  id="inputwarning" placeholder="العربون" required>
				</div>


        <div class="form-group has-warning">
          <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> العربون كتاية  </label>
          <input name="totalwrite"   value="<?php echo $row['totalwrite'];?>" type="text" class="form-control"  placeholder="العربون كتاية "> </textarea>
          </div>

              <div class="form-group has-warning">
                <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> التأمين</label>
                 <input type="text" class="form-control" value="<?php echo $row['tameen'];?>"  name="tameen" id="inputwarning" placeholder="التأمين" required>

              </div>

			 <div class="form-group has-warning">
					  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> عدد المتزوجين</label>
					  <input type="number" class="form-control"  value="<?php echo $row['marrid_no'];?>"    name="marrid_no" id="inputwarning" placeholder="عدد المتزوجين" required>
			   </div>


                 <div class="form-group has-warning">

                  <div class="form-group col-md-4">
                    <label class="control-label"> اليوم  </label>
                        <select class="form-control select2" name="hd" style="width: 100%">

                                <?php
								 $hd  = $row['hd'];
                                  $stm = $con->prepare(" SELECT * FROM day  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo  $nhd = $employee['id'];?>" <?php if($hd == $nhd){ echo "selected";}?>>
									<?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
                   <div class="form-group col-md-4">
                    <label class="control-label"> الشهر  </label>
                        <select class="form-control select2" name="hm" style="width: 100%">

                                <?php
								 $hm  = $row['hm'];
                                  $stm = $con->prepare(" SELECT * FROM month  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo    $nhm =  $employee['id']; ?>" <?php if($hm == $nhm){ echo "selected";}?>><?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
                   <div class="form-group col-md-4">
                    <label class="control-label"> السنة  </label>
                        <select class="form-control select2" name="hy" style="width: 100%">

                                <?php
								 $hy  = $row['hy'];
                                  $stm = $con->prepare(" SELECT * FROM year  ");
                                  $stm->execute();
                                  $employees = $stm->fetchAll();
                                  foreach ($employees as $employee) { ?>
                                    <option value="<?php echo $nhy  = $employee['id']; ?>" <?php if($hy == $nhy){ echo "selected";}?>><?php echo $employee['name']; ?></option>
                                <?php   } ?>
                              </select>

                  </div>
                  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> بداية الإيجار</label>
            <input type="hidden" class="form-control" name="old_start_date" id="inputwarning"   value="<?php echo $row['start_date'];?>"  placeholder="بداية الإيجار">
                  <input type="date" class="form-control" name="start_date" id="inputwarning"   value="<?php echo $row['start_date'];?>"  placeholder="بداية الإيجار">
                </div>

         <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> نهاية الإيجار</label>
                  <input type="date"   value="<?php echo $row['end_date'];?>" class="form-control" name="end_date" id="inputwarning" placeholder="نهاية الإيجار">
                </div>
      <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-clock-o"></i> من  الساعة </label>

                  <input type="time" class="form-control" name="fclock"  value="<?php echo $row['fclock'];?>" id="inputwarning" placeholder="بداية الإيجار">
                </div>

			<div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-clock-o"></i>  الي  الساعة </label>
                  <input type="time" class="form-control" name="tclock"   value="<?php echo $row['tclock'];?>" id="inputwarning" placeholder="نهاية الإيجار">
                </div>


                 <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> الخصم عند وجود مسأجر آخر</label>
                  <input type="number"   class="form-control" value="<?php echo $row['subtraction'];?>" end_dateclass="form-control" name="subtraction" id="inputwarning" placeholder="الخصم" required>
                </div>


                <div class="form-group has-warning">
                  <label class="control-label" for="inputwarning"><i class="fa fa-check"></i> ملاحظات</label>

                  <textarea class="form-control"  name="note" id="inputwarning" placeholder="ملاحظات" rows="1" ><?php echo $row['note'];?> </textarea>
                </div>

				  <?php
							$st = $con->prepare("SELECT * FROM bank where b_id = ? and type = ?  ");
							$st->execute(array($b_id,'0'));
							$rban = $st-> fetch();
					?>

                 <div class="form-group has-warning col-md-6">
                  <label class="control-label" style="text-align:right;font-size:12px" for="inputwarning"><i class="fa fa-check"></i> <?php echo $rban['Name'];?> </label>
				   <input type="hidden"  step="any"  class="form-control" step="any" value="<?php echo $row['type0'];?>" end_dateclass="form-control" name="oldtype0" id="inputwarning" placeholder="" required>
                  <input type="number"  step="any"  class="form-control" step="any" value="<?php echo $row['type0'];?>" end_dateclass="form-control" name="type0" id="inputwarning" placeholder="" required>
                </div>
				 <?php
							$st = $con->prepare("SELECT * FROM bank where b_id = ? and type = ?  ");
							$st->execute(array($b_id,'1'));
							$rban = $st-> fetch();
					?>
				  <div class="form-group has-warning col-md-6">
                  <label class="control-label" style="text-align:right;font-size:12px" for="inputwarning"><i class="fa fa-check"></i><?php echo $rban['Name'];?>  </label>
				   <input type="hidden"  step="any"   class="form-control" value="<?php echo $row['type1'];?>" end_dateclass="form-control" name="oldtype1" id="inputwarning" placeholder="" required>
                  <input type="number"  step="any" class="form-control" value="<?php echo $row['type1'];?>" end_dateclass="form-control" name="type1" id="inputwarning" placeholder="" required>
                </div>

				</div>
				</div>
				</div>

				<div class="row">

					<div class="modal-footer text-center">

                             <div class="form-group">
                               <button  type="submit"  class="btn btn-success btn-flat">
                                 <i class="fa fa-edit"></i>
                                 <?php if($lang =='1'){ ?>
                                    Save
                                <?php }elseif($lang == '2'){ ?>
                                   تعديل
                                 <?php } ?>  </button>
                               <button type="reset"  class="btn btn-danger btn-flat">
                                    <i class="fa fa-refresh"></i>
                                 <?php if($lang =='1'){ ?>
                                    Reset
                                <?php }elseif($lang == '2'){ ?>
                                   إعادة تعيين
                                 <?php } ?>  </button>
                             </div>

         					</div>
						</div>
					</form>


			</div>

	</div>


					<!-- /.box -->
					<!-- /.box -->

</section>


<?php

} elseif ($do == 'opendayold') {
      $start_date = $_GET['day'];
      $end_date = $_GET['day'];
      $contract_no = $_GET['contract_no'];

	$stmt = $con->prepare("SELECT * FROM contract WHERE  start_date  = ?   and b_id = ? and copen = ?  ");
	$stmt->execute(array($start_date,$b_id,'1'));
	$count = $stmt->rowCount();
	$row = $stmt->fetch();
	$oldcontract_no =$row['contract_no'];
	$name =$row['name'];
	$phone =$row['phone'];

?>

  <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>



    </section>

<style type="text/css">

	hr.message-inner-separator
	{
	clear: both;
	margin-top: 10px;
	margin-bottom: 13px;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	}

</style>

<section class="content">

<div class="row">
<div class="col-lg-12">

<div class="box box-widget">
  <div class="box-body">

</br></br></br>
    <div class="alert alert-info">
	</br></br></br>
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		×</button>
	  <center>  <h3 class="fa fa-times-circle fa-2x"></span> <strong>  هذا التاريخ يوجد  عقد مفتوح   </strong></center>
	  <hr class="message-inner-separator">
	  <p class="text-center lead">
		 الرجاء مراجعة العميل  -   <?php echo $name ;?> -ورقم الجوال  <a href="tel:<?php echo $phone ?>">  <?php echo $phone ?> <i class="fa fa-mobile"></i>

     </p>
	</div>

	<center>

		<a href="?do=replaceold&&oldcontract_no=<?php echo $oldcontract_no;?>&&new=<?php echo $contract_no;?>" class="btn btn-danger  btn-lg text-center">    <i class="fa fa-exchange"></i> إستبدال   </a>
		<a href="?do=confirmold&&contract_no=<?php echo $contract_no;?>" class="btn btn-success btn-lg  text-center">  <i class="fa fa-exchange"></i> تاكيد العقد القديم </a>
		<button onclick="goBack()"  class="btn btn-warning  btn-lg  text-center">  رجوع   <i class="fa fa-reply"></i></button>
	</center>


    </div>
   </div>
</div>
</div>
</section>

<script>
function goBack() {
  window.history.back();
}
</script>
<?php
} elseif ($do == 'openday') {
   $start_date = $_GET['day'];

	$stmt = $con->prepare("SELECT * FROM contract WHERE  start_date  = ?   and b_id = ? and copen = ?  ");
	$stmt->execute(array($start_date,$b_id,'1'));
	$count = $stmt->rowCount();
	$row = $stmt->fetch();
	$contract_no =$row['contract_no'];
	$name =$row['name'];
	$phone =$row['phone'];

?>

  <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>



    </section>

<style type="text/css">

	hr.message-inner-separator
	{
	clear: both;
	margin-top: 10px;
	margin-bottom: 13px;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	}

</style>

<section class="content">

<div class="row">
<div class="col-lg-12">

<div class="box box-widget">
  <div class="box-body">

</br></br></br>
    <div class="alert alert-info">
	</br></br></br>
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		×</button>
	  <center>  <h3 class="fa fa-times-circle fa-2x"></span> <strong>  هذا التاريخ يوجد  عقد مفتوح   </strong></center>
	  <hr class="message-inner-separator">
	  <p class="text-center lead">
		 الرجاء مراجعة العميل  -   <?php echo $name ;?> -ورقم الجوال  <a href="tel:<?php echo $phone ?>">  <?php echo $phone ?> <i class="fa fa-mobile"></i>

     </p>
	</div>

	<center>
		<a href="?do=replace&&contract_no=<?php echo $contract_no;?>" class="btn btn-danger  btn-lg text-center">    <i class="fa fa-exchange"></i> إستبدال   </a>
		<a href="?do=confirmold&&contract_no=<?php echo $contract_no;?>" class="btn btn-success btn-lg  text-center">  <i class="fa fa-exchange"></i> تاكيد العقد القديم </a>
		<button onclick="goBack()"  class="btn btn-warning  btn-lg  text-center">  رجوع   <i class="fa fa-reply"></i></button>
	</center>


    </div>
   </div>
</div>
</div>
</section>

<script>
function goBack() {
  window.history.back();
}
</script>

<?php

} elseif ($do == 'replaceold') {

      $oldcontract_no = $_GET['oldcontract_no'];
      $contract_no = $_GET['new'];

  		$stvat = $con->prepare(" SELECT * FROM contract where contract_no = ?  limit 1  ");
  		$stvat->execute(array($oldcontract_no));
  		$vv= $stvat->fetch();
  		$start_date =$vv['start_date'];
      $end_date =$vv['end_date'];

  		$stmt = $con->prepare("UPDATE contract SET cancel =   ?,st = ?
  		WHERE contract_no = ?  ");
  		$stmt->execute(array('1','3',$oldcontract_no));

      $stmt = $con->prepare("UPDATE contract SET start_date  =   ?,end_date = ?
      WHERE contract_no = ?  ");
      $stmt->execute(array($start_date,$end_date,$contract_no));

		echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";

} elseif ($do == 'replace') {
	$contract_no = $_GET['contract_no'];

		$stmt = $con->prepare("UPDATE contract SET cancel =   ?,st = ?
		WHERE contract_no = ?  ");
		$stmt->execute(array('1','3',$contract_no));


		$stvat = $con->prepare(" SELECT * FROM qcontract  limit 1  ");
		$stvat->execute();
		$vv= $stvat->fetch();
		$name =$vv['name']; $address =$vv['address'];  $hafiza_no =$vv['hafiza_no']; $phone =$vv['phone']; $phone1 =$vv['phone1']; $rent_price =$vv['rent_price']; $down_payment =$vv['down_payment'];
		$remaining =$vv['remaining']; $vat =$vv['vat']; $tameen =$vv['tameen']; $subtraction =$vv['subtraction']; $marrid_no =$vv['marrid_no']; $start_date =$vv['start_date'];
		$end_date =$vv['end_date']; $note =$vv['note']; $m =$vv['m']; $youm =$vv['youm']; $date =$vv['date']; $day =$vv['day'];
		$rdate =$vv['rdate']; $paymenttype =$vv['paymenttype']; $st =$vv['st']; $hd =$vv['hd']; $hm =$vv['hm']; $hy =$vv['hy'];
		$bhd =$vv['bhd']; $fclock =$vv['fclock']; $tclock =$vv['tclock']; $cancel =$vv['cancel']; $copen =$vv['copen']; $type1 =$vv['type1'];  $type0 =$vv['type0'];
	$s_name =$vv['s_name']; $e_name =$vv['e_name']; $month =$vv['month']; $year =$vv['year']; $totalwrite  =$vv['totalwrite']; $paymenttype =$vv['paymenttype'];  $day =$vv['day'];


			$date = date('Y-m-d');
				$stvat = $con->prepare(" SELECT * FROM hijri   where  date = ? ");
				$stvat->execute(array($date));
				$vv = $stvat->fetch();
				$hdate =$vv['hdate'];

				$stvat = $con->prepare(" SELECT * FROM p_vat   where  status = ? ");
				$stvat->execute(array('1'));
				$vv = $stvat->fetch();
				$va =$vv['rate'];
				$svat = $va;

				$stv = $con->prepare(" SELECT * FROM b_vat   where  status = ? ");
				$stv->execute(array('1'));
				$bann = $stv->fetch();
				$bancoo =$bann['rate'];
				if($type0 > 0){
				$bankcommission = $type0*$bancoo;
				$tamount = $type0 -$bankcommission;
				$vatcommissi = $bankcommission/$svat;
				$vatcommission = $bankcommission-$vatcommissi;
				$commamount = $vatcommissi;
				}else{
				$bankcommission =0;
				$tamount=0;
				$vatcommission=0;
				$commamount=0;
				}

				$remaining=$rent_price-$down_payment;
				$cdp = $down_payment/$svat;
				$dpv = $down_payment-$cdp; echo "</br>";
				$crv = $remaining/$svat ; echo "</br>";
				$rv = $remaining-$crv; echo "</br>";


					$stmt = $con->prepare("INSERT INTO contract (contract_no,name,address,hafiza_no,phone,phone1,rent_price,down_payment,remaining,marrid_no,tameen,subtraction,start_date,end_date,note,date,m,youm,rdate,s_name,e_name,month,year,vat,b_id,day,dpv,cdp,rv,crv,totalwrite,paymenttype,st,bhd,hd,hm,hy,fclock,tclock,type0,type1)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$stmt->execute(array($contract_no,$name,$address,$hafiza_no,$phone,$phone1,$rent_price,$down_payment,$remaining,$marrid_no,$tameen,$subtraction,$start_date,$end_date,$note,$date,$m,$vat,$rent_price,$s_name,$e_name,$month,$year,$vat,$b_id,$day,$dpv,$cdp,$rv,$crv,$totalwrite,$paymenttype,$st,$hdate,$hd,$hm,$hy,$fclock,$tclock,$type0,$type1));



					$stm = $con->prepare("SELECT MAX(bill) AS bill  FROM vatcal  where b_id = ? ");
					$stm ->execute(array($b_id));
					$invNum = $stm -> fetch(PDO::FETCH_ASSOC);
					$bill = $invNum['bill'];
					$count =$stm->rowCount();
					if($bill == ''){
					$stmt = $con->prepare("SELECT * FROM branch where id  = ?  ");
					$stmt->execute(array($b_id));
					$rus = $stmt-> fetch();
					$p_id = $rus['bill'];
					$bill = $p_id+1;
					}else{
					$bill = $bill+1;
					}

					if($type1 != 0  AND $type0 != 0){
					echo	$type = 2;
					}elseif($type1 != 0 ){
					echo 	$type = 1;
					}elseif($type0 != 0 ){
					echo	$type = 0;
					}



				$stm = $con->prepare("INSERT INTO vatcal (invon,sub,vat,total,date,month,year,type,payment,b_id,type0,type1,bill,bankcommission,tamount,vatcommission,commamount)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$stm->execute(array($contract_no,$cdp,$dpv,$down_payment,$date,$month,$year,'0','0',$b_id,$type0,$type1,$bill,$bankcommission,$tamount,$vatcommission,$commamount));


				$info = $con->prepare("SELECT * FROM branch where id = ? ");
				$info->execute(array($b_id));
				$ro = $info->fetch();
				$bname = $ro['name'];

				$stm = $con->prepare("INSERT INTO events (date,details,contract_no,b_id,st)
				VALUES (?,?,?,?,?)");
				$stm->execute(array($start_date,$name.'-'.$bname,$contract_no,$b_id,'1'));


				$stmt = $con->prepare("INSERT INTO revenues (name,price,descr,date,customer_id,type,b_id,month,year) VALUES (?,?,?,?,?,?,?,?,?)");
				$stmt->execute(array($name,$down_payment,'  إيراد عقد - '.$contract_no,$date,$contract_no,'1',$b_id,$month,$year));

				if($type1 !==  0){

					$stm1  = $con->prepare("SELECT * From bank where Type = ? and b_id = ?  ");
					$stm1 ->execute(array('1',$b_id));
					$ro1 = $stm1->fetch();
					$Name  = $ro1['Name'];
					$OBlance  = $ro1['Blance'];
					$ID  = $ro1['ID'];
					$newbalance = $OBlance+$type1;

					$stmt2 = $con->prepare("INSERT INTO safe_statment (date,month,year,descr,income,toutcome,st,invoice_no) VALUES (?,?,?,?,?,?,?,?) ");
					$stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type1,$newbalance,'1',$contract_no));

					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?
					WHERE ID = ?    ");
					$stm->execute(array($type1,$ID));

				}if($type0 != 0){

				   $stm1  = $con->prepare("SELECT * From bank where Type =  ? and opening_balance != ? and b_id = ? ");
					$stm1 ->execute(array('0','1',$b_id));
					$ro1 = $stm1->fetch();
					$Name  = $ro1['Name'];
					$OBlance  = $ro1['Blance'];
					 $newbalance = $OBlance+$type0;
					$ID  = $ro1['ID'];

					$stmt2 = $con->prepare("INSERT INTO bank_statment (date,month,year,descr,income,toutcome,st,invoice_no,bankcommission,tamount,vatcommission)
					VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
					$stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type0,$newbalance,'1',$contract_no,$bankcommission,$tamount,$vatcommission));

					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?  WHERE ID = ?  and opening_balance != ?   ");
					$stm->execute(array($type0,$ID,'1'));

				}


					$stmt = $con->prepare("INSERT INTO custody (Income,Outcome,Details,L_ID,RegDate,b_id,date,month,year) VALUES (?,?,?,?,now(),?,?,?,?)");
					$stmt->execute(array($down_payment,0,' إيراد  عقد    '. $contract_no,$contract_no,$b_id,$date,$month,$year));

					$stmt = $con->prepare(" DELETE FROM qcontract  ");
				$stmt->execute();


			echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";
?>


<?php

} elseif ($do == 'confirmold') {
	$contract_no = $_GET['contract_no'];

	$stmt = $con->prepare("UPDATE contract SET copen =   ?,st = ?
		WHERE contract_no = ?  ");
		$stmt->execute(array('0','0',$contract_no));
 echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";
?>


<?php

} elseif ($do == 'waring') {

?>
  <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>



    </section>

<style type="text/css">

hr.message-inner-separator
{
clear: both;
margin-top: 10px;
margin-bottom: 13px;
border: 0;
height: 1px;
background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}

</style>

<section class="content">

<div class="row">
<div class="col-lg-12">

<div class="box box-widget">
  <div class="box-body">

</br></br></br>
    <div class="alert alert-danger">
	</br></br></br>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    ×</button>
  <center>  <h3 class="fa fa-times-circle fa-2x"></span> <strong>عذرا لا يمكن  إصدار  العقد  </strong></center>
  <hr class="message-inner-separator">
  <p class="text-center lead">
     الرجاء  مراجعة  التاريخ  وملء البيانات
     </p>
</div>
<center>
<button onclick="goBack()"  class="btn btn-warning text-center">  رجوع   <i class="fa fa-reply"></i></button></center>


    </div>
   </div>
</div>
</div>
</section>

<script>
function goBack() {
  window.history.back();
}
</script>



<?php

} elseif ($do == 'paymentwarning') {

?>
  <section class="content-header">
      <h1> <i class="fa fa-print"></i>  العقود  </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
        <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
      </ol>



    </section>

<style type="text/css">

hr.message-inner-separator
{
clear: both;
margin-top: 10px;
margin-bottom: 13px;
border: 0;
height: 1px;
background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}

</style>

<section class="content">

<div class="row">
<div class="col-lg-12">

<div class="box box-widget">
  <div class="box-body">

</br></br></br>
    <div class="alert alert-danger">
	</br></br></br>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    ×</button>
  <center>  <h3 class="fa fa-times-circle fa-2x"></span> <strong>عذرا لا يمكن  إكمال العملية  </strong></center>
  <hr class="message-inner-separator">
  <p class="text-center lead">
     المبلغ المدفوع لا يساوي المبلغ المطلوب
     </p>
</div>
<center>
<button onclick="goBack()"  class="btn btn-warning text-center">  رجوع   <i class="fa fa-reply"></i></button></center>


    </div>
   </div>
</div>
</div>
</section>

<script>
function goBack() {
  window.history.back();
}
</script>
<?php } elseif ($do == 'down_paymentne') { ?>


    <section class="content-header">
        <h1> <i class="fa fa-print"></i>  العقود  </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i><?php if($lang =='1'){ ?> Store    <?php }elseif($lang == '2'){ ?> العقود  <?php } ?>  </a></li>
          <li class="active"><?php if($lang =='1'){ ?> Invoices  <?php }elseif($lang == '2'){ ?> العقود  <?php } ?></li>
        </ol>



      </section>

  <style type="text/css">

  hr.message-inner-separator
  {
  clear: both;
  margin-top: 10px;
  margin-bottom: 13px;
  border: 0;
  height: 1px;
  background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
  background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
  background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
  background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
  }

  </style>

  <section class="content">

  <div class="row">
  <div class="col-lg-12">

  <div class="box box-widget">
    <div class="box-body">

  </br></br></br>
      <div class="alert alert-danger">
  	</br></br></br>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      ×</button>
    <center>  <h3 class="fa fa-times-circle fa-2x"></span> <strong>عذرا لا يمكن  إكمال العملية  </strong></center>
    <hr class="message-inner-separator">
    <p class="text-center lead">
    المدفوع نقدا و نقاط بيع لا يساوي العربون
       </p>
  </div>
  <center>
  <button onclick="goBack()"  class="btn btn-warning text-center">  رجوع   <i class="fa fa-reply"></i></button></center>


      </div>
     </div>
  </div>
  </div>
  </section>



<?php } elseif ($do == 'Insert') {

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$date = date('Y-m-d');
				$stvat = $con->prepare(" SELECT * FROM hijri   where  date = ? ");
				$stvat->execute(array($date));
				$vv = $stvat->fetch();
				$hdate =$vv['hdate'];
				if($hdate == ''){
				    $hdate = "0";
				}

				$stvat = $con->prepare(" SELECT * FROM p_vat   where  status = ? ");
				$stvat->execute(array('1'));
				$vv = $stvat->fetch();
				$va =$vv['rate'];
				$svat = $va;
				$contract_no=$_POST['contract_no'];
				$date=$_POST['date'];
				$name=$_POST['name'];
				$address=$_POST['address'];
				$hafiza_no=$_POST['hafiza_no'];
				$phone=$_POST['phone'];
				$phone1=$_POST['phone1'];
				$rent_pri=$_POST['price'];
				 $rent_price=$_POST['total'];
				$tvat= $rent_pri*$svat;
				$vat =$tvat - $rent_pri;
				$note=$_POST['note'];

				$type0 = $_POST['Type0'];
				$type1 = $_POST['Type1'];
				$type2 = $_POST['Type2'];
				$type3 = $_POST['Type3'];
					echo  $payment = $type0+$type1+$type2+$type3;
				if($type3  != '0'){


				$date=date("Y-m-d");
				$client=$_POST['client'];
				$serial_no=$_POST['serial_no'];
				$account_id=$_POST['account_id'];
				$bank_account_id=$_POST['bank_account_id'];
				$amount=$_POST['amount'];
				$status=$_POST['status'];
				$exchange_at=$_POST['exchange_at'];
				$details=$_POST['details'];
				$ws = $_POST['ws'];

				$st=1;

				 $stmt = $con->prepare("INSERT INTO checks (client,serial_no,account_id,bank_account_id,amount,status,exchange_at,details,ws,b_id)
      VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($name,$serial_no,$account_id,$bank_account_id,$payment,$status,$exchange_at,$details,$ws,$b_id));

				}

				if($type0 > 0){

				$stv = $con->prepare(" SELECT * FROM b_vat   where  status = ? ");
				$stv->execute(array('1'));
				$bann = $stv->fetch();
				$bancoo =$bann['rate'];
				$bankcommission = $type0*$bancoo;
				$bankcommwvat=  $bankcommission*$svat;
				$tamount = $type0 -$bankcommwvat;
				$vatcommissi = $bankcommwvat/$svat;
				$vatcommission = $bankcommwvat-$vatcommissi;
				$commamount = $vatcommissi;
				}else{
				$bankcommission =0;$bankcommwvat=0;$tamount=0;$vatcommission=0;$commamount=0;
				}
				$down_payment=$_POST['down_payment'];
			  $remaining=$rent_price-$down_payment;
				$cdp = $down_payment/$svat;
				$dpv = $down_payment-$cdp;
				$crv = $remaining/$svat;
				$rv = $remaining-$crv;
				$tameen=$_POST['tameen'];
				$subtraction=$_POST['subtraction'];
				$marrid_no=$_POST['marrid_no'];
				$start_date=$_POST['start_date'];
				$end_date=$_POST['end_date'];
				$st  = $_POST['st'];
				$hd  = $_POST['hd'];
				$hm  = $_POST['hm'];
				$hy  = $_POST['hy'];
				$fclock  = $_POST['fclock'];
				$tclock  = $_POST['tclock'];
				$totalwrite=$_POST['totalwrite'];

				$year =date('y');
				$month =date('m');
        echo $down_payment; echo"</br>";
        echo $payment; echo"</br>";
				if($payment != $down_payment){
				// echo "<meta http-equiv='refresh' content='0; url=?do=down_paymentne' />";
				}
				IF($rent_price == $down_payment){
					$st = "1";
				}else{
					$st = "0";
				}


				$stvat = $con->prepare(" SELECT * FROM bank   where  ID = ? ");
				$stvat->execute(array($payment));
				$vv = $stvat->fetch();
				$Type =$vv['Type'];

             $nameOfDay = date('D', strtotime($start_date));
            if($nameOfDay=='Sun') { $nad='الاحد'; echo $nad;}elseif($nameOfDay=='Mon') { $nad='الاثنين'; echo $nad;}elseif($nameOfDay=='Tue') { $nad='الثلاثاء'; echo $nad;}elseif($nameOfDay=='Wed') { $nad='الاربعاء'; echo $nad;}elseif($nameOfDay=='Thu') { $nad='الخميس'; echo $nad;}elseif($nameOfDay=='Fri') { $nad='الجمعة'; echo $nad;}elseif($nameOfDay=='Sat') { $nad='السبت'; echo $nad;};

            $nameOfDay = date('D', strtotime($end_date));
            if($nameOfDay=='Sun') { $ead='الاحد'; echo $ead;}elseif($nameOfDay=='Mon') { $ead='الاثنين'; echo $ead;}elseif($nameOfDay=='Tue') { $ead='الثلاثاء'; echo $ead;}elseif($nameOfDay=='Wed') { $ead='الاربعاء'; echo $ead;}elseif($nameOfDay=='Thu') { $ead='الخميس'; echo $ead;}elseif($nameOfDay=='Fri') { $ead='الجمعة'; echo $ead;}elseif($nameOfDay=='Sat') { $ead='السبت'; echo $ead;};

            $nameOfDay = date('D', strtotime($date));
            if($nameOfDay=='Sun') { $cod='الاحد'; echo $cod;}elseif($nameOfDay=='Mon') { $cod='الاثنين'; echo $cod;}elseif($nameOfDay=='Tue') { $cod='الثلاثاء'; echo $cod;}elseif($nameOfDay=='Wed') { $cod='الاربعاء'; echo $cod;}elseif($nameOfDay=='Thu') { $cod='الخميس'; echo $cod;}elseif($nameOfDay=='Fri') { $cod='الجمعة'; echo $cod;}elseif($nameOfDay=='Sat') { $cod='السبت'; echo $cod;};

              $name     = $_POST['name'];
              $IP = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
              $computerName = gethostbyaddr($IP);
              $stmt = $con->prepare("SELECT * FROM contract WHERE  start_date  = ?   and b_id = ?  ");
              $stmt->execute(array($start_date,$b_id));
              $row = $stmt->fetch();
              $count = $stmt->rowCount();
              echo $copen = $row['copen'];

              if($copen == '1'){
      					$stmt = $con->prepare("INSERT INTO qcontract (contract_no,name,address,hafiza_no,phone,phone1,rent_price,down_payment,remaining,marrid_no,tameen,subtraction,start_date,end_date,note,date,m,youm,rdate,s_name,e_name,month,year,vat,b_id,day,dpv,cdp,rv,crv,totalwrite,paymenttype,st,bhd,hd,hm,hy,fclock,tclock,type0,type1,type2,type3)
      					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      					$stmt->execute(array($contract_no,$name,$address,$hafiza_no,$phone,$phone1,$rent_price,$down_payment,$remaining,$marrid_no,$tameen,$subtraction,$start_date,$end_date,$note,$date,$rent_pri,$vat,$rent_price,$nad,$ead,$month,$year,$vat,$b_id,$cod,$dpv,$cdp,$rv,$crv,$totalwrite,$payment,$st,$hdate,$hd,$hm,$hy,$fclock,$tclock,$type0,$type1,$type2,$type3));
				    echo "<meta http-equiv='refresh' content='0; url=?do=openday&&day=$start_date' />";
				}else{

				if ($count == 0) {
        $stmt = $con->prepare("INSERT INTO contract (contract_no,name,address,hafiza_no,phone,phone1,rent_price,down_payment,remaining,marrid_no,tameen,subtraction,start_date,end_date,note,date,m,youm,rdate,s_name,e_name,month,year,vat,b_id,day,dpv,cdp,rv,crv,totalwrite,paymenttype,st,bhd,hd,hm,hy,fclock,tclock,type0,type1,type2,type3)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($contract_no,$name,$address,$hafiza_no,$phone,$phone1,$rent_price,$down_payment,$remaining,$marrid_no,$tameen,$subtraction,$start_date,$end_date,$note,$date,$rent_pri,$vat,$rent_price,$nad,$ead,$month,$year,$vat,$b_id,$cod,$dpv,$cdp,$rv,$crv,$totalwrite,$payment,$st,$hdate,$hd,$hm,$hy,$fclock,$tclock,$type0,$type1,$type2,$type3));


					$stm = $con->prepare("SELECT MAX(bill) AS bill  FROM vatcal  where b_id = ? ");
					$stm ->execute(array($b_id));
					$invNum = $stm -> fetch(PDO::FETCH_ASSOC);
					$bill = $invNum['bill'];
					$count =$stm->rowCount();
					if($bill == ''){
					$stmt = $con->prepare("SELECT * FROM branch where id  = ?  ");
					$stmt->execute(array($b_id));
					$rus = $stmt-> fetch();
					$p_id = $rus['bill'];
					$bill = $p_id+1;
					}else{
					$bill = $bill+1;
					}

					if($type1 != 0  AND $type0 != 0){
					echo	$type = 2;
					}elseif($type1 != 0 ){
					echo 	$type = 1;
					}elseif($type0 != 0 ){
					echo	$type = 0;
					}



				$stm = $con->prepare("INSERT INTO vatcal (invon,sub,vat,total,date,month,year,type,payment,b_id,type0,type1,type2,type3,bill,bankcommission,tamount,vatcommission,commamount,totalwrite)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$stm->execute(array($contract_no,$cdp,$dpv,$down_payment,$date,$month,$year,'0','0',$b_id,$type0,$type1,$type2,$type3,$bill,$bankcommwvat,$tamount,$vatcommission,$bankcommission,$totalwrite));



				$info = $con->prepare("SELECT * FROM branch where id = ? ");
				$info->execute(array($b_id));
				$ro = $info->fetch();
				$bname = $ro['name'];

				$stm = $con->prepare("INSERT INTO events (date,details,contract_no,b_id,st)
				VALUES (?,?,?,?,?)");
				$stm->execute(array($start_date,$name.'-'.$bname,$contract_no,$b_id,'1'));


				$stmt = $con->prepare("INSERT INTO revenues (name,price,descr,date,customer_id,type,b_id,month,year) VALUES (?,?,?,?,?,?,?,?,?)");
				$stmt->execute(array($name,$down_payment,'  إيراد عقد - '.$contract_no,$date,$contract_no,'1',$b_id,$month,$year));

				if($type1 !==  0){

					$stm1  = $con->prepare("SELECT * From bank where Type = ? and b_id = ?  ");
					$stm1 ->execute(array('1',$b_id));
					$ro1 = $stm1->fetch();
					$Name  = $ro1['Name'];
					$OBlance  = $ro1['Blance'];
					$ID  = $ro1['ID'];
					$newbalance = $OBlance+$type1;

					$stmt2 = $con->prepare("INSERT INTO safe_statment (date,month,year,descr,income,toutcome,st,invoice_no) VALUES (?,?,?,?,?,?,?,?) ");
					$stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type1,$newbalance,'1',$contract_no));

					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?
					WHERE ID = ?    ");
					$stm->execute(array($type1,$ID));

				}if($type0 != 0){

          $stm1  = $con->prepare("SELECT * From bank where Type =  ? and opening_balance != ? and b_id = ? ");
          $stm1 ->execute(array('0','1',$b_id));
          $ro1 = $stm1->fetch();
          $Name  = $ro1['Name'];
          $OBlance  = $ro1['Blance'];
          $newbalance = $OBlance+$type0;
          $ID  = $ro1['ID'];

					$stmt2 = $con->prepare("INSERT INTO bank_statment (date,month,year,descr,income,toutcome,st,invoice_no,bankcommission,tamount,vatcommission)
					VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
					$stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type0,$newbalance,'1',$contract_no,$bankcommission,$tamount,$vatcommission));

					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?  WHERE ID = ?  and opening_balance != ?   ");
					$stm->execute(array($type0,$ID,'1'));
				  }

					$stmt = $con->prepare("INSERT INTO custody (Income,Outcome,Details,L_ID,RegDate,b_id,date,month,year) VALUES (?,?,?,?,now(),?,?,?,?)");
					$stmt->execute(array($down_payment,0,' إيراد  عقد    '. $contract_no,$contract_no,$b_id,$date,$month,$year));

					$stmt = $con->prepare("INSERT INTO active (Name,Oper,OperDesc,OperDate,OperTime,IPV4) VALUES (?,?,?,now(),now(),?)");
					$stmt->execute(array($main,'Add Category','إضافة فئة جديدة باسم '.$name,$computerName));

					echo "<meta http-equiv='refresh' content='0; url=?do=ReView&&id=$contract_no' />";

				} else {
					echo "<meta http-equiv='refresh' content='0; url=?do=waring' />";
				 }

				}

				 } else {
				  echo "<meta http-equiv='refresh' content='0; url=?notification=red' />";
				 }





   } elseif ($do == 'Update') {

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              $IP = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
              $computerName = gethostbyaddr($IP);
              $id       = $_POST['id'];
              $date = date('Y-m-d');
              $date = date('Y-m-d');
              $stvat = $con->prepare(" SELECT * FROM hijri   where  date = ? ");
              $stvat->execute(array($date));
              $vv = $stvat->fetch();
              $hdate =$vv['hdate'];
              if($hdate == ''){
				    $hdate = "0";
				}
              $stvat = $con->prepare(" SELECT * FROM p_vat   where  status = ? ");
              $stvat->execute(array('1'));
              $vv = $stvat->fetch();
              $va =$vv['rate'];
              $svat = $va;
              $contract_no=$_POST['contract_no'];
              $date=$_POST['date'];
              $name=$_POST['name'];
              $address=$_POST['address'];
              $hafiza_no=$_POST['hafiza_no'];
              $phone=$_POST['phone'];
              $phone1=$_POST['phone1'];
              $rent_pri=$_POST['rent_price'];
              $rent_price=$_POST['total'];
              $tvat= $rent_pri*$svat;
              $vat =$tvat - $rent_pri;
              $note=$_POST['note'];
              $type0 = $_POST['type0'];
              $type1 = $_POST['type1'];
              $down_payment = $_POST['down_payment'];
              $payment = $type0+$type1;

              if($payment != $down_payment){
              echo "<meta http-equiv='refresh' content='0; url=?do=down_paymentne' />";
              }
                IF($rent_price == $down_payment){
                $st = "1";
              }else{
                $st = "0";
              }

          if($type0 > 0){
              $stv = $con->prepare(" SELECT * FROM b_vat   where  status = ? ");
      				$stv->execute(array('1'));
      				$bann = $stv->fetch();
      				$bancoo =$bann['rate'];
      				$bankcommission = $type0*$bancoo;
              $bankcommwvat=  $bankcommission*$svat;
      				$tamount = $type0 -$bankcommwvat;
      				$vatcommissi = $bankcommwvat/$svat;
      				$vatcommission = $bankcommwvat-$vatcommissi;
      				$commamount = $vatcommissi;
  				}else{
  				      $bankcommission =0;$bankcommwvat=0;$tamount=0;$vatcommission=0;$commamount=0;
  				}
                $down_payment=$_POST['down_payment'];
                $remaining=$rent_price-$down_payment;
                $cdp = $down_payment/$svat;
                $dpv = $down_payment-$cdp; echo "</br>";
                $crv = $remaining/$svat ; echo "</br>";
                $rv = $remaining-$crv; echo "</br>";
                $tameen=$_POST['tameen'];
                $subtraction=$_POST['subtraction'];
                $marrid_no=$_POST['marrid_no'];
                $start_date=$_POST['start_date'];
                $end_date=$_POST['end_date'];
                $oldtype1=$_POST['oldtype1'];
                $oldtype0=$_POST['oldtype0'];
                $old_start_date=$_POST['old_start_date'];
                $end_date=$_POST['end_date'];
                $old_down_payment=$_POST['old_down_payment']; echo "</br>";
                $oldtotal=$_POST['oldtotal'];
                $oldprice=$_POST['oldprice'];
                $hd  = $_POST['hd'];
                $hm  = $_POST['hm'];
                $hy  = $_POST['hy'];
                $fclock  = $_POST['fclock'];
                $tclock  = $_POST['tclock'];
                $totalwrite=$_POST['totalwrite'];
                $name     = $_POST['name'];
                $IP = $_SERVER['REMOTE_ADDR'];
                $year =date('y');
                $month =date('m'); 				// Obtains the IP address
                $computerName = gethostbyaddr($IP);
                $nameOfDay = date('D', strtotime($start_date));
                if($nameOfDay=='Sun') { $nad='الاحد'; echo $nad;}elseif($nameOfDay=='Mon') { $nad='الاثنين'; echo $nad;}elseif($nameOfDay=='Tue') { $nad='الثلاثاء'; echo $nad;}elseif($nameOfDay=='Wed') { $nad='الاربعاء'; echo $nad;}elseif($nameOfDay=='Thu') { $nad='الخميس'; echo $nad;}elseif($nameOfDay=='Fri') { $nad='الجمعة'; echo $nad;}elseif($nameOfDay=='Sat') { $nad='السبت'; echo $nad;};
                $nameOfDay = date('D', strtotime($end_date));
                if($nameOfDay=='Sun') { $ead='الاحد'; echo $ead;}elseif($nameOfDay=='Mon') { $ead='الاثنين'; echo $ead;}elseif($nameOfDay=='Tue') { $ead='الثلاثاء'; echo $ead;}elseif($nameOfDay=='Wed') { $ead='الاربعاء'; echo $ead;}elseif($nameOfDay=='Thu') { $ead='الخميس'; echo $ead;}elseif($nameOfDay=='Fri') { $ead='الجمعة'; echo $ead;}elseif($nameOfDay=='Sat') { $ead='السبت'; echo $ead;};
                $nameOfDay = date('D', strtotime($date));
                if($nameOfDay=='Sun') { $cod='الاحد'; echo $cod;}elseif($nameOfDay=='Mon') { $cod='الاثنين'; echo $cod;}elseif($nameOfDay=='Tue') { $cod='الثلاثاء'; echo $cod;}elseif($nameOfDay=='Wed') { $cod='الاربعاء'; echo $cod;}elseif($nameOfDay=='Thu') { $cod='الخميس'; echo $cod;}elseif($nameOfDay=='Fri') { $cod='الجمعة'; echo $cod;}elseif($nameOfDay=='Sat') { $cod='السبت'; echo $cod;};

    			if($oldtype1 == $type1  AND $oldtype0 == $type0 AND $old_start_date == $start_date   AND $old_down_payment == $down_payment AND $oldtotal == $rent_price
    			 AND $oldprice == $rent_pri ){

            $stmt = $con->prepare(" UPDATE contract SET name = ? ,address = ? ,hafiza_no = ? ,phone = ? ,phone1 = ?
            ,marrid_no = ?,tameen = ? ,subtraction = ? ,note = ?  ,s_name = ? ,e_name = ? ,month = ? ,year = ?
            ,b_id = ? ,day = ? ,totalwrite = ? ,bhd = ? ,hd = ? ,hm = ?  ,hy = ? ,fclock = ? ,tclock = ?
            WHERE contract_no = ? ");
            $stmt->execute(array($name,$address,$hafiza_no,$phone,$phone1,$marrid_no,$tameen,$subtraction,$note,
            $nad,$ead,$month,$year,$b_id,$cod,$totalwrite,$hdate,$hd,$hm,$hy,$fclock,$tclock,$id));

    			$stmt = $con->prepare("INSERT INTO active (Name,Oper,OperDate,OperTime,IPV4) VALUES (?,?,now(),now(),?)");
    			$stmt->execute(array($main,'تعديل بيانات  عقد رقم'.$id,$computerName));

				echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";

				}if($old_start_date != $start_date){

            $stmt = $con->prepare("SELECT * FROM contract WHERE  start_date  = ?   and b_id = ?  ");
            $stmt->execute(array($start_date,$b_id));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
          echo  $copen = $row['copen'];
            if($count > 0) {

              if($copen == '1'){

            echo "<meta http-equiv='refresh' content='0; url=?do=opendayold&&day=$start_date&&end=$end_date&&contract_no=$id' />";

          } else {
              echo "<meta http-equiv='refresh' content='0; url=?do=waring' />";
           }

         }else{
          $stmt = $con->prepare(" UPDATE contract SET start_date = ?,end_date = ? 	WHERE contract_no = ? ");
          $stmt->execute(array($start_date,$end_date,$id));
          echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";
         }

				}if($oldprice != $rent_pri){
            $price1=$_POST['price1'];
            $rent_price=$_POST['total'];
            $down_payment=$_POST['down_payment'];
            $remaining=$rent_price-$down_payment;
            $cdp = $down_payment/$svat;
            $dpv = $down_payment-$cdp;
            $crv = $remaining/$svat ;
            $rv = $remaining-$crv;

					$stmt = $con->prepare(" UPDATE contract SET rent_price = ?,vat = ?,remaining = ?,m = ?,youm = ?,rdate = ?,crv = ?,rv = ?	WHERE contract_no = ? ");
					$stmt->execute(array($rent_price,$vat,$remaining,$price1,$vat,$rent_price,$crv,$rv,$contract_no));

				}if($old_down_payment != $down_payment){

						$down_payment=$_POST['down_payment']; echo "</br>";
						$remaining=$rent_price-$down_payment;	echo"</br>";
						$rent_price=$_POST['total']; echo "</br>";
						$cdp = $down_payment/$svat;echo "</br>";
						$dpv = $down_payment-$cdp; echo "</br>";
						$crv = $remaining/$svat ; echo "</br>";
						$rv = $remaining-$crv; echo "</br>";
						$type0 = $_POST['type0'];  echo "</br>";
						$type1 = $_POST['type1'];  echo "</br>";
						$payment = $type0+$type1;  echo "</br>";

            $stmt = $con->prepare(" UPDATE contract SET down_payment = ?,remaining = ?,cdp = ?,dpv = ?,crv = ?,rv = ?,type0 = ?,type1 = ?	WHERE contract_no = ? and b_id = ? ");
            $stmt->execute(array($down_payment,$remaining,$cdp,$dpv,$crv,$rv,$type0,$type1,$contract_no,$b_id));

            $stmt = $con->prepare(" UPDATE vatcal SET sub = ?,vat = ?,total = ?	WHERE invon = ? and b_id = ?  ");
            $stmt->execute(array($cdp,$dpv,$down_payment,$contract_no,$b_id));

            $stmt = $con->prepare(" UPDATE revenues SET price = ?	WHERE contract_no = ? and b_id = ?  ");
            $stmt->execute(array($down_payment,$contract_no,$b_id));



				}if($oldtype1 != $type1 ){

				      if($type = 0 or $type = 2){
                $stm1  = $con->prepare("SELECT * From bank where Type = ? and b_id = ?  ");
                $stm1 ->execute(array('1',$b_id));
                $ro1 = $stm1->fetch();
                $ID  = $ro1['ID'];

                $stmt = $con->prepare(" DELETE FROM  safe_statment WHERE invoice_no = ? and b_id = ? ");
                $stmt->execute(array($contract_no,$b_id));

                $stm = $con->prepare("UPDATE bank SET Blance = Blance - ?
                WHERE Type = ? AND b_id = ? AND ID = ?    ");
                $stm->execute(array($oldtype1,'1',$b_id,$ID));

                $stm1  = $con->prepare("SELECT * From bank where Type = ? and b_id = ?  ");
                $stm1 ->execute(array('1',$b_id));
                $ro1 = $stm1->fetch();
                $Name  = $ro1['Name'];
                $OBlance  = $ro1['Blance'];
                $ID  = $ro1['ID'];
                $newbalance = $OBlance+$type1;

      					$stmt2 = $con->prepare("INSERT INTO safe_statment (date,month,year,descr,income,toutcome,st,invoice_no,b_id) VALUES (?,?,?,?,?,?,?,?,?) ");
      					$stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type1,$newbalance,'1',$contract_no,$b_id));

      					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?
      					WHERE ID = ?   and b_id = ? ");
      					$stm->execute(array($type1,$ID,$b_id));

                $stm = $con->prepare("UPDATE vatcal SET type1 =  ?
                WHERE invon = ?   and b_id = ? ");
                $stm->execute(array($type1,$contract_no,$b_id));

                $stmt = $con->prepare(" UPDATE contract SET type1 = ?	WHERE contract_no = ? and b_id = ? ");
                $stmt->execute(array($type1,$contract_no,$b_id));
              }

            }if($oldtype0 != $type0 ){

              $stm1  = $con->prepare("SELECT * From bank where Type =  ? and opening_balance != ? and b_id = ? ");
              $stm1 ->execute(array('0','1',$b_id));
              $ro1 = $stm1->fetch();
              $ID  = $ro1['ID'];

              $stmt = $con->prepare(" DELETE FROM  bank_statment WHERE invoice_no = ? and b_id = ? ");
              $stmt->execute(array($contract_no,$b_id));

              $stm = $con->prepare("UPDATE bank SET Blance = Blance - ?
              WHERE Type = ?   and b_id = ? and  opening_balance != ? ");
      				$stm->execute(array($type1,'0',$b_id,'1'));

  					$stm1  = $con->prepare("SELECT * From bank where Type =  ? and opening_balance != ? and b_id = ? ");
  					$stm1 ->execute(array('0','1',$b_id));
  					$ro1 = $stm1->fetch();
  					$Name  = $ro1['Name'];
  					$OBlance  = $ro1['Blance'];
  					echo $newbalance = $OBlance+$type1;
  					$ID  = $ro1['ID'];


            $stmt = $con->prepare(" DELETE FROM  bank_statment WHERE invoice_no = ? and b_id = ? ");
            $stmt->execute(array($contract_no,$b_id));

            $stmt2 = $con->prepare("INSERT INTO bank_statment (date,month,year,descr,income,toutcome,st,invoice_no,bankcommission,tamount,vatcommission)
            VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
            $stmt2->execute(array($date,$month,$year,'إيراد عقد - '.$contract_no,$type0,$newbalance,'1',$contract_no,$bankcommwvat,$tamount,$vatcommission));

					$stm = $con->prepare("UPDATE bank SET Blance = Blance + ?
					WHERE ID = ? and   b_id = ? and opening_balance != ? ");
					$stm->execute(array($type1,$ID,$b_id,'1'));
          $stm = $con->prepare("UPDATE vatcal SET type0 =  ?
          WHERE invon = ?   and b_id = ? ");
          $stm->execute(array($type0,$contract_no,$b_id));
          $stmt = $con->prepare(" UPDATE contract SET type0 = ?	WHERE contract_no = ? and b_id = ? ");
          $stmt->execute(array($type0,$contract_no,$b_id));

			}
	     echo "<meta http-equiv='refresh' content='0; url=?do=ReView&&id=$contract_no' />";

		   } else {
			 echo "<meta http-equiv='refresh' content='0; url=../../dashboard.php?notification=red' />";
		   }

   } elseif ($do == 'Delete') {

    if ($_SERVER['REQUEST_METHOD']   == 'POST') {

        $IP = $_SERVER['REMOTE_ADDR'];        // Obtains the IP address
        $computerName = gethostbyaddr($IP);
        $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM contract WHERE  contract_no = ? and b_id = ? LIMIT 1");
        $stmt->execute(array($id,$b_id));
        $row = $stmt-> fetch();
        $count = $stmt->rowCount();
		$down_payment  = $row['down_payment'];
       	$paymenttype  = $row['paymenttype'];
        if ($count > 0) {

				$stmt = $con->prepare(" DELETE FROM contract WHERE contract_no = ? ");
				$stmt->execute(array($id));

				$stmt = $con->prepare(" DELETE FROM  revenues WHERE customer_id = ? ");
				$stmt->execute(array($id));

				$stmt = $con->prepare(" DELETE FROM  vatcal WHERE invon = ? ");
				$stmt->execute(array($id));

				$stmt = $con->prepare(" DELETE FROM  custody WHERE L_ID = ? ");
				$stmt->execute(array($id));



          $stmt = $con->prepare("INSERT INTO active (Name,Oper,OperDesc,OperDate,OperTime,IPV4) VALUES (?,?,?,now(),now(),?)");
          $stmt->execute(array($main,'حذف فئة','حذف'.$id,$computerName));

         echo "<meta http-equiv='refresh' content='0; url=?notification=green' />";
        } else {
          echo "<meta http-equiv='refresh' content='0; url=?notification=warn' />";
        }


   } else {
     echo "<meta http-equiv='refresh' content='0; url=../../dashboard.php?notification=red' />";
   }

		} else {
          echo "<meta http-equiv='refresh' content='0; url=../../dashboard.php?notification=red' />";
        }


    include('../../'.$tpl . "footer1.php");


      } else {

    header('Location:../../index.php');

  }
