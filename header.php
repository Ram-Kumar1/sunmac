<?php 

if(isset($_SESSION['admin'])) {
}else {
 header('Location:admin_login.php');
}
?>

<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.php" class="logo">
        SUNMAC
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->
<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <!--<ul class="nav top-menu">-->
        <!-- settings start -->
        <!--<li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">8</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have 8 pending tasks</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>25% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="45">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Product Delivery</h5>
                                <p>45% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="78">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Payment collection</h5>
                                <p>87% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="60">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>33% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="90">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>

                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
        <!-- inbox dropdown start-->
       <!-- <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">4</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 4 Mails</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/3.png"></span>
                                <span class="subject">
                                <span class="from">Jonathan Smith</span>
                                <span class="time">Just now</span>
                                </span>
                                <span class="message">
                                    Hello, this is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/1.png"></span>
                                <span class="subject">
                                <span class="from">Jane Doe</span>
                                <span class="time">2 min ago</span>
                                </span>
                                <span class="message">
                                    Nice admin template
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/3.png"></span>
                                <span class="subject">
                                <span class="from">Tasi sam</span>
                                <span class="time">2 days ago</span>
                                </span>
                                <span class="message">
                                    This is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/2.png"></span>
                                <span class="subject">
                                <span class="from">Mr. Perfect</span>
                                <span class="time">2 hour ago</span>
                                </span>
                                <span class="message">
                                    Hi there, its a test
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end -->
        <!-- notification dropdown start-->
        <!--<li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">3</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                <li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="images/2.png">

                <span id="user-type" class="username">Admin</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <!-- <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Admin</span>
                    </a>
                    <ul class="sub">
                        <li><a href="production_type.php">Production Type</a></li>
                        <li><a href="production_size.php">Production Size</a></li>
                        <li><a href="billing_address.php">Billing Address</a></li>
                        <li><a href="production_Finishing.php">production Finishing</a></li>
                    </ul>
                </li> -->
                <li class="sub-menu" id="admin-list">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus"></i>
                        <span>Admin</span>
                    </a>
                    <ul class="sub">
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Employee Setup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="designation.php">Employee Designation</a></li>
                                <li><a href="description.php">Salary Description</a></li>
                                <li><a href="employee.php">Add Employee</a></li>
                                <li><a href="employee_view.php">Employee View</a></li>
                                <!-- <li><a href="employee_login_view.php">Employee Login View</a></li> -->
                                <li><a href="employeesalary.php">Employee Salary</a></li>
                                <li><a href="employee_salary_view.php">Employee Salary View</a></li>
                                <li><a href="city1.php">Location</a></li>
                            </ul>
                        </li>
                        <!-- purchase setup -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Purchase Setup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="purchase_customer.php">Add Supplier</a></li>
                                <li><a href="purchase_customer_view.php">View Supplier</a></li>
                                <li><a href="purchase_product.php">Add Raw Material</a></li>
                                <li><a href="purchase_product_view.php">View Raw Material</a></li>
                            </ul>
                        </li>
                        <!-- followup setup -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Followup Setup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="sales_customer.php">Add Customer</a></li>
                                <li><a href="sales_customer_all.php">All Customer</a></li>
                                <li><a href="ass_new_product_cust.php">Assign New Product for Customer</a></li>
                            </ul>
                        </li>
                        <!-- sales setup -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Sales Setup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="billing_address.php">Billing Address</a></li>
                                <!-- to do -->
                                <li><a href="#">GST</a></li>
                                <!-- to do -->
                                <li><a href="#">Terms and Conditions</a></li>
                            </ul>
                        </li>
                        <!-- production setup -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Production Setup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="production_type.php">Production Type</a></li>
                                <li><a href="production_size.php">Production Size</a></li>
                                <li><a href="production_thickness.php">Product Thickness</a></li>
                                <li><a href="production_weight.php">Product Weight</a></li>
                                <li><a href="production_finishing.php">Product Finish</a></li>
                                <li><a href="machine details.php">Add Machine Details</a></li>
                                <li><a href="machine_details_view.php">Machine Details View</a></li>
                                <li><a href="category.php">Add Product</a></li>
                                <li><a href="category_job_work.php">Add Job Work</a></li>
                                <li><a href="category_view.php">Product View</a></li>
                                
                            </ul>
                        </li>
                        <!-- graph or chart -->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-bullhorn"></i>
                                <span>Graph/Chart</span>                            
                            </a>
                            <ul class="sub">
                                <!-- to do -->
                                <li><a href="#">Purchase Chart</a></li>
                                <li><a href="#">Raw Material In/Out Chart</a></li>
                                <li><a href="#">Followup chart</a></li>
                                <li><a href="#">Salse Performance Chart</a></li>
                                <li><a href="#">Production Performance Chart</a></li>
                                <li><a href="#">Turn Over Chart</a></li>
                                <li><a href="#">Production-Salse Chart</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
                <li class="sub-menu" id="purchase-list">
                            <a href="javascript:;">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Purchase</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="generatePo.php">Generate PO</a></li>
                                <!-- to do -->
                                <li><a href="viewPO.php">View PO</a></li>
                                <li><a href="purchase_entry.php">Purchase Entry</a></li>
                                <li><a href="outstandingPayment.php">Outstanding Payment</a></li>
                                <li><a href="currentSteelStock.php">Current Steel Status</a></li>
                                <!-- to do -->
                                <li><a href="#">Report</a></li>
                            </ul>
                </li>
                <li class="sub-menu" id="followup-list">
                            <a href="javascript:;">
                                <i class="fa fa-line-chart"></i>
                                <span>Followup</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="followup.php">Followup</a></li>
                                <li><a href="fr_home.php">Report</a></li>
                            </ul>
                </li>
                <li class="sub-menu" id="employeeLogin-list">
                            <a href="javascript:;">
                                <i class="fa fa-users"></i>
                                <span>Employee Login</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="employeeUniqueView.php">Employee</a></li>
                                <li><a href="employeeFollowupUnique.php">Followup</a></li>
                            </ul>
                </li>
                <li class="sub-menu" id="sales-list">
                            <a href="javascript:;">
                                <i class="fa fa-cloud-upload"></i>
                                <span>Sales</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="sales_quotation.php">Quotation from Followup</a></li>
                                <li><a href="sunmac_quotation_direct.php">New Quotation</a></li>
                                <li><a href="viewQuotationPDF.php">View Quotation</a></li>
                                <li><a href="sample_pi.php">Create Performa Invoice</a></li>
                                <li><a href="view_performa_invoice.php">View Performa Invoice</a></li>
                                <li><a href="view_invoice.php">View Invoice</a></li>
                                <li><a href="view_invoice_pending.php">View Invoice For Pending Amount</a></li>
                                <li><a href="sales_ppf.php">Sales PPI</a></li>
                                <!-- to do -->
                                <li><a href="sr_home.php">Report</a></li>
                                <li><a href="scrap.php">Scrap</a></li>
                            </ul>
                </li>
                <li class="sub-menu" id="accounts-list">
                            <a href="javascript:;">
                                <i class="fa fa-inr"></i>
                                <span>Accounts</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="sample_invoice_view.php">Generate PPI</a></li>
                                <li><a href="accounts.php">Accounts</a></li>
                                <li><a href="accounts_pending.php">Pending Payment</a></li>
                                <li><a href="settledAccounts.php">Settled Accounts</a></li>
                                <li><a href="ar_home.php">Report</a></li>
                            </ul>
                </li>
                <li class="sub-menu" id="production-list">
                            <a href="javascript:;">
                                <i class="fa fa-cubes"></i>
                                <span>Production</span>                            
                            </a>
                            <ul class="sub">
                                <li><a href="productionTeam_SPI.php">PPI</a></li>
                                <li><a href="production_flow.php">Daily Process</a></li>
                                <li><a href="poleStock.php">Pole Stock</a></li>
                                <li><a href="machineStock.php">Machine Stock</a></li>
                                <li><a href="production_Flow_report.php">Report</a></li>
                            </ul>
                </li>
                <!-- <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Employee</span>
                    </a>
                    <ul class="sub">
                        
                        <li><a href="employee.php">Add Employee</a></li>
                        <li><a href="employee_view.php">Employee View</a></li>
                        <li><a href="description.php">Salary Description</a></li>
                        <li><a href="designation.php">Employee Designation</a></li>
                        <li><a href="employee_login_view.php">Employee Login View</a></li>
                        <li><a href="employeesalary.php">Employee Salary</a></li>
                        <li><a href="employee_salary_view.php">Employee Salary View</a></li>

                    </ul>
                </li> -->
                <!-- <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Machine</span>
                    </a>
                    <ul class="sub">
                        <li><a href="machine details.php">Add Machine Details</a></li>
                        <li><a href="machine_details_view.php">Machine Details View</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub">
                        <li><a href="category.php">Add Product</a></li>
                        <li><a href="category_job_work.php">Add Job Work</a></li>
                        <li><a href="category_view.php">Product View</a></li>
                     
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Customer</span>
                    </a>
                    <ul class="sub">
                        <li><a href="sales_customer.php">Add Customer</a></li>
                        <li><a href="sales_customer_all.php">All Customer</a></li>
                        <li><a href="ass_new_product_cust.php">Assign New Products For Customer</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Purchase</span>
                    </a>
                    <ul class="sub">
                        <li><a href="purchase_customer.php">Supplier</a></li>
                        <li><a href="purchase_Entry.php">Purchase Entry</a></li>
                        <li><a href="purchase_product.php">Purchase Product</a></li>

                    </ul>
                </li>
                <li>
                    <a href="production_Flow.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Production</span>
                    </a>
                </li>
                <li>
                    <a href="production_Flow_report.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Production Reports</span>
                    </a>
                </li>
                <li>
                    <a href="followup.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Followup</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-bullhorn"></i>
                        <span>Quotation</span>
                    </a>
                    <ul class="sub">
                        <li><a href="sales_quotation.php">Sales Followup</a></li>
                        <li><a href="sunmac_quotation_direct.php">Direct Quotation</a></li>
                        <li><a href="sample_pi.php">Sample PI</a></li>
                    </ul>
                </li>

                

                <li class="sub-menu">
                    <a href="sunmac_sample_invoice.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Sample Invoice</span>
                    </a>
                    <ul class="sub">
                        <li><a href="sunmac_sample_invoice.php">Sample Invoice</a></li>
                        <li><a href="sample_invoice_view.php">Sample Invoice View</a></li>

                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="productionTeam_SPI.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Production PI</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="accounts.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="city1.php">
                        <i class="fa fa-bullhorn"></i>
                        <span>Location</span>
                    </a>
                </li> -->
                
                </ul>            
            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
</section>
<script type="text/javascript">
    $(document).ready(function() {
        let userType = <?php echo "'".$_SESSION['admin']. "'"; ?>;
        console.log('userType: ' + userType);

        if(userType == "generalManager") {
            $("#admin-list").hide();
            $("#user-type").text("GM");
        } else if(userType == "HR") {
            $("#user-type").text("HR");
            $("#admin-list").show();
            $("#purchase-list").hide();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").hide();
            $("#production-list").hide();
        } else if(userType == "followUp") {
            $("#user-type").text("Follow Up");
            $("#admin-list").hide();
            $("#purchase-list").hide();
            $("#followup-list").show();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").hide();
            $("#production-list").hide();
        } else if(userType == "salesManager") {
            $("#user-type").text("Sales");
            $("#admin-list").hide();
            $("#purchase-list").hide();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").show();
            $("#accounts-list").hide();
            $("#production-list").hide();
        } else if(userType == "accountsManager") {
            $("#user-type").text("Accounts");
            $("#admin-list").hide();
            $("#purchase-list").hide();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").show();
            $("#production-list").hide();
        } else if(userType == "purchaseManager") {
            $("#user-type").text("Purchase");
            $("#admin-list").hide();
            $("#purchase-list").show();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").hide();
            $("#production-list").hide();
        } else if(userType == "productionManager") {
            $("#user-type").text("Production");
            $("#admin-list").hide();
            $("#purchase-list").hide();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").hide();
            $("#production-list").show();
        } else if(userType == "employee" || userType == "marketingManager") {
            let logoutStr = userType.includes("marketingManager") ? "Marketing" : "Employee";
            $("#user-type").text(logoutStr);
            $("#admin-list").hide();
            $("#purchase-list").hide();
            $("#followup-list").hide();
            $("employeeLogin-list").show();
            $("#sales-list").hide();
            $("#accounts-list").hide();
            $("#production-list").hide();
        } else if(userType == "admin") {
            $("#employeeLogin-list").hide();
        }
    });

</script>


