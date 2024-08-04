<?php

include '../dbConnect.php';


$companyName = $_POST['companyName'];
$companyAddress = $_POST['companyAddress'];
$companyManager = $_POST['companyManager'];
$managerContact = $_POST['managerContact'];
$companyContact = $_POST['companyContact'];
$companyFax = $_POST['companyFax'];
$companySite = $_POST['companySite'];

$sql = "INSERT INTO company_list(company_name,company_address,company_manager,manager_contact,company_contact,company_fax,company_site) VALUES('$companyName','$companyContact','$companyManager','$managerContact','$companyContact','$companyFax','$companySite')";

if($conn->query($sql) === TRUE){
    echo '<script>alert("등록 완료"); location.href="../company-add.html"</script>';
    
}else{
    
}


?>